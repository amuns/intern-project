import axiosClient from "../../axios";

const state = {
    loading: false,
    data: []
};

const mutations = {
    setBrandingHeader(state, [loading, data=null]){
        if(data){
            state.data = data.data;
        }
        state.loading = loading
    }
};

const actions = {
    async getBrandingHeader({commit, state}, {url=null} = {}){
        commit("setBrandingHeader", [true]);
        url = url || "/branding";

        try {
            const response = await axiosClient.get(url);
            commit("setBrandingHeader", [false, response.data]);
        } catch (error) {
            commit("setBrandingHeader", [false]);
            console.log(error);
        }
    }, 

    createBrandingHeader({commit}, brandHeader){
        if(brandHeader.logo instanceof File) {
            const form = new FormData();
            form.append("logo", brandHeader.logo);
            form.append("company_name", brandHeader.company_name);
            brandHeader = form;
        }

        return axiosClient.post("/branding", brandHeader);
    },

    updateBrandingHeader({commit}, brandingHeader){
        const id = brandingHeader.id;
        if(brandingHeader.logo instanceof File){
            const form = new FormData();
            form.append("id", id);
            form.append("logo", brandingHeader.logo);
            form.append("company_name", brandingHeader.company_name);
            form.append("_method", "PUT");
            brandingHeader = form; 

        }else{
            brandingHeader._method = "PUT";
        }

        return axiosClient.post(`/branding/${id}`, brandingHeader);
    },

    
};

const getters = {};

export default{
    namespaced: true, 
    state, 
    mutations, 
    actions, 
    getters,
}