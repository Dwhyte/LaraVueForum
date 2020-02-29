<template>
  <div id="threads-section">
    <div class="mb-4">
      <ul v-if="threads" class="list-unstyled">
        <li class="threadblock-norm thread mb-4" v-for="thread in threads.data" :key="thread.id">
          <div class="content-info-block">
            <div class="thread-header row">
              <div class="col-md-1" style="padding-right: 0;">
                <AvatarIcon :user="thread.user"></AvatarIcon>
              </div>
              <div class="col-md-11">
                <div class="content-title">
                  <router-link
                    :to="`/thread/${thread.user.username}/${thread.slug}`"
                    class="font-weight-bold"
                  >{{ thread.title }}</router-link>
                  <div class="thread-meta">
                    <span class="display-name">
                      <router-link
                        class="font-weight-bold"
                        :to="`/u/${thread.user.username}`"
                      >{{ thread.user.username }}</router-link>
                    </span>
                    <span class="display-date font-weight-bold">
                      · {{ thread.thread_created_on }}
                      <span
                        v-if="thread.thread_created_on"
                        class="time-ago"
                        style="color: #596671;font-weight: 100;font-size: 11px;"
                      >({{ thread.thread_updated_on }})</span>
                    </span>
                    <div style="margin-top: 8px;position: absolute;right: 17px;">
                      <i class="fas fa-heart" style="color: #ec4141;" />
                      {{ thread.likes }}
                      <i
                        class="far fa-comment-dots"
                        style="margin-left: 16px;"
                      />
                      {{ thread.replies }}
                    </div>
                  </div>
                </div>
                <router-link
                  :to="`/threads/${thread.category}`"
                  class="text-uppercase font-weight-bold"
                  v-bind:style="{
                        color: `${thread.category_color}`,
                        fontSize: `.7rem`
                   }"
                >#{{ thread.category }}</router-link>
                <div class="content" style="font-size: 15px;">
                  <p style="margin: 0;" v-html="`${thread.skimmed_content}`"></p>
                </div>

                <div class="bottom" style="width:100%">
                  <ThreadSaveBtn
                    v-if="user"
                    :saved-threads="user.savedThreads"
                    :thread-i-d="thread.id"
                  ></ThreadSaveBtn>
                  <router-link v-if="!user" to="/signin" style="float:right">
                    <button
                      class="small mb-2 btn btn-link thread-save-btn btn-sm text-uppercase font-weight-bold"
                    >Save</button>
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
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
import ThreadSaveBtn from "@/components/Threads/ThreadSaveBtn";
import AvatarIcon from "@/components/AvatarIcon";
export default {
  // props: ["threads"],
  components: {
    ThreadSaveBtn,
    AvatarIcon
  },
  data() {
    return {};
  },
  mounted() {
    this.allThreads();
    this.$root.$on("sortBy", type => {
      console.log("you clicked on new");
      this.sortByBlah(type);
    });
  },
  watch: {
    $route: "allThreads"
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
      threads: "getThreads"
    }),
    loading() {
      return this.$store.state.isLoading;
    }
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
      // this.allThreads();
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
  float: right;
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
