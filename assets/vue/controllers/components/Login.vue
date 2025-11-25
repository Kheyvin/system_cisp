<template>
  <section class="flex flex-col justify-center items-center min-h-screen p-5">
    <div class="mb-8 text-center">
      <img src="/images/sistema_isp/logoConectica.png" alt="Logo" class="mx-auto w-48 sm:w-64" />
    </div>

    <div class="w-full max-w-md bg-white rounded-xl p-10 shadow-lg">
      <form @submit.prevent="login">
        <div class="text-center mb-8">
          <div class="flex justify-center items-center bg-[#15B8A6] w-20 h-20 rounded-full mx-auto mb-4">
            <i class="fas fa-key text-white text-3xl"></i>
          </div>
          <p class="text-2xl font-semibold text-gray-700">Acceso al Sistema</p>
          <p class="text-sm text-gray-500">Ingresa tus credenciales para continuar</p>
        </div>

        <div class="mb-6">
          <label for="username" class="block text-sm font-medium text-black mb-2">Usuario</label>
          <input 
            id="username"
            type="text" 
            placeholder="Ingrese su usuario"
            v-model="username" 
            required
            class="w-full p-3 bg-gray-100 border-2 border-gray-100 rounded-lg focus:outline-none"
          />
        </div>

        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-black mb-2">Contraseña</label>
          <div class="relative">
            <input 
              id="password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Ingrese su contraseña"
              v-model="password" 
              required 
              class="w-full p-3 border-2 bg-gray-100 border-gray-100 rounded-lg focus:outline-none"
            />
            <i @click="togglePasswordVisibility" 
               :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" 
               class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer"></i>
          </div>
        </div>

        <button type="submit" :disabled="loading" 
                class="w-full p-3 bg-[#15B8A6] text-white rounded-lg font-semibold transition-colors">
          {{ loading ? 'Iniciando sesión...' : 'Iniciar Sesión' }}
        </button>

        <p v-if="errorMessage" class="text-red-500 text-center mt-8">{{ errorMessage }}</p>
      </form>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import { authStore } from '../store/auth';
import { useRouter } from 'vue-router';

const authStorage = authStore();
const router = useRouter();

const username = ref('');
const password = ref('');
const loading = ref(false);
const errorMessage = ref('');
const showPassword = ref(false);

const login = async () => {
  loading.value = true;
  errorMessage.value = '';

  try {
    await authStorage.login(username.value, password.value);

    if (authStorage.isAuthenticated) {
      router.push({ name: 'Dashboard' });
    } else {
      errorMessage.value = 'Usuario o contraseña incorrectos';
    }
  } catch (error) {
    console.error('Error al iniciar sesión:', error);
    errorMessage.value = 'Ha ocurrido un error al intentar iniciar sesión';
  } finally {
    loading.value = false;
  }
};

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};
</script>

<style scoped>
</style>
