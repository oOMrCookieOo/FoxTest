<template>
    <div class="container-md">
        <form @submit.prevent="submitForm">
             <div class="row justify-content-center my-5" >
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                        <!-- Title -->
                        <div class="row">

                        <div class="col">
                            <div class="mb-3">
                                <label for="product-title" class="form-label">
                                    Title
                                </label>
                                <input v-model="product.title" id="product-title" type="text" class="form-control">
                                <div class="text-danger mt-1">
                                    {{ errors.title }}
                                </div>
                                <div class="text-danger mt-1">
                                    <div v-for="message in validationErrors?.title">
                                        {{ message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">

                            <div class="mb-3">
                                <label for="product-title" class="form-label">
                                    Slug
                                </label>
                                <input disabled v-model="product.slug" id="product-slug" type="text" class="form-control">
                                <div class="text-danger mt-1">
                                    {{ errors.slug }}
                                </div>
                                <div class="text-danger mt-1">
                                    <div v-for="message in validationErrors?.slug">
                                        {{ message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="product-description" class="form-label">
                                Content
                            </label>
                            <textarea v-model="product.description" id="product-description" class="form-control"></textarea>
                            <div class="text-danger mt-1">
                                {{ errors.description }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.description">
                                    {{ message }}
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                    <div class="card border-0 shadow-sm my-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="image" class="form-label">
                                    Image
                                </label>
                                <input @change="product.image = $event.target.files[0]" type="file"  class="form-control"  />
                                <div class="text-danger mt-1">
                                    {{ errors.image }}
                                </div>
                                <div class="text-danger mt-1">
                                    <div v-for="message in validationErrors?.image">
                                        {{ message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm my-3">
                        <div class="card-header bg-white border-0">
                            <h4 class="card-title">Pricing & Stock</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="product-title" class="form-label">
                                            Price
                                        </label>
                                        <input v-model="product.price" id="product-price" type="number" class="form-control">
                                        <div class="text-danger mt-1">
                                            {{ errors.price }}
                                        </div>
                                        <div class="text-danger mt-1">
                                            <div v-for="message in validationErrors?.price">
                                                {{ message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">

                                    <div class="mb-3">
                                        <label for="product-title" class="form-label">
                                            Stock
                                        </label>
                                        <input v-model="product.stock" id="product-title" type="number" class="form-control">
                                        <div class="text-danger mt-1">
                                            {{ errors.stock }}
                                        </div>
                                        <div class="text-danger mt-1">
                                            <div v-for="message in validationErrors?.stock">
                                                {{ message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0">
                            <h4 class="card-title">Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input v-model="product.is_active" class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Visible</label>
                                </div>
                                <small>This product will be hidden from all sales channels.</small>
                                <div class="text-danger mt-1">
                                    {{ errors.is_active }}
                                </div>
                                <div class="text-danger mt-1">
                                    <div v-for="message in validationErrors?.is_active">
                                        {{ message }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="my-3 card border-0 shadow-sm">
                        <div class="card-header bg-white border-0">
                            <h4 class="card-title">Associations</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="product-category" class="form-label">
                                    Category
                                </label>
                                <v-select v-model="product.category_id" :options="categoryList" :reduce="category => category.id" label="name"  />
                                <div class="text-danger mt-1">
                                    {{ errors.category_id }}
                                </div>
                                <div class="text-danger mt-1">
                                    <div v-for="message in validationErrors?.category_id">
                                        {{ message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <button type="submit" :disabled="isLoading" class="btn btn-primary w-auto me-4">
                            <div v-show="isLoading" class=""></div>
                            <span v-if="isLoading">Processing...</span>
                            <span v-else>Create</span>
                        </button>

                    <!-- Buttons -->
                        <router-link to="/admin/products" type="button" class="btn btn-secondary w-auto me-4">
                            <span>Cancel</span>
                        </router-link>
                </div>
    </div>
        </form>

    </div>
</template>
<script setup>
    import { onMounted, reactive,watch } from "vue";
    import useCategories from "@/composables/categories";
    import useProducts from "@/composables/products";
    import { useForm, useField, defineRule } from "vee-validate";
    import { required, min} from "../../../validation/rules"
    import slugify from 'slugify';
    defineRule('required', required)
    defineRule('min', min);

    // Define a validation schema
    const schema = {
        title: 'required|min:5',
        description: 'required|min:50',
        category_id: 'required',
        image: 'required',
        stock: 'required',
        price: 'required'
    }



    // Create a form context with the validation schema
    const { validate, errors } = useForm({ validationSchema: schema })
    // Define actual fields for validation
    const { value: title } = useField('title', null, { initialValue: '' });
    const { value: slug } = useField('slug', null, { initialValue: '' });
    const { value: description } = useField('description', null, { initialValue: '' });
    const { value: category_id } = useField('category_id', null, { initialValue: '', label: 'category' });
    const { value: price } = useField('price', null, { initialValue: ''});
    const { value: stock } = useField('stock', null, { initialValue: ''});
    const { value: is_active } = useField('is_active', null, {label: 'Visible'});
    const { value: image } = useField('image', null, { initialValue: ''});

    const { categoryList, getCategoryList } = useCategories()
    const { storeProduct, validationErrors, isLoading } = useProducts()
    const product = reactive({
        title,
        description,
        category_id,
        price,
        is_active:true,
        stock,
        image
    })

    watch(() => product.title, (newTitle) => {
        product.slug = slugify(newTitle, {
            lower: true,
            strict: true
        });
    });
    function submitForm() {
        validate().then(form => { if (form.valid) storeProduct(product) })
    }
    onMounted(() => {
        getCategoryList()
    })
</script>
<style scoped>
input {
    background-color: white;
}
textarea{
    background-color: white;
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
