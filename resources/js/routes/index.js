import { createRouter, createWebHistory } from "vue-router";
import store from '../store'
import modulePermission from "../helper/modulePermission.js";

import Dashboard from '../pages/Dashboard.vue'
import About from '../pages/About.vue'
import Login from '../pages/Login.vue'
import Ministry from '../pages/Ministry.vue'
import RolePermission from '../pages/RolePermission.vue'
import Ticket from '../pages/Ticket.vue'
import Inventory from '../pages/Inventory.vue'
import Profile from '../pages/Profile.vue'

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
        component: Profile,
        meta : { auth : true }
    },
    { 
        path: '/profile/:id',
        name: 'profile-id',
        component: Profile,
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
        component: RolePermission,
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
        path: '/ticket',
        name: 'ticket',
        component: Ticket,
        meta : { auth : true }
    },
    { 
        path: '/inventory',
        name: 'inventory',
        component: Inventory,
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
    if( to.meta.auth && !store.getters.GET_IS_AUTHENTICATED ) {
        next({ name: 'login' })
    } else if( !to.meta.auth && store.getters.GET_IS_AUTHENTICATED && to.path !== '/forbidden' ) {
        next({ name: 'dashboard' })
    } else if (store.getters.GET_IS_AUTHENTICATED && to.meta.auth && !modulePermission(capitalize(to.name)).includes('INDEX')) {
        next({ name: 'forbidden' })
    } else if(store.getters.GET_IS_AUTHENTICATED && to.meta.auth && modulePermission(capitalize(to.name)).includes('INDEX') ) {
        next()
    } else {
        next()
    }
})

export default router