import { createRouter, createWebHistory } from "vue-router";
import store from "../store";

import AppLayout from "../components/AppLayout.vue";
import Login from "../views/Login.vue";
import Dashboard from "../views/Users/Dashboard.vue";
import ProductIndex from "../views/Products/ProductIndex.vue";
import Products from "../views/Products/Products.vue";
import Users from "../views/Users/Users.vue";
import Customers from "../views/Customers/Customers.vue";
import CustomerView from "../views/Customers/CustomerView.vue";
import Orders from "../views/Orders/Orders.vue";
import OrderView from "../views/Orders/OrderView.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import NotFound from "../views/NotFound.vue";
import Report from "../views/Reports/Report.vue";
import OrdersReport from "../views/Reports/OrdersReport.vue";
import CustomersReport from "../views/Reports/CustomersReport.vue";
import Categories from "../views/Categories/Categories.vue";
import ProductAdd from "../views/Products/ProductAdd.vue";
import ProductEdit from "../views/Products/ProductEdit.vue";

import PageIndex from "../views/PageSettings/PageIndex.vue";
import Overview from "../views/PageSettings/Overview.vue";
import PageAdd from "../views/PageSettings/PageAdd.vue";
import PageEdit from "../views/PageSettings/PageEdit.vue";
import GroupPages from "../views/PageSettings/GroupPages.vue";

import TestimonialIndex from "../views/Testimonials/TestimonialIndex.vue";
import Testimonials from "../views/Testimonials/Testimonials.vue";
import TestimonialAdd from "../views/Testimonials/TestimonialAdd.vue";
import TestimonialEdit from "../views/Testimonials/TestimonialEdit.vue";

import Settings from "../views/Settings/Settings.vue";

import GeneralSettings from "../views/Settings/GeneralSettings.vue";
import HeaderSettings from "../views/Settings/Header/HeaderSettings.vue";
import BannerSettings from "../views/Settings/Banner/BannerSettings.vue";

import SliderSettings from "../views/Settings/Slider/SliderSettings.vue";

import FeaturedSettings from "../views/Settings/Featured/FeaturedSettings.vue";

import ScriptSettings from "../views/Settings/ScriptSettings.vue";

import ShippingCharge from "../views/Settings/ShippingCharge.vue";

import SocialMedia from "../views/Settings/SocialMedia.vue";

const routes = [
  {
    path: "/",
    redirect: "/app",
  },
  {
    path: "/app",
    name: "app",
    redirect: "/app/dashboard",
    component: AppLayout,
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: "dashboard",
        name: "app.dashboard",
        component: Dashboard,
      },
      {
        path: "products",
        name: "app.products",
        component: ProductIndex,
        children: [
          {
            path: "all",
            name: "app.products.all",
            component: Products,
          },
          {
            path: "add",
            name: "app.products.add",
            component: ProductAdd,
          },
          {
            path: "edit/:id",
            name: "app.products.edit",
            component: ProductEdit,
          },
        ],
      },
      {
        path: "testimonials",
        name: "app.testimonials",
        component: TestimonialIndex,
        children: [
          {
            path: "all",
            name: "app.testimonials.all",
            component: Testimonials,
          },
          {
            path: "add",
            name: "app.testimonials.add",
            component: TestimonialAdd,
          },
          {
            path: "edit/:id",
            name: "app.testimonials.edit",
            component: TestimonialEdit,
          },
        ],
      },
      
      {
        path: "categories",
        name: "app.categories",
        component: Categories,
      },
      {
        path: "users",
        name: "app.users",
        component: Users,
      },
      {
        path: "customers",
        name: "app.customers",
        component: Customers,
      },
      {
        path: "customers/:id",
        name: "app.customers.view",
        component: CustomerView,
      },
      {
        path: "orders",
        name: "app.orders",
        component: Orders,
      },
      {
        path: "orders/:id",
        name: "app.orders.view",
        component: OrderView,
      },
      {
        path: "/report",
        name: "reports",
        component: Report,
        meta: {
          requiresAuth: true,
        },
        children: [
          {
            path: "orders/:date?",
            name: "reports.orders",
            component: OrdersReport,
          },
          {
            path: "customers/:date?",
            name: "reports.customers",
            component: CustomersReport,
          },
        ],
      },
      {
        path: "/page_settings",
        name: "page_settings",
        component: PageIndex,

        children: [
          {
            path: "overview",
            name: "page_settings.overview",
            component: Overview,
          },
          {
            path: "add", 
            name: "page_settings.add",
            component: PageAdd,
          },
          {
            path: "edit/:id",
            name: "page_settings.edit",
            component: PageEdit,
          },
          {
            path: "menu",
            name: "page_settings.menu",
            component: GroupPages,
          },
        ],
      },
      {
        path: "/settings",
        name: "settings",
        component: Settings,
        /* meta: {
          requiresAuth: true,
        }, */
        children: [
          {
            path: "general-settings",
            name: "settings.general",
            component: GeneralSettings,

            children: [
              {
                path: "header",
                name: "general.header",
                component: HeaderSettings,
              },
              {
                path: "banner",
                name: "general.banner",
                component: BannerSettings,
              },
              {
                path: "featured",
                name: "general.featured",
                component: FeaturedSettings,
              },
              {
                path: "script",
                name: "general.script", 
                component: ScriptSettings
              },
              {
                path: "slider",
                name: "general.slider.settings",
                component: SliderSettings,
    
              },
            ]
          },
          
          {
            path: "shipping-charges",
            name: "settings.shipping-charges",
            component: ShippingCharge,
          },
          {
            path: "social-media",
            name: "settings.social-media",
            component: SocialMedia,
          }

          
        ],
      },
      
    ],
  },
  {
    path: "/login",
    name: "login",
    component: Login,
    meta: {
      requiresGuest: true,
    },
  },
  {
    path: "/request-password",
    name: "requestPassword",
    component: RequestPassword,
    meta: {
      requiresGuest: true,
    },
  },
  {
    path: "/reset-password/:token",
    name: "resetPassword",
    component: ResetPassword,
    meta: {
      requiresGuest: true,
    },
  },
  {
    path: "/:pathMatch(.*)",
    name: "notfound",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: "login" });
  } else if (to.meta.requiresGuest && store.state.user.token) {
    next({ name: "app.dashboard" });
  } else {
    next();
  }
});

export default router;
