<template>
  <div>
    <i
      v-if="!saveThreadStatus"
      style="float:right"
      @click="saveThisThread(threadID)"
      class="far fa-bookmark"
    ></i>
    <i
      v-if="saveThreadStatus"
      style="float:right"
      @click="removeThisThread(threadID)"
      class="fas fa-bookmark"
    ></i>
  </div>
</template>

<script>
export default {
  name: "ThreadSaveBtn",
  props: ["threadID", "savedThreads"],
  data() {
    return {
      saveThreadStatus: false,
      savedData: this.savedThreads,
      currentThreadID: this.threadID,
      errors: null
    };
  },
  created() {
    this.savedThreadExists();
  },
  methods: {
    savedThreadExists() {
      if (this.savedThreads) {
        this.savedData.forEach(savedItem => {
          if (savedItem.thread_id === this.currentThreadID) {
            this.saveThreadStatus = true;
          }
        });
      }
    },

    async saveThisThread(threadID) {
      try {
        // const isThread = this.savedThreadExists(threadID);
        let res = await this.axios.post("/api/thread/save", {
          thread_id: threadID
        });
        console.log(res);
        this.savedData.push(res.data.data);
        this.savedThreadExists(res.data.data.thread_id);
      } catch (e) {
        // console.log(e)
        this.errors = e.response;
      }
    },
    async removeThisThread(threadID) {
      try {
        await this.axios.post("/api/thread/remove", {
          thread_id: threadID
        });
        this.removeElement(threadID);
        this.savedThreadExists(threadID);
      } catch (e) {
        this.errors = e.response;
      }
    },
    removeElement: function(threadID) {
      this.savedData.forEach((savedItem, index) => {
        if (threadID === savedItem.thread_id) {
          this.savedData.splice(index, 1);
          this.savedThreadExists();
          this.saveThreadStatus = false;
        }
      });
    }
  }
};
</script>

<style scoped>
.fa-bookmark {
  cursor: pointer;
  font-size: 26px;
  position: absolute;
  right: 15px;
  top: -8px;
}

.fa-bookmark:hover {
  color: #536eec;
}

.fas.fa-bookmark {
  color: #536eec;
}
</style>
