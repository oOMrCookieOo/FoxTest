import { ref} from 'vue'

export default function useCategories() {

    const categoryList = ref([])


    const getCategoryList = async () => {
        axios.get('/api/categories')
            .then(response => {
                categoryList.value = response.data.data;
            })
    }

    return {
        categoryList,
        getCategoryList,
    }
}
