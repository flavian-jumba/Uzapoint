# API Integration Setup - Wardrobe App

## Overview
This document describes the complete API integration between the Laravel backend and React frontend for the Wardrobe application.

## Backend Configuration

### Base URL
**Development:** `http://127.0.0.1:8000`
**API Endpoint:** `http://127.0.0.1:8000/api`

### Environment Variables (.env)
```env
APP_URL=http://127.0.0.1:8000
FRONTEND_URL=http://localhost:5173
SANCTUM_STATEFUL_DOMAINS=localhost:5173,localhost:3000,127.0.0.1:5173
```

### CORS Configuration
- Configured in `/Wardrobe/config/cors.php`
- Allows requests from frontend URL
- Supports credentials for Sanctum authentication
- Allowed paths: `api/*`, `sanctum/csrf-cookie`

### Authentication
- **Method:** Laravel Sanctum (Token-based)
- **Middleware:** EnsureFrontendRequestsAreStateful configured in `bootstrap/app.php`
- **Token Storage:** localStorage (`auth_token` key)

## Frontend Configuration

### Environment Variables (.env)
```env
VITE_API_URL=http://127.0.0.1:8000
```

### Directory Structure
```
wardrobe-FE/src/
├── lib/
│   └── api/
│       ├── auth.service.ts          # Authentication methods
│       ├── category.service.ts      # Category CRUD
│       ├── tag.service.ts           # Tag CRUD
│       ├── clothing-item.service.ts # Clothing item CRUD
│       ├── outfit.service.ts        # Outfit CRUD
│       ├── user.service.ts          # User CRUD
│       ├── client.ts                # Axios instance with interceptors
│       ├── config.ts                # API configuration
│       ├── types.ts                 # TypeScript interfaces
│       └── index.ts                 # Barrel exports
├── contexts/
│   └── AuthContext.tsx              # Authentication context provider
├── hooks/
│   └── useAuth.ts                   # Authentication hook
├── components/
│   └── ProtectedRoute.tsx           # Route protection component
└── pages/
    ├── LoginPage.tsx                # Login form
    └── RegisterPage.tsx             # Registration form
```

## API Endpoints

### Authentication Endpoints

#### Register
```typescript
POST /api/register
Body: {
  name: string,
  email: string,
  password: string,
  password_confirmation: string
}
Response: {
  message: string,
  user: User,
  access_token: string,
  token_type: "Bearer"
}
```

#### Login
```typescript
POST /api/login
Body: {
  email: string,
  password: string
}
Response: {
  message: string,
  user: User,
  access_token: string,
  token_type: "Bearer"
}
```

#### Logout
```typescript
POST /api/logout
Headers: { Authorization: "Bearer {token}" }
Response: {
  message: string
}
```

#### Get Current User
```typescript
GET /api/me
Headers: { Authorization: "Bearer {token}" }
Response: {
  user: User (with clothingItems and outfits relationships)
}
```

### Categories Endpoints

```typescript
GET    /api/categories           # List all categories
GET    /api/categories/{id}      # Get single category
POST   /api/categories           # Create category
PUT    /api/categories/{id}      # Update category
DELETE /api/categories/{id}      # Delete category
```

### Tags Endpoints

```typescript
GET    /api/tags           # List all tags
GET    /api/tags/{id}      # Get single tag
POST   /api/tags           # Create tag
PUT    /api/tags/{id}      # Update tag
DELETE /api/tags/{id}      # Delete tag
```

### Clothing Items Endpoints

```typescript
GET    /api/clothing-items               # List all items
GET    /api/clothing-items/{id}          # Get single item
POST   /api/clothing-items               # Create item
PUT    /api/clothing-items/{id}          # Update item
DELETE /api/clothing-items/{id}          # Delete item
GET    /api/clothing-items/{id}/tags     # Get item tags
POST   /api/clothing-items/{id}/tags     # Attach tag
DELETE /api/clothing-items/{id}/tags/{tagId}  # Detach tag
```

### Outfits Endpoints

```typescript
GET    /api/outfits           # List all outfits
GET    /api/outfits/{id}      # Get single outfit
POST   /api/outfits           # Create outfit
PUT    /api/outfits/{id}      # Update outfit
DELETE /api/outfits/{id}      # Delete outfit
```

