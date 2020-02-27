<template>
  <div class="thread-sticky-side-menu">
    <div class="cat-box">
      <ul v-if="catData" class="list-unstyled">
        <li class="mb-3">
          <button
            @click.prevent="updateNav('all')"
            class="btn btn-link btn-outline-claim btn-sm text-uppercase font-weight-bold"
            :class="{ catActive: $route.path == `/threads/all` }"
          >ALL</button>
        </li>
        <li class="mb-3" v-for="category in catData.data" :key="category.id">
          <button
            class="btn btn-link btn-outline-claim btn-sm text-uppercase font-weight-bold"
            :class="{
                            catActive:
                                $route.path == `/threads/${category.slug}`
                        }"
            @click.prevent="updateNav(category.slug)"
          >{{ category.name }}</button>
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
    updateNav(categoryName) {
      this.$router.push({
        name: "landing",
        params: { category: categoryName }
      });
    }
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
