import Vue from 'vue'
import Router from 'vue-router'
import List from './components/pages/List.vue'
import Thread from './components/pages/Thread.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'List',
            component: List
        },
        {
            path: '/temata',
            name: 'List',
            component: List
        },
        {
            path: '/tema/:slug',
            name: 'Thread',
            component: Thread
        },
        // {
        //     path: '*',
        //     name: '404',
        //     component: PageNotFound
        // }
    ]
})
