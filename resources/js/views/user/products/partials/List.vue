<template>
    <div  v-for="(product,key) in products"
          :key="'list'+key"
          class="card hover-card my-3 ">
        <div class="card-body">
            <div class="media align-items-center  text-center text-lg-left flex-column flex-lg-row">
                <div class="mr-2 mb-3 mb-lg-0">

                    <img :src="product.img" width="150" height="150" alt="">

                </div>

                <div class="media-body text-center text-md-start mx-2">
                    <h2 class="fs-5 text-primary fw-bolder mb-1">
                        {{product.title}}
                    </h2>
                    <div class="text-small mb-1">
                        <small class="text-muted fw-bolder">{{product.category}}</small>
                    </div>

                    <p class="mb-3">
                        {{product.description}}
                    </p>
                </div>

                <div class="mt-3 mt-lg-0 ml-lg-3 text-center">
                    <h3 class="mb-0 fw-bold">{{product.price}} OMR</h3>
                    <button type="button" class="btn btn-primary mt-4 text-white"
                            @click="$emit('add-To-Cart',product)"
                    >Add to cart</button>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

defineProps({
    products: {
        type: Array,
        required: true,
    },
});

defineEmits(['addToCart']);
</script>

<style scoped>

</style>
