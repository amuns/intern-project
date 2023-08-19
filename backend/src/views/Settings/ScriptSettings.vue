<template>
  <div class="script-wrapper">
    <form @submit.prevent="onSubmit">
      <div class="flex flex-flow-cols gap-10">
        <div>
          <label for="scripts">Scripts</label><br />
          <textarea
            id="scripts"
            v-model="script.scripts"
            class="scripts"
            rows="10"
            cols="80"
            placeholder="<script></script"
          ></textarea>
        </div>

        <div v-if="scripts">
          <fieldset>
            <legend>Existing Script</legend>
            {{ scripts.scripts }}
          </fieldset>
        </div>
      </div>
      <input
        v-model="script.header"
        :checked="script.header"
        type="checkbox"
        id="header"
      />
      <label for="header">Header</label>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

      <input
        v-model="script.footer"
        :checked="script.footer"
        type="checkbox"
        id="footer"
      />
      <label for="header">Footer</label><br /><br />
      <button v-if="scripts" type="submit">Update</button>
      <button v-else type="submit">Add</button>
    </form>
  </div>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import store from "../../store/index.js";
import Toast from "../../components/core/Toast.vue";
import Spinner from "../../components/core/Spinner.vue";

const scripts = computed(() => store.state.scripts.data);
const script = ref({});

onMounted(async () => {
  await getScripts();
  if (Object.keys(scripts.value).length > 0) {
    script.value.id = scripts.value.id;
    script.value.header = scripts.value.header;
    script.value.footer = scripts.value.footer;
  }
});

async function getScripts() {
  await store.dispatch("scripts/getScripts");
}

function onSubmit() {
  // console.log(script.value); return
  if (
    Object.keys(scripts.value).length > 0 &&
    Object.keys(script.value).length >= 3
  ) {
    store
      .dispatch("scripts/updateScript", script.value)
      .then((res) => {
        if (res.status == 200) {
          store.dispatch("scripts/getScripts");
          store.dispatch("toast/enableSuccessToast", "Script updated!");
        } else {
          store.dispatch("toast/enableErrorToast", "Error Occured!");
        }
      })
      .catch((err) => {
        store.dispatch("toast/enableErrorToast", "Error occured!");
      });
  } else if (
    Object.keys(scripts.value).length <= 0 &&
    Object.keys(script.value).length > 1
  ) {
    store.dispatch("scripts/createScript", script.value).then((res) => {
      if (res.status == 201) {
        store.dispatch("scripts/getScripts");
        store.dispatch("toast/enableSuccessToast", "Script created!");
      } else {
        store.dispatch("toast/enableErrorToast", "Error Occured!");
      }
    });
  } else {
    store.dispatch("toast/enableErrorToast", "No changes found!");
  }
}
</script>

<style scoped>
button[type] {
  padding: 0.5rem;
  border: 1px transparent;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 500;
  border-radius: 6px;
  margin-bottom: 5px;
  /* background-color: rgb(79, 70, 229) !important; */
  transition: all 0.23s ease-in-out;
  width: 5rem;
}

button[type]:hover {
  background-color: rgb(67, 56, 202) !important;
  transition: all ease 0.23s;
}

button:active {
  transform: scale(0.95);
}

input[type="checkbox"] {
  margin-right: 0.75rem;
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
button[type] {
  border-radius: 6px;
  color: white;
  background-color: rgb(79, 70, 229);
}

.script-wrapper {
  padding: 2rem;
}

.scripts {
  border: 1px solid lightgrey;
  padding: 0.75rem;
  width: auto;
}

.scripts:focus {
  outline: 1px solid rgb(79, 70, 229);
  border-radius: 6px;
  transition: all 0.13s ease-in;
}
</style>
