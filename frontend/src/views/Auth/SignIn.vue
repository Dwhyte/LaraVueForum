<template>
  <div id="auth-view" class="login container-fluid">
    <div class="row">
      <div class="col-lg-6 splash-bg"></div>
      <div class="col-lg-6 m-auto">
        <div class="col-md-6 offset-md-3">
          <h1 class="title mb-4">Welcome Back!</h1>
          <div
            :style="{display: errors ? 'block' : 'none'}"
            class="invalid-feedback"
          >{{ errors.msg }}</div>
          <form novalidate @submit.prevent="submit">
            <div class="form-group row">
              <input
                id="username"
                type="text"
                class="form-control"
                v-model="form.username"
                placeholder="Username"
                required
                autofocus
              />
            </div>
            <div class="form-group row">
              <input
                id="password"
                type="password"
                class="form-control"
                v-model="form.password"
                placeholder="Password"
                required
              />
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="submit" class="btn">Login</button>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-12 question">
                <p>
                  Don't have an account?
                  <router-link to="/register">
                    <a>Register</a>
                  </router-link>
                </p>
                <p>
                  <router-link to="/">
                    <a>Back home</a>
                  </router-link>
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// @ is an alias to /src
import { mapActions, mapGetters } from "vuex";
export default {
  name: "signin",
  data() {
    return {
      form: {
        username: "",
        password: ""
      }
    };
  },
  created() {
    this.clearErrors();
  },
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
      clearErrors: "auth/clearErrors"
    }),
    submit() {
      this.signIn(this.form);
    }
  },
  computed: {
    ...mapGetters({
      errors: "auth/getLoginErrors"
    })
  }
};
</script>
<style>
#search-bar {
  display: none;
}

#auth-view .title {
  text-align: center;
}

#auth-view.login .splash-bg {
  width: 100%;
  background-image: url("~@/assets/login_splash_img.jpg");
  background-position: center;
  background-size: cover;
  height: 100vh;
  background-repeat: no-repeat;
}
</style>
