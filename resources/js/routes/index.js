import { createRouter, createWebHistory } from "vue-router";
import store from '../store'

import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import Login from '../pages/Login.vue'

const routes = [
    {
        path: '/',
        name: 'index',
        component: Login,
        meta : { auth : false }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta : { auth : false }
    },
    { 
        path: '/',
        name: 'home',
        component: Home,
        meta : { auth : true }
    },
    { 
        path: '/about',
        name: 'about',
        component: About,
        meta : { auth : true }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

console.log(store.getters.GET_IS_AUTHENTICATED)

router.beforeEach((to, from, next) => {
    if( to.meta.auth && !store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'login' })
    } else if( !to.meta.auth && store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'home' })
    } else {
        next()
    }
})

export default router