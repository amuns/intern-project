<template>
  <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
    <div class="flex justify-between border-b-2 pb-3">
      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Per Page</span>
        <select
          @change="getProducts(null)"
          v-model="perPage"
          class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
        >
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <span class="ml-3">Found {{ testimonials?.total }} testimonials</span>
      </div>
      <div>
        <input
          v-model="search"
          @change="getProducts(null)"
          class="appearance-none relative block w-64 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
          placeholder="Type to Search testimonials"
        />
      </div>
    </div>

    <table class="table-auto w-full">
      <thead>
        <tr>
          <TableHeaderCell
            field="id"
            :sort-field="sortField"
            :sort-direction="sortDirection"
            @click="sortTestimonials('id')"
          >
            ID
          </TableHeaderCell>
          <TableHeaderCell
            field="image"
          >
            Image
          </TableHeaderCell>
          <TableHeaderCell
            field="fullname"
            :sort-field="sortField"
            :sort-direction="sortDirection"
            @click="sortTestimonials('fullname')"
          >
            Fullname
          </TableHeaderCell>

          <TableHeaderCell
            field="feedback"
            :sort-field="sortField"
            :sort-direction="sortDirection"
            @click="sortTestimonials('feedback')"
            >
            Feedback
          </TableHeaderCell>

          <TableHeaderCell
            field="updated_at"
            :sort-field="sortField"
            :sort-direction="sortDirection"
            @click="sortProducts('updated_at')"
          >
            Last Updated At
          </TableHeaderCell>
          <TableHeaderCell field="actions"> Actions </TableHeaderCell>
        </tr>
      </thead>
      <tbody v-if="testimonials?.loading || !testimonials?.data.length">
        <tr>
          <td colspan="5">
            <Spinner v-if="testimonials.loading" />
            <p v-else class="text-center py-8 text-gray-700">
              There are no testimonials
            </p>
          </td>
        </tr>
      </tbody>
      <!-- {{
          testimonials
        }} -->
      <tbody v-if="testimonials && testimonials?.data">
        <tr v-for="(testimonial, index) of testimonials?.data" :key="index">
          <td class="border-b p-2">{{ testimonial.id }}</td>
          <td class="border-b p-2">
            <img
              class="w-16 h-16 object-cover"
              :src="testimonial.display_picture"
              alt="404 Not found"
            />
          </td>
          <td
            class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis"
          >
            {{ testimonial.fullname }}
          </td>

          <td
            class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis"
          >
            {{ testimonial.feedback }}
          </td>

          <td class="border-b p-2">
            {{ testimonial.updated_at }}
          </td>
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
                      <router-link :to="{ path: 'edit/' + testimonial.id }">
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
                        @click="deleteTestimonial(testimonial)"
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

    <div
      v-if="!testimonials.loading"
      class="flex justify-between items-center mt-5"
    >
      <div v-if="testimonials.data.length">
        Showing from {{ testimonials.from }} to {{ testimonials.to }}
      </div>
      <nav
        v-if="testimonials.total > testimonials.limit"
        class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
        aria-label="Pagination"
      >
        <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
        <a
          v-for="(link, i) of testimonials.links"
          :key="i"
          :disabled="!link.url"
          href="#"
          @click="getForPage($event, link)"
          aria-current="page"
          class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
          :class="[
            link.active
              ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
              : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
            i === 0 ? 'rounded-l-md' : '',
            i === testimonials.links.length - 1 ? 'rounded-r-md' : '',
            !link.url ? ' bg-gray-100 text-gray-700' : '',
          ]"
          v-html="link.label"
        >
        </a>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import store from "../../store";
import Spinner from "../../components/core/Spinner.vue";
import { TESTIMONIALS_PER_PAGE } from "../../constants";
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import {
  DotsVerticalIcon,
  PencilIcon,
  TrashIcon,
} from "@heroicons/vue/outline";

const perPage = ref(TESTIMONIALS_PER_PAGE);
const search = ref("");
const sortField = ref("updated_at");
const sortDirection = ref("desc");

const testimonials = computed(() => store.state.testimonials);

getTestimonials();

function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }

  getProducts(link.url);
}

async function getTestimonials(url = null) {
  await store.dispatch("testimonials/getTestimonials", {
    url,
    search: search.value,
    per_page: perPage.value,
    sort_field: sortField.value,
    sort_direction: sortDirection.value,
  });
}

function sortTestimonials(field) {
  if (field === sortField.value) {
    if (sortDirection.value === "desc") {
      sortDirection.value = "asc";
    } else {
      sortDirection.value = "desc";
    }
  } else {
    sortField.value = field;
    sortDirection.value = "asc";
  }

  getTestimonials();
}

function deleteTestimonial(testimonial) {
  let arr = [];
  let urlValues = [];

  if (!confirm(`Are you sure you want to delete the product?`)) {
    return;
  }

  if (testimonial.display_picture == null) {
    urlValues['id'] = testimonial.id;
    urlValues['path'] = null;
    // console.log(testimonial.id); return
    store.dispatch("testimonials/deleteTestimonial", urlValues).then((res) => {
      // TODO Show notification
      store.dispatch("testimonials/getTestimonials");
    });
  } else {
    arr = testimonial.display_picture.split("/");
    urlValues['id'] = testimonial.id;
    urlValues['path'] = arr[5];
    // console.log(arr[5]); return;
    store.dispatch("testimonials/deleteTestimonial", urlValues).then((res) => {
      // TODO Show notification
      store.dispatch("testimonials/getTestimonials");
    });
  }
}
</script>
