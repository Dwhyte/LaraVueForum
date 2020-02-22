<template>
    <div>
        <TheNavigation></TheNavigation>
    </div>
</template>
<script>
import TheNavigation from "../components/Inc/TheNavigation";
export default {
    name: "App",
    components: {
        TheNavigation
    },
    metaInfo: {
        title: "Lara Vue Forum",
        // all titles will be injected into this template
        titleTemplate: "%s | Welcome To My Awesome Forum"
    },
    data() {
        return {};
    }
};
</script>
