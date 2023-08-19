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
  setCategories(state, [loading, data = null]) {
    if (data) {
      // console.log(data);
      state.data = data.data;
      state.links = data.meta?.links;
      state.page = data.meta.current_page;
      state.limit = data.meta.per_page;
      state.from = data.meta.from;
      state.to = data.meta.to;
      state.total = data.meta.total;
    }
    state.loading = loading;
    // console.log(state);
  },
};

const actions = {
  async getCategories(
    { commit, state },
    { url = null, search = "", per_page, sort_field, sort_direction } = {}
  ) {
    commit("setCategories", [true]);
    url = url || "/categories";
    const params = {
      per_page: state.limit,
    };
    try {
      const response = await axiosClient.get(url, {
        params: {
          ...params,
          search,
          per_page,
          sort_field,
          sort_direction,
        },
      });
      commit("setCategories", [false, response.data]);
    } catch (error) {
      commit("setCategories", [false]);
      console.error(error);
    }
  },

  getCategory({ commit }, id) {
    return axiosClient.get(`/categories/${id}`);
  },

  createCategory({ commit }, category) {
    // return axiosClient.post('/categories', category)
    if (category.image instanceof File) {
      const form = new FormData();
      form.append("title", category.title);
      form.append("image", category.image);
      form.append("description", category.description || "");
      category = form;
    }

    return axiosClient.post("/categories", category);
  },

  deleteCategory({ commit }, id) {
    return axiosClient.delete(`/categories/${id}`);
  },

  updateCategory({ commit }, category) {
    const id = category.id;
    if (category.image instanceof File) {
      const form = new FormData();
      form.append("id", category.id);
      form.append("title", category.title);
      form.append("image", category.image);
      form.append("description", category.description || "");
      form.append("_method", "PUT");
      category = form;
    } else {
      category._method = "PUT";
    }
    return axiosClient.post(`/categories/${id}`, category);
  },
};

const getters = {};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
