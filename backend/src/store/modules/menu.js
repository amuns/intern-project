import axiosClient from "../../axios";

const state = {
  loading: false,
  data: [],
};

const mutations = {
  setMenus(state, [loading, data = null]) {
    if (data) {
      state.data = data.data;
    }
    state.loading = false;
  },
};

const actions = {
  async getMenus({ commit, state }, { url = null } = {}) {
    commit("setMenus", [true]);
    url = url || "/menus";

    try {
      const response = await axiosClient.get(url);
      commit("setMenus", [false, response.data]);
    } catch (error) {
      commit("setMenus", [false]);
      console.log(error);
    }
  },

  getMenu({ commit }, id) {
    return axiosClient.get(`/menus/${id}`);
  },

  createMenu({ commit }, menu) {
    return axiosClient.post(`/menus`, menu);
  },

  deleteMenu({ commit }, id) {
    return axiosClient.delete(`/menus/${id}`);
  },

  updateMenu({ commit }, menu) {
    const title = menu.title;
    return axiosClient.put(`/menus/${title}`, menu);
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
