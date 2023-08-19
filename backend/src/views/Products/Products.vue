<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Products</h1>
    <router-link :to="{ name: 'app.products.add' }">
      <span class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add</span>
    </router-link>
    
  </div>
  <ProductsTable/>
  <!-- v-model="showProductModal" -->
  <!-- <ProductAdd
  /> -->
  <!-- :product="productModel" -->
    <!-- @close="onModalClose" -->
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import store from "../../store";
import ProductAdd from "./ProductAdd.vue";
import ProductsTable from "./ProductsTable.vue";

const DEFAULT_PRODUCT = {
  id: "",
  title: "",
  description: "",
  image: "",
  price: "",
  categories: [],
};

const products = computed(() => store.state.products);




/* function editProduct(p) {
  store.dispatch("getProduct", p.id).then(({ data }) => {
    // console.log(data);return;
    productModel.value = data;
    showAddNewModal();
  });
}
 */

</script>

<style scoped></style>
