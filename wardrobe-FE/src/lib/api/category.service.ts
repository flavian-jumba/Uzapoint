import apiClient from './client';
import { Category } from './types';

export const categoryService = {
  // Get all categories
  async getAll(): Promise<Category[]> {
    const response = await apiClient.get<Category[]>('/categories');
    return response.data;
  },

  // Get single category
  async getById(id: number): Promise<Category> {
    const response = await apiClient.get<Category>(`/categories/${id}`);
    return response.data;
  },

  // Create category
  async create(data: Omit<Category, 'id' | 'created_at' | 'updated_at'>): Promise<Category> {
    const response = await apiClient.post<Category>('/categories', data);
    return response.data;
  },

  // Update category
  async update(id: number, data: Partial<Omit<Category, 'id' | 'created_at' | 'updated_at'>>): Promise<Category> {
    const response = await apiClient.put<Category>(`/categories/${id}`, data);
    return response.data;
  },

  // Delete category
  async delete(id: number): Promise<void> {
    await apiClient.delete(`/categories/${id}`);
  },
};
