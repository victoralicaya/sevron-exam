import { createRouter, createWebHistory } from "vue-router";

import Login from '../components/Login.vue';
import Home from '../components/Home.vue';

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/home',
        name: 'home',
        component: Home,
        meta: {
            requiresAuth: true
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token');
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!isAuthenticated) {
            next({ name: 'Login' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
