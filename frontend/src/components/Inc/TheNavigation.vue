<template>
  <div>
    <nav
      class="navbar navbar-expand-md navbar-dark forum-nav fixed-top"
      :class="{
        'forum-nav-hide': $route.path == '/signin' || $route.path == '/register'
      }"
    >
      <router-link to="/threads/all">
        <a class="navbar-brand">Lara Node Forum</a>
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav ml-auto">
            <router-link v-if="!isAuth" to="/signin" activeClass="active" tag="li">
              <a class="nav-link">Login</a>
            </router-link>
            <router-link v-if="!isAuth" to="/register" activeClass="active" tag="li">
              <a class="nav-link">Register</a>
            </router-link>
            <router-link
              v-if="isAuth"
              to="/thread/new"
              class="btn btn-sm btn-outline-claim font-weight-bold text-uppercase mr-5"
              style="height: 32px;margin-top: 6px;"
            >Write A Post</router-link>
            <li v-if="isAuth" style="height: 32px;margin-top: 10px;">
              <span class="name font-weight-bold">Hello, {{ user.username }}</span>
            </li>
            <li v-if="isAuth" class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="dropdown01"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
<!--                <img-->
<!--                  v-if="isAuth && !user.picture"-->
<!--                  class="avatar"-->
<!--                  :src="`${require(`@/assets/default_avatar.png`)}`"-->
<!--                />-->
                <div
                  v-if="isAuth && !user.picture"
                  class="avatar-circle"
                  v-bind:style="{
                    color: `#000`,
                    backgroundColor: `#${user.color}`
                  }"
                >
                  {{ user.username.charAt(0) }}
                </div>
                <img v-if="isAuth && user.picture" class="avatar" :src="user.picture" />
              </a>
              <div class="dropdown-menu profile-dropdown" aria-labelledby="dropdown01">
                <router-link
                  v-if="isAuth"
                  :to="`/u/${user.username}`"
                  activeClass="active"
                  tag="li"
                >
                  <a class="dropdown-item">Profile</a>
                </router-link>
                <li>
                  <router-link :to="`/u/${user.username}/settings`">
                    <a class="dropdown-item">Settings</a>
                  </router-link>
                </li>
                <li>
                  <button
                    v-if="isAuth"
                    @click.prevent="signOut"
                    type="button"
                    class="btn btn-link dropdown-item"
                  >Logout</button>
                </li>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
// import SearchBar from "../inc/SearchBar";
export default {
  components: {
    // "search-bar": SearchBar
  },
  computed: {
    ...mapGetters({
      isAuth: "auth/authenticated",
      user: "auth/user"
    }),
  },
  methods: {
    singleLetter() {
      // return charAt()
    },
    ...mapActions({
      signOutAction: "auth/signOut"
    }),
    signOut() {
      this.signOutAction().then(() => {
        // this.$router.replace({
        //   name: "landing",
        //   params: {
        //     category: "all"
        //   }
        // });
      });
    }
  }
};
</script>
<style scoped>
.dropdown-menu .btn.btn-link {
  box-shadow: none;
}

.navbar .dropdown-menu.profile-dropdown {
  margin-left: -106px;
}

  .avatar-circle {
    position: absolute;
    left: 1px;
    top: 5px;
  }
</style>
