<template>
  <div class="settings-container">
    

    <div class="settings-content">
      <router-view />
    </div>
  </div>
</template>

<script setup>
// import { computed, ref, onMounted } from "vue";
// import { useRoute, useRouter } from "vue-router";
// import { useStore } from "vuex";
</script>

<style>
.settings-container {
  font-family: "Verdana";
  font-size: 18px;
}

.nav-text {
  font-size: 24px;
  font-weight: 400;
  line-height: 150%;
  letter-spacing: 0.2px;
  background-color: white;
  padding: 0.5rem 0.75rem 0.5rem 0.75rem;
  color: rgb(55, 65, 81);
  border-radius: 6px;
  text-align: center;
}

input[type="checkbox"] {
  appearance: none;
  width: 20px;
  height: 20px;
  border-radius: 5px;
  border: 1px solid lightgrey;
  background-color: white;
  margin-right: 8px;
  position: relative;
  top: 0.2rem;
}

input[type="checkbox"]::before {
  content: "";
  position: absolute;
  width: 0;
  height: 3px;
  background-color: blue;
  transform: translate(8px, 13px) rotate(-45deg);
  transform-origin: left;
  transition: 150ms all linear;
  transition-delay: 0ms;
}

input[type="checkbox"]::after {
  content: "";
  position: absolute;
  width: 0;
  height: 3px;
  background-color: blue;
  transform: translate(1px, 8px) rotate(45deg);
  transform-origin: left;
  transition: 150ms all linear;
  transition-delay: 150ms;
}

input[type="checkbox"]:checked::before {
  width: 14px;
  transition-delay: 150ms;
}

input[type="checkbox"]:checked::after {
  width: 10px;
  transition-delay: 0ms;
}

button[type="button"].crud-button{
  padding: 0.5rem 1rem 0.5rem 1rem;
  border: 1px transparent;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 500;
  border-radius: 6px;
  color: white;
  background-color: rgb(79, 70, 229);
}

button[type="button"].crud-button:hover{
  background-color: rgb(67, 56, 202);
}

button[type="button"].crud-button:active{
  transform: scale(0.95);
}

.router-link *{
  transition: all 0.3s ease-in;
}

.router-link *:hover{
  text-decoration: underline;
}

</style>
