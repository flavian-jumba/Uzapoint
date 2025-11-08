<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClothingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClothingItemController extends Controller
{
    public function index()
    {
        return ClothingItem::with(['user', 'category', 'outfits', 'tags'])->get();
    }

    public function show($id)
    {
        return ClothingItem::with(['user', 'category', 'outfits', 'tags'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:3072',
            'price' => 'nullable|numeric|min:0',
            'season' => 'nullable|in:Spring,Summer,Fall,Winter,All Season',
            'condition' => 'nullable|in:New,Like New,Good,Fair,Worn',
            'purchase_date' => 'nullable|date',
            'is_favorite' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('clothing-items', 'public');
        }

        return ClothingItem::create($validated);
    }

    public function update(Request $request, $id)
    {
        $item = ClothingItem::findOrFail($id);
        
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:3072',
            'price' => 'nullable|numeric|min:0',
            'season' => 'nullable|in:Spring,Summer,Fall,Winter,All Season',
            'condition' => 'nullable|in:New,Like New,Good,Fair,Worn',
            'purchase_date' => 'nullable|date',
            'is_favorite' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('clothing-items', 'public');
        }

        $item->update($validated);
        return $item;
    }

    public function destroy($id)
    {
        ClothingItem::destroy($id);
        return response()->noContent();
    }

    public function tags($id)
    {
        $item = ClothingItem::findOrFail($id);
        return $item->tags;
    }

    public function attachTag(Request $request, $id)
    {
        $validated = $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        $item = ClothingItem::findOrFail($id);
        $item->tags()->attach($validated['tag_id']);
        return $item->load('tags');
    }

    public function detachTag($id, $tagId)
    {
        $item = ClothingItem::findOrFail($id);
        $item->tags()->detach($tagId);
        return $item->load('tags');
    }
}
