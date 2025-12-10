<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import ProductItem from "@/Components/Admin/Product/ProductItem.vue";
import axios from "axios";


export default {
    name: "Index",
    layout: AdminLayout,
    components: {
        ProductItem,
        Link,
    },
    props: {
        products: Array,
    },
    data() {
        return {
            productsData: this.products,
            productsChildrenData: [],
            isSearch: false,
            filter: {},
        }
    },
    methods: {
        updateProductsData(product) {
            if (product.parent_id) {
                this.productsData.forEach(productData => {
                    if (productData.id === product.parent_id) {
                        productData.children = productData.children.filter(child => child.id !== product.id)
                    }
                })
                return
            }
            this.productsData = this.productsData.filter(productData => productData.id !== product.id)
        },
        search(){
            axios.get(route('admin.products.index'), {
                params: this.filter
            })
                .then(res => {
                    this.productsData = res.data
                })
        },
        resetFilter(){
            this.filter = {};
            this.productsData = this.products;
        }
    }
}
</script>

<template>
    <div class="grid grid-cols-6 gap-4">
        <div class="col-span-4 col-start-2 ...">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <h1>Index Product</h1>
                </div>
            </div>
        </div>
        <div class="col-start-1 col-end-3 ...">
            <Link :href="route('admin.products.create')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Create Product
            </Link>
        </div>
        <div class="col-span-2 col-end-7 ...">
            <button @click.prevent="isSearch=!isSearch"
                    class="ml-4 px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-green active:bg-blue-600 transition duration-150 ease-in-out">
                Filters
            </button>
        </div>
        <div class="col-start-1 col-end-7 ...">
            <div v-if="isSearch" class="px-5 flex">

                <input
                    v-model="filter.title"
                    @input.prevent="search"
                    type="text"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-80"
                    placeholder="Enter Title" required="">
                <input
                    v-model="filter.price_from"
                    @input.prevent="search"
                    type="number"
                    class="ml-2 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-40"
                    placeholder="Enter min price" required="">
                <input
                    v-model="filter.price_to"
                    @input.prevent="search"
                    type="number"
                    class="ml-2 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-40"
                    placeholder="Enter max price" required="">
                <input
                    v-model="filter.qty_from"
                    @input.prevent="search"
                    type="number"
                    class="ml-2 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-40"
                    placeholder="Enter min qty" required="">
                <input
                    v-model="filter.qty_to"
                    @input.prevent="search"
                    type="number"
                    class="ml-2 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-40"
                    placeholder="Enter max qty" required="">


                <button @click.prevent="resetFilter"
                        class="ml-4 px-4 py-2 font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-500 focus:outline-none focus:shadow-outline-green active:bg-yellow-600 transition duration-150 ease-in-out">
                    Reset Filter
                </button>
            </div>
        </div>
        <div class="col-start-1 col-end-7 ...">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">id</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QTY</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <template v-for="product in productsData">
                    <ProductItem :product @product_deleted='updateProductsData'></ProductItem>
                    <template v-if="product.children" v-for="productChild in product.children">
                        <ProductItem :product="productChild" :is-child="true"
                                     @product_deleted='updateProductsData'></ProductItem>
                    </template>
                </template>
                </tbody>
            </table>
        </div>
    </div>


</template>

<style scoped>

</style>
