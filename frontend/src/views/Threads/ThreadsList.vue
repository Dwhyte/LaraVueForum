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
    $route: "allThreads"
  },
  computed: {
    ...mapGetters({
      loading: "loading",
      user: "auth/user",
      threads: "getThreads"
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
.threadblock-norm {
  background: #fff;
  border: 1px solid #eef0f1;
  min-height: 125px;
}

.threadblock-norm:hover {
  -webkit-box-shadow: 0 0 0.3rem hsla(0, 0%, 69%, 0.25),
    0 0.2rem 0.35rem hsla(0, 0%, 69%, 0.25);
  box-shadow: 0 0 0.3rem hsla(0, 0%, 69%, 0.25),
    0 0.2rem 0.35rem hsla(0, 0%, 69%, 0.25);
}

.thread-header {
}

.thread-title {
  /* font-size: 1.1rem;
  padding-left: 1.5rem;
  display: block;
  border-radius: 4px;
  position: relative;
  padding: 1rem 0.75rem;
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out; */
}

.content-info-block {
  font-size: 1.1rem;
  padding-left: 1.5rem;
  /* display: block; */
  border-radius: 4px;
  position: relative;
  padding: 1rem 0.75rem;
  padding-bottom: 0;
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
  /*height: 184px;*/
  /*max-height: 184px;*/
  /* min-height: 184px; */
}

.thread-title a {
  text-transform: capitalize;
}

.thread-title .content-title {
  font-size: 17px;
  line-height: 25px;
}

.thread-title a:hover {
  text-decoration: none;
  color: #6e7c8a;
}

.thread-meta {
  font-size: 13px;
  /* float: right; */
  margin-bottom: 15px;
}

.thread-avatar {
  width: 40px;
  height: 40px;
  border-radius: 16%;
  border-radius: 999em;
}
.avatar-circle > span {
  font-size: 19px;
  position: absolute;
  left: 27px;
  top: 2px;
}
</style>
