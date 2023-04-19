<template>
    <Nav/>
    <router-view></router-view>
</template>
<script setup>
import Nav from '../components/Nav.vue'

</script>

<style>

body{
    background-color: #f6f6f6;
}
.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
</style>
