<template>
    <v-app>
        <v-app-bar app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Forester Buddy</v-toolbar-title>
        </v-app-bar>
        <v-navigation-drawer dark :mini-variant="drawer" app color="green">
            <v-list
                nav
            >
                <v-list-item
                    v-for="item in items"
                    :to="item.to"
                    :key="item.title"
                    link
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>

</template>

<script>

export default {
    name: 'App',
    components: {},
    data() {
        return {
            drawer: false,
            items: [
                {title: 'Home', icon: 'mdi-home',to: '/'},
                {title: 'VCalculator', icon: 'mdi-calculator', to:'/vcalc'},
            ],
            right: null,
        }
    },
}
</script>
