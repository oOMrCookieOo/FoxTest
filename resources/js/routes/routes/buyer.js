
const GuestLayout = ()  => import('@/layouts/Guest.vue')
import { guest } from '../routes';
export default [
    {
        path: '/',
        component: GuestLayout,
        children: [
            {
                path: '',
                name: 'products-list',
                component: () => import(/* webpackChunkName: "user-products" */'@/views/user/products/Index.vue'),
            },
            {
                path: 'login',
                name: 'auth.login',
                component: () => import(/* webpackChunkName: "admin-login" */'@/views/login/Login.vue'),
                beforeEnter: guest,
            },
        ]
    },
]
