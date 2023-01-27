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
            <v-container>
                <router-view></router-view>
            </v-container>
            </v-main>
        </v-layout>
        <v-footer 
            color="#FF9100" 
            absolute
            v-if="$store.state.isAutheticated"
        >Footer</v-footer>
    </v-app>
</template>

<script>
export default {
  data() {
    return { 
        drawer: false,
        group: null,
        navItems: [
            {
                id: 1,
                title: 'Menu 1',
                value: 'menu_1',
                path: '/'
            },
            {
                id: 2,
                title: 'Menu 2',
                value: 'menu_2',
                path: '/about'
            }
        ],
        menuItems: [
            { title: 'Profile' },
            { title: 'Logout' },
        ],
    }
  },
  mounted() {
    console.log(this.$store.state.isAutheticated)
  },
  watch: {
    group () {
      this.drawer = false
    },
  },
}

</script>