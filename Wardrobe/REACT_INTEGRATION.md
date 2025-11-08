# React Integration Guide - Wardrobe API

## Table of Contents
1. [Setup](#setup)
2. [Environment Configuration](#environment-configuration)
3. [API Service Setup](#api-service-setup)
4. [Authentication Implementation](#authentication-implementation)
5. [React Components Examples](#react-components-examples)
6. [State Management](#state-management)
7. [Error Handling](#error-handling)

---

## Setup

### 1. Install Required Dependencies

```bash
npm install axios react-router-dom
```

Optional for state management:
```bash
npm install zustand
# or
npm install @reduxjs/toolkit react-redux
```

---

## Environment Configuration

### Create `.env` file in your React project root:

```env
# Base URL for API
VITE_API_BASE_URL=http://127.0.0.1:8000/api

# Alternative options:
# VITE_API_BASE_URL=http://localhost:8000/api
# VITE_API_BASE_URL=http://wardrobe.test/api

# Demo credentials (for testing)
VITE_DEMO_EMAIL=demo@wardrobe.com
VITE_DEMO_PASSWORD=password123
```

### API Configuration
**Base URL:** `http://127.0.0.1:8000/api`

**Demo Account:**
- Email: `demo@wardrobe.com`
- Password: `password123`

---

## API Service Setup

### Create `src/services/api.js`

```javascript
import axios from 'axios';

// Base URL from environment variable
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Create axios instance
const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Request interceptor - Add auth token to requests
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('authToken');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor - Handle errors globally
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Token expired or invalid - redirect to login
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export default api;
```

---

## Authentication Implementation

### Create `src/services/authService.js`

```javascript
import api from './api';

export const authService = {
  // Register new user
  register: async (userData) => {
    try {
      const response = await api.post('/register', userData);
      const { access_token, user } = response.data;
      
      // Store token and user data
      localStorage.setItem('authToken', access_token);
      localStorage.setItem('user', JSON.stringify(user));
      
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    }
  },

  // Login user
  login: async (credentials) => {
    try {
      const response = await api.post('/login', credentials);
      const { access_token, user } = response.data;
      
      // Store token and user data
      localStorage.setItem('authToken', access_token);
      localStorage.setItem('user', JSON.stringify(user));
      
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    }
  },

  // Logout user
  logout: async () => {
    try {
      await api.post('/logout');
    } catch (error) {
      console.error('Logout error:', error);
    } finally {
      // Clear local storage regardless of API response
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
    }
  },

  // Get current user
  getCurrentUser: async () => {
    try {
      const response = await api.get('/me');
      return response.data.user;
    } catch (error) {
      throw error.response?.data || error;
    }
  },

  // Check if user is authenticated
  isAuthenticated: () => {
    return !!localStorage.getItem('authToken');
  },

  // Get stored user data
  getStoredUser: () => {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
  },
};
```

---

### Create `src/services/clothingItemService.js`

```javascript
import api from './api';

export const clothingItemService = {
  // Get all clothing items
  getAll: async () => {
    const response = await api.get('/clothing-items');
    return response.data;
  },

  // Get single clothing item
  getById: async (id) => {
    const response = await api.get(`/clothing-items/${id}`);
    return response.data;
  },

  // Create clothing item
  create: async (data) => {
    const response = await api.post('/clothing-items', data);
    return response.data;
  },

  // Update clothing item
  update: async (id, data) => {
    const response = await api.put(`/clothing-items/${id}`, data);
    return response.data;
  },

  // Delete clothing item
  delete: async (id) => {
    const response = await api.delete(`/clothing-items/${id}`);
    return response.data;
  },

  // Get tags for clothing item
  getTags: async (id) => {
    const response = await api.get(`/clothing-items/${id}/tags`);
    return response.data;
  },

  // Attach tag to clothing item
  attachTag: async (id, tagId) => {
    const response = await api.post(`/clothing-items/${id}/tags`, { tag_id: tagId });
    return response.data;
  },

  // Detach tag from clothing item
  detachTag: async (id, tagId) => {
    const response = await api.delete(`/clothing-items/${id}/tags/${tagId}`);
    return response.data;
  },
};
```

---

### Create similar services for other resources

`src/services/categoryService.js`:
```javascript
import api from './api';

export const categoryService = {
  getAll: async () => {
    const response = await api.get('/categories');
    return response.data;
  },
  getById: async (id) => {
    const response = await api.get(`/categories/${id}`);
    return response.data;
  },
  create: async (data) => {
    const response = await api.post('/categories', data);
    return response.data;
  },
  update: async (id, data) => {
    const response = await api.put(`/categories/${id}`, data);
    return response.data;
  },
  delete: async (id) => {
    const response = await api.delete(`/categories/${id}`);
    return response.data;
  },
};
```

`src/services/outfitService.js`:
```javascript
import api from './api';

export const outfitService = {
  getAll: async () => {
    const response = await api.get('/outfits');
    return response.data;
  },
  getById: async (id) => {
    const response = await api.get(`/outfits/${id}`);
    return response.data;
  },
  create: async (data) => {
    const response = await api.post('/outfits', data);
    return response.data;
  },
  update: async (id, data) => {
    const response = await api.put(`/outfits/${id}`, data);
    return response.data;
  },
  delete: async (id) => {
    const response = await api.delete(`/outfits/${id}`);
    return response.data;
  },
};
```

`src/services/tagService.js`:
```javascript
import api from './api';

export const tagService = {
  getAll: async () => {
    const response = await api.get('/tags');
    return response.data;
  },
  getById: async (id) => {
    const response = await api.get(`/tags/${id}`);
    return response.data;
  },
  create: async (data) => {
    const response = await api.post('/tags', data);
    return response.data;
  },
  update: async (id, data) => {
    const response = await api.put(`/tags/${id}`, data);
    return response.data;
  },
  delete: async (id) => {
    const response = await api.delete(`/tags/${id}`);
    return response.data;
  },
};
```

---

## React Components Examples

### 1. Login Component

`src/components/Auth/Login.jsx`:
```jsx
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { authService } from '../../services/authService';

function Login() {
  const [formData, setFormData] = useState({
    email: '',
    password: '',
  });
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      await authService.login(formData);
      navigate('/dashboard');
    } catch (err) {
      setError(err.message || 'Login failed. Please check your credentials.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="login-container">
      <h2>Login to Wardrobe</h2>
      
      {error && <div className="error-message">{error}</div>}
      
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value={formData.email}
            onChange={handleChange}
            required
          />
        </div>

        <div className="form-group">
          <label htmlFor="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            value={formData.password}
            onChange={handleChange}
            required
          />
        </div>

        <button type="submit" disabled={loading}>
          {loading ? 'Logging in...' : 'Login'}
        </button>
      </form>
    </div>
  );
}

export default Login;
```

---

### 2. Register Component

`src/components/Auth/Register.jsx`:
```jsx
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { authService } from '../../services/authService';

function Register() {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });
  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({});
    setLoading(true);

    try {
      await authService.register(formData);
      navigate('/dashboard');
    } catch (err) {
      if (err.errors) {
        setErrors(err.errors);
      } else {
        setErrors({ general: err.message || 'Registration failed' });
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="register-container">
      <h2>Create Account</h2>
      
      {errors.general && <div className="error-message">{errors.general}</div>}
      
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="name">Name</label>
          <input
            type="text"
            id="name"
            name="name"
            value={formData.name}
            onChange={handleChange}
            required
          />
          {errors.name && <span className="error">{errors.name[0]}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value={formData.email}
            onChange={handleChange}
            required
          />
          {errors.email && <span className="error">{errors.email[0]}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            value={formData.password}
            onChange={handleChange}
            required
          />
          {errors.password && <span className="error">{errors.password[0]}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="password_confirmation">Confirm Password</label>
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            value={formData.password_confirmation}
            onChange={handleChange}
            required
          />
        </div>

        <button type="submit" disabled={loading}>
          {loading ? 'Creating account...' : 'Register'}
        </button>
      </form>
    </div>
  );
}

export default Register;
```

---

### 3. Clothing Items List Component

`src/components/ClothingItems/ClothingItemList.jsx`:
```jsx
import React, { useState, useEffect } from 'react';
import { clothingItemService } from '../../services/clothingItemService';

function ClothingItemList() {
  const [items, setItems] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchClothingItems();
  }, []);

  const fetchClothingItems = async () => {
    try {
      setLoading(true);
      const data = await clothingItemService.getAll();
      setItems(data);
    } catch (err) {
      setError('Failed to fetch clothing items');
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Are you sure you want to delete this item?')) {
      return;
    }

    try {
      await clothingItemService.delete(id);
      setItems(items.filter((item) => item.id !== id));
    } catch (err) {
      alert('Failed to delete item');
      console.error(err);
    }
  };

  if (loading) return <div>Loading...</div>;
  if (error) return <div className="error">{error}</div>;

  return (
    <div className="clothing-items-list">
      <h2>My Clothing Items</h2>
      
      <div className="items-grid">
        {items.map((item) => (
          <div key={item.id} className="item-card">
            {item.image_url && (
              <img src={item.image_url} alt={item.name} />
            )}
            <h3>{item.name}</h3>
            <p>{item.description}</p>
            <div className="item-details">
              <span>Brand: {item.brand}</span>
              <span>Size: {item.size}</span>
              <span>Color: {item.color}</span>
            </div>
            <div className="item-category">
              Category: {item.category?.name}
            </div>
            <div className="item-tags">
              {item.tags?.map((tag) => (
                <span key={tag.id} className="tag">
                  {tag.name}
                </span>
              ))}
            </div>
            <div className="item-actions">
              <button onClick={() => handleDelete(item.id)}>Delete</button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default ClothingItemList;
```

---

### 4. Create Clothing Item Component

`src/components/ClothingItems/CreateClothingItem.jsx`:
```jsx
import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { clothingItemService } from '../../services/clothingItemService';
import { categoryService } from '../../services/categoryService';
import { authService } from '../../services/authService';

function CreateClothingItem() {
  const [formData, setFormData] = useState({
    user_id: '',
    category_id: '',
    name: '',
    description: '',
    color: '',
    brand: '',
    size: '',
    image_url: '',
  });
  const [categories, setCategories] = useState([]);
  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    // Set user_id from stored user
    const user = authService.getStoredUser();
    if (user) {
      setFormData((prev) => ({ ...prev, user_id: user.id }));
    }

    // Fetch categories
    fetchCategories();
  }, []);

  const fetchCategories = async () => {
    try {
      const data = await categoryService.getAll();
      setCategories(data);
    } catch (err) {
      console.error('Failed to fetch categories', err);
    }
  };

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({});
    setLoading(true);

    try {
      await clothingItemService.create(formData);
      navigate('/clothing-items');
    } catch (err) {
      if (err.errors) {
        setErrors(err.errors);
      } else {
        setErrors({ general: err.message || 'Failed to create item' });
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="create-clothing-item">
      <h2>Add New Clothing Item</h2>
      
      {errors.general && <div className="error-message">{errors.general}</div>}
      
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="name">Name *</label>
          <input
            type="text"
            id="name"
            name="name"
            value={formData.name}
            onChange={handleChange}
            required
          />
          {errors.name && <span className="error">{errors.name[0]}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="category_id">Category *</label>
          <select
            id="category_id"
            name="category_id"
            value={formData.category_id}
            onChange={handleChange}
            required
          >
            <option value="">Select a category</option>
            {categories.map((category) => (
              <option key={category.id} value={category.id}>
                {category.name}
              </option>
            ))}
          </select>
          {errors.category_id && <span className="error">{errors.category_id[0]}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="description">Description</label>
          <textarea
            id="description"
            name="description"
            value={formData.description}
            onChange={handleChange}
            rows="4"
          />
        </div>

        <div className="form-row">
          <div className="form-group">
            <label htmlFor="color">Color</label>
            <input
              type="text"
              id="color"
              name="color"
              value={formData.color}
              onChange={handleChange}
            />
          </div>

          <div className="form-group">
            <label htmlFor="brand">Brand</label>
            <input
              type="text"
              id="brand"
              name="brand"
              value={formData.brand}
              onChange={handleChange}
            />
          </div>

          <div className="form-group">
            <label htmlFor="size">Size</label>
            <input
              type="text"
              id="size"
              name="size"
              value={formData.size}
              onChange={handleChange}
            />
          </div>
        </div>

        <div className="form-group">
          <label htmlFor="image_url">Image URL</label>
          <input
            type="url"
            id="image_url"
            name="image_url"
            value={formData.image_url}
            onChange={handleChange}
          />
        </div>

        <div className="form-actions">
          <button type="button" onClick={() => navigate('/clothing-items')}>
            Cancel
          </button>
          <button type="submit" disabled={loading}>
            {loading ? 'Creating...' : 'Create Item'}
          </button>
        </div>
      </form>
    </div>
  );
}

export default CreateClothingItem;
```

---

### 5. Protected Route Component

`src/components/ProtectedRoute.jsx`:
```jsx
import React from 'react';
import { Navigate } from 'react-router-dom';
import { authService } from '../services/authService';

function ProtectedRoute({ children }) {
  const isAuthenticated = authService.isAuthenticated();

  if (!isAuthenticated) {
    return <Navigate to="/login" replace />;
  }

  return children;
}

export default ProtectedRoute;
```

---

### 6. App Router Setup

`src/App.jsx`:
```jsx
import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import Login from './components/Auth/Login';
import Register from './components/Auth/Register';
import Dashboard from './components/Dashboard';
import ClothingItemList from './components/ClothingItems/ClothingItemList';
import CreateClothingItem from './components/ClothingItems/CreateClothingItem';
import ProtectedRoute from './components/ProtectedRoute';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        
        <Route
          path="/dashboard"
          element={
            <ProtectedRoute>
              <Dashboard />
            </ProtectedRoute>
          }
        />
        
        <Route
          path="/clothing-items"
          element={
            <ProtectedRoute>
              <ClothingItemList />
            </ProtectedRoute>
          }
        />
        
        <Route
          path="/clothing-items/create"
          element={
            <ProtectedRoute>
              <CreateClothingItem />
            </ProtectedRoute>
          }
        />
        
        <Route path="/" element={<Navigate to="/dashboard" replace />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
```

---

## State Management

### Using Zustand (Recommended for simplicity)

`src/stores/authStore.js`:
```javascript
import { create } from 'zustand';
import { authService } from '../services/authService';

export const useAuthStore = create((set) => ({
  user: authService.getStoredUser(),
  token: localStorage.getItem('authToken'),
  isAuthenticated: authService.isAuthenticated(),

  login: async (credentials) => {
    const data = await authService.login(credentials);
    set({
      user: data.user,
      token: data.access_token,
      isAuthenticated: true,
    });
  },

  register: async (userData) => {
    const data = await authService.register(userData);
    set({
      user: data.user,
      token: data.access_token,
      isAuthenticated: true,
    });
  },

  logout: async () => {
    await authService.logout();
    set({
      user: null,
      token: null,
      isAuthenticated: false,
    });
  },

  updateUser: (user) => set({ user }),
}));
```

`src/stores/clothingItemStore.js`:
```javascript
import { create } from 'zustand';
import { clothingItemService } from '../services/clothingItemService';

export const useClothingItemStore = create((set, get) => ({
  items: [],
  loading: false,
  error: null,

  fetchItems: async () => {
    set({ loading: true, error: null });
    try {
      const data = await clothingItemService.getAll();
      set({ items: data, loading: false });
    } catch (error) {
      set({ error: error.message, loading: false });
    }
  },

  addItem: async (itemData) => {
    const newItem = await clothingItemService.create(itemData);
    set({ items: [...get().items, newItem] });
  },

  updateItem: async (id, itemData) => {
    const updatedItem = await clothingItemService.update(id, itemData);
    set({
      items: get().items.map((item) =>
        item.id === id ? updatedItem : item
      ),
    });
  },

  deleteItem: async (id) => {
    await clothingItemService.delete(id);
    set({ items: get().items.filter((item) => item.id !== id) });
  },
}));
```

---

## Error Handling

### Create a global error handler

`src/utils/errorHandler.js`:
```javascript
export const handleApiError = (error) => {
  if (error.response) {
    // Server responded with error status
    const { status, data } = error.response;

    switch (status) {
      case 400:
        return 'Bad request. Please check your input.';
      case 401:
        return 'Unauthorized. Please log in again.';
      case 403:
        return 'Forbidden. You do not have permission.';
      case 404:
        return 'Resource not found.';
      case 422:
        // Validation errors
        return data.message || 'Validation failed.';
      case 500:
        return 'Server error. Please try again later.';
      default:
        return data.message || 'An error occurred.';
    }
  } else if (error.request) {
    // Request made but no response
    return 'No response from server. Please check your connection.';
  } else {
    // Error in request setup
    return error.message || 'An unexpected error occurred.';
  }
};
```

---

## Testing API Integration

### Example test with Jest

`src/services/__tests__/authService.test.js`:
```javascript
import { authService } from '../authService';
import api from '../api';

jest.mock('../api');

describe('authService', () => {
  afterEach(() => {
    localStorage.clear();
    jest.clearAllMocks();
  });

  test('login stores token and user data', async () => {
    const mockResponse = {
      data: {
        access_token: 'test-token',
        user: { id: 1, name: 'John Doe', email: 'john@example.com' },
      },
    };

    api.post.mockResolvedValue(mockResponse);

    await authService.login({
      email: 'john@example.com',
      password: 'password',
    });

    expect(localStorage.getItem('authToken')).toBe('test-token');
    expect(JSON.parse(localStorage.getItem('user'))).toEqual(
      mockResponse.data.user
    );
  });

  test('isAuthenticated returns true when token exists', () => {
    localStorage.setItem('authToken', 'test-token');
    expect(authService.isAuthenticated()).toBe(true);
  });

  test('isAuthenticated returns false when no token', () => {
    expect(authService.isAuthenticated()).toBe(false);
  });
});
```

---

## Quick Start Checklist

- [ ] Install dependencies (`axios`, `react-router-dom`)
- [ ] Create `.env` file with `VITE_API_BASE_URL`
- [ ] Set up API service with axios instance
- [ ] Configure request/response interceptors
- [ ] Create service files for each resource
- [ ] Implement authentication (login/register/logout)
- [ ] Create protected route component
- [ ] Build UI components
- [ ] Add error handling
- [ ] Test API integration
- [ ] Configure CORS on Laravel backend if needed

---

## Additional Tips

### 1. File Upload Support
If you need to upload images:

```javascript
export const uploadImage = async (file) => {
  const formData = new FormData();
  formData.append('image', file);

  const response = await api.post('/upload', formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  });

  return response.data.url;
};
```

### 2. Query Parameters
```javascript
// Filter clothing items by category
const getByCategory = async (categoryId) => {
  const response = await api.get('/clothing-items', {
    params: { category_id: categoryId },
  });
  return response.data;
};
```

### 3. Loading States
Use a loading component:

```jsx
function LoadingSpinner() {
  return <div className="spinner">Loading...</div>;
}
```

### 4. Pagination
```javascript
const fetchWithPagination = async (page = 1, perPage = 10) => {
  const response = await api.get('/clothing-items', {
    params: { page, per_page: perPage },
  });
  return response.data;
};
```

---

## Support

For questions or issues with React integration, please refer to the main API documentation or contact the development team.
