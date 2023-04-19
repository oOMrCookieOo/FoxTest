<template>
    <div class="dropdown">
        <a href="#" class="text-muted position-relative mt-2" id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">{{count}}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" style="top: 2.5rem" aria-labelledby="cartDropdown">
            <div class="dropdown-header">
                <div class="title">
                    <div class="row">
                        <div class="col"><h4><b>Shopping Cart</b></h4></div>
                        <div class="col align-self-center text-end text-muted fw-bold">{{ count }} items</div>
                    </div>
                </div>
            </div>
            <li v-for="product in cartProducts" :key="'cart-'+product.id" class="cart-item">
                <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded cursor-pointer">
                    <div class="d-flex flex-row">
                        <img alt="Prod" class="rounded" :src="product.img" width="40">
                        <div class="ml-2">
                            <span class="font-weight-bold d-block fw-bold">{{product.title}}</span>
                            <span class="spec ">{{product.category}}</span>
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                        <span class="d-block fw-bold">{{product.quantity}}</span>
                        <span class="d-block ml-5 font-weight-bold mx-4 fw-bold">{{product.price}} OMR</span>
                        <span
                            title="remove from cart"
                            @click="removeFromCart(product)"
                            class="cursor-pointer trash-icon">
                            <i class="fa fa-trash-o ml-3 text-danger"></i>
                        </span>

                    </div>
                </div>
            </li>
            <li>
                <a class="btn btn-outline-primary w-100" href="javascript:void(0)">Checkout</a>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { useStore} from "vuex";
import {computed} from "vue";
import { useToast } from "vue-toastification";
const toast = useToast();
const store = useStore();
const user = computed(() => store.getters["auth/user"])

const cartProducts = computed(() => store.getters['cart/cartProducts'])

const count = computed(() => store.getters['cart/addedCount'])

const removeFromCart = (product) => {
    store.commit('cart/REMOVE_FROM_CART', product)
    toast.error("Product Removed", {
        timeout: 2000,
        position: "bottom-right",
    });
}

</script>

<style scoped>

.trash-icon {
    transition: all 0.2s ease-in-out;
}
.trash-icon:hover {
    transform: scale(1.4);
}
.cursor-pointer{
    cursor: pointer;
}
/* Cart dropdown styles */
@media (min-width: 767px) {
    .dropdown-menu {
        width: 420px;
        padding: 10px;
        top: 4rem;
    }

}

.dropdown-menu {
    width: 380px;
    transition: opacity 0.3s ease;
}

.cart-item {
    margin-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 10px;
}

.items:hover {
    background-color: #f2f2f2;
}
.cart-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.cart-item img {
    width: 50px;
    height: 50px;
    object-fit: contain;
    margin-right: 10px;
}


.dropdown-menu-end {
    left: auto !important;
    right: 0 !important;
}
</style>
