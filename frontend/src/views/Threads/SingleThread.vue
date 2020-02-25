<template>
  <div id="singleThread">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1">
          <div class="loading" v-if="isLoading">Loading...</div>
          <div class="thread-container" v-if="Thread">
            <div v-for="data in Thread.data" :key="data.id">
              <div>
                <div>
                  <img :src="data.thread_cover" style="width:100%" alt />
                </div>
                <div class="main-content">
                  <h1>{{ data.title }}</h1>
                  <small>{{ Thread.readtime }}</small>
                  <div v-cloak v-html="data.thread_content"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      routeInfo: {
        username: this.$route.params.username,
        slug: this.$route.params.slug
      }
    };
  },
  created() {
    this.getSingleThread();
  },
  watch: {
    // call again the method if the route change
    $route: "getSingleThread"
  },
  computed: {
    ...mapGetters({
      Thread: "getSingleThread",
      isLoading: "loading"
    })
  },
  methods: {
    ...mapActions({
      clearThread: "clearThread"
    }),
    getSingleThread() {
      this.$store.dispatch("GetSingleThread", this.routeInfo);
    }
  }
};
</script>
<style>
#singleThread .thread-container {
  /* background: #fff;
  padding: 4rem 4.75rem;
  border-radius: 4px;
  border: 1px solid #eef0f1; */
}

#singleThread .main-content {
  background: #fff;
  padding: 4rem 4.75rem;
  border-radius: 4px;
  border: 1px solid #eef0f1;
}

#singleThread .thread-container img {
  width: 100%;
}

[v-cloak] > * {
  display: none;
}
[v-cloak]::before {
  content: " ";
  display: block;
  position: absolute;
  width: 80px;
  height: 80px;
  background-image: url("~@/assets/spinner.gif");
  background-size: cover;
  left: 50%;
  top: 50%;
}
</style>
