<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-serif font-semibold">Edit Contents</h1>
    <router-link :to="{ name: 'page_settings.overview' }">
      <span
        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Back
      </span>
    </router-link>
  </div>

  <Spinner v-if="page?.loading || page?.length < 0" />
  <div
    v-else
    class="menu-wrapper relative bg-white p-4 rounded-lg shadow animate-fade-in-down"
  >
    <form @submit.prevent="updateMenu">
      <fieldset>
        <legend>Page Contents</legend>
        <div class="input-field relative">
          <label for="Description">
            <span
              class="font-serif text-gray-400 underline-offset-8 align-top text-l"
              >Title</span
            ></label
          ><br />
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
        <label for="Description">
            <span
              class="font-serif text-gray-400 underline-offset-8 align-top text-l"
              >Meta Title</span
            ></label
          >
        <div class="input-field relative">
          <input
            type="text"
            name="meta_title"
            v-model="page.meta_title"
            placeholder="Meta Title"
            
          />
          <br /><br />

          <label for="Description">
            <span
              class="font-serif text-gray-400 underline-offset-8 align-top text-l"
              >Meta Description</span
            ></label
          ><br>
          <textarea
            v-model="page.meta_description"
            name="meta_description"
            cols="50"
            rows="10"
            placeholder="Meta Description"
          ></textarea>
          <br /><br />
          <label for="Description">
            <span
              class="font-serif text-gray-400 underline-offset-8 align-top text-l"
              >Keywords</span
            ></label
          ><br>
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
      <input v-model="page.published" type="checkbox" id="published" />

      <button type="submit">Update</button>
    </form>
  </div>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import Editor from "../../components/Editor.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";

const page = ref({});
const loading = ref(false);
const lastParam = ref(null);

onMounted(() => {
  const url = window.location.href;
  lastParam.value = url.split("/").slice(-1)[0];

  store.dispatch("pages/getPage", lastParam.value).then(({ data }) => {
    page.value = data.data;
  });
});

onUpdated(() => {
  page.value.published = page.value.published == 1 ? true : false;
});

function updateMenu() {
  // console.log(page.value); return
  store
    .dispatch("pages/updatePage", page.value)
    .then((response) => {
      loading.value = false;
      console.log(response.status);
      if (response.status === 200) {
        store.dispatch(
          "toast/enableSuccessToast",
          "Page updated successfully!"
        );
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
  top: 0;
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
