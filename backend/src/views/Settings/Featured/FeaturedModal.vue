<template>
  <TransitionRoot as="template" :show="show">
    <Dialog as="div" class="relative z-10" @close="show = false">
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity" />
      </TransitionChild>

      <div class="fixed z-10 inset-0 overflow-y-auto">
        <div
          class="flex items-end sm:items-center justify-center min-h-full p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full"
            >
              <Spinner
                v-if="loading"
                class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"
              />
              <header class="py-3 px-4 flex justify-between items-center">
                <DialogTitle
                  as="h3"
                  class="text-lg leading-6 font-medium text-gray-900"
                >
                  {{
                    props.selectedProduct.id
                      ? "Make/Update " +
                        props.selectedProduct.title +
                        " as Featured Product?"
                      : ""
                  }}
                </DialogTitle>
                <button
                  @click="closeModal()"
                  class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </header>
              <form @submit.prevent="onSubmit">
                <div class="bg-white px-4 pt-5 pb-4">
                  <div v-if="product.id">
                    <CustomInput
                      type="file"
                      class="mb-2"
                      label="slider_image"
                      @change="addSliderImage($event)"
                    />

                    <div v-if="displayImage && product.slider_image">
                      <img :src="displayImage" />
                    </div>
                    <div v-else-if="displayImage">
                      <img :src="displayImage" />
                    </div>
                    <div v-else-if="product.slider_image">
                      <img :src="product.slider_image" />
                    </div>
                    <div v-else>
                      <span class="text-gray-400">Please select an Image!</span>
                    </div>
                    <br />
                  </div>

                  <input
                    v-model="productFeature.featured"
                    type="checkbox"
                    id="slider"
                    :checked="product.featured"
                  />
                  <label for="slider">Featured</label>
                </div>
                <footer
                  class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                >
                  <button
                    type="submit"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
                  >
                    Submit
                  </button>
                  <button
                    type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    @click="closeModal"
                    ref="cancelButtonRef"
                  >
                    Cancel
                  </button>
                </footer>
              </form>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import CustomInput from "../../../components/core/CustomInput.vue";
import store from "../../../store/index.js";
import Spinner from "../../../components/core/Spinner.vue";

const loading = ref(false);
const productFeature = ref({});
const displayImage = ref("");
const product = ref({
  id: props.selectedProduct.id,
  title: props.selectedProduct.title,
  slider_image: props.selectedProduct.slider_image,
  featured: props.selectedProduct.featured,
  slider: props.selectedProduct.slider,
  trending: props.selectedProduct.trending,
});
const props = defineProps({
  modelValue: Boolean,
  selectedProduct: {
    required: true,
    type: Object,
  },
  //   count: {
  //     required: true,
  //     type: Object,
  //   },
});

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});

const emit = defineEmits(["update:modelValue", "close"]);

onUpdated(() => {
  product.value = {
    id: props.selectedProduct.id,
    title: props.selectedProduct.title,
    slider_image: props.selectedProduct.slider_image,
    featured: props.selectedProduct.featured,
    slider: props.selectedProduct.slider,
    trending: props.selectedProduct.trending,
  };

  /* count.value = {
    slider: props.count.slider,
    trending: props.count.trending,
  }; */
});

function closeModal() {
  show.value = false;
  displayImage.value = "";
  productFeature.value = {};
  emit("close");
}

function onSubmit() {
  // console.log(Object.keys(productFeature.value).length);
  //   console.log(productFeature.value); return

  if (Object.keys(productFeature.value).length > 0) {
    productFeature.value.product_id = product.value.id;
    
    if(!Object.keys(productFeature.value).includes('slider')){
      productFeature.value.slider = product.value.slider??0;
    }

    if(!Object.keys(productFeature.value).includes('trending')){
      productFeature.value.trending = product.value.trending??0;
    }

    if(!Object.keys(productFeature.value).includes('featured')){
      productFeature.value.featured = product.value.featured??0;
    }

    if(!Object.keys(productFeature.value).includes('slider_image')){
      productFeature.value.slider_image = displayImage.value;
    }
    // console.log(productFeature.value); return

    store
      .dispatch("sliders/createSlider", productFeature.value)
      .then(async (res) => {
        if (res.status === 201) {
          store.dispatch(
            "toast/enableSuccessToast",
            "Feature added to product!"
          );
          closeModal();
        }

        if(res.status === 200){
          store.dispatch(
            "toast/enableSuccessToast",
            "Featured Product updated!"
          );
          closeModal();
        }
      })
      .catch((err) => {
        store.dispatch("toast/enableWarningToast", "Image is missing!");
        closeModal();
      });
  } else {
    console.log(productFeature.value);
    store.dispatch("toast/enableErrorToast", "No changes to be saved!");
  }
}
</script>

<style scoped>
button[type] {
  padding: 0.5rem 1rem 0.5rem 1rem;
  border: 1px transparent;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 500;
  border-radius: 6px;
  color: white;
  background-color: rgb(79, 70, 229);
  margin-bottom: 5px;
  position: relative;
  top: -1.5px;
}

button[type]:hover {
  background-color: rgb(67, 56, 202);
  transition: all ease 0.23s;
}

button[type]:active {
  transform: scale(0.95);
}
</style>
