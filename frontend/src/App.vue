<template>
    <div id="app">
        <TheNavigation :user="user" :is-auth="isAuth" />
        <router-view />
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import TheNavigation from "@/components/Inc/TheNavigation";
export default {
    name: "AppHome",
    mounted() {
        this.getCats();
    },
    components: {
        TheNavigation
    },
    metaInfo: {
        // if no subcomponents specify a metaInfo.title, this title will be used
        title: "Lara Node Forum",
        // all titles will be injected into this template
        titleTemplate: "%s | Welcome To My Awesome Forum"
    },
    watch: {
        // $route: "getCats"
    },
    computed: {
        ...mapGetters({
            isAuth: "auth/authenticated",
            user: "auth/user"
        })
    },
    methods: {
        ...mapActions({
            getCats: "GetCategories"
        })
    }
};
</script>
<style>
@import url("https://fonts.googleapis.com/css?family=Oxygen");
@import "main.css";
@import "../src/assets/css/nprogress.css";
</style>
