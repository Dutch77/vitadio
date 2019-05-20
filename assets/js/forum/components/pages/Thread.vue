<template>
    <div>
        <ul>
            <li v-if="posts.length === 0">
                Žádné příspěvky k nalezení
            </li>
            <li v-else v-for="post in posts">
                <h2>{{ post.title }}</h2>
                <div>{{ post.content }}</div>
            </li>
        </ul>
    </div>
</template>
<script lang="ts">
    import Vue from 'vue'
    import axios, {AxiosResponse} from 'axios'
    import {stringifyURL} from './../../util'

    export default Vue.extend({
        name: "List",
        props: {
            threadName: String
        },
        data() {
            return {
                threads: [] as Thread[]
            }
        },
        computed: {
            posts() {
                return this.$store.getters['getThreadBySlug'](this.$route.params.slug)
            }
        },
        components: {},
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