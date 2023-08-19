import axiosClient from "../../axios";

const state = {
  loading: false,
  data: [],
};

const mutations = {
  setScripts(state, [loading, data = null]) {
    if (data) {
      state.data = data?.data;
    }

    state.loading = loading;
  },
};

const actions = {
  async getScripts({ commit, state }, { url = null } = {}) {
    commit("setScripts", [true]);
    url = url || "/scripts";

    try {
      const response = await axiosClient.get(url);
      commit("setScripts", [false, response.data]);
    } catch (err) {
      commit("setScripts", [false]);
      console.log(err);
    }
  },

  createScript({ commit }, scripts) {
    // console.log(scripts);
    return axiosClient.post("/scripts", scripts);
  },

  updateScript({ commit }, scripts) {
    const id = scripts.id;

    return axiosClient.put(`/scripts/${id}`, scripts);
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
