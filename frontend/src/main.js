import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import NProgress from "nprogress";
import axios from "axios";
import VueAxios from "vue-axios";
// import vbclass from "vue-body-class";
import Meta from "vue-meta";
import VueFlashMessage from "vue-flash-message";
require("vue-flash-message/dist/vue-flash-message.min.css");

Vue.config.productionTip = false;

require("@/store/subscriber");

if (process.env.NODE_ENV === "development") {
    console.log("Devlopment mode");
    axios.defaults.baseURL = process.env.VUE_APP_AXIOS;
} else {
    axios.defaults.baseURL = process.env.VUE_APP_AXIOS_PRODUCTION;
    console.log("Live mode");
}

Vue.use(require("vue-moment"));
Vue.use(Meta);
Vue.use(VueAxios, axios);
Vue.use(VueFlashMessage);

// const vueBodyClass = new vbclass(router);
// router.beforeEach((to, from, next) => {
//     vueBodyClass.guard(to, next);
// });

router.beforeEach((to, from, next) => {
    // console.log(store.state.auth.isAuthenticated);
    NProgress.start();
    // check if the route requires authentication and user is not logged in
    if (
        to.matched.some(route => route.meta.requiresAuth) &&
        !store.state.auth.isAuthenticated
    ) {
        // redirect to login page
        next({
            name: "signin"
        });
        return;
    }

    // if logged in redirect to landing
    if (to.path === "/") {
        next({
            name: "landing",
            params: {
                category: "all"
            }
        });
        return;
    }

    // if logged in redirect to landing
    if (to.path === "/" && store.state.auth.isAuthenticated) {
        next({
            name: "landing",
            params: {
                category: "all"
            }
        });
        return;
    }

    // if logged in redirect to landing
    if (to.path === "/register" && store.state.auth.isAuthenticated) {
        next({
            name: "landing",
            params: {
                category: "all"
            }
        });
        return;
    }

    // if logged in redirect to landing
    if (to.path === "/signin" && store.state.auth.isAuthenticated) {
        next({
            name: "landing",
            params: {
                category: "all"
            }
        });
        return;
    }

    next();
});

router.afterEach(() => {
    NProgress.done();
});

store.dispatch("auth/attempt", localStorage.getItem("token")).then(() => {
    new Vue({
        router,
        store,
        render: h => h(App)
    }).$mount("#app");
});
