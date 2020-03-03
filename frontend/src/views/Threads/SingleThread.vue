<template>
  <div id="singleThread">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="loading" v-if="isLoading">Loading...</div>
          <div class="thread-container" v-if="threadData">
            <div v-for="thread in threadData" :key="thread.id">
              <div>
                <div>
                  <img :src="thread.featured_image" style="width:100%" alt />
                </div>
                <div class="main-content">
                  <h1>{{ thread.title }}</h1>
                  <div class="thread-meta mb-5">
                    <AvatarIcon :user="thread.user"></AvatarIcon>
                    <span>{{ thread.thread_created_on }} ・</span>
                    <span>{{ thread.read_time }}</span>
                  </div>
                  <div v-cloak v-html="thread.content" class="thread-content mb-5"></div>
                  <hr />
                  <div id="comment-container" class="container">
                    <ThreadComments :comments="thread.replies"></ThreadComments>
                  </div>
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
// import { mapGetters, mapActions } from "vuex";
import AvatarIcon from "@/components/AvatarIcon";
import ThreadComments from "@/components/Threads/ThreadComments";
export default {
  components: {
    AvatarIcon,
    ThreadComments
  },
  data() {
    return {
      routeInfo: {
        username: this.$route.params.username,
        slug: this.$route.params.slug
      },
      threadData: null,
      isLoading: false
    };
  },
  created() {
    this.getThread();
  },
  // watch: {
  //     // call again the method if the route change
  //     $route: "getSingleThread"
  // },
  // computed: {
  //     ...mapGetters({
  //         Thread: "getSingleThread",
  //         isLoading: "loading"
  //     })
  // },
  methods: {
    async getThread() {
      // console.log(routeInfo);
      try {
        this.isLoading = true;
        const response = await this.axios.get(
          `/api/thread/${this.routeInfo.username}/${this.routeInfo.slug}`
        );

        if (response) {
          this.isLoading = false;
          this.threadData = response.data.data;
        }
      } catch (e) {
        this.isLoading = false;
        console.log("oppsies ---> Get single thread Error:    " + e);
      }
    }
    // ...mapActions({
    //     clearThread: "clearThread",
    //     singleThread: "GetSingleThread"
    // }),
    // getSingleThread() {
    //     this.$store.dispatch("GetSingleThread", this.routeInfo);
    // }
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
  padding: 2rem 2.75rem;
  border-radius: 4px;
  border: 1px solid #eef0f1;
}

#singleThread .thread-content {
  font-size: 17px;
  line-height: 33px;
}

#singleThread .thread-container img {
  width: 100%;
}

#singleThread .thread-meta {
  display: inline-flex;
}

#singleThread .thread-meta span {
  margin-top: 12px;
}

#singleThread .thread-meta .avatar_icon__icon.picture_circle {
  margin: inherit !important;
  margin-right: 25px !important;
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

.moveLeft {
  margin-left: 40px;
}

@media (max-width: 500px) {
  #singleThread > .container > .row > .col-lg-12 {
    padding: 0;
  }

  #singleThread .main-content > h1 {
    font-size: 28px;
  }

  .editr--toolbar {
    overflow: hidden;
  }
}
</style>
