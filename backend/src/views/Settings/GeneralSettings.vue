<template>
  <div class="router-link grid gap-3 grid-cols-5">
    <router-link
      :to="{ name: 'general.header' }"
      class="nav-text"
      active-class="text-indigo-600 bg-indigo-50"
      >Header Settings
    </router-link>

    <router-link
      :to="{ name: 'general.banner' }"
      class="nav-text"
      active-class="text-indigo-600 bg-indigo-50"
      >Banner Settings
    </router-link>
    <router-link
      :to="{ name: 'general.featured' }"
      class="nav-text"
      active-class="text-indigo-600 bg-indigo-50"
      >Featured Settings
    </router-link>
    <router-link
      :to="{ name: 'general.slider.settings' }"
      class="nav-text"
      active-class="text-indigo-600 bg-indigo-50"
      >Product Features
    </router-link>
    <router-link
      :to="{ name: 'general.script' }"
      class="nav-text"
      active-class="text-indigo-600 bg-indigo-50"
      >Script Settings
    </router-link>
  </div>

  <div class="settings-content">
    <router-view />
  </div>
</template>

<style scoped>
.settings-content {
  background-color: rgb(255 255 255 / var(--tw-bg-opacity));
  border-radius: 6px;
  --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
  --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color),
    0 2px 4px -2px var(--tw-shadow-color);
  box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000),
    var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
  padding: 0.75rem;
  margin-top: 2rem;
}
</style>
