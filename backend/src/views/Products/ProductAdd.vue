<template>
  <Spinner
    v-if="loading"
    class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"
  />
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-serif font-semibold">Add Product</h1>
    <router-link :to="{ name: 'app.products.all' }">
      <span
        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Back
      </span>
    </router-link>
  </div>
  <form @submit.prevent="onSubmit">
    <div class="flex flex-cols-2 gap-8 justify-center">
      <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <CustomInput
          type="text"
          class="mb-2"
          label="*Product Title"
          v-model="product.title"
        />

        <br />

        <label for="Description">
          <span
            class="font-serif text-gray-400 underline-offset-8 align-top text-l"
            >Description</span
          ></label
        >
        <Editor v-model="product.description" />
        <br />
        <CustomInput
          type="number"
          class="mb-2"
          label="*Price"
          prepend="NPR"
          v-model="product.price"
        />
      </div>

      <div class="">
        <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down h-2/5">
          <p
            class="font-serif text-center text-gray-400 underline-offset-8 align-top text-xl"
          >
            Categories
          </p>
          <label v-for="category in catList?.data" :key="category.id">
            <input
              type="checkbox"
              class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              :value="category.id"
              v-model="selectedCategories"
            />
            <span class="font-serif ml-2">{{ category.title }}</span> <br />
          </label>
        </div>

        <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down mt-6">
          <CustomInput
            type="text"
            class="mb-2"
            label="Product Size"
            v-model="product.size"
          />

          <CustomInput
            type="text"
            class="mb-2"
            label="Warranty"
            v-model="product.warranty"
          />

          <CustomInput
            type="text"
            class="mb-2"
            label="Product Color"
            v-model="product.color"
          />

          <CustomInput
            type="text"
            class="mb-2"
            label="Product Material"
            v-model="product.material"
          />

          <CustomInput
            type="textarea"
            class="mb-2"
            label="Delivery Description"
            v-model="product.delivery_description"
          />
        </div>
      </div>
    </div>

    <div class="bg-white p-4 mt-3 mb-2 rounded-lg shadow animate-fade-in-down">
      <div class="flex justify-between border-b-2 pb-3">
        <div class="flex items-center">
          <input
            type="file"
            ref="imageFile"
            multiple="multiple"
            @change="selectedImageFile($event)"
            hidden
            accept="image/*"
          />

          <div
            class="mx-auto max-w-2xl py-16 px-4 sm:py-5 sm:px-6 lg:max-w-7xl lg:px-8"
            v-if="images.length > 0"
          >
            <div
              class="mt-6 grid grid-cols-1 gap-y-12 gap-x-8 sm:grid-cols-2 lg:grid-cols-5 xl:gap-x-10"
            >
              <div class="group relative" v-for="(image, index) in images">
                <div
                  class="min-h-40 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-71"
                >
                  <button type="button" @click="removeImage(index)">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-6 h-6"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </button>
                  <img
                    v-if="image"
                    :src="image"
                    class="w-50 h-100 object-cover"
                    alt=""
                  />
                </div>
              </div>
            </div>
            &#160; <br />
            <button
              type="button"
              @click="imageFile.click()"
              class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Add More Image
            </button>
          </div>
          <div v-else>
            <button
              type="button"
              @click="imageFile.click()"
              class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Add Image
            </button>
          </div>
        </div>
      </div>
    </div>

    <footer
      class="bg-gray-50 px-4 py-3 rounded-md sm:px-6 sm:flex sm:flex-row-reverse space-x-40 content-center ..."
    >
      <div class="flex-row mt-3 justify-center order-1">
        <input
          type="checkbox"
          class="mb-2 w-4 h-4 align-baseline text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
          label="Published"
          v-model="product.published"
        />
        <label class="font-serif ml-1 align-top" for="Published"
          >Published</label
        >
      </div>
      <button
        type="submit"
        class="mt-3 ml-24 w-50 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
      >
        Confirm
      </button>
    </footer>
  </form>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import Editor from "../../components/Editor.vue";
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";

const catList = ref([]);
const selectedCategories = ref([]);
const loading = ref(false);
const product = ref({});
const file = ref({});
const imageFile = ref(null);
const images = ref([]);
const selectedImages = ref([]);

function selectedImageFile(e) {
  const file = e.target.files;

  for (let i = 0; i < file.length; i++) {
    images.value.push(URL.createObjectURL(file[i]));
    selectedImages.value.push(file[i]);
  }
}

onMounted(() => {
  store
    .dispatch("categories/getCategories")
    .then(() => {
      catList.value = store.state.categories;
    })
    .catch((err) => {
      console.log(err);
    });
});

function removeImage(index) {
  images.value.splice(index, 1);
  selectedImages.value.splice(index, 1);
  // console.log(images.value);
}

function onSubmit() {
  product.value.images = selectedImages.value;
  product.value.categories = selectedCategories.value;

  loading.value = true;
  store
    .dispatch("products/createProduct", product.value)
    .then((response) => {
      loading.value = false;
      if (response.status === 201) {
        // TODO show notification
        store.dispatch("products/getProducts");
        store.dispatch(
          "toast/enableSuccessToast",
          "Product created successfully!"
        );
      } else {
        store.dispatch("toast/enableErrorToast", "Data Mismatch!");
      }
    })
    .catch((err) => {
      loading.value = false;
      store.dispatch("toast/enableErrorToast", "Data Mismatch!");
    });
}
</script>

<style scoped>
button[type="submit"] {
  padding: 0.5rem;
  border: 1px transparent;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 500;
  border-radius: 6px;
  color: white;
  margin-bottom: 5px;
  background-color: rgb(79, 70, 229) !important;
  transition: all 0.23s ease-in-out;
}

button[type="submit"]:hover {
  background-color: rgb(67, 56, 202) !important;
  transition: all ease 0.23s;
}

button:active {
  transform: scale(0.95);
}
</style>
