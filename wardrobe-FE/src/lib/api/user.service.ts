import apiClient from './client';
import { User } from './types';

export const userService = {
  // Get all users
  async getAll(): Promise<User[]> {
    const response = await apiClient.get<User[]>('/users');
    return response.data;
  },

  // Get single user
  async getById(id: number): Promise<User> {
    const response = await apiClient.get<User>(`/users/${id}`);
    return response.data;
  },

  // Create user
  async create(data: Omit<User, 'id' | 'created_at' | 'updated_at'>): Promise<User> {
    const response = await apiClient.post<User>('/users', data);
    return response.data;
  },

  // Update user
  async update(id: number, data: Partial<Omit<User, 'id' | 'created_at' | 'updated_at'>>): Promise<User> {
    const response = await apiClient.put<User>(`/users/${id}`, data);
    return response.data;
  },

  // Delete user
  async delete(id: number): Promise<void> {
    await apiClient.delete(`/users/${id}`);
  },
};
