// Type definitions for API responses
export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at?: string | null;
  created_at: string;
  updated_at: string;
}

export interface Category {
  id: number;
  title: string;
  slug: string;
  description?: string | null;
  image?: string | null;
  icon?: string | null;
  color?: string | null;
  sort_order?: number;
  is_active?: boolean;
  created_at: string;
  updated_at: string;
}

export interface Tag {
  id: number;
  name: string;
  created_at: string;
  updated_at: string;
}

export interface ClothingItem {
  id: number;
  user_id: number;
  name: string;
  category_id: number;
  description?: string | null;
  color?: string | null;
  brand?: string | null;
  size?: string | null;
  image?: string | null;
  price?: number | null;
  season?: string | null;
  condition?: string | null;
  purchase_date?: string | null;
  is_favorite?: boolean;
  created_at: string;
  updated_at: string;
  category?: Category;
  tags?: Tag[];
  user?: User;
  outfits?: Outfit[];
}

export interface Outfit {
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

export interface AuthResponse {
  message: string;
  user: User;
  access_token: string;
  token_type: string;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface RegisterRequest {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export interface ApiError {
  message: string;
  errors?: Record<string, string[]>;
}

export interface PaginatedResponse<T> {
  data: T[];
  links?: {
    first: string;
    last: string;
    prev: string | null;
    next: string | null;
  };
  meta?: {
    current_page: number;
    from: number;
    last_page: number;
    path: string;
    per_page: number;
    to: number;
    total: number;
  };
}
