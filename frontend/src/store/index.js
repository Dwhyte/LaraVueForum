import Vue from "vue";
import Vuex from "vuex";
import auth from "./auth";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    namespaced: true,
    state: {
        isLoading: false,
        threadData: null,
        categories: null,
        singleThread: null
    },
    getters: {
        loading(state) {
            return state.isLoading;
        },
        getThreads(state) {
            return state.threadData;
        },
        getCategoryNames(state) {
            return state.categories;
        },
        getSingleThread(state) {
            return state.singleThread;
        }
    },
    mutations: {
        SET_LOADER(state, loader) {
            state.isLoading = loader;
        },
        SET_THREADS(state, threads) {
            state.threadData = threads;
            state.isLoading = false;
        },
        SET_CATEGORIES(state, categories) {
            state.categories = categories;
        },
        SET_SINGLETHREAD(state, thread) {
            state.singleThread = thread;
        }
    },
    actions: {
        // Get all Categories
        async GetCategories({ commit }) {
            try {
                const response = await axios.get("/api/categories");
                // console.log(response.data);
                commit("SET_CATEGORIES", response.data);
            } catch (e) {
                console.log("oppsies ---> Get Categories Error:    " + e);
            }
        },

        // Get all threads by category
        async GetThreads({ commit }, category) {
            try {
                commit("SET_LOADER", true);
                const response = await axios.get(`/api/thread/${category}`);

                if (response) {
                    commit("SET_LOADER", false);
                    commit("SET_THREADS", response.data);
                }
            } catch (e) {
                console.log("oppsies ---> Get Threads Error:    " + e);
            }
        },

        // Get single thread by :username and :slug
        async GetSingleThread({ commit, dispatch }, routeInfo) {
            // console.log(routeInfo);
            try {
                dispatch("clearThread");
                commit("SET_LOADER", true);
                const response = await axios.get(
                    `/api/thread/${routeInfo.username}/${routeInfo.slug}`
                );

                if (response) {
                    commit("SET_LOADER", false);
                    commit("SET_SINGLETHREAD", response.data);
                }
            } catch (e) {
                console.log("oppsies ---> Get single thread Error:    " + e);
            }
        },

        clearThread({ commit }) {
            commit("SET_SINGLETHREAD", null);
        }
    },
    modules: {
        auth
    }
});
