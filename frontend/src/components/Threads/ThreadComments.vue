<template>
  <div>
    <h3>Comments:</h3>
    <wysiwyg placeholder="Add to the discussion" v-model="editorData" />
    <div
      class="display-comments container mt-4"
      v-for="comment in comments"
      :key="comment.id"
      :class="{ moveLeft: comment.parent_id !== null }"
    >
      <div class="comment row">
        <div class="col-md-1" style="padding-right:0px">
          <AvatarIcon :user="comment.user"></AvatarIcon>
        </div>
        <div class="col-md-11">
          <div class="meta mb-2">
            <router-link
              :to="`/u/${comment.user.username}`"
              :title="comment.user.username"
              class="font-weight-bold mr-2"
            >{{ comment.user.username }}</router-link>
            <span class="comment-time">{{ comment.created_at }}</span>
          </div>
          <div class="comment-text">
            <p>{{ comment.reply }}</p>
          </div>
        </div>
      </div>
      <div
        class="comment inner-comment row mt-1"
        :id="child.id"
        v-for="(child, index) in comment.replies"
        :key="index"
        :class="{ moveLeft: child.parent_id !== null }"
      >
        <div class="col-md-1" style="padding-right:0px">
          <AvatarIcon :user="comment.user"></AvatarIcon>
        </div>
        <div class="col-md-11">
          <div class="meta mb-2">
            <router-link
              :to="`/u/${child.user.username}`"
              :title="child.user.username"
              class="font-weight-bold mr-2"
            >{{ child.user.username }}</router-link>
            <span class="comment-time">{{ child.created_at }}</span>
          </div>
          <div class="comment-text">
            <p>{{ child.reply }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AvatarIcon from "@/components/AvatarIcon";
export default {
  name: "Comments",
  props: ["comments"],
  components: {
    AvatarIcon
  },
  data() {
    return {
      editorData: ""
    };
  }
};
</script>

<style scoped>
.comment {
  border: 2px solid #58585826;
  padding: 15px;
}
.comment-time {
  font-size: 13px;
  margin-bottom: 15px;
  float: right;
}

.comment-text p {
  font-size: 15px;
  width: 71%;
  margin-bottom: 15px;
}
</style>