<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-serif font-semibold">Add Page</h1>
    <router-link :to="{ name: 'page_settings.overview' }">
      <span
        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Back
      </span>
    </router-link>
  </div>

  <div
    class="menu-wrapper relative bg-white p-4 rounded-lg shadow animate-fade-in-down"
  >
    <form @submit.prevent="addMenu">
      <fieldset>
        <legend>Page Contents</legend>
        <div class="input-field relative">
          <input
            type="text"
            name="title"
            v-model="page.title"
            placeholder="Title"
            required
          />
          <br /><br />

          <label for="Description">
            <span
              class="font-serif text-gray-400 underline-offset-8 align-top text-l"
              >Body</span
            ></label
          >
          <Editor v-model="page.body" :desc="page.body" />
        </div>
      </fieldset>

      <fieldset>
        <legend>SEO</legend>
        <div class="input-field relative">
          <input
            type="text"
            name="meta_title"
            v-model="page.meta_title"
            placeholder="Meta Title"
            
          />
          <br /><br />

          <textarea
            v-model="page.meta_description"
            name="meta_description"
            cols="50"
            rows="10"
            placeholder="Meta Description"
          ></textarea>
          <br /><br />
          <textarea
            v-model="page.keywords"
            name="keywords"
            cols="50"
            rows="10"
            placeholder="Keywords"
          ></textarea>
        </div>
      </fieldset>

      <label for="published">Published</label> &nbsp;
      <input v-model="page.published" type="checkbox" id="published">
      <button type="submit">Add</button>
    </form>
  </div>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import store from "../../store/index.js";
import Toast from "../../components/core/Toast.vue";
import Spinner from "../../components/core/Spinner.vue";
import Editor from "../../components/Editor.vue";

const page = ref({});
const editorData = ref(null);
// const createdMenu = computed(()=> { return store.state.menus });
const loading = ref(false);

function addMenu() {
  // console.log(page.value); return;
  store
    .dispatch("pages/createPage", page.value)
    .then((response) => {
      loading.value = false;
      if (response.status === 201) {
        store.dispatch("toast/enableSuccessToast", "Page created successfully!");
        store.dispatch("pages/getPages");
      }
    })
    .catch(({ response }) => {
      // console.log(store);
      store.dispatch("toast/enableErrorToast", "Credentials mismatch!");
    });
}
</script>

<style scoped>
.menu-wrapper {
  padding: 1.75rem;
  width: 70%;
  /* display: flex; */
  margin: 0 auto 0;
}

fieldset {
  border: 1px solid lightgrey;
  margin: 1rem 0 0.75rem 0;
  padding: 1rem;
}

legend {
  padding: 0.4rem;
  border-radius: 6px;
  color: white;
  margin: 0 0 0 1.25rem;
}

legend,
button {
  background-color: rgb(79, 70, 229) !important;
}

input[type="text"],
textarea {
  border: 1px solid lightgrey;
  padding: 0.25rem 0 0.2rem 0.75rem;
}

input[type="text"]:focus,
textarea:focus {
  border-radius: 6px;
  outline: 1px solid rgb(79, 70, 229);
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
}

button[type="submit"] {
  padding: 0.5rem 1rem 0.5rem 1rem;
  border: 1px transparent;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 500;
  border-radius: 6px;
  color: white;
  margin-bottom: 5px;
  position: relative;
  top: 0px;
  left: 1.75rem;
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
