<script setup></script>

<template>
  <div>
    <div class="grid gap-3 grid-cols-3">
      <div class="router-link col-span-2 grid grid-cols-2 gap-3">
        <router-link
          :to="{ name: 'page_settings.overview' }"
          class="bg-white py-2 px-3 text-gray-700 rounded-md text-center"
          active-class="text-indigo-600 bg-indigo-50"
          >Overview
        </router-link>
        <router-link
          :to="{ name: 'page_settings.menu' }"
          class="bg-white py-2 px-3 text-gray-700 rounded-md text-center"
          active-class="text-indigo-600 bg-indigo-50"
          >Group Pages
        </router-link>
      </div>
    </div>
  </div>

  <div class="container bg-white p-3 rounded-md mt-3 shadow-md">
    <router-view></router-view>
  </div>
</template>

<style scoped>
.router-link * {
  transition: all 0.3s ease-in;
}

.router-link *:hover {
  text-decoration: underline;
}
</style>
