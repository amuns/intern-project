import axiosClient from "../../axios";

const state = [];

const mutations = {
  setCountries(state, countries) {
    state.splice(0, state.length, ...countries?.data);
  },
};

const actions = {
  getCountries({ commit }) {
    return axiosClient.get("countries").then(({ data }) => {
      commit("setCountries", data);
    });
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
