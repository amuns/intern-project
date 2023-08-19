<template>
  <div class="social-media-wrapper">
    <div class="flex flex-flow-col gap-10 justify-center">
      <div class="social-medias">
        <form @submit.prevent="onSubmit">
          <fieldset>
            <legend><img src="/img/facebook.png" /></legend>
            <input
              v-model="socialMedia.facebook"
              required
              type="text"
              size="50"
            />
            <button v-if="search.facebook" type="submit">Update</button>
            <button v-else type="submit">Add</button>
          </fieldset>
        </form>

        <form @submit.prevent="onSubmit">
          <fieldset>
            <legend><img src="/img/instagram.png" /></legend>
            <input
              v-model="socialMedia.instagram"
              required
              type="text"
              size="50"
            />
            <button v-if="search.instagram" type="submit">Update</button>
            <button v-else type="submit">Add</button>
          </fieldset>
        </form>

        <form @submit.prevent="onSubmit">
          <fieldset>
            <legend><img src="/img/twitter.png" /></legend>
            <input
              v-model="socialMedia.twitter"
              required
              type="text"
              size="50"
            />
            <button v-if="search.twitter" type="submit">Update</button>
            <button v-else type="submit">Add</button>
          </fieldset>
        </form>

        <form @submit.prevent="onSubmit">
          <fieldset>
            <legend><img src="/img/linkedIn.png" /></legend>
            <input
              v-model="socialMedia.linkedIn"
              required
              type="text"
              size="50"
            />
            <button v-if="search.linkedIn" type="submit">Update</button>
            <button v-else type="submit">Add</button>
          </fieldset>
        </form>
      </div>
      <div>
        <fieldset>
          <legend>Existing Social Media Handles</legend>
          <ul class="list-none">
            <li v-for="(social, index) of socials.data" :key="index" class="mb-5">
              <div class="flex flex-flow-row justify-between">
                <img :src="`/img/${social.title}.png`">
                <button @click="removeHandle(social)">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="red"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </div>
              <span>{{ social.link  }}</span>
            </li>
          </ul>
        </fieldset>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import store from "../../store/index.js";
import CustomInput from "../../components/core/CustomInput.vue";
import Spinner from "../../components/core/Spinner.vue";


const socials = computed(() => store.state.socialMedias);
const socialMedia = ref({});
const search = ref({});

onMounted(async () => {
  await getSocialMedias();

  searchHandle('facebook');
  searchHandle('instagram');
  searchHandle('twitter');
  searchHandle('linkedIn');
});

onUpdated(()=>{

  searchHandle('facebook');
  searchHandle('instagram');
  searchHandle('twitter');
  searchHandle('linkedIn');
});

async function getSocialMedias() {
  await store.dispatch("socialMedias/getSocialMedias");
}

function searchHandle(handle) {
  socials.value.data.filter((item) => {
    if (item.title === handle) {
      search.value[handle] = true; 
    }
  });
}

function onSubmit() {
  const data = {};

  if (socialMedia.value.facebook) {
    data.link = socialMedia.value.facebook;
    data.title = "facebook";
    socials.value.data.filter((item) => {
      if(data.title === item.title){
        data.id = item.id;
      }
    });
    delete socialMedia.value.facebook;
  } else if (socialMedia.value.instagram) {
    data.link = socialMedia.value.instagram;
    data.title = "instagram";
    socials.value.data.filter((item) => {
      if(data.title === item.title){
        data.id = item.id;
      }
    });
    delete socialMedia.value.instagram;

  } else if (socialMedia.value.twitter) {
    data.link = socialMedia.value.twitter;
    data.title = "twitter";
    socials.value.data.filter((item) => {
      if(data.title === item.title){
        data.id = item.id;
      }
    });
    delete socialMedia.value.twitter;

  } else {
    data.link = socialMedia.value.linkedIn;
    data.title = "linkedIn";
    socials.value.data.filter((item) => {
      if(data.title === item.title){
        data.id = item.id;
      }
    });
    delete socialMedia.value.linkedIn;

  }

  if(data.id){
    store.dispatch("socialMedias/updateSocialMedia", data).then(async (res)=>{
      if(res.status === 200){
        await store.dispatch("socialMedias/getSocialMedias");
        store.dispatch("toast/enableSuccessToast", "Social media handle updated!");
      }
    }).catch((err)=>{
      store.dispatch("toast/enableErrorToast", "Data mismatch!");
    });
  }
  else{
    store.dispatch("socialMedias/createSocialMedia", data).then(async (res)=>{
      if(res.status === 201){
        await store.dispatch("socialMedias/getSocialMedias");
        store.dispatch("toast/enableSuccessToast", "Social media handle created!");
      }
    }).catch((err)=>{
      store.dispatch("toast/enableErrorToast", "Data mismatch!");
    });
  }
}

function removeHandle(social){
  if(!confirm("Are you sure you want to remove the handle?")){
    return;
  }

  store.dispatch("socialMedias/deleteSocialMedia", social.id).then(async (res)=>{
    if(res.status === 204){
      await store.dispatch("socialMedias/getSocialMedias");
      store.dispatch("toast/enableErrorToast", "Social media handle removed!");
    }
  });

  searchHandle(social.title);

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
  /* background-color: rgb(79, 70, 229) !important; */
  transition: all 0.23s ease-in-out;
  width: 5rem;
  margin-left: 2rem;
}

button[type]:hover {
  background-color: rgb(67, 56, 202) !important;
  transition: all ease 0.23s;
}

button:active {
  transform: scale(0.95);
}

input {
  border: 1px solid lightgrey;
  border-radius: 6px;
  margin: 0 0 1rem 0;
}

input:focus {
  outline: 1px solid rgb(79, 70, 229);
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
.social-media-wrapper {
  background-color: rgb(255 255 255 / var(--tw-bg-opacity));
  border-radius: 6px;
  --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
  --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color),
    0 2px 4px -2px var(--tw-shadow-color);
  box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000),
    var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
  padding: 0.75rem;
  margin-top: 2rem;
}

.social-medias fieldset {
  margin-bottom: 2rem;
}
</style>
