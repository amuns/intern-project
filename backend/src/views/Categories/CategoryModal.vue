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
          class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0"
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
                    category.id
                      ? `Update category: "${props.category.title}"`
                      : "Create new Category"
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
                  <CustomInput
                    class="mb-2"
                    v-model="category.title"
                    label="Category Title"
                  />
                  <CustomInput
                    type="file"
                    class="mb-2"
                    label="Category Image"
                    @change="addImage($event)"
                  />
                  <div v-if="displayImage">
                    <img
                      class="w-16 h-16 object-cover"
                      :src="displayImage"
                    />
                  </div>

                  <CustomInput
                    type="textarea"
                    class="mb-2"
                    v-model="category.description"
                    label="Description"
                  />
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
import { computed, onUpdated, ref } from "vue";
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { ExclamationIcon } from "@heroicons/vue/outline";
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";

const category = ref({
  id: props.category.id,
  title: props.category.title,
  image: props.category.image,
  // image_url: props.category.image_url,
  description: props.category.description,
});
const loading = ref(false);

const props = defineProps({
  modelValue: Boolean,
  category: {
    required: true,
    type: Object,
  },
});
const displayImage = ref("");

const emit = defineEmits(["update:modelValue", "close"]);

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});

onUpdated(() => {
  category.value = {
    id: props.category.id,
    title: props.category.title,
    image: props.category.image,
    // image_url: props.category.image_url,
    description: props.category.description,
  };

  displayImage.value = props.category.image_url;

  // console.log(category);
});

function addImage(e){
  // console.log(e);
  const file = e;
  displayImage.value = URL.createObjectURL(file);
  category.value.image = file;
}

function closeModal() {
  show.value = false;
  emit("close");
}

function onSubmit() {
  loading.value = true;
  if (category.value.id) {
    store
      .dispatch("categories/updateCategory", category.value)
      .then(async (response) => {
        loading.value = false;
        if (response.status === 200) {
          // TODO show notification
          await store.dispatch("categories/getCategories");
          store.dispatch(
            "toast/enableSuccessToast",
            "Category updated successfully!"
          );
          closeModal();
        } else {
          store.dispatch("toast/enableErrorToast", "Error occured!");
        }
      })
      .catch((err) => {
        store.dispatch("toast/enableErrorToast", "Data mismatch");
      });
  } else {
    // console.log(category.value);
    store
      .dispatch("categories/createCategory", category.value)
      .then(async (response) => {
        loading.value = false;
        if (response.status === 201) {
          // TODO show notification
          await store.dispatch("categories/getCategories");
          store.dispatch(
            "toast/enableSuccessToast",
            "Category created successfully!"
          );
          closeModal();
        } else {
          store.dispatch("toast/enableErrorToast", "Error occured!");
        }
      })
      .catch((err) => {
        store.dispatch("toast/enableErrorToast", "Data mismatch");
      });
  }
}
</script>

<style scoped>
button[type="submit"] {
  background-color: rgb(79, 70, 229);
}
</style>
