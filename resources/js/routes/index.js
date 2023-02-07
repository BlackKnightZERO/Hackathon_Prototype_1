import { createRouter, createWebHistory } from "vue-router";
import store from '../store'

import Dashboard from '../pages/Dashboard.vue'
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
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta : { auth : true }
    },
    { 
        path: '/about',
        name: 'about',
        component: About,
        meta : { auth : true }
    },
    { 
        path: '/profile',
        name: 'profile',
        component: About,
        meta : { auth : true }
    },
    { 
        path: '/user',
        name: 'user',
        component: About,
        meta : { auth : true }
    },
    { 
        path: '/role',
        name: 'role',
        component: About,
        meta : { auth : true }
    },
    { 
        path: '/permission',
        name: 'permission',
        component: About,
        meta : { auth : true }
    },
    { 
        path: '/role-permission',
        name: 'role-permission',
        component: About,
        meta : { auth : true }
    },
    { 
        path: '/coop-term',
        name: 'coop-term',
        component: About,
        meta : { auth : true }
    },
    { 
        path: '/ministry',
        name: 'ministry',
        component: About,
        meta : { auth : true }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if( to.meta.auth && !store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'login' })
    } else if( !to.meta.auth && store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'dashboard' })
    } else {
        next()
    }
})

export default router