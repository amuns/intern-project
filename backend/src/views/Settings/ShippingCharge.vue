<template>
  <Spinner v-if="shippingCharge?.loading" />
  <h1 class="text-xl font-semibold">Shipping Charge</h1>
  <div class="shipping-charge-wrapper relative">
    <form @submit.prevent="updateDeliveryCharge">
      <div class="flex flex-flow-col gap-10 justify-center">
        <div>
          <label for="deliveryCharge">Delivery Charge</label>
          <CustomInput
            required
            v-model="updateShippingCharge.delivery_charge"
            class="w-44"
            type="number"
            label="Delivery Charge"
          />
        </div>
        <div>
          <fieldset>
            <legend>Existing Delivery Charge</legend>
            <span v-if="shippingCharge?.data[0]">
              Rs. {{ shippingCharge.data[0].amount }}
            </span>
            <span v-else> Set shipping charge! </span>
          </fieldset>
        </div>
      </div>
      <div>
        <button v-if="shippingCharge?.data.length <= 0" type="submit">
          Add
        </button>
        <button v-else type="submit">Update</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { computed, onUpdated, ref, onMounted } from "vue";
import store from "../../store/index.js";
import CustomInput from "../../components/core/CustomInput.vue";
import Spinner from "../../components/core/Spinner.vue";

const shippingCharge = computed(() => store.state.shippingCharge);
const updateShippingCharge = ref({});

onMounted(async () => {
  await getShippingCharge();
});

async function getShippingCharge() {
  await store.dispatch("shippingCharge/getShippingCharge");
}

function updateDeliveryCharge() {
  if (shippingCharge.value.data.length <= 0) {
    console.log(updateShippingCharge.value);
    store
      .dispatch(
        "shippingCharge/createShippingCharge",
        updateShippingCharge.value
      )
      .then((res) => {
        if (res.status === 201) {
          store.dispatch("shippingCharge/getShippingCharge");
          store.dispatch(
            "toast/enableSuccessToast",
            "Shipping charge updated!"
          );
        }
      })
      .catch((err) => {
        store.dispatch("toast/enableErrorToast", "Data mismatch!");
      });
  } else {
    updateShippingCharge.value.id = shippingCharge.value.data[0].id;
    store
      .dispatch(
        "shippingCharge/updateShippingCharge",
        updateShippingCharge.value
      )
      .then((res) => {
        if (res.status === 200) {
          store.dispatch("shippingCharge/getShippingCharge");
          store.dispatch(
            "toast/enableSuccessToast",
            "Shipping charge updated!"
          );
        }
      })
      .catch((err) => {
        store.dispatch("toast/enableErrorToast", "Data mismatch!");
      });
  }
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
.shipping-charge-wrapper {
  background-color: rgb(255 255 255 / var(--tw-bg-opacity));
  border-radius: 6px;
  --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
  --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color),
    0 2px 4px -2px var(--tw-shadow-color);
  box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000),
    var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
  padding: 0.75rem;
  margin-top: 2rem;
  width: 80%;
}
</style>
