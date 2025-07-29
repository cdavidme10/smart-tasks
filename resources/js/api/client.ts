import { AuthApi, ProjectsApi, TasksApi } from './api';
import { Configuration } from './configuration';
import axios, { AxiosInstance } from 'axios';
import {
    LoginRequest,
    RegisterRequest,
    Task,
    CreateTaskRequest,
    UpdateTaskRequest,
    Project,
    CreateProjectRequest,
    UpdateProjectRequest
} from './api';

class ApiClient {
  private axiosInstance: AxiosInstance;
  private authApi: AuthApi;
  private projectsApi: ProjectsApi;
  private tasksApi: TasksApi;
  private token: string | null = null;

  constructor() {
    const config = new Configuration({
      basePath: import.meta.env.VITE_API_URL || 'http://localhost:8000',
    });

    this.axiosInstance = axios.create({
      baseURL: config.basePath,
      withCredentials: true, // Required for Sanctum CSRF cookie
    });

    // Initialize API instances
    this.authApi = new AuthApi(config, undefined, this.axiosInstance);
    this.projectsApi = new ProjectsApi(config, undefined, this.axiosInstance);
    this.tasksApi = new TasksApi(config, undefined, this.axiosInstance);

    // Load token from localStorage
    this.token = localStorage.getItem('auth_token');

    // Set up request interceptor to attach token
    this.axiosInstance.interceptors.request.use(
      async (config) => {
        // Fetch CSRF cookie for POST/PUT requests
        if (['post', 'put'].includes(config.method?.toLowerCase() || '')) {
          await this.axiosInstance.get('/sanctum/csrf-cookie');
        }

        // Attach token to Authorization header if available
        if (this.token) {
          config.headers = config.headers || {};
          config.headers.Authorization = `Bearer ${this.token}`;
        }

        return config;
      },
      (error) => Promise.reject(error)
    );
  }

  async register(data: RegisterRequest): Promise<string> {
    const response = await this.authApi.register(data);
    const token = response.data.token;
    if (!token) {
        throw new Error('No token returned from registration');
    }
    this.setToken(token);
    return token;
  }

  async login(data: LoginRequest): Promise<string> {
    const response = await this.authApi.login(data);
    const token = response.data.token;

    if (!token) {
        throw new Error('No token returned from login');
    }

    this.setToken(token);
    return token;
  }

  async logout(): Promise<void> {
    await this.authApi.logout();
    this.clearToken();
  }

  async getProjects(): Promise<Project[]> {
    const response = await this.projectsApi.getProjects();
    return response.data;
  }

  async createProject(data: CreateProjectRequest): Promise<Project> {
    const response = await this.projectsApi.createProject(data);
    return response.data;
  }

  async getProject(id: number): Promise<Project> {
    const response = await this.projectsApi.getProject(id);
    return response.data;
  }

  async updateProject(id: number, data: UpdateProjectRequest): Promise<Project> {
    const response = await this.projectsApi.updateProject(id, data);
    return response.data;
  }

  async deleteProject(id: number): Promise<void> {
    await this.projectsApi.deleteProject(id);
  }

  async getTasks(): Promise<Task[]> {
    const response = await this.tasksApi.getTasks();
    return response.data;
  }

  async createTask(data: CreateTaskRequest): Promise<Task> {
    const response = await this.tasksApi.createTask(data);
    return response.data;
  }

  async getTask(id: number): Promise<Task> {
    const response = await this.tasksApi.getTask(id);
    return response.data;
  }

  async updateTask(id: number, data: UpdateTaskRequest): Promise<Task> {
    const response = await this.tasksApi.updateTask(id, data);
    return response.data;
  }

  async deleteTask(id: number): Promise<void> {
    await this.tasksApi.deleteTask(id);
  }

  private setToken(token: string): void {
    this.token = token;
    localStorage.setItem('auth_token', token);
  }

  private clearToken(): void {
    this.token = null;
    localStorage.removeItem('auth_token');
  }

  getToken(): string | null {
    return this.token;
  }
}

export const apiClient = new ApiClient();
