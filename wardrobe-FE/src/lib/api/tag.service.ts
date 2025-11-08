import apiClient from './client';
import { Tag } from './types';

export const tagService = {
  // Get all tags
  async getAll(): Promise<Tag[]> {
    const response = await apiClient.get<Tag[]>('/tags');
    return response.data;
  },

  // Get single tag
  async getById(id: number): Promise<Tag> {
    const response = await apiClient.get<Tag>(`/tags/${id}`);
    return response.data;
  },

  // Create tag
  async create(data: Omit<Tag, 'id' | 'created_at' | 'updated_at'>): Promise<Tag> {
    const response = await apiClient.post<Tag>('/tags', data);
    return response.data;
  },

  // Update tag
  async update(id: number, data: Partial<Omit<Tag, 'id' | 'created_at' | 'updated_at'>>): Promise<Tag> {
    const response = await apiClient.put<Tag>(`/tags/${id}`, data);
    return response.data;
  },

  // Delete tag
  async delete(id: number): Promise<void> {
    await apiClient.delete(`/tags/${id}`);
  },
};
