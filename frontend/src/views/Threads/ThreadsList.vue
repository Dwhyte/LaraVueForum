<template>
    <div id="threads-section">
        <div class="mb-4">
            <ul v-if="threads" class="list-unstyled">
                <li
                    class="threadblock-norm thread mb-4"
                    v-for="thread in threads.data"
                    :key="thread.id"
                >
                    <div class="content-info-block row">
                        <div class="thread-header col-md-12">
                            <div class="content-title">
                                <router-link
                                    :to="
                                        `/thread/${thread.user}/${thread.slug}`
                                    "
                                    class="font-weight-bold"
                                    >{{ thread.title }}</router-link
                                >
                            </div>
                            <div class="thread-meta">
                                <div>
                                    <span class="display-name">
                                        <router-link
                                            class="font-weight-bold"
                                            :to="`/u/${thread.user}`"
                                            >{{ thread.user }}</router-link
                                        >
                                    </span>
                                    <span class="display-date font-weight-bold">
                                        · {{ thread.thread_created_on }}
                                        <span
                                            v-if="thread.thread_created_on"
                                            class="time-ago"
                                            style="color: #596671;"
                                            >({{
                                                thread.thread_updated_on
                                            }})</span
                                        >
                                    </span>
                                </div>
                                <div>
                                    <router-link
                                        :to="`/threads/${thread.category}`"
                                    >
                                        <span
                                            class="text-uppercase font-weight-bold"
                                            v-bind:style="{
                                                color: `${thread.category_color}`,
                                                fontSize: `13px`
                                            }"
                                            >#{{ thread.category }}</span
                                        >
                                    </router-link>
                                </div>
                            </div>
                            <!-- <div>
                                    <i
                                        class="fas fa-heart"
                                        style="color: #ec4141;"
                                    />
                                    {{ thread.likes }}
                                    <i
                                        class="far fa-comment-dots"
                                        style="margin-left: 16px;"
                                    />
                                    {{ thread.replies }}
                                </div> -->
                            <!-- <div
                                    class="small mt-2"
                                    style="position: absolute;bottom: -7px;right: 121px;font-weight: 600;"
                                >
                                    {{ thread.read_time }}
                                </div> -->
                            <ThreadHeartsComponent
                                v-if="user"
                                :saved-threads="user.savedThreads"
                                :thread-i-d="thread.id"
                            />
                            <router-link to="/signin">
                                <button
                                    v-if="!user"
                                    class="small mt-2 btn btn-link thread-save-btn btn-sm text-uppercase font-weight-bold"
                                    style="position: absolute;bottom: -7px;right: 15px;font-weight: 600;"
                                >
                                    Save
                                </button>
                            </router-link>
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
import ThreadHeartsComponent from "../../components/Threads/ThreadHeartsComponent";
export default {
    // props: ["threads"],
    components: {
        ThreadHeartsComponent
    },
    data() {
        return {};
    },
    mounted() {
        this.allThreads();
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
            getAllThreads: "GetThreads"
        }),
        allThreads() {
            this.getAllThreads(this.$route.params.category);
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
}

.threadblock-norm:hover {
    -webkit-box-shadow: 0 0 0.3rem hsla(0, 0%, 69%, 0.25),
        0 0.2rem 0.35rem hsla(0, 0%, 69%, 0.25);
    box-shadow: 0 0 0.3rem hsla(0, 0%, 69%, 0.25),
        0 0.2rem 0.35rem hsla(0, 0%, 69%, 0.25);
}

.thread {
    /* font-size: 1.1rem;
  padding-left: 1.5rem;
  display: block;
  border-radius: 4px;
  position: relative;
  padding: 1rem 0.75rem;
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out; */
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
