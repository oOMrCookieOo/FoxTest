<template>
    <div class="container-fluid">
    <div class="row justify-content-center mb-5">
        <h5 class="float-start fw-bolder fs-2 mb-4">Products</h5>
        <div class="col-md-12">
            <div class="card border-0">
                <div class="align-items-center bg-transparent border-0 card-header d-flex flex-column flex-md-row flex-wrap justify-content-between pt-3">
                        <div class="form-group has-search ">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input v-model="search_global" type="text" placeholder="Search in products"
                                   class="form-control bg-transparent">
                        </div>
                    <div class="d-flex flex-column flex-md-row">
                        <router-link :to="{ name: 'products.create' }" class="me-1 btn btn-primary px-4 py-2 rounded-4">
                            <svg class="me-1" viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span class="align-middle fw-normal">Add Product</span>
                        </router-link>

                        <a href="javascript:void(0)" class="me-1 btn btn-outline-secondary px-4 py-2 rounded-4">
                            <svg class="me-1" viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span class="align-middle fw-normal">Import Csv</span>
                        </a>
                    </div>

                </div>
                <div class="card-body shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="bg-light border-white">
                            <tr>
                                <th class="text-center">  <input type="checkbox" class="form-check-input"></th>
                                <th v-for="(column,key) in tableColumns" :key="key">
                                    {{column}}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="fw-bold" v-for="product in products.data" :key="product.id">
                                <td class="px-6 py-4 text-sm align-middle text-center">
                                    <input type="checkbox" class="form-check-input" :value="product.id">
                                </td>
                                <td class="px-6 py-4 text-sm w-25">
                                        <img :src="product.img" class="img-fluid rounded-4 w-20 d-none d-lg-inline" alt="Sheep">
                                        <span class="ml-1">{{ product.title }}</span>


                                </td>
                                <td class="px-6 py-4 text-sm align-middle">
                                   <span class="bg-light p-2 rounded-3">{{ product.category }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm align-middle">
                                    {{ product.stock }}
                                </td>
                                <td class="px-6 py-4 text-sm align-middle">
                                    {{ product.price +" OMR" }}
                                </td>
                                <td class="px-6 py-4 text-sm align-middle d-flex">
                                    <a
                                        href="#" class="btn btn-info rounded-3 text-white btn-sm">
                                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    </a>
                                    <a href="#"  @click.prevent="deleteProduct(product.id)"
                                       class="bg-warning border-warning btn btn-danger btn-sm ms-2 rounded-3 text-white">
                                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-white" v-if="products.meta">
                    <div class="align-items-baseline d-flex justify-content-between">
                        <div class="fw-bolder">Showing {{products.meta.from}} to {{products.meta.to}} of {{products.meta.total}} entries</div>
                        <Pagination  :data="products"
                                    @pagination-change-page="page => getProducts(page,search_global)"
                                    class="mt-4 justify-content-center"/>
                        <div class="align-items-center d-flex fw-bold">
                            <span class="mr-1">show</span>
                            <select v-model="perPage" class="form-select bg-transparent" aria-label="Default select example">
                                <option v-for="(option,key) in perPageOptions" :value="option">{{ option }}</option>
                            </select>
                            <span class="ml-1">entries</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script setup>
    import {ref, onMounted, watch} from "vue";
    import useProducts from "@/composables/products";

    const search_global = ref('')
    const perPage=ref(5)
    const {products, getProducts, deleteProduct,perPageOptions,tableColumns} = useProducts()
    onMounted(() => {
        getProducts()
    })
    watch([search_global,perPage], _.debounce((current, previous) => {
        getProducts(
            1,
            search_global.value,
            perPage.value
        )
    }, 200))

</script>

<style scoped>
@media screen and (max-width: 767px) {
    .card-header > div {
        flex-direction: column;
        align-items: stretch;
    }
    .card-header > div > * {
        margin-bottom: 1rem;
    }
}
.w-10per{
 width: 10%;
}
.icons {
    display: grid;
    grid-gap: 0.5rem;
    grid-template-columns: repeat(auto-fill, minmax(14rem, 1fr));
    list-style: none;
    margin: 0;
    padding: 0;
}

.icons > li {
    background-color: #f8f8f8;
    padding: 0.5rem 1rem;
    transition: color 0.15s;
}

.icons > li:hover {
    color: #0074d9;
}

.icons > li > i {
    vertical-align: middle;
}

.icons > li > span {
    color: gray;
    margin-left: 0.5rem;
    transition: color 0.15s;
}

.icons > li:hover > span {
    color: inherit;
}
</style>
