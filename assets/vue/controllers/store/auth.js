import { defineStore } from 'pinia'
import axios from './token'

export const authStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || null,
    user: null,
    userId: null,
    message: '',
  }),
  
  getters: {
    isAuthenticated: (state) => !!state.token && !!state.user,
  },
  
  actions: {
    async login(username, password) {
      try {
        const { data } = await axios.post('/login_check', { username, password });
        this.setToken(data.token);
        await this.fetchUser();
        
      } catch (error) {
        // Manejo de errores mejorado
        if (error.response) {
          // Si el error viene de la respuesta de la API
          if (error.response.status === 401) {
            // Error 401: No autorizado (credenciales incorrectas)
            this.message = 'Credenciales incorrectas. Por favor, verifica tu correo y contraseña.';
          } else if (error.response.status === 404) {
            // Error 404: Usuario no encontrado (correo no registrado)
            this.message = 'El correo ingresado no está registrado. Por favor, verifica e intenta nuevamente.';
          } else {
            // Otros errores
            this.message = 'Ha ocurrido un error. Por favor, intenta de nuevo más tarde.';
          }
          console.error('Error de respuesta:', message.value);
        }
    
        this.handleError(error, 'Login failed');
      }
    },

    async fetchUser() {
      try {
        const { data } = await axios.get('/auth/user');
        this.user = data.user;
        console.log('Usuario autenticado:', this.user);
      } catch (error) {
        this.handleError(error, 'Fetching user failed');
        this.logout();
      }
    },

    logout() {
      this.clearToken();
      this.user = null;
    },

    async checkAuth() {
      if (this.token) {
        await this.fetchUser();
      }
    },

    setToken(token) {
      this.token = token;
      localStorage.setItem('token', token);
    },

    clearToken() {
      this.token = null;
      localStorage.removeItem('token');
    },

    handleError(error, defaultMessage) {
      const message = error?.response?.data?.message || defaultMessage;
      console.error(message);
    }
  }
});
