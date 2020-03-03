<template>
    <div class="thread-sticky-side-menu">
        <div class="cat-box">
            <ul v-if="catData" class="list-unstyled">
                <li class="mb-3">
                    <router-link to="/threads/all">
                        <button
                            class="btn btn-link btn-outline-claim btn-sm text-uppercase font-weight-bold"
                            :class="{
                                catActive: $route.path == `/threads/all`
                            }"
                        >
                            ALL
                        </button>
                    </router-link>
                </li>
                <li
                    class="mb-3"
                    v-for="category in catData.data"
                    :key="category.id"
                >
                    <router-link :to="`/threads/${category.slug}`">
                        <button
                            class="btn btn-link btn-outline-claim btn-sm text-uppercase font-weight-bold"
                            :class="{
                                catActive:
                                    $route.path == `/threads/${category.slug}`
                            }"
                        >
                            {{ category.name }}
                        </button>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {};
    },
    watch: {
        // $route: "updateNav"
        // eslint-disable-next-line no-dupe-keys
        // $route: "getCats"
    },
    computed: {
        ...mapGetters({
            catData: "getCategoryNames"
        })
    },
    methods: {
        // ...mapActions({
        //   getCats: "GetCategories"
        // }),
        // updateNav(categoryName) {
        //   // this.$router
        //   //   .replace({
        //   //     path: `/threads/${categoryName}`
        //   //   })
        //   //   .catch(err => {
        //   //     console.log(err);
        //   //   });
        //   // this.$router
        //   //   .push({
        //   //     path: "/threads/",
        //   //     params: { category: categoryName }
        //   //   })
        //   //   .catch(err => {
        //   //     console.log(err);
        //   //   });
        // }
    }
};
</script>
<style>
.thread-sticky-side-menu {
    /* margin-left: auto;
  margin-right: auto; */
}

.cat-box {
    position: sticky;
    top: 4.5rem;
}

.thread-sticky-side-menu .cat-box .btn.btn-link {
    width: 100%;
    color: #34495e;
}

.thread-sticky-side-menu .cat-box .btn.btn-link:hover {
    text-decoration: none;
    color: #ffffff;
}

.catActive {
    color: #ffffff !important;
    background-color: #536eec;
    border-color: #536eec;
    text-decoration: none;
}

.catActive:focus {
    text-decoration: none;
}
</style>
