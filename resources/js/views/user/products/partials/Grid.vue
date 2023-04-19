<template>
    <div
        v-for="(product,key) in products"
        :key="'grid'+key"
        class="col-12 col-md-6 col-lg-4 col-xxl-3 mt-3">
        <div class="card hover-card">
            <div class="card-body">
                <!-- badge -->
                <div class="text-center position-relative ">
                    <div class="bg-white position-absolute r-n10 rounded rounded-circle t-n10" title="Add to cart">
                        <span class="text-primary cursor-pointer "
                              @click="$emit('addToCart',product)"
                        >
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        </span>
                    </div>
                    <img :src="product.img" alt="Grocery Ecommerce Template" class="mb-3 img-fluid">
                </div>
                <h2 class="fs-5 mb-1">
                    {{product.title}}
                </h2>
                <div class="text-small mb-1">
                    <small class="text-muted">{{product.category}}</small>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div><span class="text-primary fw-bolder fs-5">{{product.price}} OMR</span> / <span class=" text-muted fw-normal">{{ product.stock }} in stock</span>
                    </div>
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

.r-n10 {
    right: -10px !important;
}
.t-n10 {
    top: -10px !important;
}
svg {
    transition: all 0.3s ease;
}

svg:hover {
    transform: scale(1.2);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    border-radius: 50% !important;
}
</style>
