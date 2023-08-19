<template>
  <div class="mt-10">
    <table class="table-auto w-full">
      <thead>
        <tr>
          <TableHeaderCell field="id">ID</TableHeaderCell>
          <TableHeaderCell field="menu">Page Title</TableHeaderCell>
          <TableHeaderCell field="submenu">Page Content</TableHeaderCell>
          <TableHeaderCell field="submenu">Meta Title</TableHeaderCell>
          <TableHeaderCell field="submenu">Meta Description</TableHeaderCell>
          <TableHeaderCell field="submenu">Keywords</TableHeaderCell>
          <TableHeaderCell field="submenu">Last Updated At</TableHeaderCell>
          <TableHeaderCell field="submenu">Actions</TableHeaderCell>
        </tr>
      </thead>
      <tbody v-if="pages?.loading || !pages?.data.length">
        <tr>
          <td colspan="7">
            <Spinner v-if="pages.loading" />
            <p v-else class="text-center py-8 text-gray-700">
              There are no Pages!
            </p>
          </td>
        </tr>
      </tbody>

      <tbody v-else>
        <tr v-for="(page, index) of pages?.data" :key="index">
            <td class="border-b p-2">{{ page.id }}</td>
            <td class="border-b p-2">{{ page.title }}</td>
            <td class="border-b p-2" v-html="page.body"></td>
            <td class="border-b p-2">{{ page.meta_title }}</td>
            <td class="border-b p-2">{{ page.meta_description }}</td>
            <td class="border-b p-2">{{ page.keywords }}</td>
            <td class="border-b p-2">{{ page.updated_at }}</td>
            
            <td class="border-b p-2">
            <Menu as="div" class="relative inline-block text-left">
              <div>
                <MenuButton
                  class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                >
                  <DotsVerticalIcon
                    class="h-5 w-5 text-indigo-500"
                    aria-hidden="true"
                  />
                </MenuButton>
              </div>

              <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
              >
                <MenuItems
                  class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                      <router-link :to="{ path: 'edit/' + page.id }">
                        <button
                          :class="[
                            active
                              ? 'bg-indigo-600 text-white'
                              : 'text-gray-900',
                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                          ]"
                        >
                          <PencilIcon
                            :active="active"
                            class="mr-2 h-5 w-5 text-indigo-400"
                            aria-hidden="true"
                          />
                          Edit
                        </button>
                      </router-link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                      <button
                        :class="[
                          active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                          'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                        ]"
                        @click="deleteMenu(page)"
                      >
                        <TrashIcon
                          :active="active"
                          class="mr-2 h-5 w-5 text-indigo-400"
                          aria-hidden="true"
                        />
                        Delete
                      </button>
                    </MenuItem>
                  </div>
                </MenuItems>
              </transition>
            </Menu>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script setup>
import { computed, onBeforeMount, onMounted, ref, onUpdated, watch } from "vue";
import store from "../../store";
import Spinner from "../../components/core/Spinner.vue";
import { PRODUCTS_PER_PAGE } from "../../constants";
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import {
  DotsVerticalIcon,
  PencilIcon,
  TrashIcon,
} from "@heroicons/vue/outline";

getPages();

const pages = computed(() => {
  return store.state.pages;
});


async function getPages(url = null) {
  await store.dispatch("pages/getPages", {
    url,
  });
  // console.log(pages.value);
}

function deleteMenu(page) {
  if (!confirm(`Are you sure you want to delete the Menu?`)) {
    return;
  }
  store.dispatch("pages/deletePage", page.id).then((res) => {
    // TODO Show notification
    store.dispatch("pages/getPages");
  });
}

</script>

<style scoped></style>
