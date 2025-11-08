# 🚀 Wardrobe API - Quick Start Guide

## 📍 Base URL
```
http://127.0.0.1:8000/api
```

## 🔑 Demo Credentials (Pre-seeded)
```
Email: demo@wardrobe.com
Password: password123
```

---

## 🎯 Getting Your API Token

### Step 1: Login
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "demo@wardrobe.com",
    "password": "password123"
  }'
```

### Step 2: Copy Your Token
The response will include your access token:
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "Demo User",
    "email": "demo@wardrobe.com"
  },
  "access_token": "1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0",
  "token_type": "Bearer"
}
```

### Step 3: Use Your Token
Copy the `access_token` value and use it in all subsequent requests:
```bash
curl -X GET http://127.0.0.1:8000/api/clothing-items \
  -H "Authorization: Bearer 1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0" \
  -H "Accept: application/json"
```

---

## 🧪 Test Endpoints

### 1. Get Current User
```bash
curl -X GET http://127.0.0.1:8000/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### 2. Get All Clothing Items
```bash
curl -X GET http://127.0.0.1:8000/api/clothing-items \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### 3. Get All Categories
```bash
curl -X GET http://127.0.0.1:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### 4. Get All Outfits
```bash
curl -X GET http://127.0.0.1:8000/api/outfits \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### 5. Get All Tags
```bash
curl -X GET http://127.0.0.1:8000/api/tags \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## 📝 Create New Items

### Create a Category
```bash
curl -X POST http://127.0.0.1:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Jackets",
    "description": "All types of jackets and coats"
  }'
```

### Create a Clothing Item
```bash
curl -X POST http://127.0.0.1:8000/api/clothing-items \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": 1,
    "category_id": 1,
    "name": "Black Leather Jacket",
    "description": "Classic leather jacket",
    "color": "Black",
    "brand": "Zara",
    "size": "M",
    "image_url": "https://example.com/jacket.jpg"
  }'
```

### Create an Outfit
```bash
curl -X POST http://127.0.0.1:8000/api/outfits \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": 1,
    "name": "Evening Casual",
    "description": "Perfect for casual evening outings",
    "occasion": "Casual",
    "season": "Fall",
    "clothing_items": [1, 2, 3]
  }'
```

### Create a Tag
```bash
curl -X POST http://127.0.0.1:8000/api/tags \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "autumn"
  }'
```

---

## 🔄 For Frontend Developers

### JavaScript/Axios Setup
```javascript
// api.js
import axios from 'axios';

const API_BASE_URL = 'http://127.0.0.1:8000/api';

const api = axios.create({
  baseURL: API_BASE_URL,
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

// Login and store token
export const login = async (email, password) => {
  const response = await api.post('/login', { email, password });
  localStorage.setItem('authToken', response.data.access_token);
  return response.data;
};

// Get clothing items
export const getClothingItems = async () => {
  const response = await api.get('/clothing-items');
  return response.data;
};
```

### React .env Setup
```env
VITE_API_BASE_URL=http://127.0.0.1:8000/api
VITE_DEMO_EMAIL=demo@wardrobe.com
VITE_DEMO_PASSWORD=password123
```

---

## 📊 What's in the Demo Database

The demo account has access to:
- **12 Clothing Items** - Various shirts, pants, shoes with different brands
- **10 Outfits** - Pre-made outfit combinations
- **8 Categories** - Shirts, Pants, Dresses, Shoes, Accessories, etc.
- **15 Tags** - casual, formal, vintage, modern, comfortable, etc.

---

## 🛠️ Useful Commands

### Start API Server
```bash
php artisan serve
```

### Re-seed Database
```bash
php artisan migrate:fresh --seed
```

### View All Routes
```bash
php artisan route:list --path=api
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
```

---

## ⚠️ Important Notes

1. **Token Security**: Never commit tokens to version control
2. **Token Storage**: Store tokens securely (localStorage/sessionStorage)
3. **Token Lifetime**: Tokens don't expire by default (configurable in `config/sanctum.php`)
4. **CORS**: If connecting from a different domain, configure in `config/sanctum.php`
5. **HTTPS**: Always use HTTPS in production

---

## 📚 Full Documentation

- **API Reference**: See `API_DOCUMENTATION.md`
- **React Integration**: See `REACT_INTEGRATION.md`
- **Quick Reference**: See `QUICK_REFERENCE.md`

---

## ✅ Quick Test Checklist

- [ ] Start Laravel server: `php artisan serve`
- [ ] Login with demo account
- [ ] Copy access token from response
- [ ] Test GET `/api/me` with token
- [ ] Test GET `/api/clothing-items` with token
- [ ] Verify response includes related data

---

**🎉 You're ready to start using the Wardrobe API!**
