# 🎯 API Integration Complete - Quick Start Guide

## ✅ What's Been Set Up

### Backend (Laravel)
- ✅ Laravel Sanctum configured for API authentication
- ✅ CORS properly configured for React frontend
- ✅ All API routes protected with authentication
- ✅ Environment configured for development

### Frontend (React)
- ✅ Axios client with automatic token management
- ✅ Complete API service layer (auth, categories, tags, clothing items, outfits, users)
- ✅ Authentication context and hooks
- ✅ Protected routes
- ✅ Login and Register pages
- ✅ TypeScript interfaces for all API responses

## 🚀 Quick Start

### Option 1: Use the Startup Script (Recommended)
```bash
cd /home/infinity/coding/laravel/Uzapoint
./start-dev.sh
```

This will start both the backend and frontend servers automatically.

### Option 2: Start Manually

#### Terminal 1 - Backend
```bash
cd /home/infinity/coding/laravel/Uzapoint/Wardrobe
php artisan serve
```
Backend will run on: `http://127.0.0.1:8000`

#### Terminal 2 - Frontend
```bash
cd /home/infinity/coding/laravel/Uzapoint/wardrobe-FE
npm run dev
```
Frontend will run on: `http://localhost:5173`

## 📝 First Steps

1. **Create a User Account**
   - Navigate to `http://localhost:5173`
   - You'll be redirected to the login page
   - Click "Register" 
   - Fill in your details:
     - Name: Your Name
     - Email: your@email.com
     - Password: minimum 8 characters
     - Confirm Password: same as above
   - Click "Register"

2. **You're In!**
   - After registration, you'll be automatically logged in
   - The auth token is stored in localStorage
   - You can now access all protected routes

3. **Testing the API**
   - The Wardrobe page will automatically fetch your clothing items
   - Try adding, editing, or deleting items
   - All changes are saved to the database

## 🔑 API Configuration

### Base URLs
- **Backend:** `http://127.0.0.1:8000`
- **Frontend:** `http://localhost:5173`
- **API Endpoint:** `http://127.0.0.1:8000/api`

### Environment Files

#### Backend (.env)
```env
APP_URL=http://127.0.0.1:8000
FRONTEND_URL=http://localhost:5173
SANCTUM_STATEFUL_DOMAINS=localhost:5173,localhost:3000,127.0.0.1:5173
```

#### Frontend (.env)
```env
VITE_API_URL=http://127.0.0.1:8000
```

## 📚 Available API Services

All services are imported from `@/lib/api`:

```typescript
import { 
  authService,        // login, register, logout, getCurrentUser
  categoryService,    // CRUD for categories
  tagService,         // CRUD for tags
  clothingItemService,// CRUD for clothing items
  outfitService,      // CRUD for outfits
  userService        // CRUD for users
} from '@/lib/api';
```

## 🔐 Authentication

### Using the Auth Hook
```typescript
import { useAuth } from '@/hooks/useAuth';

function MyComponent() {
  const { user, login, logout, isAuthenticated, loading } = useAuth();
  
  // user: Current user object or null
  // login: Function to log in
  // logout: Function to log out
  // isAuthenticated: Boolean
  // loading: Boolean (true during auth check)
}
```

### Login Flow
1. User enters credentials on `/login`
2. Frontend fetches CSRF cookie from Laravel
3. Frontend sends credentials to `/api/login`
4. Backend validates and returns token + user data
5. Token stored in localStorage as `auth_token`
6. All subsequent API calls include the token automatically

## 🛡️ Protected Routes

Wrap any route that requires authentication:

```typescript
import { ProtectedRoute } from '@/components/ProtectedRoute';

<Route
  path="/wardrobe"
  element={
    <ProtectedRoute>
      <WardrobePage />
    </ProtectedRoute>
  }
/>
```

## 📖 API Endpoints Reference

### Authentication
- `POST /api/register` - Create new user account
- `POST /api/login` - Login and get token
- `POST /api/logout` - Logout and invalidate token
- `GET /api/me` - Get current user info

### Categories
- `GET /api/categories` - List all categories
- `POST /api/categories` - Create category
- `GET /api/categories/{id}` - Get single category
- `PUT /api/categories/{id}` - Update category
- `DELETE /api/categories/{id}` - Delete category

