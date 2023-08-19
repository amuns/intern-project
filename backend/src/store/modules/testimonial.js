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
  setTestimonials(state, [loading, data = null]) {
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
  async getTestimonials(
    { commit, state },
    { url = null, search = "", per_page, sort_field, sort_direction } = {}
  ) {
    commit("setTestimonials", [true]);
    url = url || "/testimonials";
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
        commit("setTestimonials", [false, response.data]);
        // console.log(state);

      })
      .catch((err) => {
        commit("setTestimonials", [false]);
      });
  },

  getTestimonial({ commit }, id) {
    return axiosClient.get(`/testimonials/${id}`);
  },

  createTestimonial({ commit }, testimonial) {
    if (testimonial.display_picture instanceof File) {
      const form = new FormData();
      form.append("fullname", testimonial.fullname);
      form.append('display_picture', testimonial.display_picture);
      form.append("feedback", testimonial.feedback);
      form.append("published", testimonial.published ? 1 : 0);
      testimonial = form;
    }
    return axiosClient.post("/testimonials", testimonial);
  },

  deleteTestimonial({ commit }, id) {
    // return console.log(`/testimonials/${id}?path=${path}`);
    // console.log(url);
    return axiosClient.delete(`/testimonials/${id}`);
  },

  updateTestimonial({ commit }, testimonial) {
    const id = testimonial.id;
    if (testimonial.display_picture instanceof File) {
      const form = new FormData();
      form.append("fullname", testimonial.fullname);
      form.append('display_picture', testimonial.display_picture);
      form.append("feedback", testimonial.feedback);
      form.append("published", testimonial.published ? 1 : 0);
      form.append("_method", "PUT");
      testimonial = form;
    } else {
      testimonial._method = "PUT";
    }
    return axiosClient.post(`/testimonials/${id}`, testimonial);
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
