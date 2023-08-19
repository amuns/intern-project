<template>
  <Spinner
    v-if="products.loading"
    class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"
  />
  <div class="featured-wrapper">
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
                <button type="button" @click="addFeaturedProduct(product)">
                  Make Featured
                </button>
              </td>
            </tr>
          </tbody>
        </table>

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

      <div class="featured-product-wrapper">
        <div class="slider-product-list">
          <fieldset>
            <legend>Featured Product</legend>
            <ul class="list-none">
              <li>
                <div v-if="featured[0]">
                  Featured Product:
                  <span class="font-semibold">{{ featured[0].title }}</span>
                  <br><br>
                  <button type="button" @click="editFeaturedProduct(featured[0])">Update</button>
                </div>
                <div v-else> Product not featured yet! </div>
              </li>
            </ul>
          </fieldset>
        </div>
      </div>
    </div>
  </div>

  <FeaturedModal
    v-model="showSliderModal"
    :selectedProduct="productModel"
    @close="onModalClose(e)"
  />
</template>

<script setup>
import { computed, ref, watch, onMounted, onUpdated } from "vue";
import store from "../../../store/index.js";
import TableHeaderCell from "../../../components/core/Table/TableHeaderCell.vue";
import { PRODUCTS_PER_PAGE } from "../../../constants";
import FeaturedModal from "./FeaturedModal.vue";
import Spinner from "../../../components/core/Spinner.vue";

const search = ref("");
const products = computed(() => store.state.products);
const featured = ref({});
const showSliderModal = ref(false);
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
  feature: false,
};
const productModel = ref({ ...DEFAULT_Product });

onMounted(async () => {
  await getProducts();
  getCategories();
});

async function getProducts(url = null) {
  await store
    .dispatch("products/getProducts", {
      url,
      search: search.value,
      per_page: perPage.value,
    })
    .then(() => {
      featured.value = products.value.data.filter(
        (product) => product.featured == 1
      );
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

function addFeaturedProduct(product) {
  // console.log(featured.value); return
  // console.log(Object.keys(featured.value).length); return
  if (Object.keys(featured.value).length >= 1) {
    store.dispatch("toast/enableErrorToast", "Featured Product exists!");
  } else {
    productModel.value = product;
    showSliderAddModal();
  }
}

function editFeaturedProduct(product){
  // console.log(product); return 
  productModel.value = product;
  showSliderAddModal();
}

async function onModalClose(e) {
  productModel.value = { ...DEFAULT_Product };
  showSliderModal.value = false;
  await getProducts();
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

.featured-wrapper {
  padding: 3rem;
}

.products-table {
  width: 60%;
}

.search-bar {
  width: 30%;
}

.featured-product-wrapper {
  margin: 0 auto;
  width: 40%;
  padding: 0 2rem 0 2rem;
}
</style>
