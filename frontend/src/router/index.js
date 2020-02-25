import Vue from "vue";
import VueRouter from "vue-router";
import NotFound from "@/views/NotFound.vue";
import SignIn from "../views/Auth/SignIn.vue";
import Register from "../views/Auth/Register.vue";
import Landing from "../views/Landing.vue";
import SingleThread from "@/views/Threads/SingleThread.vue";
import CreateThread from "@/views/Threads/CreateThread.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "*",
        name: "NotFound",
        component: NotFound
    },
    {
        path: "/signin",
        name: "signin",
        component: SignIn,
        meta: {
            bodyClass: "body-padding"
        }
    },
    {
        path: "/register",
        name: "register",
        component: Register,
        meta: {
            bodyClass: "body-padding"
        }
    },
    {
        path: "/threads/:category",
        name: "landing",
        component: Landing
    },
    {
        path: "/thread/:username/:slug",
        component: SingleThread
    },
    {
        path: "/thread/new",
        name: "newThread",
        component: CreateThread,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/u/:username",
        component: () =>
            import(/* webpackChunkName: "profile" */ "@/views/User/Profile"),
        meta: {
            bodyClass: "body-profile-padding"
        }
    },
    {
        path: "/u/:username/settings",
        name: "UserSettings",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import(/* webpackChunkName: "settings" */ "@/views/User/Settings"),
        meta: {
            requiresAuth: true
        }
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    linkActiveClass: "active",
    routes
});

export default router;
