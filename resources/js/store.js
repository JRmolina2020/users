import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        filters: {
            data: { value: "", keys: ["name", "surname", "email"] }
        },
        users: [],
        status: false,
        urluser: "users"
    },
    mutations: {
        Usermutations(state, item) {
            state.users = item;
        }
    },
    actions: {
        async Useractions({ commit, state }) {
            try {
                let response = await axios.get(state.urluser);
                commit("Usermutations", response.data);
                state.status = true;
            } catch (error) {
                console.log(error);
            }
        }
    }
});
