<template>
    <div id="newpost">
        <flash-message class="flashpool"></flash-message>
        <div class="container">
            <!-- <flash-message></flash-message> -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="header mb-4">
                        <span class="border font-weight-bold text-uppercase"
                            >Post A New Thread</span
                        >
                    </h1>
                    <div class="section-header mb-4">
                        <form>
                            <div class="form-row align-items-center">
                                <div class="col-sm-3 my-1">
                                    <label
                                        class="mr-sm-2 sr-only"
                                        for="inlineFormCustomSelect"
                                        >Select a category</label
                                    >
                                    <select
                                        v-if="catData"
                                        v-model="selectedCategory"
                                        class="custom-select mr-sm-2"
                                        id="inlineFormCustomSelect"
                                    >
                                        <option
                                            selected
                                            disabled
                                            value="Select a category"
                                            >Select a category</option
                                        >
                                        <option
                                            v-for="category in catData.data"
                                            :key="category.id"
                                            :value="category.id"
                                            >{{ category.name }}</option
                                        >
                                    </select>
                                </div>
                                <div class="col-sm-3 my-1">
                                    <label
                                        class="sr-only"
                                        for="inlineFormInputName"
                                        >Thread Title</label
                                    >
                                    <div
                                        v-if="errors"
                                        :style="{
                                            display: errors.password
                                                ? 'display'
                                                : 'block'
                                        }"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.name }}
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inlineFormInputName"
                                        placeholder="Thread title"
                                        v-model="title"
                                    />
                                </div>
                                <div class="col-sm-3 my-1">
                                    <label for="addfeaturedImage" class="mt-2">
                                        <a
                                            class="btn btn-sm btn-blue font-weight-bold"
                                            >Add Featured Image</a
                                        >
                                    </label>
                                    <input
                                        type="file"
                                        hidden
                                        class="form-control-file"
                                        id="addfeaturedImage"
                                    />
                                </div>
                            </div>
                        </form>
                    </div>
                    <wysiwyg v-model="editorData" />
                    <div class="save-area">
                        <div style="display: inline-block;">
                            <button
                                @click="clearEditPost"
                                class="btn btn-sm btn-red font-weight-bold mt-3"
                            >
                                Clear
                            </button>
                        </div>
                        <div style="float: right;">
                            <button
                                @click="toggleState()"
                                class="btn btn-sm btn-grey font-weight-bold mt-3 mr-3"
                            >
                                Save as a draft ?
                            </button>
                            <button
                                @click="createNewPost"
                                class="btn btn-sm btn-green font-weight-bold mt-3"
                            >
                                Publish Post
                            </button>
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
    name: "newThread",
    data() {
        return {
            title: null,
            selectedCategory: "Select a category",
            isDraft: 0,
            errors: null,
            editorData: "<p>Write something amazing!</p>",
            featured_image: null
        };
    },
    mounted() {
        this.getCats();
    },
    watch: {
        $route: "getCats"
    },
    computed: {
        ...mapGetters({
            catData: "getCategoryNames"
        })
    },
    methods: {
        ...mapActions({
            getCats: "GetCategories"
        }),
        toggleState: function() {
            this.isDraft = !this.isDraft;
            console.log(this.isDraft);
        },
        createNewPost() {
            this.axios
                .post("/api/thread/create", {
                    title: this.title,
                    thread_content: this.editorData,
                    category: this.selectedCategory,
                    isDraft: this.isDraft
                    // featured_image: this.featured_image
                })
                .then(res => {
                    // this.flashSuccess(res.data.message);
                    this.flash(res.data.message, "info flash__message");
                    // console.log(res.data);
                    this.title = null;
                    this.selectedCategory = "Select a category";
                    this.editorData = "";
                    this.isDraft = 0;
                })
                .catch(error => {
                    this.errors = error.response.data;
                });
        },

        clearEditPost() {
            if (confirm("Do you really want to erase all of your content?")) {
                this.title = null;
                this.selectedCategory = "Select a category";
                this.editorData = "";
                this.isDraft = 0;
            }
        }
    }
};
</script>
<style>
#newpost .header {
    font-size: 1rem;
    color: #34495e;
}

#newpost .header > .border {
    padding-bottom: 0.3em;
    border: none !important;
    border-bottom: solid 2px #536eec !important;
}

#newpost .save-area .btn-outline-save:hover {
    color: #ffffff;
}

#newpost .save-area .btn-danger-outline:hover {
    color: #ffffff;
}

#newpost .editr--content {
    background: #fff;
}

#newpost .editr--content {
    min-height: 350px;
}
</style>
