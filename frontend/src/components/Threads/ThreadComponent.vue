<template>
  <ul v-if="threads" class="list-unstyled">
    <li class="threadblock-norm thread mb-4" v-for="thread in threads.data" :key="thread.id">
      <div class="content-info-block">
        <div class="thread-header row">
          <div class="col-md-1" style="padding-right: 0;">
            <AvatarIcon :user="thread.user"></AvatarIcon>
          </div>
          <div class="col-md-11">
            <div class="content-title mb-2">
              <router-link
                :to="`/thread/${thread.user.username}/${thread.slug}`"
                class="font-weight-bold"
              >{{ thread.title }}</router-link>
              <ThreadSaveBtn v-if="user" :saved-threads="user.savedThreads" :thread-i-d="thread.id"></ThreadSaveBtn>
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
              >#{{ thread.category }}</router-link>|
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
              <div style="margin-top: 8px;position: absolute;right: 17px;font-size: 17px;">
                <i class="fas fa-heart" style="color: #ec4141;" />
                {{ thread.likes }}
                <i
                  class="far fa-comment-dots"
                  style="margin-left: 16px;"
                />
                {{ thread.replies }}
              </div>
            </div>
            <div class="content" style="font-size: 15px;width: 71%;margin-bottom: 15px;">
              <p style="margin: 0;" v-html="`${thread.skimmed_content}`"></p>
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

<style>
</style>