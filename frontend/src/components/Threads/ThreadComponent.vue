<template>
    <ul v-if="threads" class="list-unstyled">
        <li
            class="threadblock-norm thread mb-4"
            v-for="thread in threads.data"
            :key="thread.id"
        >
            <div class="content-info-block">
                <div class="thread-header row">
                    <div class="col-md-1" style="padding-right: 0;">
                        <AvatarIcon :user="thread.user"></AvatarIcon>
                    </div>
                    <div class="col-md-11">
                        <div class="content-title mb-2">
                            <router-link
                                :to="
                                    `/thread/${thread.user.username}/${thread.slug}`
                                "
                                class="font-weight-bold"
                                >{{ thread.title }}</router-link
                            >
                            <ThreadSaveBtn
                                v-if="user"
                                :saved-threads="user.savedThreads"
                                :thread-i-d="thread.id"
                            ></ThreadSaveBtn>
                        </div>
                        <div class="thread-meta">
                            <router-link
                                :to="`/threads/${thread.category}`"
                                class="btn btn-sm text-uppercase font-weight-bold"
                                v-bind:style="{
                                    color: `#ffffff`,
                                    backgroundColor: `${thread.category_color}`,
                                    borderColor: `${thread.category_color}`,
                                    fontSize: `.5rem`,
                                    marginRight: `5px`,
                                    padding: `3px`
                                }"
                                >#{{ thread.category }}</router-link
                            >|
                            <span class="display-name">
                                <router-link
                                    class="font-weight-bold"
                                    :to="`/u/${thread.user.username}`"
                                    >{{ thread.user.username }}</router-link
                                >
                            </span>
                            <span class="display-date font-weight-bold">
                                · {{ thread.thread_created_on }}
                                <span
                                    v-if="thread.thread_created_on"
                                    class="time-ago"
                                    style="color: #596671;font-weight: 100;font-size: 11px;"
                                    >({{ thread.thread_updated_on }})</span
                                >
                            </span>
                            <div class="thread-stats">
                                <i class="fas fa-heart" />
                                {{ thread.likes }}
                                <i class="far fa-comment-dots" />
                                {{ thread.replies }}
                            </div>
                        </div>
                        <div class="thread-content">
                            <p
                                class="m-0"
                                v-html="`${thread.skimmed_content}`"
                            ></p>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
import ThreadSaveBtn from "@/components/Threads/ThreadSaveBtn";
import AvatarIcon from "@/components/AvatarIcon";
export default {
    name: "ThreadComponent",
    props: ["threads", "user"],
    components: {
        AvatarIcon,
        ThreadSaveBtn
    },
    data() {
        return {};
    }
};
</script>

<style scoped>
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

.content-title a:hover {
    color: #468cca;
}

.thread-content {
    font-size: 15px;
    width: 71%;
    margin-bottom: 15px;
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

.thread-meta .display-name a:hover {
    text-decoration: none;
    color: #468cca;
}

.thread-stats {
    margin-top: 8px;
    position: absolute;
    right: 17px;
    font-size: 17px;
}

.thread-stats .fas.fa-heart {
    color: #ec4141;
}

.thread-stats .far.fa-comment-dots {
    margin-left: 16px;
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
