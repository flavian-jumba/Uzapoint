<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Outfit;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    public function index()
    {
        return Outfit::with(['user', 'clothingItems'])->get();
    }

    public function show($id)
    {
        return Outfit::with(['user', 'clothingItems'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'occasion' => 'nullable|string|max:100',
            'season' => 'nullable|string|max:50',
            'image_url' => 'nullable|string|max:500',
            'clothing_items' => 'nullable|array',
            'clothing_items.*' => 'exists:clothing_items,id',
        ]);

        $outfit = Outfit::create($validated);
        
        if (isset($validated['clothing_items'])) {
            $outfit->clothingItems()->sync($validated['clothing_items']);
        }
        
        return $outfit->load('clothingItems');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'occasion' => 'nullable|string|max:100',
            'season' => 'nullable|string|max:50',
            'image_url' => 'nullable|string|max:500',
            'clothing_items' => 'nullable|array',
            'clothing_items.*' => 'exists:clothing_items,id',
        ]);

        $outfit = Outfit::findOrFail($id);
        $outfit->update($validated);
        
        if (isset($validated['clothing_items'])) {
            $outfit->clothingItems()->sync($validated['clothing_items']);
        }
        
        return $outfit->load('clothingItems');
    }

    public function destroy($id)
    {
        Outfit::destroy($id);
        return response()->noContent();
    }
}
