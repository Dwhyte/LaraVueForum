<template>
    <div>
        <button
            v-if="!saveThreadStatus"
            class="small mt-2 btn btn-link thread-save-btn btn-sm text-uppercase font-weight-bold"
            style="position: absolute;bottom: -7px;right: 15px;font-weight: 600;"
            @click="saveThisThread(threadID)"
        >
            Save
        </button>
        <button
            v-if="saveThreadStatus"
            class="small mt-2 btn btn-link thread-saved btn-sm text-uppercase font-weight-bold"
            style="position: absolute;bottom: -7px;right: 15px;font-weight: 600;"
            @click="removeThisThread(threadID)"
        >
            Saved
        </button>
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

<style scoped></style>
