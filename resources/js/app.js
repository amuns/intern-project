import "./bootstrap";

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import { get, post } from "./http.js";
import Swiper, { Navigation, Pagination, FreeMode, Autoplay } from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "../css/app.css";

Alpine.plugin(collapse);

window.Alpine = Alpine;

window.Swiper = Swiper;

document.addEventListener("alpine:init", async () => {
  Alpine.data("toast", () => ({
    visible: false,
    delay: 5000,
    percent: 0,
    interval: null,
    timeout: null,
    message: null,
    type: null,
    close() {
      this.visible = false;
      clearInterval(this.interval);
    },
    show(message) {
      this.visible = true;
      this.message = message;

      if (this.interval) {
        clearInterval(this.interval);
        this.interval = null;
      }
      if (this.timeout) {
        clearTimeout(this.timeout);
        this.timeout = null;
      }

      this.timeout = setTimeout(() => {
        this.visible = false;
        this.timeout = null;
      }, this.delay);
      const startDate = Date.now();
      const futureDate = Date.now() + this.delay;
      this.interval = setInterval(() => {
        const date = Date.now();
        this.percent = ((date - startDate) * 100) / (futureDate - startDate);
        if (this.percent >= 100) {
          clearInterval(this.interval);
          this.interval = null;
        }
      }, 30);
    },
  }));

  Alpine.data("productItem", (product) => {
    return {
      product,
      addToCart(quantity = 1) {
        post(this.product.addToCartUrl, { quantity })
          .then((result) => {
            this.$dispatch("cart-change", { count: result.count });
            this.$dispatch("notify", {
              message: "The item was added into the cart",
            });
          })
          .catch((response) => {
            console.log(response);
          });
      },
      removeItemFromCart() {
        post(this.product.removeUrl).then((result) => {
          this.$dispatch("notify", {
            message: "The item was removed from cart",
            type: "error",
          });
          this.$dispatch("cart-change", { count: result.count });
          this.cartItems = this.cartItems.filter((p) => p.id !== product.id);
        });
      },
      changeQuantity() {
        post(this.product.updateQuantityUrl, {
          quantity: Math.abs(product.quantity),
        }).then((result) => {
          this.$dispatch("cart-change", { count: result.count });
          this.$dispatch("notify", {
            message: "The item quantity was updated",
          });
        });
      },
    };
  });

  /* Alpine.data("counter", ()=>({
    count: 0,

    increment(){
      return this.count++;
    }
  })); */
});

Alpine.start();

const slider = new Swiper(".sliders-wrapper", {
  modules: [Pagination, Autoplay],
  direction: "horizontal",
  loop: true,
  slidesPerView: 2.1,
  spaceBetween: 25,
  rewind: true,

  //For the half image effect
  centeredSlides: true,
  roundLengths: true,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    // dynamicBullets: true,
  },

  autoplay: {
    delay: 5000,
  },

  on: {
    slideChangeTransitionEnd: function () {
      var activeIndex = this.activeIndex;
      var slidesLength = this.slides.length - 2; // Exclude two cloned slides
      if (activeIndex === 0) {
        this.slideTo(slidesLength, 0, false);
      } else if (activeIndex === slidesLength + 1) {
        this.slideTo(1, 0, false);
      }
    },
  },
});

const categorySwiper = new Swiper(".category-swiper", {
  // Optional parameters
  modules: [Autoplay, Pagination],
  direction: "horizontal",
  loop: true,
  rewind: true,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },

  // Navigation arrows
  /* navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  }, */
  autoplay: {
    delay: 3000,
  },
  // And if we need scrollbar
  scrollbar: {
    el: ".swiper-scrollbar",
  },

  breakpoints: {
    1440: {
      slidesPerView: 4,
      spaceBetween: 40,
    },

    1900: {
      slidesPerView: 4 || 5,
      spaceBetween: 40,
    },
  },
});

const trendingSlider = new Swiper(".trending-products-wrapper", {
  modules: [Navigation, Pagination, Autoplay],
  direction: "horizontal",
  loop: true,
  loopAdditionalSlides: 2,
  spaceBetween: 20,

  // slidesPerView: 3,
  // rewind: true,

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    // type: "bullets",
  },

  navigation: {
    prevEl: ".swiper-button-next",
  },

  /* autoplay: {
    delay: 5000,
  }, */

  breakpoints: {
    1440: {
      slidesPerView: 2.2,
      /* centeredSlides: true, 
      centeredSlidesBounds: true, */
    },

    1900: {
      slidesPerView: 3.2,
      centeredSlides: true, 
      centeredSlidesBounds: true,
      // spaceBetween: 20,
    },
  },

  /* on: {
    slideChangeTransitionEnd: function () {
      var activeIndex = this.activeIndex;
      var slidesLength = this.slides.length - 2; // Exclude two cloned slides
      if (activeIndex === 0) {
        this.slideTo(slidesLength, 0, false);
      } else if (activeIndex === slidesLength + 1) {
        this.slideTo(1, 0, false);
        
      }
    },
  }, */
  
});

const testimonials = new Swiper(".testimonial-wrapper", {
  modules: [Pagination, Navigation, Autoplay],
  direction: "horizontal",
  loop: true,
  slidesPerView: 1,

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    // dynamicBullets: true,
  },

  navigation: {
    prevEl: ".swiper-button-prev",
    nextEl: ".swiper-button-next",
  },
});
