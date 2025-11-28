<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <Sidebar :isOpen="isSidebarOpen" @logout="handleLogout" />

    <!-- Main Content -->
    <div
      class="flex-1 flex flex-col transition-all duration-300"
      :class="isSidebarOpen ? 'ml-64' : 'ml-20'"
    >
      <Header :isSidebarOpen="isSidebarOpen" @toggle-sidebar="toggleSidebar" />

      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Sidebar from '../organisms/Sidebar.vue';
import Header from '../organisms/Header.vue';
// import { authStore } from '../../../store/auth'; // Adjust path as needed

const isSidebarOpen = ref(true);
const router = useRouter();
// const store = authStore();

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const handleLogout = () => {
  // store.logout();
  console.log('Logging out...');
  router.push('/login');
};
</script>
