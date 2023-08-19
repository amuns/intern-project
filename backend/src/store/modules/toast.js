// import axiosClient from "../axios";

const state = {
  show: false,
  message: "",
  type: "",
  delay: 3000,
};

const mutations = {
  showSuccessToast(state, message) {
    state.show = true;
    state.message = message;
    state.type = "success";
  },

  showErrorToast(state, message) {
    state.show = true;
    state.message = message;
    state.type = "error";
  },

  showWarningToast(state, message) {
    state.show = true;
    state.message = message;
    state.type = "warning";
  },

  hideToast(state) {
    state.show = false;
    state.message = "";
  },
};

const actions = {
  enableSuccessToast({commit, state}, payload){
    commit("showSuccessToast", payload);
    setTimeout(() => {
      commit("hideToast");
    }, 3000);
  },

  enableErrorToast({commit, state}, payload){
    commit("showErrorToast", payload);
    setTimeout(() => {
      commit("hideToast");
    }, 3000);
  },

  enableWarningToast({commit, state}, payload){
    commit("showWarningToast", payload);
    setTimeout(() => {
      commit("hideToast");
    }, 3000);
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
