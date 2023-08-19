<template>
  <h1 class="text-3xl font-medium">Edit Testimonial</h1>
  
  <div class="testimonial-wrapper relative">
    
    <form @submit.prevent="onSubmit">
        <div class="flex justify-between">
            <router-link :to="{ name: 'app.testimonials.all' }">
      <button
        class="back py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Back
      </button>
    </router-link>
            <button type="submit">Update</button>
        </div>

      <div class="grid grid-cols-4">
        <div class="display-picture">
          <img class="displayImage" :src="displayImage" />
          <input type="file" hidden ref="img" @change="changeImage($event)" accept="image/*">
          <button
              type="button"
              class="dp"
              @click="img.click()"
              >Change</button>
        </div>
        <div class="col-span-3 flex flex-flow-col testimonial-details">
          <div class="">
            
            <CustomInput
              required
              v-model="testimonial.fullname"
              type="text"
              class="mb-2"
              label="Full Name"
            />

            <textarea
              required
              v-model="testimonial.feedback"
              class="border testimonial-feedback"
              cols="28"
              rows="10"
              col="80"
              placeholder="Testimonial"
            ></textarea>

            <input id="published" type="checkbox" v-model="testimonial.published" :checked="testimonial.published">
            <label for="published">Published</label>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import store from "../../store/index.js";
import CustomInput from "../../components/core/CustomInput.vue";

const lastParam = ref(null);
const testimonial = ref({});
const displayImage = ref("");
const img = ref(null);

onMounted(async() => {
  const url = window.location.href;
  lastParam.value = url.split("/").slice(-1)[0];

  await store.dispatch("testimonials/getTestimonial", lastParam.value).then(({data})=>{
    testimonial.value = data.data;
    displayImage.value = data.data.display_picture;
  });

});

function changeImage(e){
  if(e.target.files[0]){
    const file = e.target.files[0];
    testimonial.value.display_picture = file;
    displayImage.value = URL.createObjectURL(file);
  }
}

async function onSubmit(){
  // console.log(testimonial.value); return

  await store.dispatch("testimonials/updateTestimonial", testimonial.value).then((res)=>{
    if(res.status === 200){
      store.dispatch("testimonials/getTestimonials");
      store.dispatch("toast/enableSuccessToast", "Testimonial Updated!");
    }
  }).catch((err)=>{
    store.dispatch("toast/enableErrorToast", "Oops! Error occured during update");
  });
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
  position: relative;
}

button[type]:hover {
  background-color: rgb(67, 56, 202);
  transition: all ease 0.23s;
}

button[type]:active {
  transform: scale(0.95);
}
.testimonial-wrapper {
  background-color: white;
  border-radius: 6px;
  border: 1px solid lighgrey;
  padding: 2rem;
  width: 80%;
  margin: 6% auto;
}

.display-picture {
  width: 181px;
  height: 181px;
  border-radius: 50%;
  background-color: lightgrey;
  margin: 3rem auto;
}

.displayImage {
  border-radius: 50%;
  height: 181px;
  width: 181px;
}

.display-picture:hover {
  background: rgba(33, 33, 33, 0.5);
  transition: 0.23s all ease-in-out;
}

.dp {
  margin: 1rem 0 0 2.75rem;
}

.testimonial-details {
  margin: 2rem 0 0 4rem;
  width: 100%;
}

.testimonial-feedback {
  min-width: 150%;
  height: auto;
  padding: 0.375rem;
  margin-top: 1rem;
}

.testimonial-feedback:focus {
  outline: 1px rgb(79, 70, 229) solid;
  border-radius: 6px;
}
</style>
