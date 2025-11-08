import apiClient from './client';
import { Outfit } from './types';

export const outfitService = {
  // Get all outfits
  async getAll(): Promise<Outfit[]> {
    const response = await apiClient.get<Outfit[]>('/outfits');
    return response.data;
  },

  // Get single outfit
  async getById(id: number): Promise<Outfit> {
    const response = await apiClient.get<Outfit>(`/outfits/${id}`);
    return response.data;
  },

  // Create outfit
  async create(data: FormData | Omit<Outfit, 'id' | 'created_at' | 'updated_at'>): Promise<Outfit> {
    const config = data instanceof FormData ? {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    } : {};
    
    const response = await apiClient.post<Outfit>('/outfits', data, config);
    return response.data;
  },

  // Update outfit
  async update(id: number, data: FormData | Partial<Omit<Outfit, 'id' | 'created_at' | 'updated_at'>>): Promise<Outfit> {
    const config = data instanceof FormData ? {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    } : {};
    
    const response = await apiClient.put<Outfit>(`/outfits/${id}`, data, config);
    return response.data;
  },

  // Delete outfit
  async delete(id: number): Promise<void> {
    await apiClient.delete(`/outfits/${id}`);
  },
};
