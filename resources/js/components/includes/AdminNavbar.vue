<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom ">
        <button class="d-md-none btn btn-primary" id="menu-toggle">Toggle Menu</button>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mx-md-5" id="navbarSupportedContent">
            <div class="my-3 my-md-0 form-group has-search ">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" placeholder="Search"
                       class="form-control bg-transparent">
            </div>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Hi, {{ user.name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                        <li><a class="dropdown-item" :class="{ 'opacity-25': processing }" :disabled="processing"
                               href="javascript:void(0)" @click="logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import {computed} from "vue";
import { useStore } from 'vuex';
import useAuth from "@/composables/auth";

const store = useStore();
const user = computed(() => store.state.auth.user)
const {processing, logout} = useAuth();
</script>

<style scoped>

</style>
