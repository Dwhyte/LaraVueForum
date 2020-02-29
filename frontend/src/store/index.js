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
        singleThread: null,
        sortBy: null
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
        },
        getSortKeyword(state) {
            return state.sortBy;
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
        },
        SET_SORT(state, sortBy) {
            state.sortBy = sortBy;
        },

        SORT_THREADS(state, sortBy) {
            switch (sortBy) {
                case "new":
                    state.threadData.data = state.threadData.data.sort(
                        (a, b) => a.created_at - b.created_at
                    );
                    state.sortBy = sortBy;
                    console.log("sort by new");
                    break;

                case "most_active":
                    state.threadData.data = state.threadData.data.sort(
                        (a, b) => b.replies - a.replies
                    );
                    state.sortBy = sortBy;
                    console.log("sort by most_active");
                    break;

                case "no_replies":
                    state.threadData.data = state.threadData.data.sort(
                        (a, b) => a.replies - b.replies
                    );
                    state.sortBy = sortBy;
                    console.log("sort by no_replies");
                    break;

                default:
                    break;
            }
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

        // Set thread sort option
        setSortOption({ commit }, sortBy) {
            commit("SORT_THREADS", sortBy);
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
