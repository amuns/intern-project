import axiosClient from "../../axios";

const state = {
  loading: false,
  data: [],
};

const mutations = {
  setBanner(state, [loading, data = null]) {
    if (data) {
      state.data = data.data;
    }
    state.loading = false;
  },
};

const actions = {
  async getBanner({ commit, state }, { url = null } = {}) {
    commit("setBanner", [true]);
    url = url || "/banner";

    try {
      const response = await axiosClient.get(url);
      commit("setBanner", [false, response.data]);
    } catch (error) {
      commit("setBanner", [false]);
      console.log(error);
    }
  },

  createBanner({ commit }, banner) {
    return axiosClient.post("/banner", banner);
  },

  updateBanner({ commit }, banner) {
    const id = banner.id;

    return axiosClient.put(`/banner/${id}`, banner);
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
