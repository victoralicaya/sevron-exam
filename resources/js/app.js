/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import { createApp } from "vue";

import App from './components/App.vue';
import router from './router/index.js';

import axios from 'axios';

axios.defaults.baseURL = process.env.APP_URL;
axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

createApp(App)
    .use(router)
    .mount("#app");

require('./bootstrap');
