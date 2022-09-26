import Home from '../pages/Home.vue'
import VCalc from '../pages/VCalc.vue'

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/vcalc',
            name: 'vcalc',
            component: VCalc,
        }
    ]
}
