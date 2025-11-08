# 📸 Filament Categories - Complete Setup Guide

## ✅ What's Been Created

### 1. **Enhanced Categories Table**
New database fields:
- `title` - Category name (required)
- `slug` - URL-friendly identifier (unique, required)
- `description` - Category description (optional)
- **`image`** - Photo upload field (optional, max 2MB)
- `icon` - Heroicon name for UI (optional)
- `color` - Hex color code (optional)
- `sort_order` - Custom ordering (default: 0)
- `is_active` - Enable/disable categories (default: true)

---

## 🎨 Filament Form Features

### Photo Upload Field
```php
FileUpload::make('image')
    ->image()
    ->directory('categories')         // Stored in storage/app/public/categories
    ->visibility('public')
    ->imageEditor()                   // Built-in image editor
    ->imageEditorAspectRatios([
        '16:9', '4:3', '1:1'         // Crop ratios
    ])
    ->maxSize(2048)                   // 2MB max
```

### Auto-Generated Slug
The form automatically generates a URL slug from the title as you type:
- Type "Formal Shirts" → slug becomes "formal-shirts"
- Editable if you want to customize it

### Field Layout
The form uses a 2-column grid with:
- Title & Slug side-by-side
- Full-width description textarea
- Full-width image upload with editor
- Icon, Color, and Sort Order in a row
- Active toggle

---

## 📊 Filament Table Features

### Display Columns
1. **Image** - Circular avatar (with fallback to generated avatar)
2. **Title** - Sortable & searchable category name
3. **Slug** - Copyable (click to copy to clipboard)
4. **Description** - Limited to 50 chars with tooltip
5. **Icon** - Visual icon display
6. **Color** - Color swatch (copyable)
7. **Sort Order** - Badge showing order number
8. **Status** - Active/Inactive with icons
9. **Items Count** - Number of clothing items in category
10. **Created/Updated** - Dates (hidden by default, toggleable)

### Filters
- **Active Status** - Filter by active/inactive categories
- **Sort Order Range** - Filter by order ranges (0-10, 11-50, 51+)

### Actions
- **View** - View category details
- **Edit** - Edit category
- **Bulk Delete** - Delete multiple categories at once

### Table Settings
- Default sorted by `sort_order` ascending
- Auto-refreshes every 30 seconds
- Striped rows for better readability
- Custom empty state with helpful message

---

## 🚀 How to Access Filament

### 1. Start the Server
```bash
php artisan serve
```

### 2. Access Filament Admin Panel
```
http://127.0.0.1:8000/admin
```

### 3. Login
If you haven't created a Filament user yet:
```bash
php artisan make:filament-user
```

Or login with demo account (if you made it a Filament user):
- Email: demo@wardrobe.com
- Password: password123

---

## 📸 Uploading Photos

### Via Filament Form:
1. Click on Categories in the sidebar
2. Click "New Category"
3. Fill in the fields
4. Click or drag an image to the upload area
5. Use the built-in editor to crop (16:9, 4:3, or 1:1)
6. Click "Create"

### Via API:
```bash
curl -X POST http://127.0.0.1:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "title=Summer Collection" \
  -F "slug=summer-collection" \
  -F "description=Light and breezy summer wear" \
  -F "image=@/path/to/image.jpg" \
  -F "icon=heroicon-o-sun" \
  -F "color=#F59E0B" \
  -F "sort_order=1" \
  -F "is_active=1"
```

---

## 🗂️ File Storage

### Uploaded Images Location:
```
storage/app/public/categories/
```

### Public Access URL:
```
http://127.0.0.1:8000/storage/categories/filename.jpg
```

### Storage Link
The symbolic link has been created:
```
public/storage → storage/app/public
```

If you need to recreate it:
```bash
php artisan storage:link
```

---

## 🎯 Model & API Updates

### Category Model (`app/Models/Category.php`)
```php
protected $fillable = [
    'title', 'slug', 'description', 
    'image', 'icon', 'color', 
    'sort_order', 'is_active',
];

protected $casts = [
    'is_active' => 'boolean',
    'sort_order' => 'integer',
];
```

### API Controller Features
- Automatic image upload handling
- Old image deletion when updating
- Validation for all fields
- Image stored in `storage/app/public/categories`

---

## 🎨 Available Heroicons

The form includes these icon options:
- heroicon-o-user (User)
- heroicon-o-sparkles (Sparkles)
- heroicon-o-star (Star)
- heroicon-o-heart (Heart)
- heroicon-o-shopping-bag (Shopping Bag)
- heroicon-o-gift (Gift)
- heroicon-o-sun (Sun)
- heroicon-o-moon (Moon)
- heroicon-o-bolt (Bolt)
- heroicon-o-fire (Fire)
- heroicon-o-shield-check (Shield)
- heroicon-o-squares-2x2 (Squares)
- heroicon-o-rectangle-stack (Rectangle Stack)
- heroicon-o-cube (Cube)
- heroicon-o-tag (Tag)

---

## ✨ Special Features

### 1. **Auto-Generated Avatars**
If no image is uploaded, the table displays a generated avatar with the category's initials:
```
https://ui-avatars.com/api/?name=Shirts&color=7F9CF5&background=EBF4FF
```

### 2. **Image Editor**
Built-in Filament image editor allows:
- Cropping to specific aspect ratios
- Rotating images
- Adjusting before saving

### 3. **Responsive Design**
All columns are toggleable - users can show/hide columns as needed

### 4. **Copy to Clipboard**
- Slug field: Click to copy
- Color field: Click to copy hex code

---

## 🧪 Testing the Setup

### Create a Test Category with Image:
1. Visit `http://127.0.0.1:8000/admin/categories`
2. Click "New Category"
3. Enter:
   - Title: "Vintage Denim"
   - Description: "Classic denim pieces from the 80s and 90s"
   - Upload an image
   - Icon: "heroicon-o-star"
   - Color: "#6366F1"
   - Sort Order: 1
   - Active: ON
4. Save

### Verify in Table:
- See your uploaded image as circular avatar
- Click slug to copy
- Click color to copy hex code
- Toggle columns on/off
- Filter by active status
- Sort by any column

---

## 📝 Database Summary

Current seeded data:
- **8 Categories** with icons and colors
- **79 Clothing Items** distributed across categories
- **35 Outfits** with clothing items
- **15 Tags** for categorization

---

## 🔧 Troubleshooting

### Images not displaying?
```bash
php artisan storage:link
```

### Permission issues?
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Clear cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📚 Next Steps

1. **Customize the form** - Add more fields if needed
2. **Add validation rules** - Enhance data integrity
3. **Create relationships** - Link to other models
4. **Add bulk actions** - Mass update categories
5. **Export functionality** - Export to CSV/Excel

---

**🎉 Your Filament Categories resource is ready to use with full photo upload capability!**
