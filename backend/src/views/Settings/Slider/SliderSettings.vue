<template>
  <div class="slider-wrapper">
    <div class="search-bar">
      <input
        v-model="search"
        @change="getProducts(null)"
        class="appearance-none relative w-full block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
        placeholder="Type to Search products"
      />
    </div>

    <div class="product-wrapper flex flex-flow-row mt-5">
      <div class="products-table">
        <table class="table-auto w-full">
          <thead>
            <tr>
              <TableHeaderCell field="actions">Product ID</TableHeaderCell>
              <TableHeaderCell field="actions">Product Name</TableHeaderCell>
              <TableHeaderCell field="actions">Image</TableHeaderCell>
              <TableHeaderCell field="actions">Category(s)</TableHeaderCell>
              <TableHeaderCell field="actions">Action</TableHeaderCell>
            </tr>
          </thead>
          <tbody v-if="products && products?.data">
            <tr v-for="(product, index) of products?.data" :key="index">
              <td class="border-b p-2">
                {{ product.id }}
              </td>
              <td class="border-b p-2">{{ product.title }}</td>

              <td class="border-b p-2">
                <span v-if="product.images.length > 0">
                  <img
                    v-for="img of product.images"
                    class="w-16 h-16 object-cover"
                    :src="img.image"
                    :alt="product.title"
                  />
                </span>
                <span v-else>Image Not Found</span>
              </td>

              <td class="border-b p-2">
                <div v-if="product.categories.length > 0">
                  <div v-for="(c, index) of product.categories">
                    <div v-for="(cat, i) of categories?.data">
                      <span v-if="c.category_id == cat.id">{{
                        index + 1 + ". " + cat.title
                      }}</span>
                    </div>
                  </div>
                </div>
                <div v-else>Categories not linked!</div>
              </td>
              <td>
                <button type="button" @click="addProduct(product)">
                  Add/Update Attributes
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <Spinner v-if="products.loading" />
        <div v-if="!products.loading">
          <div v-if="products.data.length">
            Showing from {{ products.from }} to {{ products.to }}
          </div>
          <nav
            v-if="products.total > products.limit"
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
            aria-label="Pagination"
          >
            <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
            <a
              v-for="(link, i) of products.links"
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
                i === products.links.length - 1 ? 'rounded-r-md' : '',
                !link.url ? ' bg-gray-100 text-gray-700' : '',
              ]"
              v-html="link.label"
            >
            </a>
          </nav>
        </div>
      </div>
      <div class="flex-flow-col features-list-wrapper">
        <div class="slider-product-list">
          <fieldset>
            <legend>Slider Product List</legend>
            <ul class="list-none">
              <li v-for="(product, index) of products?.data">
                <!-- {{ product.product_type[0] }} -->
                <span v-if="product.slider">
                  {{ (index += 1) + ". " + product.title }}
                </span>
              </li>
            </ul>
          </fieldset>
        </div>
        <div class="trending-product-list">
          <fieldset>
            <legend>Trending Product List</legend>
            <ul class="list-none">
              <li v-for="(product, index) of products?.data">
                <span v-if="product.trending">
                  {{ (index += 1) + ". " + product.title }}
                </span>
              </li>
            </ul>
          </fieldset>
        </div>
      </div>
    </div>
  </div>

  <SliderModal
    v-model="showSliderModal"
    :selectedProduct="productModel"
    :count="count"
    @close="onModalClose(e)"
  />
</template>

<script setup>
import { computed, ref, watch, onMounted, onUpdated } from "vue";
import store from "../../../store/index.js";
import TableHeaderCell from "../../../components/core/Table/TableHeaderCell.vue";
import { PRODUCTS_PER_PAGE } from "../../../constants";
import SliderModal from "./SliderModal.vue";
import Spinner from "../../../components/core/Spinner.vue";

const search = ref("");
const products = computed(() => store.state.products);
const showSliderModal = ref(false);
const count = ref({
  slider: 0,
  trending: 0,
});
const categories = computed(() => {
  return store.state.categories;
});
const perPage = ref(PRODUCTS_PER_PAGE);
const DEFAULT_Product = {
  id: "",
  title: "",
  slider_image: "",
  slider: false,
  trending: false,
  featured: false,
};
const productModel = ref({ ...DEFAULT_Product });

onMounted(async () => {
  await getProducts();
  getCategories();
});

async function getProducts(url = null) {
  await store.dispatch("products/getProducts", {
    url,
    search: search.value,
    per_page: perPage.value,
  });
}

async function getCategories() {
  await store.dispatch("categories/getCategories");
}

function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }

  getProducts(link.url);
}

function showSliderAddModal() {
  showSliderModal.value = true;
}

function addProduct(product) {
  productModel.value = product;
  showSliderAddModal();
}

function onModalClose(e) {
  productModel.value = { ...DEFAULT_Product };
  showSliderModal.value = false;
}
</script>

<style scoped>
button[type="button"] {
  padding: 0.5rem 1rem 0.5rem 1rem;
  border: 1px transparent;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 500;

  margin-bottom: 5px;
  position: relative;
}

button[type="button"]:hover {
  background-color: rgb(67, 56, 202);
  transition: all ease 0.23s;
}

button[type="button"]:active {
  transform: scale(0.95);
}

fieldset {
  border: 1px solid lightgrey;
  padding: 1.75rem;
}

legend {
  padding: 5px;
  margin-left: 0.1rem;
}

legend,
button[type="button"] {
  border-radius: 6px;
  color: white;
  background-color: rgb(79, 70, 229);
}

.slider-wrapper {
  padding: 2rem;
}

.search-bar {
  width: 30%;
}

.products-table {
  width: 60%;
}

.slider-product-list,
.trending-product-list {
  height: 50%;
  padding: 0.75rem;
}

.slider-product-list h2,
.trending-product-list h2 {
  font-weight: 600;
}

.features-list-wrapper {
  margin: 0 auto;
}
</style>
