# Wardrobe API - Quick Reference

## API Configuration

### Base URL
```
Production: http://wardrobe.test/api
Development: http://127.0.0.1:8000/api
Local Testing: http://localhost:8000/api
```

**📍 Default Base URL:**
```
http://127.0.0.1:8000/api
```

### Authentication Type
**Laravel Sanctum** - Token-based authentication

### 🔑 Demo API Credentials (Pre-seeded)
```
Email: demo@wardrobe.com
Password: password123
```

**Example Token (Generated after login):**
```
1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0
```
*Note: Tokens are dynamically generated. Use the login endpoint to get your token.*

### Getting Your API Token

#### 1. Register a new user:
```bash
POST /api/register
```
**Body:**
```json
{
  "name": "Your Name",
  "email": "your@email.com",
  "password": "yourpassword",
  "password_confirmation": "yourpassword"
}
```

**Response includes:**
```json
{
  "access_token": "1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6",
  "token_type": "Bearer"
}
```

#### 2. Or login with existing credentials:
```bash
POST /api/login
```
**Body:**
```json
{
  "email": "your@email.com",
  "password": "yourpassword"
}
```

**Response includes:**
```json
{
  "access_token": "2|x9y8z7w6v5u4t3s2r1q0p9o8n7m6l5k4",
  "token_type": "Bearer"
}
```

---

## Using Your API Token

### Required Headers for All Protected Endpoints

```
Authorization: Bearer YOUR_ACCESS_TOKEN_HERE
Content-Type: application/json
Accept: application/json
```

### Example with cURL
```bash
curl -X GET http://wardrobe.test/api/clothing-items \
  -H "Authorization: Bearer 1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6" \
  -H "Accept: application/json"
```

### Example with JavaScript (Axios)
```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://wardrobe.test/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Add token to all requests
api.interceptors.request.use(config => {
  const token = localStorage.getItem('authToken');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Use the API
const getClothingItems = async () => {
  const response = await api.get('/clothing-items');
  return response.data;
};
```

### Example with Fetch API
```javascript
const token = 'YOUR_ACCESS_TOKEN_HERE';

fetch('http://wardrobe.test/api/clothing-items', {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
})
  .then(response => response.json())
  .then(data => console.log(data));
```

---

## Quick Endpoint Reference

### Public Endpoints (No Auth Required)
- `POST /api/register` - Register new user
- `POST /api/login` - Login user

### Protected Endpoints (Auth Required)

#### Authentication
- `POST /api/logout` - Logout user
- `GET /api/me` - Get current user info

#### Categories
- `GET /api/categories` - List all categories
- `POST /api/categories` - Create category
- `GET /api/categories/{id}` - Get single category
- `PUT /api/categories/{id}` - Update category
- `DELETE /api/categories/{id}` - Delete category

#### Clothing Items
- `GET /api/clothing-items` - List all clothing items
- `POST /api/clothing-items` - Create clothing item
- `GET /api/clothing-items/{id}` - Get single item
- `PUT /api/clothing-items/{id}` - Update item
- `DELETE /api/clothing-items/{id}` - Delete item
- `GET /api/clothing-items/{id}/tags` - Get item's tags
- `POST /api/clothing-items/{id}/tags` - Attach tag to item
- `DELETE /api/clothing-items/{id}/tags/{tagId}` - Remove tag from item

#### Outfits
- `GET /api/outfits` - List all outfits
- `POST /api/outfits` - Create outfit
- `GET /api/outfits/{id}` - Get single outfit
- `PUT /api/outfits/{id}` - Update outfit
- `DELETE /api/outfits/{id}` - Delete outfit

#### Tags
- `GET /api/tags` - List all tags
- `POST /api/tags` - Create tag
- `GET /api/tags/{id}` - Get single tag
- `PUT /api/tags/{id}` - Update tag
- `DELETE /api/tags/{id}` - Delete tag

#### Users
- `GET /api/users` - List all users
- `POST /api/users` - Create user
- `GET /api/users/{id}` - Get single user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

---

## Environment Variables

### For React/Frontend (.env)
```env
VITE_API_BASE_URL=http://wardrobe.test/api
```

### For Laravel/Backend (.env)
```env
APP_URL=http://wardrobe.test
DB_DATABASE=wardrobe
DB_USERNAME=root
DB_PASSWORD=your_password

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1,127.0.0.1:8000
```

---

## Testing Your Setup

### 1. Test Registration
```bash
curl -X POST http://wardrobe.test/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### 2. Test Login
```bash
curl -X POST http://wardrobe.test/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

### 3. Test Protected Endpoint (Copy token from login response)
```bash
curl -X GET http://wardrobe.test/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## Important Notes

1. **Token Storage**: Store your access token securely in localStorage or sessionStorage
2. **Token Expiration**: Tokens don't expire by default (set in `config/sanctum.php`)
3. **CORS**: Configured in `config/sanctum.php` for stateful domains
4. **Rate Limiting**: 60 requests per minute per user
5. **HTTPS**: Use HTTPS in production for secure token transmission

---

## Common Error Codes

- `200` - Success
- `201` - Created successfully
- `204` - Deleted successfully (no content)
- `401` - Unauthenticated (missing or invalid token)
- `403` - Forbidden (insufficient permissions)
- `404` - Resource not found
- `422` - Validation error
- `429` - Too many requests (rate limit exceeded)
- `500` - Server error

---

## Database Schema

### Tables
- `users` - User accounts
- `categories` - Clothing categories
- `clothing_items` - Individual clothing pieces
- `outfits` - Outfit combinations
- `tags` - Tags for clothing items
- `outfit_items` - Pivot table (outfits ↔ clothing_items)
- `clothing_item_tag` - Pivot table (clothing_items ↔ tags)
- `personal_access_tokens` - API tokens (Sanctum)

### Relationships
- User → Clothing Items (one-to-many)
- User → Outfits (one-to-many)
- Category → Clothing Items (one-to-many)
- Outfit ↔ Clothing Items (many-to-many)
- Clothing Item ↔ Tags (many-to-many)

---

## Support & Documentation

- **Full API Documentation**: `API_DOCUMENTATION.md`
- **React Integration Guide**: `REACT_INTEGRATION.md`
- **Laravel Sanctum Docs**: https://laravel.com/docs/sanctum

---

## Quick Start Command

Start the development server:
```bash
php artisan serve
```

Run migrations:
```bash
php artisan migrate
```

View all routes:
```bash
php artisan route:list --path=api
```
