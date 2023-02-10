import { createRouter, createWebHistory } from "vue-router";
import store from '../store'
import modulePermission from "../helper/modulePermission.js";

import Dashboard from '../pages/Dashboard.vue'
import About from '../pages/About.vue'
import Login from '../pages/Login.vue'
import Ministry from '../pages/Ministry.vue'
import Page403 from '../pages/Page403.vue'

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
        component: Ministry,
        meta : { auth : true }
    },
    { 
        path: '/forbidden',
        name: 'forbidden',
        component: Page403,
        meta : { auth : false }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

const capitalize = ([first,...rest]) => first.toUpperCase() + rest.join('').toLowerCase();

router.beforeEach((to, from, next) => {
    // console.log(modulePermission(capitalize(to.name)))
    if( to.meta.auth && !store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'login' })
    } else if( !to.meta.auth && store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'dashboard' })
    } else {
        next()
    }
})

export default router