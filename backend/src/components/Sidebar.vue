<template>
  <div
    class="min-w-[160px] w-[160px] transition-all bg-indigo-700 text-white py-4 px-2"
  >
    <router-link
      :to="{ name: 'app.dashboard' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <HomeIcon class="w-5" />
      </span>
      <span class="text-xs"> Dashboard </span>
    </router-link>
    <router-link
      :to="{ name: 'app.products.all' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5" />
      </span>
      <span class="text-xs"> Products </span>
    </router-link>
    <router-link
      :to="{ name: 'app.categories' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5" />
      </span>
      <span class="text-xs"> Categories </span>
    </router-link>
    <router-link
      :to="{ name: 'app.orders' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5" />
      </span>
      <span class="text-xs"> Orders </span>
    </router-link>

    <router-link
      :to="{ name: 'app.testimonials.all' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5" />
      </span>
      <span class="text-xs"> Testimonials </span>
    </router-link>

    <router-link
      :to="{ name: 'page_settings.overview' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5" />
      </span>
      <span class="text-xs"> Pages </span>
    </router-link>

    <router-link
      :to="{ name: 'app.users' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <UsersIcon class="w-5" />
      </span>
      <span class="text-xs"> Users </span>
    </router-link>
    <router-link
      :to="{ name: 'app.customers' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <UserGroupIcon class="w-5" />
      </span>
      <span class="text-xs"> Customers </span>
    </router-link>
    <router-link
      :to="{ name: 'reports.orders' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30"
    >
      <span class="mr-2 text-gray-300">
        <ChartBarIcon class="w-5" />
      </span>
      <span class="text-xs"> Reports </span>
    </router-link>

    <div class="dropdown p-2 rounded transition-colors hover:bg-black/30">
      <button
        x-model="show"
        v-on:click="changeStatus"
        class="dropbtn flex items-center"
      >
        <span class="mr-2 text-gray-300">
          <CogIcon class="w-5" />
        </span>
        <span class="text-xs"> Settings </span>
        <Transition name="arrowChange">
          <span v-if="!show" class="ml-10 text-gray-300">
            <ArrowSmDownIcon class="w-5" />
          </span>
          <span v-else class="ml-10 text-gray-300">
            <ArrowSmUpIcon class="w-5" />
          </span>
        </Transition>
      </button>
      <div
        v-if="show"
        id="myDropdown"
        class="dropdown-content grid grid-flow-row"
      >
        <router-link
          :to="{ name: 'general.header' }"
          class="flex items-center mt-2 ml-2 rounded transition-colors hover:bg-black/30"
        >
          <span class="mr-2 text-gray-300">
            <DatabaseIcon class="w-5" />
          </span>
          <span class="text-xs"> General Settings </span>
        </router-link>

        <router-link
          :to="{ name: 'settings.shipping-charges' }"
          class="flex items-center mt-2 ml-2 rounded transition-colors hover:bg-black/30"
        >
          <span class="mr-2 text-gray-300">
            <DatabaseIcon class="w-5" />
          </span>
          <span class="text-xs"> Shipping Charge </span>
        </router-link>

        <router-link
          :to="{ name: 'settings.social-media' }"
          class="flex items-center mt-2 ml-2 rounded transition-colors hover:bg-black/30"
        >
          <span class="mr-2 text-gray-300">
            <DatabaseIcon class="w-5" />
          </span>
          <span class="text-xs"> Social Media </span>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import {
  HomeIcon,
  UserGroupIcon,
  UsersIcon,
  ViewListIcon,
  ChartBarIcon,
  DatabaseIcon,
  CogIcon,
  ArrowSmDownIcon,
  ArrowSmUpIcon,
} from "@heroicons/vue/outline";

const show = ref(false);

function changeStatus() {
  if (show.value == false) {
    show.value = true;
  } else {
    show.value = false;
  }
}
</script>

<style scoped>
/* .dropdown-content {
  display: none;
} */
.arrowChange-enter-active {
  transition: 0.23s ease-in-out;
}

.arrowChange-enter-from,
.arrowChange-leave-to {
  opacity: 0;
}
</style>
