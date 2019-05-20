import Vuex from 'vuex'
import Vue from 'vue'
import createPersistedState from 'vuex-persistedstate'
import axios, {AxiosResponse} from 'axios'
import {stringifyURL} from './util'

Vue.use(Vuex)

export default new Vuex.Store({
    plugins: [createPersistedState({
        filter (mutation) {
            return true
        }
    })],
    state: {
        threads: [] as Thread[],
        posts: [] as Post[]
    },
    mutations: {
        saveThreads (state, threads: Thread[]) {
            state.threads = threads
        }
    },
    actions: {
        loadThreads (context, parameters) {
            return axios.get(stringifyURL('/api/forum/list', {page: parameters.page}))
                .then((response: AxiosResponse<ThreadsListResponse>) => {
                    let threads: Thread[] = response.data.result
                    context.commit('saveThreads', threads)
                    return threads
                })
        },
        loadPosts (context, parameters) {
            return axios.get(stringifyURL(`/api/forum/${parameters.slug}/list`, {page: parameters.page}))
                .then((response: AxiosResponse<PostsListResponse>) => {
                    let posts: Post[] = response.data.result
                    context.commit('saveThreads', posts)
                    return posts
                })
        }
    },
    modules: {

    },
    getters: {
        getThreadBySlug: (state) => (slug: string) => {
            for (let thread of state.threads) {
                if (thread.slug === slug) {
                    return thread
                }
            }
            return null
        }
    }
})
