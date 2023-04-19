import store from "../store";
import guest_routes from './routes/buyer'
import admin_routes from './routes/seller'

function requireLogin(to, from, next) {
    let isLogin;

    isLogin = !!store.state.auth.authenticated;

    if (isLogin) next()

    else next('/login')

}

function guest(to, from, next) {
    let isLogin;

    isLogin = !!store.state.auth.authenticated;

    if (isLogin) next('/')

    else next()
}

export default [

    ...guest_routes,
    ...admin_routes,
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),
    },
];
export { guest,requireLogin };
