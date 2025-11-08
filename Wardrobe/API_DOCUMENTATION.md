# Wardrobe API Documentation

## Base URL
```
Production: http://wardrobe.test/api
Development: http://127.0.0.1:8000/api
Local Testing: http://localhost:8000/api
```

**Default Base URL for Development:**
```
http://127.0.0.1:8000/api
```

## Authentication

This API uses **Laravel Sanctum** for authentication with Bearer tokens.

### Demo Account (Pre-seeded)
For testing purposes, use this demo account:
```
Email: demo@wardrobe.com
Password: password123
```

After login, you'll receive an access token like:
```
1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0
```

### Headers Required for Protected Routes
```
Authorization: Bearer {your_access_token}
Content-Type: application/json
Accept: application/json
```

---

## Authentication Endpoints

### 1. Register User
Create a new user account and receive an access token.

**Endpoint:** `POST /api/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201 Created):**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z"
  },
  "access_token": "1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6",
  "token_type": "Bearer"
}
```

---

### 2. Login
Authenticate user and receive access token.

**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z"
  },
  "access_token": "2|x9y8z7w6v5u4t3s2r1q0p9o8n7m6l5k4",
  "token_type": "Bearer"
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "message": "The provided credentials are incorrect.",
  "errors": {
    "email": [
      "The provided credentials are incorrect."
    ]
  }
}
```

---

### 3. Logout
Revoke the current access token.

**Endpoint:** `POST /api/logout`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
{
  "message": "Logged out successfully"
}
```

---

### 4. Get Current User
Get authenticated user's information with related data.

**Endpoint:** `GET /api/me`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z",
    "clothing_items": [],
    "outfits": []
  }
}
```

---

## Categories Endpoints

### 1. Get All Categories
**Endpoint:** `GET /api/categories`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "Shirts",
    "description": "All types of shirts",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z",
    "clothing_items": []
  }
]
```

---

### 2. Get Single Category
**Endpoint:** `GET /api/categories/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "Shirts",
  "description": "All types of shirts",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z",
  "clothing_items": []
}
```

---

### 3. Create Category
**Endpoint:** `POST /api/categories`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "Shirts",
  "description": "All types of shirts"
}
```

**Response (201 Created):**
```json
{
  "id": 1,
  "name": "Shirts",
  "description": "All types of shirts",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z"
}
```

---

### 4. Update Category
**Endpoint:** `PUT /api/categories/{id}` or `PATCH /api/categories/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "T-Shirts",
  "description": "Casual t-shirts"
}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "T-Shirts",
  "description": "Casual t-shirts",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:31:00.000000Z"
}
```

---

### 5. Delete Category
**Endpoint:** `DELETE /api/categories/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (204 No Content)**

---

## Clothing Items Endpoints

### 1. Get All Clothing Items
**Endpoint:** `GET /api/clothing-items`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "category_id": 1,
    "name": "Blue Denim Shirt",
    "description": "Classic blue denim shirt",
    "color": "Blue",
    "brand": "Levi's",
    "size": "M",
    "image_url": "https://example.com/image.jpg",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "category": {
      "id": 1,
      "name": "Shirts"
    },
    "tags": [],
    "outfits": []
  }
]
```

---

### 2. Get Single Clothing Item
**Endpoint:** `GET /api/clothing-items/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
{
  "id": 1,
  "user_id": 1,
  "category_id": 1,
  "name": "Blue Denim Shirt",
  "description": "Classic blue denim shirt",
  "color": "Blue",
  "brand": "Levi's",
  "size": "M",
  "image_url": "https://example.com/image.jpg",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z",
  "user": {},
  "category": {},
  "tags": [],
  "outfits": []
}
```

---

### 3. Create Clothing Item
**Endpoint:** `POST /api/clothing-items`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "user_id": 1,
  "category_id": 1,
  "name": "Blue Denim Shirt",
  "description": "Classic blue denim shirt",
  "color": "Blue",
  "brand": "Levi's",
  "size": "M",
  "image_url": "https://example.com/image.jpg"
}
```

**Response (201 Created):**
```json
{
  "id": 1,
  "user_id": 1,
  "category_id": 1,
  "name": "Blue Denim Shirt",
  "description": "Classic blue denim shirt",
  "color": "Blue",
  "brand": "Levi's",
  "size": "M",
  "image_url": "https://example.com/image.jpg",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z"
}
```

---

### 4. Update Clothing Item
**Endpoint:** `PUT /api/clothing-items/{id}` or `PATCH /api/clothing-items/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "Light Blue Denim Shirt",
  "color": "Light Blue"
}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "user_id": 1,
  "category_id": 1,
  "name": "Light Blue Denim Shirt",
  "description": "Classic blue denim shirt",
  "color": "Light Blue",
  "brand": "Levi's",
  "size": "M",
  "image_url": "https://example.com/image.jpg",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:31:00.000000Z"
}
```

---

### 5. Delete Clothing Item
**Endpoint:** `DELETE /api/clothing-items/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (204 No Content)**

---

### 6. Get Clothing Item Tags
**Endpoint:** `GET /api/clothing-items/{id}/tags`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "casual",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z"
  }
]
```

---

### 7. Attach Tag to Clothing Item
**Endpoint:** `POST /api/clothing-items/{id}/tags`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "tag_id": 1
}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "user_id": 1,
  "category_id": 1,
  "name": "Blue Denim Shirt",
  "tags": [
    {
      "id": 1,
      "name": "casual"
    }
  ]
}
```

---

### 8. Detach Tag from Clothing Item
**Endpoint:** `DELETE /api/clothing-items/{id}/tags/{tagId}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
{
  "id": 1,
  "user_id": 1,
  "category_id": 1,
  "name": "Blue Denim Shirt",
  "tags": []
}
```

---

## Outfits Endpoints

### 1. Get All Outfits
**Endpoint:** `GET /api/outfits`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "name": "Summer Casual",
    "description": "Perfect for hot summer days",
    "occasion": "Casual",
    "season": "Summer",
    "image_url": "https://example.com/outfit.jpg",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z",
    "user": {},
    "clothing_items": []
  }
]
```

