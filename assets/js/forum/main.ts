import Vue from 'vue'
import EventHub from 'vue-event-hub'
import Forum from './components/Forum.vue'
import router from './router'
import store from './store'
import Vuex from 'vuex'

Vue.use(Vuex)
Vue.use(EventHub)

export function init() {
    new Vue(
        {
            el: '#forum',
            template: `<Forum />`,
            components: {Forum},
            router,
            store
        }
    )
}


