<template>
  <div class="group-page-wrapper flex flex-flow-col justify-center">
    <div class="group-page">
      <form @submit.prevent="createGroup">
        <div v-for="(page, index) of pages.data" :key="index">
          <input
            v-model="selectedPages"
            :id="page.title"
            :value="page.id"
            type="checkbox"
          />
          <label :for="page.title">
            {{ page.title }}
          </label>
          &nbsp;
          <br />
        </div>

        <input
          v-model="groupPage.title"
          type="text"
          name="group_title"
          placeholder="Menu Title"
          required
        />
        <button type="submit">Create Menu</button>
      </form>
    </div>
    <div class="group-list relative">
      <span v-if="!menus?.data.length">There are no menu list yet!</span>
      <div v-else>
        <p class="text-xl font-medium">Existing menu list!</p>

        <div v-for="(menu, index) of menus.data">
          <div class="menu-title flex flex-flow-col justify-between">
            <div>
              {{ menu.title }}
            </div>
            <div>
              <button @click="removeMenu(menu.id)" class="btn-remove" type="button"><TrashIcon /></button>
            </div>
          </div>
          <ul class="page-list list-none">
            <li v-for="p of menu.pages"><span>----</span>{{ p.page_title }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import store from "../../store/index.js";
import Toast from "../../components/core/Toast.vue";
import Spinner from "../../components/core/Spinner.vue";
import { TrashIcon } from "@heroicons/vue/outline";

const pages = computed(() => store.state.pages);
const groupPage = ref({});
const selectedPages = ref([]);

const menus = computed(() => store.state.menus);

const pageTitle = ref([]);

onMounted(async() => {
  await getPages();
  await getMenus();

  console.log(menus.value);
});

async function getPages(url = null) {
  await store.dispatch("pages/getPages", {
    url,
  });
}

async function getMenus() {
  await store.dispatch("menus/getMenus");
}

function createGroup() {
  groupPage.value.pages = selectedPages.value;

  store
    .dispatch("menus/createMenu", groupPage.value)
    .then((res) => {
      // loading.value=false;
      if (res.status == 201) {
        store.dispatch("menus/getMenus");
        store.dispatch(
          "toast/enableSuccessToast",
          "Menu created successfully!"
        );
      } else {
        store.dispatch("toast/enableErrorToast", "Data Mismatch!");
      }
    })
    .catch((err) => {
      store.dispatch("toast/enableErrorToast", "Data Mismatch!");
      console.log(err);
    });
  // console.log(selectedPages.value);
}

function removeMenu(id){
  if (!confirm(`Are you sure you want to delete the menu?`)) {
    return;
  }
  store.dispatch("menus/deleteMenu", id).then((res) => {
    // TODO Show notification
    store.dispatch("menus/getMenus");
    store.dispatch("toast/enableErrorToast", "Menu deleted!");
  });

}
</script>

<style scoped>
input[type="text"] {
  border: 1px solid lightgrey;
  padding: 0.25rem 0 0.2rem 0.75rem;
}

input[type="text"]:focus {
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
  /* background-color: rgb(79, 70, 229) !important; */
  margin-top: 1rem;
  position: relative;
  top: 0px;
  left: 10px;
  transition: all 0.23s ease-in-out;
}

button[type="submit"]:hover {
  background-color: rgb(67, 56, 202) !important;
  transition: all ease 0.23s;
}

button:active {
  transform: scale(0.95);
}

input[type="checkbox"] {
  margin-top: 0.5rem;
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
  margin: 0 0 0 0.5rem;
}

legend,
button {
  background-color: rgb(79, 70, 229) !important;
}

button.btn-remove {
  background-color: white !important;
  margin-bottom: 0.5rem;
  width: 22px;
  height: 22px;
  color: red;
}

button.btn-remove:hover{
  background-color: red !important;
  color: white;
  border-radius: 50%;
}

button.btn-remove:active{
  transform: scale(0.90);
}

.container {
  max-width: 60%;
}

.group-page-wrapper {
  padding: 2rem;
  /* width:60% */
  align-items: center;
}

.group-page {
  margin-left: 2rem;
  padding-right: 5rem;
  border-right: solid 1px lightgrey;
}

.group-list {
  margin: 0 5rem 0 0rem;
  padding-left: 4rem;
  border-left: solid 1px lightgrey;
}

.menu-title {
  font-size: large;
  margin: 1rem 0 0 0;
  font-weight: 500;
  color: grey;
}

.page-list li {
  border-left: 1px solid lightgrey;
  margin-left: 1rem;
}

.page-list li span {
  color: lightgrey;
}
</style>
