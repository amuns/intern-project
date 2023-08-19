import axiosClient from "../../axios";

const state = {
  loading: false,
  data: [],
  
};

const mutations = {
  setSliders(state, [loading, data = null]) {
    if (data) {
      // console.log(loading);return
      state.data = data.data;
      
    }
    state.loading = loading;
  },
};

const actions = {
  async getSliders(
    { commit, state },
    { url = null } = {}
  ) {
    commit("setSliders", [true]);
    url = url || "/sliders";
   
    try{
      const response = await axiosClient.get(url);
      // console.log(response.data); return
      commit("setSliders", [false, response.data]);
    } catch(error) {
      commit("setSliders", [false]);
      console.error(error);
    }
    
  },

  getFeatured({ commit }) {
    return axiosClient.get(`/sliders/featured`);
  },

  createSlider({ commit }, slider) {
    if (slider.slider_image instanceof File) {
      const form = new FormData();
      form.append("image", slider.slider_image);
      form.append("product_id", slider.product_id);
      form.append("slider", slider.slider==true?1:0);
      form.append("trending", slider.trending==true?1:0);
      form.append("featured", slider.trending==true?1:0);
      slider = form;
    }

    return axiosClient.post("/sliders", slider);
  },

  deleteSlider({ commit }, id) {
    return axiosClient.delete(`/sliders/${id}`);
  },

  updateSlider({ commit }, slider) {
    // console.log(slider); return;
    const id = slider.id;
    if (slider.image instanceof File) {
      const form = new FormData();
      form.append("id", slider.id);
      // form.append("title", slider.title);
      // form.append("subtitle", slider.subtitle);
      form.append("image", slider.image);
      form.append("link", slider.link);
      form.append("published", slider.published ? 1 : 0);
      form.append("_method", "PUT");
      slider = form;
    } else {
      slider._method = "PUT";
    }
    // console.log(slider);return;
    return axiosClient.post(`/sliders/${id}`, slider);
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
