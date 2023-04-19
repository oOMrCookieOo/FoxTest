import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'
import store from "../store";

export default function useProducts() {
    const products = ref({})

    const tableColumns = [
        'Product',
        'Category' ,
        'Stock',
        'Price',
        'Actions'
    ]

    const perPageOptions=[
        5,10,15,20
    ]

    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getProducts = async (
        page = 1,
        search = '',
        perPage = 5,
    ) => {

        axios.defaults.headers.common.Authorization = `Bearer ${store.getters['auth/token']}`
        axios.get('/api/seller/products?page=',{
            params:{
                page,
                search,
                perPage
            }
        })
            .then(response => {
                products.value = response.data;
            })
    }

    const storeProduct = async (post) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        let serializedPost = new FormData()
        for (let item in post) {
            if (post.hasOwnProperty(item)) {
                serializedPost.append(item, post[item])
            }
        }
        axios.defaults.headers.common.Authorization = `Bearer ${store.getters['auth/token']}`
        axios.post('/api/seller/products', serializedPost)
            .then(response => {
                router.push({name: 'products.index'})
                swal({
                    icon: 'success',
                    title: 'Product saved successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }


    const deleteProduct = async (id) => {
        swal({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this action!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.defaults.headers.common.Authorization = `Bearer ${store.getters['auth/token']}`
                    axios.delete(`/api/seller/products/${id}`)
                        .then(response => {
                            getProducts()
                            router.push({name: 'products.index'})
                            swal({
                                icon: 'success',
                                title: 'Product deleted successfully'
                            })
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Something went wrong'
                            })
                        })
                }
            })

    }

    return {
        products,
        getProducts,
        storeProduct,
        deleteProduct,
        validationErrors,
        isLoading,
        tableColumns,
        perPageOptions,
    }
}
