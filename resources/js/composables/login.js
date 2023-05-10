import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default function login() {
    const errors = ref({});
    const router = useRouter();
    
    const login = async (data) => {
        await axios.post('/api/login', data)
        .then((response) => {
            console.log(response);
            localStorage.setItem('token', response.data.token);
            router.push({ path: '/home' });
        }).catch((error) => {
            console.log(error);
            errors.value = error.response.data;
        });
    }

    return {
        login,
        errors,
    }
}
