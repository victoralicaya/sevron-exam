<script setup>
import { reactive } from 'vue';
import useLogin from '../composables/login.js';

const { login, errors } = useLogin();

const form = reactive({
    username: "",
    password: "",
});
console.log(form);
</script>

<template>
    <div class="relative flex min-h-screen text-gray-800 antialiased flex-col justify-center overflow-hidden bg-gray-900 py-6 sm:py-12">
        <div class="relative py-3 sm:w-96 mx-auto text-center">

          <div class="mt-4 bg-white shadow-md rounded-lg">
            <div class="text-2xl text-center py-5 border-b border-gray-500">
                LOGIN
            </div>

            <div class="px-8 py-6 text-left">
                <form @submit.prevent="login(form)">
                    <label class="block font-semibold">Username</label>
                    <input type="text" id="username" v-model="form.username" placeholder="Username" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-indigo-500 focus:ring-1 rounded-md">

                    <label class="block mt-3 font-semibold">Password </label>
                    <input type="password" id="password" v-model="form.password" placeholder="Password" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-indigo-500 focus:ring-1 rounded-md">

                    <div class="flex justify-between items-baseline mt-5">
                        <button type="submit" class="w-full bg-gray-800 text-white py-2 px-6 rounded-md hover:bg-gray-900">Login</button>
                    </div>
                </form>
            </div>

        </div>
      </div>
    </div>
</template>
