<template>
    <div class="container-md my-5" >
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-transparent border-0">
                    <div class="card-header px-0 border-0 bg-transparent">
                        <div class="form-group has-search ">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input v-model="search"  type="text" placeholder="Search in products"
                                    class="form-control bg-white">
                        </div>

                    </div>
                </div>
                <div class="card border-white mt-3">
                    <div class="card-body">
                        <h4 class="text-primary fw-bold mb-3">Categories</h4>
                        <h2 v-for="(category,key) in categories"
                          :key="category"
                           @click="changeCategory(category.id)"
                          class="fw-bold fs-6 cursor-pointer p-1"
                           :class="selected_category===category.id?'text-secondary bg-light  rounded text-bolder':''"
                        >{{ category.name }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card bg-transparent border-0">
                    <div class="card-header border-0 bg-transparent d-flex align-items-center justify-content-between">
                        <h4 class="text-dark fw-bold">Products</h4>
                        <div>
                            <select v-model="view"  class="form-select bg-white">
                                <option v-for="option in viewOptions" :key="option" :value="option" >{{option}}</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div>
                    <div v-if="loading" class="text-center mt-5">
                        <div class="spinner-border" role="status">
                        </div>
                    </div>
                    <div v-else>
                        <Transition name="slide-fade">
                                <div v-if="products.length">
                                    <div v-if="view==='Grid'" class="row match-height">
                                        <Grid @add-To-Cart="addToCart" :products="products" />

                                    </div>
                                    <div v-else-if="view==='List'">
                                        <List @add-To-Cart="addToCart" :products="products" />
                                    </div>
                                </div>
                                <div v-else class="text-center mt-5">
                                    <h3>No products found.</h3>
                                    <button @click="resetFilter" v-if="selected_category || search" class="btn btn-outline-primary"> <i class="fa fa-reload"></i> reset filters</button>
                                </div>
                        </Transition>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted, watch} from 'vue'
import { useStore } from 'vuex'
import { useToast } from "vue-toastification";

import Grid from "./partials/Grid.vue";
import List from "./partials/List.vue";


const products = ref([])

const categories =ref([])

const view= ref('Grid')

const search =ref('')

const store = useStore()

const toast = useToast();

const selected_category =ref('')

const viewOptions=[
    'Grid',
    'List'
]

const loading=ref(false)

const changeCategory = (id)=>{

    if (selected_category.value === id) selected_category.value = ''
    else     selected_category.value=id

}

onMounted(() => {
    loadCategories()
    loadProducts()

})

const loadCategories = async ()=>{
    await axios.get('/api/categories')
        .then((response) => {
            const {data}= response.data
            categories.value = data;
        }).catch((e)=>{
        console.log(e)
    })
}

const  resetFilter =()=>{
    selected_category.value=''
    search.value=''
}

const loadProducts = async () =>{
    loading.value=true
   await axios.get('/api/products',{
    params:{
        search:search.value,
        category:selected_category.value
    }
   })
        .then((response) => {
            const {data}= response.data
            products.value = data;
        }).catch((e)=>{
        console.log(e)
    }).finally(()=>{
        loading.value=false
    })
}

watch([search,selected_category], _.debounce((current, previous) => {
    loadProducts()
}, 200))


const addToCart = (product) => {
    store.commit('cart/ADD_TO_CART', product)
    toast.info("Product Added", {
        timeout: 2000,
        position: "bottom-right",
    });
}

</script>


<style scoped>
h2 {
    transition: all 0.3s ease;
    border-radius: 10px;
}

h2:hover {
    background-color: #f7f7f7;
    color: #333;
    transform: scale(1.05);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
</style>

<style>


.media {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: start;
    align-items: flex-start;
}
.media-body {
    -ms-flex: 1;
    flex: 1;
}
</style>

<style>
.slide-fade-enter-active {
    transition: all 0.3s ease;
}
.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to {
    opacity: 0;
    transform: translateX(10px);
}
</style>
<style>
.cursor-pointer{
    cursor: pointer;
}
.hover-card {
    border: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.25);
}

.hover-card .card-body {
    padding: 1.5rem;
}

.hover-card .card-body img {
    border-radius: 0.25rem;
}

.hover-card .text-small a {
    color: #6c757d;
}

.hover-card h2 a {
    color: #212529;
}

.hover-card .mt-3 {
    margin-top: 1.5rem;
}

.hover-card .text-dark {
    font-weight: 600;
    font-size: 1.2rem;
}

.match-height>[class*=col] {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-flow: column;
    flex-flow: column
}

.match-height>[class*=col]>.card {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto
}
</style>
