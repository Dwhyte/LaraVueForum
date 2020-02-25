<template>
  <div id="auth-view" class="register container-fluid">
    <div class="row">
      <div class="col-lg-6 splash-bg"></div>
      <div class="col-lg-6 m-auto">
        <div class="col-md-6 offset-md-3">
          <h1 class="title mb-4">Sign Up</h1>
          <form novalidate @submit.prevent="submitRegister">
            <div class="form-group row">
              <div
                v-if="errors.username"
                :style="{display: errors.username ? 'block' : 'none'}"
                class="invalid-feedback"
              >{{ errors.username[0] }}</div>
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
              <div
                v-if="errors.email"
                :style="{display: errors.email ? 'block' : 'none'}"
                class="invalid-feedback"
              >{{ errors.email[0] }}</div>
              <input
                id="email"
                type="text"
                class="form-control"
                v-model="form.email"
                placeholder="Email"
                required
                autofocus
              />
            </div>
            <div class="form-group row">
              <div
                v-if="errors.password"
                :style="{display: errors.password ? 'block' : 'none'}"
                class="invalid-feedback"
              >{{ errors.password[0] }}</div>
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
                <button type="submit" class="btn">Register</button>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-12 question">
                <p>
                  Already have an account?
                  <router-link to="/signin">
                    <a>Login</a>
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
import { mapActions, mapGetters } from "vuex";
export default {
  name: "register",
  data() {
    return {
      form: {
        username: "",
        email: "",
        password: ""
      }
    };
  },
  created() {
    this.clearErrors();
  },
  methods: {
    ...mapActions({
      register: "auth/register",
      clearErrors: "auth/clearErrors"
    }),
    submitRegister() {
      this.register(this.form);
    }
  },
  computed: {
    ...mapGetters({
      errors: "auth/getRegisterErrors"
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

#auth-view.register .splash-bg {
  width: 100%;
  background-image: url("~@/assets/register_splash_img.jpg");
  background-position: center;
  background-size: cover;
  height: 100vh;
  background-repeat: no-repeat;
}
</style>
