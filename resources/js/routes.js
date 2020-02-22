import Vue from "vue";
import VueRouter from "vue-router";

import NotFound from "./components/views/NotFound";
import SignIn from "./components/views/Auth/SignIn";
import Register from "./components/views/Auth/Register";

Vue.use(VueRouter);

// export default new VueRouter({
//     mode: "history",
//     linkActiveClass: "active",

//     routes: [
//         {
//             path: "*",
//             name: "NotFound",
//             component: NotFound
//         },
//         {
//             path: "/auth/signin",
//             name: "SignIn",
//             component: SignIn
//         },
//         {
//             path: "/auth/register",
//             name: "Register",
//             component: Register
//         }
//     ]
// });

const routes = [
    {
        path: "*",
        name: "NotFound",
        component: NotFound
    },
    {
        path: "/auth/signin",
        name: "SignIn",
        component: SignIn
    },
    {
        path: "/auth/register",
        name: "Register",
        component: Register
    }
];

// const vueBodyClass = new VueBodyClass(routes);
// router.beforeEach((to, from, next) => {
//     vueBodyClass.guard(to, next);
// });

export default new VueRouter({
    mode: "history",
    linkActiveClass: "active",
    routes
});
