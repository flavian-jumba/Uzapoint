import apiClient from './client';
import { ClothingItem, Tag } from './types';

export const clothingItemService = {
  // Get all clothing items
  async getAll(): Promise<ClothingItem[]> {
    const response = await apiClient.get<ClothingItem[]>('/clothing-items');
    return response.data;
  },

  // Get single clothing item
  async getById(id: number): Promise<ClothingItem> {
    const response = await apiClient.get<ClothingItem>(`/clothing-items/${id}`);
    return response.data;
  },

  // Create clothing item
  async create(data: FormData | Omit<ClothingItem, 'id' | 'created_at' | 'updated_at'>): Promise<ClothingItem> {
    const config = data instanceof FormData ? {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    } : {};
    
    const response = await apiClient.post<ClothingItem>('/clothing-items', data, config);
    return response.data;
  },

  // Update clothing item
  async update(id: number, data: FormData | Partial<Omit<ClothingItem, 'id' | 'created_at' | 'updated_at'>>): Promise<ClothingItem> {
    const config = data instanceof FormData ? {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    } : {};
    
    const response = await apiClient.put<ClothingItem>(`/clothing-items/${id}`, data, config);
    return response.data;
  },

  // Delete clothing item
  async delete(id: number): Promise<void> {
    await apiClient.delete(`/clothing-items/${id}`);
  },

  // Get tags for a clothing item
  async getTags(id: number): Promise<Tag[]> {
    const response = await apiClient.get<Tag[]>(`/clothing-items/${id}/tags`);
    return response.data;
  },

  // Attach tag to clothing item
  async attachTag(clothingItemId: number, tagId: number): Promise<void> {
    await apiClient.post(`/clothing-items/${clothingItemId}/tags`, { tag_id: tagId });
  },

  // Detach tag from clothing item
  async detachTag(clothingItemId: number, tagId: number): Promise<void> {
    await apiClient.delete(`/clothing-items/${clothingItemId}/tags/${tagId}`);
  },
};
