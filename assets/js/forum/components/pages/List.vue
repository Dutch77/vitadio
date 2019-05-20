<template>
    <div>
        <h1>Témata</h1>
        <ul>
            <li v-if="threads.length === 0">
                Žádná témata k nalezení
            </li>
            <li v-else v-for="thread in threads">
                <router-link :to="{ name: 'Thread', params: {slug: thread.slug} }">{{ thread.title }}</router-link>
            </li>
        </ul>
    </div>
</template>
<script lang="ts">
    import Vue from 'vue'

    export default Vue.extend({
        name: "List",
        data() {
            return {
            }
        },
        computed: {
            threads () {
                console.log('dsasad', this.$store.state.threads)
                return this.$store.state.threads as Thread[]
            }
        },
        components: {},
        mounted() {
            this.loadThreads(1)
        },
        watch: {
            '$route'(to, from) {
            }
        },
        methods: {
            loadThreads (page: number = 1) {
                this.$store.dispatch('loadThreads', {page: page})
            }
        }
    })
</script>
<style scoped>
</style>