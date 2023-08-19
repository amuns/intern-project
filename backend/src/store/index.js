import { createStore } from "vuex";

import products from "./modules/product";
import categories from "./modules/category";
import user from "./modules/user";
import users from "./modules/users";
import customers from "./modules/customer";
import sliders from "./modules/slider"
import countries from "./modules/country"
import orders from "./modules/order";
import toast from "./modules/toast";
import dateOptions from "./modules/dateOptions";
import testimonials from "./modules/testimonial";
import pages from "./modules/page";
import menus from "./modules/menu";
import brandingHeader from "./modules/brandingHeader";
import banner from "./modules/banner";
import scripts from "./modules/script";
import shippingCharge from "./modules/shippingCharge";
import socialMedias from "./modules/socialMedia.js";
// const debug = process.env.NODE_ENV !== 'production'


const store = createStore({
  modules: {
    products,
    categories,
    user,
    users,
    customers,
    sliders,
    countries,
    orders,
    toast,
    dateOptions,
    testimonials,
    pages,
    menus,
    brandingHeader,
    banner,
    scripts,
    shippingCharge,
    socialMedias,
  }
})
/* const store = {
  // modules: {
    products,
    categories,
    user,
    users,
    customers,
    sliders,
    countries,
    orders,
    toast,
    dateOptions
  // }
}
 */
export default store

// Vue.use(Vuex);

// export default new Vuex.Store({
//   modules: {
//     products
//   }
// })