
const AuthenticatedLayout = () => import('@/layouts/Authenticated.vue')
import { requireLogin } from '../routes';
export default [
    {
        path: '/admin',
        component: AuthenticatedLayout,
        beforeEnter: requireLogin,
        children: [
            {
                name: 'admin.index',
                path: '',
                component: () => import(/* webpackChunkName: "admin-index" */ '@/views/admin/index.vue'),
                meta: { breadCrumb: 'Admin' }
            },
            {
                name: 'products.index',
                path: 'products',
                component: () => import(/* webpackChunkName: "admin-products" */ '@/views/admin/products/Index.vue'),
                meta: { breadCrumb: 'products' }
            },
            {
                name: 'products.create',
                path: 'products/create',
                component: () => import(/* webpackChunkName: "admin-products-create" */ '@/views/admin/products/Create.vue'),
                meta: { breadCrumb: 'Add new products' }
            },

        ]
    },
]
