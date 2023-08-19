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
  setPages(state, [loading, data = null]) {
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
  async getPages({ commit, state }, { url=null, search = "", per_page, sort_field, sort_direction } = {}){
    commit("setPages", [true]);
    url = url || "/pages";
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
        commit("setPages", [false, response.data]);
        // console.log(state);

      })
      .catch((err) => {
        commit("setPages", [false]);
      });
  },

  async getPage({ commit }, id) {
    return await axiosClient.get(`/pages/${id}`);
  },

  createPage({commit}, page){
    return axiosClient.post("/pages", page);
  },

  deletePage({commit}, id){
    return axiosClient.delete(`/pages/${id}`);
  },

  updatePage({commit}, page){
    const id = page.id;
    // if(page.published === false){
    //   page.published = '0';
    //   console.log("true");
    // }
    // else{
    //   page.published = 1;
    // }
    // console.log(page); return
    return axiosClient.put(`/pages/${id}`, page);
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
