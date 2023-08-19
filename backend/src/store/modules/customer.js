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
  setCustomers(state, [loading, data = null]) {
    if (data) {
      /* state = {
        ...state,
        data: data.data,
        links: data.meta?.links,
        page: data.meta.current_page,
        limit: data.meta.per_page,
        from: data.meta.from,
        to: data.meta.to,
        total: data.meta.total,
      }; */
      state.data = data.data;
      state.links = data.meta?.links;
      state.page = data.meta.current_page;
      state.limit = data.meta.per_page;
      state.from = data.meta.from;
      state.to = data.meta.to;
      state.total = data.meta.total;
    }
    state.loading = loading;
  },
};

const actions = {
  getCustomers(
    { commit, state },
    { url = null, search = "", per_page, sort_field, sort_direction } = {}
  ) {
    commit("setCustomers", [true]);
    url = url || "/customers";
    const params = {
      per_page: state.limit,
    };
    return axiosClient
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
        commit("setCustomers", [false, response.data]);
      })
      .catch(() => {
        commit("setCustomers", [false]);
      });
  },

  getCustomer({ commit }, id) {
    return axiosClient.get(`/customers/${id}`);
  },

  createCustomer({ commit }, customer) {
    return axiosClient.post("/customers", customer);
  },

  updateCustomer({ commit }, customer) {
    return axiosClient.put(`/customers/${customer.id}`, customer);
  },

  deleteCustomer({ commit }, customer) {
    return axiosClient.delete(`/customers/${customer.id}`);
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
