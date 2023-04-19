import { ref, reactive} from 'vue'
import { useRouter } from "vue-router";
import store from '../store'

let user = reactive({
    name: '',
    email: '',
})

export default function useAuth() {
    const processing = ref(false)
    const validationErrors = ref({})
    const router = useRouter()


    const loginForm = reactive({
        email: '',
        password: '',
        remember: false
    })

    const submitLogin = async () => {
        if (processing.value) return

        processing.value = true
        validationErrors.value = {}
        await axios.get('/sanctum/csrf-cookie')
        await axios.post('/api/login', loginForm)
            .then(async response => {
                await store.dispatch('auth/login',response)
                await router.push({ name: 'admin.index' })
            })
            .catch(e => {
                console.log(e)
                if (e.response && e.response.status === 422) {
                    validationErrors.value = e.response.data.errors
                }
            })
            .finally(() => processing.value = false)
    }

    const logout = async () => {
        if (processing.value) return

        processing.value = true

        axios.post('/api/seller/logout')
            .then(response => {
                user.name = ''
                user.email = ''
                store.dispatch('auth/logout')
                router.push({ name: 'auth.login' })
            })
            .catch(error => {
            })
            .finally(() => {
                processing.value = false
            })
    }


    return {
        loginForm,
        validationErrors,
        processing,
        submitLogin,
        user,
        logout,
    }
}
