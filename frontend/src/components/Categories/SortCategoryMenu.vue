<template>
  <div class="sort-menu">
    <button
      @click="SortBy(`new`)"
      :class="[sortWord === 'new' ? 'activeSortMenu' : '']"
      class="btn btn-sm btn-sort font-weight-bold text-uppercase mr-3"
    >New</button>
    <button
      @click="SortBy(`most_active`)"
      :class="[sortWord === 'most_active' ? 'activeSortMenu' : '']"
      class="btn btn-sm btn-sort font-weight-bold text-uppercase mr-3"
    >Most Active</button>
    <button
      @click="SortBy(`no_replies`)"
      :class="[sortWord === 'no_replies' ? 'activeSortMenu' : '']"
      class="btn btn-sm btn-sort font-weight-bold text-uppercase mr-3"
    >No Replies</button>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "CategorySortMenu",
  data() {
    return {
      isActive: false
    };
  },
  computed: {
    ...mapGetters({
      sortWord: "getSortKeyword"
    })
  },
  methods: {
    SortBy(sortByType) {
      this.$root.$emit("sortBy", sortByType);
    }
  }
};
</script>

<style>
.sort-menu {
  display: inline-block;
}

.btn-sort {
  color: #34495d !important;
  border: 2px solid #3d4b8c;
  text-decoration: none;
}

.btn-sort:hover {
  color: #ffffff !important;
  background-color: #8195ce;
}

.activeSortMenu {
  background-color: #5d7ee2;
  color: #fff !important;
}

.activeSortMenu:hover {
  background-color: #5d7ee2;
  color: #fff !important;
}
</style>