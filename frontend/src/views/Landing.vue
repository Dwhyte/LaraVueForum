<template>
    <div class="content">
        <div class="container position-relative">
            <div class="row">
                <div class="message-board col-md-12 mb-5">
                    <p>Message Board: Some kind of message</p>
                </div>
            </div>
            <div class="row">
                <div
                    class="thread-sorting mb-5"
                    style="width: calc(100% - 5.5rem);"
                >
                    <router-link
                        v-if="isAuth"
                        to="/thread/new"
                        class="btn btn-sm btn-outline-claim font-weight-bold text-uppercase"
                        >Write A Post</router-link
                    >

                    <router-link
                        v-if="!isAuth"
                        to="/signin"
                        class="btn btn-sm btn-outline-claim font-weight-bold text-uppercase"
                        >Login to Post</router-link
                    >
                </div>
            </div>
            <div class="row">
                <category-actions />
                <threads />
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
import Threads from "@/views/Threads/ThreadsList";
import CategoryActions from "@/components/Categories/CategoryActions";
export default {
    name: "landing",
    components: {
        Threads,
        CategoryActions
    },
    data() {
        return {
            routeName: this.$route.params.category
        };
    },
    metaInfo() {
        return {
            titleTemplate: `%s - ${this.routeName.toUpperCase()}`
        };
    },
    computed: {
        ...mapGetters({
            isAuth: "auth/authenticated"
        })
    }
};
</script>
<style>
body {
    background: #fafafa;
}

.thread-sorting .btn-outline-claim {
    float: right;
}
</style>
