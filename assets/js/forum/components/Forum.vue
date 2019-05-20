<template>
    <div class="main">
        <router-view></router-view>
    </div>
</template>
<script lang="ts">
    import Vue from 'vue'

    export default Vue.extend({
        name: "Forum",
        data() {
            return {

            }
        },
        computed: {

        },
        components: {
        },
        mounted() {

        },
        watch: {
            '$route'(to, from) {
            }
        },
        methods: {

        }
    })
</script>
<style scoped>
</style>