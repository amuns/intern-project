<template>
  <div v-if="brandingHeader.loading || !brandingHeader.data.length">
    <Spinner v-if="brandingHeader.loading"/>
    <button @click="showAddNewModal" type="button" class="crud-button" v-else>Add Branding Header</button>
  </div>
  <div v-else class="header-wrapper relative">
    <fieldset>
      <legend>Branding Header</legend>
      <!-- <div v-if="brandingHeader.data.length > 0">
        
      </div> -->
      <div class="branding-wrapper flex flex-col gap-5">
        <div>Logo: <img class="logo" :src="brandingHeader?.data[0].logo" alt="" /></div>
        <hr />
        <div>Company Name: {{ brandingHeader?.data[0].company_name }}</div>
        <hr>
        <button @click="editBrandingModel(brandingHeader?.data[0])" type="button" class="crud-button w-16">
          Edit
        </button>
      </div>
    </fieldset>
   
  </div>

  <HeaderModal v-model="showBrandingHeaderModal" :brandingHeader="brandingHeaderModel" @close="onModalClose"/>
</template>

<script setup>
import { computed, ref, onMounted } from "vue";
import store from "../../../store";
import Spinner from "../../../components/core/Spinner.vue";
import HeaderModal from "./HeaderModal.vue";
// import CustomInput from "../../../components/core/CustomInput.vue";

const DEFAULT_BrandingHeader = {
  id : "",
  logo : "",
  company_name : "",
};

const brandingHeaderModel = ref({ ...DEFAULT_BrandingHeader });
const brandingHeader = computed(()=> store.state.brandingHeader);

const loading = ref(false);
const showBrandingHeaderModal = ref(false);

onMounted(async () => {
  try {
    getBrandingHeader();
  } catch (err) {
    console.log(err);
  }
});


async function getBrandingHeader(url = null) {
  await store.dispatch("brandingHeader/getBrandingHeader", {
    url,
  });
}

function showAddNewModal(){
  showBrandingHeaderModal.value = true;
}

function onModalClose(){
  brandingHeaderModel.value = { ...DEFAULT_BrandingHeader };
  showBrandingHeaderModal.value = false;
}

function editBrandingModel(brandingHeader){
  brandingHeaderModel.value = brandingHeader;
  showAddNewModal();
}
/* function addSubtitle(menuId, subtitle){
  loading.value = true;

  let subMenu = [];
  subMenu['subtitle'] = subtitle;
  subMenu['menuId'] = subtitle;

  store.dispatch("brandingHeader/addSubtitle", subMenu).then((response) => {
    loading.value = false;

    if(response.status === 200){
      store.dispatch("brandingHeader/getMenus");
    }
  });

} */
</script>

<style scoped>
.header-wrapper {
  position: relative;
  padding: 1.75rem;
  width: 60%;
  /* display: flex; */
  margin: 0 auto 0;
}

fieldset {
  border: 1px solid lightgrey;
  margin: 1rem 0 0.75rem 0;
}

legend {
  background-color: rgb(79, 70, 229);
  padding: 0.3rem;
  border-radius: 6px;
  color: white;
  margin: 0 0 0 1.25rem;
}

.menu-list legend{
    background-color: #e89f71;
}

.branding-wrapper,
.menu-wrapper {
  padding: 1.75rem;
}

.subtitle-list{
  padding: 2rem;
}

input.subtitle {
  border: 1px solid lightgrey;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
  padding: 0.25rem 0 0.2rem 0.75rem;
  margin: 0.3rem 0.75rem 0 0;
}

input.subtitle:focus{
  border-radius: 6px;
  outline: 1px solid #e89f71;
}

button[type="submit"] {
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

button[type="submit"]:hover{
  background-color: rgb(67, 56, 202) ;
  transition: all ease 0.23s;
} 

button[type="submit"]:active{
  transform: scale(0.95);
}

.crud-button{
  margin: 0 0 0 auto ;
}
</style>
