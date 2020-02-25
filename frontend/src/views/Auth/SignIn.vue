<template>
    <div id="auth-view" class="login container">
        <div class="row">
            <!-- <div class="col-lg-6 splash-bg"></div> -->
            <div class="col-sm-12 col-lg-4 m-auto">
                <h4 class="title mb-5">Welcome Back!</h4>
                <div
                    :style="{ display: errors ? 'block' : 'none' }"
                    class="invalid-feedback"
                >
                    {{ errors.msg }}
                </div>
                <form novalidate @submit.prevent="submit">
                    <div class="form-group row">
                        <label for="username">Username</label>
                        <input
                            id="username"
                            type="text"
                            class="form-control"
                            v-model="form.username"
                            required
                            autofocus
                        />
                    </div>
                    <div class="form-group row">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            class="form-control"
                            v-model="form.password"
                            required
                        />
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12" style="text-align: center;">
                            <button type="submit" class="btn btn-green">
                                Login
                            </button>
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

.login.container {
    margin-top: 250px;
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
