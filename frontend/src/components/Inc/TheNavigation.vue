<template>
    <div>
        <nav
            class="navbar navbar-expand-md navbar-dark forum-nav fixed-top"
            :class="{
                'forum-nav-hide':
                    $route.path == '/signin' || $route.path == '/register'
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
                        <router-link
                            v-if="!isAuth"
                            to="/signin"
                            activeClass="active"
                            tag="li"
                        >
                            <a class="nav-link">Login</a>
                        </router-link>
                        <router-link
                            v-if="!isAuth"
                            to="/register"
                            activeClass="active"
                            tag="li"
                        >
                            <a class="nav-link">Register</a>
                        </router-link>
                        <router-link
                            v-if="isAuth && user.role === 'Administrator'"
                            :to="`/u/${user.username}/settings`"
                        >
                            <button
                                class="btn btn-sm btn-normy font-weight-bold text-uppercase mr-3"
                            >
                                Admin Settings
                            </button>
                        </router-link>
                        <router-link
                            v-if="isAuth"
                            :to="`/u/${user.username}/settings`"
                        >
                            <button
                                class="btn btn-sm btn-normy font-weight-bold text-uppercase mr-3"
                            >
                                Settings
                            </button>
                        </router-link>
                        <button
                            style="height: 30px;"
                            v-if="isAuth"
                            @click.prevent="signOut"
                            class="btn btn-sm btn-normy font-weight-bold text-uppercase mr-5"
                        >
                            Log out
                        </button>
                        <li v-if="isAuth" style="height: 32px;margin-top: 6px;">
                            <span class="name font-weight-bold"
                                >Hello, {{ user.username }}</span
                            >
                        </li>
                        <AvatarIcon
                            v-if="isAuth"
                            :user="user"
                            :className="`avatar_icon__icon--small`"
                        ></AvatarIcon>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
import { mapActions } from "vuex";
import AvatarIcon from "@/components/AvatarIcon";
// import SearchBar from "../inc/SearchBar";
export default {
    props: ["user", "isAuth"],
    components: {
        // "search-bar": SearchBar
        AvatarIcon
    },
    methods: {
        singleLetter() {
            // return charAt()
        },
        ...mapActions({
            signOutAction: "auth/signOut"
        }),
        signOut() {
            this.signOutAction();
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

.btn {
    font-size: 12px;
}
</style>
