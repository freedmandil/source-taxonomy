import axios from 'axios'

// Create an axios instance with base config
const api = axios.create({
    baseURL: '/api', // Laravel's default API prefix
    headers: {
        'Accept': 'application/json',
    }
})

// If you're using Laravel Sanctum or need CSRF, we can add that here later

export default api
