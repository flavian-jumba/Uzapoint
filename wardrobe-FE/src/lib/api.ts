// API configuration and utilities for connecting to Laravel backend
import type { User, ClothingItem, Category, Tag, Outfit } from './api/types';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api';

interface ApiResponse<T> {
  data: T;
  message?: string;
}

class ApiClient {
  private baseUrl: string;
  private token: string | null = null;

  constructor(baseUrl: string) {
    this.baseUrl = baseUrl;
    this.token = localStorage.getItem('auth_token');
  }

  setToken(token: string | null) {
    this.token = token;
    if (token) {
      localStorage.setItem('auth_token', token);
    } else {
      localStorage.removeItem('auth_token');
    }
  }

  private async request<T>(
    endpoint: string,
    options: RequestInit = {}
  ): Promise<T> {
    const headers: HeadersInit = {
      'Content-Type': 'application/json',
      ...options.headers,
    };

    if (this.token) {
      headers['Authorization'] = `Bearer ${this.token}`;
    }

    const response = await fetch(`${this.baseUrl}${endpoint}`, {
      ...options,
      headers,
    });

    if (!response.ok) {
      const error = await response.json().catch(() => ({ message: 'An error occurred' }));
      throw new Error(error.message || `HTTP error! status: ${response.status}`);
    }

    return response.json();
  }

  // Authentication
  async login(email: string, password: string) {
    return this.request<{ token: string; user: User }>('/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    });
  }

  async register(email: string, password: string, name: string) {
    return this.request<{ token: string; user: User }>('/register', {
      method: 'POST',
      body: JSON.stringify({ email, password, name }),
    });
  }

  // Clothing Items
  async getClothingItems() {
    return this.request<ApiResponse<ClothingItem[]>>('/clothing-items');
  }

  async getClothingItem(id: number) {
    return this.request<ApiResponse<ClothingItem>>(`/clothing-items/${id}`);
  }

  async createClothingItem(data: Partial<ClothingItem>) {
    return this.request<ApiResponse<ClothingItem>>('/clothing-items', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }

  async updateClothingItem(id: number, data: Partial<ClothingItem>) {
    return this.request<ApiResponse<ClothingItem>>(`/clothing-items/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    });
  }

  async deleteClothingItem(id: number) {
    return this.request<void>(`/clothing-items/${id}`, {
      method: 'DELETE',
    });
  }

  // Categories
  async getCategories() {
    return this.request<ApiResponse<Category[]>>('/categories');
  }

  async getCategory(id: number) {
    return this.request<ApiResponse<Category>>(`/categories/${id}`);
  }

  async createCategory(data: Partial<Category>) {
    return this.request<ApiResponse<Category>>('/categories', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }

  async updateCategory(id: number, data: Partial<Category>) {
    return this.request<ApiResponse<Category>>(`/categories/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    });
  }

  async deleteCategory(id: number) {
    return this.request<void>(`/categories/${id}`, {
      method: 'DELETE',
    });
  }

  // Tags
  async getTags() {
    return this.request<ApiResponse<Tag[]>>('/tags');
  }

  async getItemTags(itemId: number) {
    return this.request<ApiResponse<Tag[]>>(`/clothing-items/${itemId}/tags`);
  }

  async attachTag(itemId: number, tagId: number) {
    return this.request<void>(`/clothing-items/${itemId}/tags`, {
      method: 'POST',
      body: JSON.stringify({ tag_id: tagId }),
    });
  }

  async detachTag(itemId: number, tagId: number) {
    return this.request<void>(`/clothing-items/${itemId}/tags/${tagId}`, {
      method: 'DELETE',
    });
  }

  // Outfits
  async getOutfits() {
    return this.request<ApiResponse<Outfit[]>>('/outfits');
  }

  async getOutfit(id: number) {
    return this.request<ApiResponse<Outfit>>(`/outfits/${id}`);
  }

  async createOutfit(data: Partial<Outfit>) {
    return this.request<ApiResponse<Outfit>>('/outfits', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }

  async updateOutfit(id: number, data: Partial<Outfit>) {
    return this.request<ApiResponse<Outfit>>(`/outfits/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    });
  }

  async deleteOutfit(id: number) {
    return this.request<void>(`/outfits/${id}`, {
      method: 'DELETE',
    });
  }
}

export const apiClient = new ApiClient(API_BASE_URL);

// Re-export new API services for compatibility
export { authService } from './api/auth.service';
export { categoryService } from './api/category.service';
export { tagService } from './api/tag.service';
export { clothingItemService } from './api/clothing-item.service';
export { outfitService } from './api/outfit.service';
export { userService } from './api/user.service';

// Re-export types from new API structure
export type { 
  User, 
  AuthResponse, 
  LoginRequest, 
  RegisterRequest,
  ClothingItem,
  Category,
  Tag,
  Outfit,
} from './api/types';
