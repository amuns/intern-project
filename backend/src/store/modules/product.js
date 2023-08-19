import axiosClient from "../../axios";

const state = {
  loading: false,
  data: [],
  links: [],
  from: null,
  to: null,
  page: 1,
  limit: null,
  total: null,
};

const mutations = {
  setProducts(state, [loading, data = null]) {
    if (data) {
      state.data = data?.data;
      state.links = data?.meta?.links;
      state.page = data?.meta.current_page;
      state.limit = data?.meta.per_page;
      state.from = data?.meta.from;
      state.to = data?.meta.to;
      state.total = data?.meta.total;

    }
    state.loading = loading;
  },
};

const actions = {
  async getProducts(
    { commit, state },
    { url = null, search = "", per_page, sort_field, sort_direction } = {}
  ) {
    commit("setProducts", [true]);
    url = url || "/products";
    const params = {
      per_page: state.limit,
    };
    // console.log(state); return
    return await axiosClient
      .get(url, {
        params: {
          ...params,
          search,
          per_page,
          sort_field,
          sort_direction,
        },
      })
      .then((response) => {
        // console.log(response.data);
        commit("setProducts", [false, response.data]);
        // console.log(state);

      })
      .catch((err) => {
        commit("setProducts", [false]);
      });
  },

  getProduct({ commit }, id) {
    return axiosClient.get(`/products/${id}`);
  },

  createProduct({ commit }, product) {
    if (product.images) {
      const form = new FormData();
      form.append("title", product.title);
      for (let i = 0; i < product.images.length; i++) {
        form.append("images[]", product.images[i]);
      }
      form.append("description", product.desc);
      form.append("published", product.published ? 1 : 0);
      form.append("price", product.price);
      form.append("categories", product.categories);
      product = form;
    }
    return axiosClient.post("/products", product);
  },

  deleteProduct({ commit }, id) {
    return axiosClient.delete(`/products/${id}`);
  },

  deleteProductImage({ commit }, image) {
    // console.log(image); return
    return axiosClient.post(`/products/${image.productId}/${image.dir}`);
  },

  updateProduct({ commit }, product) {
    const id = product.id;
    if (product.addImages) {
      const form = new FormData();
      form.append("title", product.title);
      // console.log(product);
      // console.log(product.images[0].length); return
      for (let i = 0; i < product.addImages.length; i++) {
        form.append("addImages[]", product.addImages[i]);
      }
      form.append("description", product.description);
      form.append("published", product.published ? 1 : 0);
      form.append("price", product.price);
      form.append("categories", product.categories);
      form.append("_method", "PUT");
      product = form;
    } else {
      product._method = "PUT";
    }
    // console.log(product); return
    return axiosClient.post(`/products/${id}`, product);
  },
};

const getters = {};

export default {
  namespaced: true,
  actions,
  state,
  mutations,
  getters,
};