### Users Endpoints

```typescript
GET    /api/users           # List all users
GET    /api/users/{id}      # Get single user
POST   /api/users           # Create user
PUT    /api/users/{id}      # Update user
DELETE /api/users/{id}      # Delete user
```

## Usage Examples

### Using Authentication

```typescript
import { useAuth } from '@/hooks/useAuth';

function MyComponent() {
  const { user, login, logout, isAuthenticated } = useAuth();

  const handleLogin = async () => {
    try {
      await login({ email: 'user@example.com', password: 'password' });
      // Redirects to '/' automatically
    } catch (error) {
      console.error('Login failed', error);
    }
  };

  return (
    <div>
      {isAuthenticated ? (
        <button onClick={logout}>Logout {user?.name}</button>
      ) : (
        <button onClick={handleLogin}>Login</button>
      )}
    </div>
  );
}
```

### Using API Services

```typescript
import { clothingItemService, categoryService } from '@/lib/api';

// Get all items
const items = await clothingItemService.getAll();

// Get single item
const item = await clothingItemService.getById(1);

// Create item
const newItem = await clothingItemService.create({
  name: 'Blue Jeans',
  category_id: 2,
  color: 'blue',
  brand: 'Levi\'s',
  size: 'M',
});

// Update item
const updatedItem = await clothingItemService.update(1, {
  name: 'Dark Blue Jeans',
});

// Delete item
await clothingItemService.delete(1);

// Work with tags
const tags = await clothingItemService.getTags(1);
await clothingItemService.attachTag(1, 5);
await clothingItemService.detachTag(1, 5);
```

### Protected Routes

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

## Data Types

### User
```typescript
interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at?: string | null;
  created_at: string;
  updated_at: string;
}
```

### Category
```typescript
interface Category {
  id: number;
  name: string;
  slug?: string;
  description?: string | null;
  created_at: string;
  updated_at: string;
}
```

### Tag
```typescript
interface Tag {
  id: number;
  name: string;
  created_at: string;
  updated_at: string;
}
```

### ClothingItem
```typescript
interface ClothingItem {
  id: number;
  user_id: number;
  name: string;
  category_id: number;
  color?: string | null;
  brand?: string | null;
  size?: string | null;
  image_url?: string | null;
  notes?: string | null;
  created_at: string;
  updated_at: string;
  category?: Category;
  tags?: Tag[];
}
```

### Outfit
```typescript
interface Outfit {
  id: number;
  user_id: number;
  name: string;
  description?: string | null;
  image_url?: string | null;
  occasion?: string | null;
  season?: string | null;
  created_at: string;
  updated_at: string;
  clothing_items?: ClothingItem[];
}
```

## Starting the Applications

### Backend (Laravel)
```bash
cd /home/infinity/coding/laravel/Uzapoint/Wardrobe
php artisan serve
# Server runs on http://127.0.0.1:8000
```

### Frontend (React)
```bash
cd /home/infinity/coding/laravel/Uzapoint/wardrobe-FE
npm run dev
# Server runs on http://localhost:5173
```

## Authentication Flow

1. User submits login credentials
2. Frontend calls `/sanctum/csrf-cookie` to get CSRF token
3. Frontend calls `/api/login` with credentials
4. Backend returns user data and access token
5. Frontend stores token in localStorage
6. Token is automatically added to all subsequent requests via axios interceptor
7. On logout, token is deleted from backend and localStorage

## Error Handling

- **401 Unauthorized:** Automatically clears token and redirects to login
- **403 Forbidden:** Logged to console
- **500 Server Error:** Logged to console
- All API calls should be wrapped in try-catch blocks
- Use toast notifications to display errors to users

## Security Notes

- CSRF protection enabled via Sanctum
- Tokens stored in localStorage (consider httpOnly cookies for production)
- CORS configured to only allow frontend domain
- All API routes require authentication except login/register
- Passwords hashed with bcrypt
- Validation on both frontend and backend

## Next Steps

1. Add file upload functionality for images
2. Implement pagination for large datasets
3. Add search and filtering capabilities
4. Set up production environment variables
5. Configure production CORS settings
6. Set up proper error logging
7. Add request rate limiting
8. Implement refresh tokens for better security
