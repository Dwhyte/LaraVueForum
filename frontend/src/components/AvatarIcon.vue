<template>
    <div class="avatar_icon_header">
        <router-link :to="`/u/${user.username}`" :title="user.username">
            <div
                class="avatar_icon__icon picture_circle"
                :class="className"
                :style="{
                    'background-color': user.color,
                    'background-image': avatarUrl,
                    margin: '0 auto'
                }"
            >
                {{ letter }}
            </div>
        </router-link>
    </div>
</template>

<script>
export default {
    name: "AvatarIcon",
    props: ["user", "className"],
    data() {
        return {
            userData: null
        };
    },
    computed: {
        proxyUser() {
            if (this.userData) {
                // data loaded from api
                return this.userData;
            } else if (this.user) {
                return this.user;
            }
            return {};
        },
        letter() {
            if (this.proxyUser.username && !this.proxyUser.avatar) {
                return this.proxyUser.username.charAt(0).toUpperCase();
            } else {
                return "";
            }
        },
        avatarUrl() {
            if (this.proxyUser.avatar) {
                return "url(" + this.proxyUser.avatar + ")";
            }
            return null;
        }
    }
};
</script>

<style>
.avatar_icon__icon {
    height: 3rem;
    width: 3rem;
    line-height: 3rem;
    cursor: pointer;
    font-family: Lato, sans-serif;
    font-size: 2rem;
    font-weight: 300;
    text-align: center;
    border-radius: 100%;
    background-color: #bdbdbd;
    color: #fff;
}
.avatar_icon__icon--small {
    height: 2.2rem;
    width: 2.2rem;
    font-size: 1.75rem;
    line-height: 2.5rem;
}

.avatar_icon__icon--medium {
    height: 2.2rem;
    width: 2.5rem;
    font-size: 1.75rem;
    line-height: 2.5rem;
}

/* .avatar_icon__icon {
  font-size: 0.7rem;
  margin-right: 0.25rem;
  color: rgba(0, 0, 0, 0.87);
} */

.picture_circle {
    border-radius: 100%;
    background-position: 50%;
    background-size: cover;
    background-repeat: no-repeat;
    position: relative;
}
</style>
