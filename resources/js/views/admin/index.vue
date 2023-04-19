<template>
    <div>
        <div class="card">
            <div class="card-body border-white ">
                <h3>Welcome to Fox test</h3>
                <br>
                <span class="fw">head to </span>
                <router-link :to="{name:'products.index'}">
                    <span class="fw-bolder">Products</span>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
</script>

<style scoped>

</style>
