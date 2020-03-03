<template>
  <div id="threads-section">
    <div class="mb-4">
      <thread-component :threads="threads" :user="user"></thread-component>
      <div v-if="loading" class="text-center">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <div v-if="!threads">
        <h4 class="text-center">No exists for this category</h4>
      </div>
    </div>
  </div>
</template>
<script>
// import ThreadDisplayPlaceholder from "./ThreadDisplayPlaceholder";
// import { ContentLoader } from "vue-content-loader";
import { mapGetters, mapActions } from "vuex";
import ThreadComponent from "@/components/Threads/ThreadComponent";
export default {
  components: {
    ThreadComponent
  },
  data() {
    return {};
  },
  mounted() {
    this.allThreads();
    this.$root.$on("sortBy", type => {
      this.sortByBlah(type);
    });
  },
  watch: {
    $route: ["allThreads"]
  },
  computed: {
    ...mapGetters({
      loading: "loading",
      user: "auth/user",
      threads: "getThreads",
      getSortKeyword: "getSortKeyword"
    })
  },
  methods: {
    ...mapActions({
      getAllThreads: "GetThreads",
      sortBy: "setSortOption"
    }),
    allThreads() {
      this.getAllThreads(this.$route.params.category);
    },
    sortByBlah(type) {
      this.sortBy(type);
    }
  }
};
</script>
<style>
#threads-section {
  margin-left: 1rem;
  width: calc(100% - 11rem);
}
</style>
