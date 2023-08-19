import axiosClient from "../../axios";

const state = {
  loading: false,
  data: [],
};

const mutations = {
  setSocialMedia(state, [loading, data = null]) {
    if (data) {
      state.data = data.data;
    }
    state.loading = false;
  },
};

const actions = {
  async getSocialMedias({ commit, state }, { url = null } = {}) {
    commit("setSocialMedia", [true]);
    url = url || "/socials";

    try {
      const response = await axiosClient.get(url);
      commit("setSocialMedia", [false, response.data]);
    } catch (err) {
      commit("setSocialMedia", [false]);
    }
  },

  async getSocialMedia(id) {
    return await axiosClient.get(`/socials/${id}`);
  },

  createSocialMedia({ commit }, socialMedia) {
    return axiosClient.post("/socials", socialMedia);
  },

  updateSocialMedia({ commit }, socialMedia) {
    const id = socialMedia.id;
    return axiosClient.put(`/socials/${id}`, socialMedia);
  },

  deleteSocialMedia({ commit }, id) {
    return axiosClient.delete(`/socials/${id}`);
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