### Tags
- `GET /api/tags` - List all tags
- `POST /api/tags` - Create tag
- `GET /api/tags/{id}` - Get single tag
- `PUT /api/tags/{id}` - Update tag
- `DELETE /api/tags/{id}` - Delete tag

### Clothing Items
- `GET /api/clothing-items` - List all items
- `POST /api/clothing-items` - Create item
- `GET /api/clothing-items/{id}` - Get single item
- `PUT /api/clothing-items/{id}` - Update item
- `DELETE /api/clothing-items/{id}` - Delete item
- `GET /api/clothing-items/{id}/tags` - Get item's tags
- `POST /api/clothing-items/{id}/tags` - Attach tag to item
- `DELETE /api/clothing-items/{id}/tags/{tagId}` - Remove tag from item

### Outfits
- `GET /api/outfits` - List all outfits
- `POST /api/outfits` - Create outfit
- `GET /api/outfits/{id}` - Get single outfit
- `PUT /api/outfits/{id}` - Update outfit
- `DELETE /api/outfits/{id}` - Delete outfit

### Users
- `GET /api/users` - List all users
- `POST /api/users` - Create user
- `GET /api/users/{id}` - Get single user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

## 🧪 Testing the Integration

### Test Authentication
```typescript
// In browser console or component
import { authService } from '@/lib/api';

// Register
await authService.register({
  name: 'Test User',
  email: 'test@example.com',
  password: 'password123',
  password_confirmation: 'password123'
});

// Login
await authService.login({
  email: 'test@example.com',
  password: 'password123'
});

// Get current user
const user = await authService.getCurrentUser();
console.log(user);

// Logout
await authService.logout();
```

### Test Clothing Items
```typescript
import { clothingItemService } from '@/lib/api';

// Get all items
const items = await clothingItemService.getAll();

// Create item
const newItem = await clothingItemService.create({
  name: 'Blue Shirt',
  category_id: 1,
  color: 'blue',
  brand: 'Nike',
  size: 'M'
});
```

## 🐛 Troubleshooting

### CORS Errors
- Make sure backend is running on `http://127.0.0.1:8000`
- Check `FRONTEND_URL` in backend `.env`
- Check `SANCTUM_STATEFUL_DOMAINS` in backend `.env`

### 401 Unauthorized
- Make sure you're logged in
- Check if token exists: `localStorage.getItem('auth_token')`
- Try logging out and logging back in

### Connection Refused
- Verify backend is running: `curl http://127.0.0.1:8000/api`
- Check if MySQL is running: `sudo systemctl status mysql`
- Verify database credentials in backend `.env`

### CSRF Token Mismatch
- Clear browser cookies and localStorage
- Restart backend server
- Try in incognito/private browsing mode

## 📁 File Structure

### Frontend API Layer
```
wardrobe-FE/src/lib/api/
├── index.ts                  # Barrel exports
├── config.ts                 # Base URL configuration
├── client.ts                 # Axios instance
├── types.ts                  # TypeScript interfaces
├── auth.service.ts           # Authentication
├── category.service.ts       # Categories
├── tag.service.ts            # Tags
├── clothing-item.service.ts  # Clothing items
├── outfit.service.ts         # Outfits
└── user.service.ts           # Users
```

### Authentication Files
```
wardrobe-FE/src/
├── contexts/AuthContext.tsx  # Auth state management
├── hooks/useAuth.ts          # Auth hook
├── components/ProtectedRoute.tsx
└── pages/
    ├── LoginPage.tsx
    └── RegisterPage.tsx
```

## 🎉 You're All Set!

The complete API integration is ready. All API calls from the frontend will:
1. ✅ Automatically include authentication tokens
2. ✅ Handle CSRF protection
3. ✅ Manage errors appropriately
4. ✅ Redirect to login on 401 errors
5. ✅ Use TypeScript for type safety

For more detailed information, see `API_INTEGRATION_GUIDE.md` in the frontend folder.

## 📞 Need Help?

Check the complete API documentation:
- `wardrobe-FE/API_INTEGRATION_GUIDE.md` - Detailed API guide
- `Wardrobe/API_DOCUMENTATION.md` - Backend API docs
- `Wardrobe/routes/api.php` - All available routes
