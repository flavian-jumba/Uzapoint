# Wardrobe API - Digital Wardrobe Management System

A comprehensive Laravel-based REST API for managing your digital wardrobe, including clothing items, outfits, categories, and tags.

## 📚 Documentation

- **[API Documentation](./API_DOCUMENTATION.md)** - Complete API reference with all endpoints
- **[React Integration Guide](./REACT_INTEGRATION.md)** - Step-by-step React integration
- **[Quick Reference](./QUICK_REFERENCE.md)** - Quick start and essential info

---

## 🚀 Features

- ✅ **User Authentication** - Register, login, logout with Laravel Sanctum
- ✅ **Clothing Items Management** - CRUD operations for clothing pieces
- ✅ **Categories** - Organize items by category (Shirts, Pants, etc.)
- ✅ **Outfits** - Create and manage outfit combinations
- ✅ **Tags** - Tag items for easy searching and filtering
- ✅ **Relationships** - Complex many-to-many relationships
- ✅ **RESTful API** - Clean, standard REST endpoints
- ✅ **Token Authentication** - Secure API access with Sanctum tokens
- ✅ **Validation** - Request validation on all endpoints
- ✅ **CORS Support** - Configured for frontend integration

---

## 🛠️ Tech Stack

- **Laravel 12** - PHP Framework
- **Laravel Sanctum** - API Authentication
- **MySQL** - Database
- **Vite** - Frontend tooling

---

## 📋 Requirements

- PHP 8.2+
- Composer
- MySQL 5.7+ / MariaDB 10.3+
- Node.js & NPM (for Vite)

---

## ⚙️ Installation

### 1. Clone the repository
```bash
git clone <repository-url>
cd Wardrobe
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install Node dependencies
```bash
npm install
```

### 4. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure database in `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wardrobe
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6. Run migrations
```bash
php artisan migrate
```

### 7. Start the development server
```bash
php artisan serve
```

### 8. Start Vite (in another terminal)
```bash
npm run dev
```

---

## 🔑 API Quick Start

### Base URL
```
http://127.0.0.1:8000/api
```

### Demo Account (Pre-seeded)
```
Email: demo@wardrobe.com
Password: password123
```

### 1. Login to get your API token
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "demo@wardrobe.com",
    "password": "password123"
  }'
```

**Response:**
```json
{
  "access_token": "1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Demo User",
    "email": "demo@wardrobe.com"
  }
}
```

### 2. Use the token for authenticated requests
```bash
curl -X GET http://127.0.0.1:8000/api/clothing-items \
  -H "Authorization: Bearer 1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0"
```

---

## 📊 Database Schema

### Tables
- `users` - User accounts
- `categories` - Clothing categories
- `clothing_items` - Individual clothing pieces
- `outfits` - Outfit combinations
- `tags` - Tags for items
- `outfit_items` - Pivot (outfits ↔ clothing items)
- `clothing_item_tag` - Pivot (items ↔ tags)
- `personal_access_tokens` - API tokens

### Key Relationships
```
User ──┬─→ ClothingItems (1:many)
       └─→ Outfits (1:many)

Category ──→ ClothingItems (1:many)

ClothingItem ─┬─→ Outfits (many:many)
              └─→ Tags (many:many)
```

---

## 🔐 Authentication

This API uses **Laravel Sanctum** for token-based authentication.

### Getting a Token
1. Register: `POST /api/register`
2. Login: `POST /api/login`
3. Use token in header: `Authorization: Bearer {token}`

### Protected Routes
All routes except `/register` and `/login` require authentication.

---

## 📡 API Endpoints

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout (requires auth)
- `GET /api/me` - Get current user (requires auth)

### Resources (all require authentication)
- **Categories**: `/api/categories`
- **Clothing Items**: `/api/clothing-items`
- **Outfits**: `/api/outfits`
- **Tags**: `/api/tags`
- **Users**: `/api/users`

Each resource supports:
- `GET /{resource}` - List all
- `POST /{resource}` - Create new
- `GET /{resource}/{id}` - Get single
- `PUT/PATCH /{resource}/{id}` - Update
- `DELETE /{resource}/{id}` - Delete

### Special Endpoints
- `GET /api/clothing-items/{id}/tags` - Get item's tags
- `POST /api/clothing-items/{id}/tags` - Attach tag
- `DELETE /api/clothing-items/{id}/tags/{tagId}` - Detach tag

**See [API_DOCUMENTATION.md](./API_DOCUMENTATION.md) for complete details.**

---

## 🧪 Testing

### View all routes
```bash
php artisan route:list --path=api
```

### Run tests
```bash
php artisan test
```

---

## 🌐 Frontend Integration

### React Example
```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
});

// Add token to requests
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

**See [REACT_INTEGRATION.md](./REACT_INTEGRATION.md) for complete guide.**

---

## 📝 Example Requests

### Create a Category
```bash
curl -X POST http://127.0.0.1:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Shirts",
    "description": "All types of shirts"
  }'
```

### Create a Clothing Item
```bash
curl -X POST http://127.0.0.1:8000/api/clothing-items \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "category_id": 1,
    "name": "Blue Denim Shirt",
    "color": "Blue",
    "brand": "Levis",
    "size": "M"
  }'
```

### Create an Outfit
```bash
curl -X POST http://127.0.0.1:8000/api/outfits \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "name": "Summer Casual",
    "description": "Perfect for hot days",
    "occasion": "Casual",
    "season": "Summer",
    "clothing_items": [1, 2, 3]
  }'
```

---

## 🔧 Configuration

### CORS (for frontend)
Edit `config/sanctum.php`:
```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 
    'localhost,localhost:3000,127.0.0.1:8000'
)),
```

### Token Expiration
Edit `config/sanctum.php`:
```php
'expiration' => null, // Never expires (default)
// or
'expiration' => 60, // 60 minutes
```

---

## 🐛 Troubleshooting

### "Unauthenticated" error
- Ensure token is included in header: `Authorization: Bearer {token}`
- Check token is valid (not expired/revoked)
- Verify middleware is applied to route

### CORS errors
- Add your frontend domain to `SANCTUM_STATEFUL_DOMAINS` in `.env`
- Ensure headers include `Accept: application/json`

### Database errors
- Run migrations: `php artisan migrate`
- Check database credentials in `.env`
- Ensure MySQL is running

---

## 📦 Project Structure

```
Wardrobe/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           ├── AuthController.php
│   │           ├── CategoryController.php
│   │           ├── ClothingItemController.php
│   │           ├── OutfitController.php
│   │           ├── TagController.php
│   │           └── UserController.php
│   └── Models/
│       ├── Category.php
│       ├── ClothingItem.php
│       ├── Outfit.php
│       ├── Tag.php
│       └── User.php
├── database/
│   └── migrations/
├── routes/
│   └── api.php
├── API_DOCUMENTATION.md
├── REACT_INTEGRATION.md
└── QUICK_REFERENCE.md
```

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👥 Support

For questions or issues:
- Check the [API Documentation](./API_DOCUMENTATION.md)
- Review the [React Integration Guide](./REACT_INTEGRATION.md)
- Open an issue in the repository

---

## 🎯 Roadmap

- [ ] Image upload support
- [ ] Search and filtering
- [ ] Pagination
- [ ] Outfit recommendations
- [ ] Weather-based suggestions
- [ ] Social sharing features
- [ ] Mobile app support

---

**Built with ❤️ using Laravel 12**

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
