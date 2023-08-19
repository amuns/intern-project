<template>
  <div v-if="banner?.loading || !banner?.data.length">
    <Spinner v-if="banner?.loading" />
    <p v-else class="text-center py-8 text-gray-700">
      Banner Title and Subtitle not set!
    </p>
    <button type="button" @click="addBanner()" class="crud-button">
        Add Sticky
      </button>
  </div>
  <div v-else class="banner-wrapper">
    <div class="banner-content">
      <button type="button" @click="editBanner()" class="crud-button">
        Edit Sticky
      </button>
      <Spinner v-if="banner?.loading" />
      <div v-else>
        <div class="title rounded">
          {{ banner?.data[0].title ? banner?.data[0].title : "Add Title" }}
        </div>
        <div class="subtitle rounded">
          {{
            banner?.data[0].subtitle
              ? banner?.data[0].subtitle
              : "Add Subtitle"
          }}
        </div>
      </div>

      <div class="published">
        Published
        <!-- <div v-if="banner?.data[0].published"> -->
        <input
          v-model="banner.data[0].published"
          :checked="checked"
          type="checkbox"
          class="published-check"
          name="published"
          disabled
        />
        <!-- </div> -->
      </div>
    </div>
  </div>

  <BannerModal
    v-model="showBannerModal"
    :banner="bannerModel"
    @close="onModalClose"
  />
</template>

<script setup>
import { computed, ref, onMounted, onUpdated } from "vue";
import store from "../../../store";
import Spinner from "../../../components/core/Spinner.vue";
import BannerModal from "./BannerModal.vue";

const DEFAULT_Banner = {
  id: "",
  title: "",
  subtitle: "",
  published: 0,
};


const bannerModel = ref({ ...DEFAULT_Banner });

const banner = computed(() => store.state.banner);
const checked = ref(0);
const showBannerModal = ref(false);

onMounted(() => {
  try {
    getBanner();
  } catch (err) {
    console.log(err);
  }
  // console.log(banner.value)
});

/* onUpdated(()=>{
  checked.value = banner.value.data[0].published;
}); */

async function getBanner(url = null) {
  await store.dispatch("banner/getBanner", {
    url,
  }).then(()=>{
      checked.value = banner.value.data[0].published;
  });
}

function showAddNewModal() {
  showBannerModal.value = true;
}

function onModalClose(e) {
  bannerModel.value = { ...DEFAULT_Banner };
  checked.value = e;
}

function addBanner(){
  showAddNewModal();
}

function editBanner(s) {
  bannerModel.value = banner.value.data[0];
  showAddNewModal();
}
</script>

<style scoped>
.banner-content {
  position: relative;
  top: 0;
  left: 0;
  max-height: 22rem;
  padding: 2rem;
}

.banner-content div {
  margin-top: 1.5rem;
}

.banner-content .title,
.banner-content .subtitle {
  border: 1px lightgrey solid;
  padding: 1rem 2rem;
  margin: 1rem 0 1rem 0;
  color: lightgrey;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.075);
}

.banner-content .title {
  max-width: 60%;
}

.banner-content .subtitle {
  height: auto;
}

.published {
  /* font-weight: 500; */
  color: #3a3a3a;
  font-size: 18px;
  letter-spacing: 0.2px;
  line-height: 24px;
}

.published .published-check {
  margin-left: 0.75rem;
}
</style>
