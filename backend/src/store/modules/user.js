import axiosClient from "../../axios";

const state = {
    token: sessionStorage.getItem("TOKEN"),
    data: {},
};

const mutations = {
  setUser(state, user) {
    state.data = user;
  },

  setToken(state, token) {
    state.token = token;
    if (token) {
      sessionStorage.setItem("TOKEN", token);
    } else {
      sessionStorage.removeItem("TOKEN");
    }
  },
};

const actions = {
  getCurrentUser({ commit }, data) {
    return axiosClient.get("/user", data).then(({ data }) => {
      commit("setUser", data);
      return data;
    });
  },

  login({ commit }, data) {
    // return console.log("hi");
    return axiosClient.post("/login", data).then(({ data }) => {
      commit("setUser", data.user);
      commit("setToken", data.token);
      return data;
    });
  },

  logout({ commit }) {
    return axiosClient.post("/logout").then((response) => {
      commit("setToken", null);

      return response;
    });
  },
};

const getters = {};

export default {
  namespaced: false,
  state,
  mutations,
  actions,
  getters,
};
