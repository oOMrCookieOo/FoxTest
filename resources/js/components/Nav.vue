<template>

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <router-link to="/" class="navbar-brand">Fox Test</router-link>
            <a class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                    <template v-if="!user?.name">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link fw-bold" aria-current="page">{{ 'products' }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link fw-bold" to="/login"
                            >{{ 'login' }}</router-link
                            >
                        </li>
                        <li class="nav-item mt-2">
                            <CardModal />
                        </li>
                    </template>
                    <li v-if="user?.name" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><router-link class="dropdown-item" to="/admin">Panel</router-link></li>
                            <li><router-link to="/admin/products" class="dropdown-item">Products</router-link></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" @click="logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { useStore} from "vuex";
import useAuth from "@/composables/auth";
import {computed} from "vue";
import CardModal from "./includes/CardModal.vue";

    const store = useStore();
    const user = computed(() => store.getters["auth/user"])
    const { processing, logout } = useAuth();

    const cartProducts = computed(() => store.getters['cart/cartProducts'])
    const count = computed(() => store.getters['cart/addedCount'])
    const removeFromCart = (product) => {
        store.commit('cart/REMOVE_FROM_CART', product)
    }

</script>


