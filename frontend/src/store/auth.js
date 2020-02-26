import axios from "axios";
import router from "@/router";

export default {
    namespaced: true, // must add this so we can call action methods inside components
    state: {
        token: null,
        user: null,
        isAuthenticated: false,
        loginErrors: {},
        registerErrors: {}
    },
    getters: {
        authenticated(state) {
            return state.token && state.user;
        },
        user(state) {
            return state.user;
        },
        getLoginErrors(state) {
            return state.loginErrors;
        },
        getRegisterErrors(state) {
            return state.registerErrors;
        }
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token;
        },
        SET_USER(state, data) {
            state.user = data;
        },
        SET_AUTH(state, status) {
            state.isAuthenticated = status;
        },
        SET_LOGIN_ERRORS(state, errors) {
            state.loginErrors = errors;
        },
        SET_REGISTER_ERRORS(state, errors) {
            state.registerErrors = errors;
        }
    },
    actions: {
        // Sign In User
        async signIn({ commit, dispatch }, credentials) {
            try {
                // dispatch("clearErrors");
                let response = await axios.post("/api/auth/login", credentials);
                if (response) {
                    router.push({
                        name: "landing",
                        params: {
                            category: "all"
                        }
                    });
                    return dispatch("attempt", response.data.token);
                }
            } catch (e) {
                commit("SET_LOGIN_ERRORS", e.response.data);
            }
        },

        // Register a User
        async register({ commit, dispatch }, credentials) {
            try {
                // dispatch("clearErrors");
                let response = await axios.post(
                    "/api/auth/register",
                    credentials
                );
                if (response) {
                    router.push({
                        name: "landing",
                        params: {
                            category: "all"
                        }
                    });
                    return dispatch("attempt", response.data.token);
                }
            } catch (e) {
                commit("SET_REGISTER_ERRORS", e.response.data);
            }
        },

        // Attemp login/Register Token
        async attempt({ commit, state }, token) {
            if (token) {
                commit("SET_TOKEN", token);
            }

            if (!state.token) {
                return;
            }

            // check if me route works
            try {
                let response = await axios.post("/api/auth/me", {
                    headers: {
                        Authorization: "Bearer " + token
                    }
                });

                commit("SET_USER", response.data);
                commit("SET_AUTH", true);
            } catch (error) {
                commit("SET_TOKEN", null);
                commit("SET_USER", null);
            }
        },

        signOut({ commit }) {
            return axios.post("/api/auth/logout").then(() => {
                commit("SET_TOKEN", null);
                commit("SET_USER", null);
                commit("SET_AUTH", false);
            });
        },

        clearErrors({ commit }) {
            commit("SET_REGISTER_ERRORS", {});
            commit("SET_LOGIN_ERRORS", {});
        }
    }
};
