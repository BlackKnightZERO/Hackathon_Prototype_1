<template>
    <v-app>
        <v-layout>
            <v-app-bar
            color="#FF9100"
            prominent
            v-if="$store.state.isAutheticated"
            >
                <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
                <v-toolbar-title>My files</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-avatar>
                    <v-img
                        :src="$store.state.user.src"
                        :alt="$store.state.user.alt"
                    ></v-img>
                </v-avatar>
                <v-menu>
                    <template v-slot:activator="{ props }">
                        <v-btn variant="text" icon="mdi-dots-vertical" v-bind="props"></v-btn>
                    </template>
                    <v-list>
                        <v-list-item
                            v-for="(item, index) in menuItems"
                            :key="index"
                            :value="index"
                            @click="logout"
                        >
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-app-bar>
            <v-navigation-drawer
                v-model="drawer"
                location="left"
                permanent
                v-if="$store.state.isAutheticated"
            >
            <v-list density="compact">
                <v-list-item 
                    v-for="item in navItems" 
                    :key="item.id" 
                    :title="item.title" 
                    :value="item.value" 
                    link 
                    :to="item.path"></v-list-item>
            </v-list>
            </v-navigation-drawer>
            <v-main style="min-height: 95vh;">
                <v-alert 
                    closable 
                    class="text-center" 
                    density="compact" 
                    :type="$store.state.alert.type" 
                    :text="$store.state.alert.text" 
                    v-show="$store.state.alert.value"></v-alert>
            <v-container>
                <router-view></router-view>
            </v-container>
            </v-main>
        </v-layout>
        <v-footer 
            color="#FF9100" 
            absolute
            v-if="$store.state.isAutheticated"
        >Footer<button @click="logout">logout</button> </v-footer>
    </v-app>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import store from './store/index.js'

    const router = useRouter()
    const drawer = ref(false)
    const group = ref(null)

    const navItems = ref([
                {
                    id: 1,
                    title: 'Menu 1',
                    value: 'menu_1',
                    path: '/dashboard'
                },
                {
                    id: 2,
                    title: 'Menu 2',
                    value: 'menu_2',
                    path: '/about'
                }
            ])

    const menuItems = ref([
                { title: 'Profile' },
                { title: 'Logout' },
            ])

    watch(group, (newGroup, oldGroup) => {
        drawer.value = false
    })

    onMounted(async () => {
        axios({
            method: 'GET',
            url: '/sanctum/csrf-cookie',
        }).then(response => {
            // console.log(response)
        });
    })

    const logout = async () => {
            axios({
                method: 'POST',
                url: '/api/logout',
                data: {}
            }).then(res => {
                store.dispatch('RESET_USER')
                router.push('/')
                console.log(res)
            }).catch(err => {
                console.log(err)
            })
    }
</script>