---

### 2. Get Single Outfit
**Endpoint:** `GET /api/outfits/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
{
  "id": 1,
  "user_id": 1,
  "name": "Summer Casual",
  "description": "Perfect for hot summer days",
  "occasion": "Casual",
  "season": "Summer",
  "image_url": "https://example.com/outfit.jpg",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z",
  "user": {},
  "clothing_items": []
}
```

---

### 3. Create Outfit
**Endpoint:** `POST /api/outfits`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "user_id": 1,
  "name": "Summer Casual",
  "description": "Perfect for hot summer days",
  "occasion": "Casual",
  "season": "Summer",
  "image_url": "https://example.com/outfit.jpg",
  "clothing_items": [1, 2, 3]
}
```

**Response (201 Created):**
```json
{
  "id": 1,
  "user_id": 1,
  "name": "Summer Casual",
  "description": "Perfect for hot summer days",
  "occasion": "Casual",
  "season": "Summer",
  "image_url": "https://example.com/outfit.jpg",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z",
  "clothing_items": [
    {
      "id": 1,
      "name": "Blue Denim Shirt"
    }
  ]
}
```

---

### 4. Update Outfit
**Endpoint:** `PUT /api/outfits/{id}` or `PATCH /api/outfits/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "Updated Summer Look",
  "clothing_items": [1, 2, 4]
}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "user_id": 1,
  "name": "Updated Summer Look",
  "description": "Perfect for hot summer days",
  "occasion": "Casual",
  "season": "Summer",
  "image_url": "https://example.com/outfit.jpg",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:31:00.000000Z",
  "clothing_items": []
}
```

---

### 5. Delete Outfit
**Endpoint:** `DELETE /api/outfits/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (204 No Content)**

---

## Tags Endpoints

### 1. Get All Tags
**Endpoint:** `GET /api/tags`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "casual",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z",
    "clothing_items": []
  }
]
```

---

### 2. Get Single Tag
**Endpoint:** `GET /api/tags/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "casual",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z",
  "clothing_items": []
}
```

---

### 3. Create Tag
**Endpoint:** `POST /api/tags`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "formal"
}
```

**Response (201 Created):**
```json
{
  "id": 2,
  "name": "formal",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z"
}
```

---

### 4. Update Tag
**Endpoint:** `PUT /api/tags/{id}` or `PATCH /api/tags/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "business-casual"
}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "business-casual",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:31:00.000000Z"
}
```

---

### 5. Delete Tag
**Endpoint:** `DELETE /api/tags/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (204 No Content)**

---

## Users Endpoints

### 1. Get All Users
**Endpoint:** `GET /api/users`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-11-07T19:30:00.000000Z",
    "updated_at": "2025-11-07T19:30:00.000000Z",
    "clothing_items": [],
    "outfits": []
  }
]
```

---

### 2. Get Single User
**Endpoint:** `GET /api/users/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z",
  "clothing_items": [],
  "outfits": []
}
```

---

### 3. Create User
**Endpoint:** `POST /api/users`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "Jane Smith",
  "email": "jane@example.com",
  "password": "password123"
}
```

**Response (201 Created):**
```json
{
  "id": 2,
  "name": "Jane Smith",
  "email": "jane@example.com",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:30:00.000000Z"
}
```

---

### 4. Update User
**Endpoint:** `PUT /api/users/{id}` or `PATCH /api/users/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "Jane Doe",
  "email": "janedoe@example.com"
}
```

**Response (200 OK):**
```json
{
  "id": 2,
  "name": "Jane Doe",
  "email": "janedoe@example.com",
  "created_at": "2025-11-07T19:30:00.000000Z",
  "updated_at": "2025-11-07T19:31:00.000000Z"
}
```

---

### 5. Delete User
**Endpoint:** `DELETE /api/users/{id}`

**Headers Required:** `Authorization: Bearer {token}`

**Response (204 No Content)**

---

## Error Responses

### Validation Error (422 Unprocessable Entity)
```json
{
  "message": "The name field is required. (and 1 more error)",
  "errors": {
    "name": [
      "The name field is required."
    ],
    "email": [
      "The email field must be a valid email address."
    ]
  }
}
```

---

### Unauthorized (401 Unauthorized)
```json
{
  "message": "Unauthenticated."
}
```

---

### Not Found (404 Not Found)
```json
{
  "message": "No query results for model [App\\Models\\ClothingItem] 999"
}
```

---

### Server Error (500 Internal Server Error)
```json
{
  "message": "Server Error"
}
```

---

## Rate Limiting

API requests are rate-limited to prevent abuse. Default limits:
- **60 requests per minute** for authenticated users

If you exceed the rate limit, you'll receive a `429 Too Many Requests` response.

---

## Testing with cURL

### Register a User
```bash
curl -X POST http://wardrobe.test/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login
```bash
curl -X POST http://wardrobe.test/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Get Clothing Items (with token)
```bash
curl -X GET http://wardrobe.test/api/clothing-items \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Create Category
```bash
curl -X POST http://wardrobe.test/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Shirts",
    "description": "All types of shirts"
  }'
```

---

## Support

For issues or questions, please contact the development team or create an issue in the project repository.
