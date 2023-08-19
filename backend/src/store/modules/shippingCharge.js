import axiosClient from "../../axios";

const state = {
  loading: false,
  data: [],
};

const mutations = {
  setShippingCharge(state, [loading, data = null]) {
    if (data) {
      state.data = data.data;
    }
    state.loading = false;
  },
};

const actions = {
    async getShippingCharge({commit, state}, {url = null} = {}){
        commit("setShippingCharge", [true]);
        url = url || "/shipping";

        try{
            const response = await axiosClient.get(url);
            commit("setShippingCharge", [false, response.data]);
        }catch(err){
            commit("setShippingCharge", [false]);
        }
    },

    createShippingCharge({commit}, shippingCharge){
        return axiosClient.post("/shipping", shippingCharge);
    },

    updateShippingCharge({commit}, shippingCharge){
        const id = shippingCharge.id;
        return axiosClient.put(`/shipping/${id}`, shippingCharge);
    }
};

const getters = {};

export default{
    namespaced: true, 
    state, 
    mutations, 
    actions,
    getters,
}
