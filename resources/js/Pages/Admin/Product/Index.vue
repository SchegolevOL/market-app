<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import ProductItem from "@/Components/Admin/Product/ProductItem.vue";


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
            productsChildrenData: []
        }
    },
    methods: {
        updateProductsData(product) {
            if (product.parent_id){
                this.productsData.forEach(productData=>{
                    if (productData.id === product.parent_id){
                        productData.children = productData.children.filter(child=> child.id !== product.id)
                    }
                })
                return
            }
            this.productsData = this.productsData.filter(productData => productData.id !== product.id)
        },


    }
}
</script>

<template>


    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <h1>Index Product</h1>
        </div>
    </div>

    <div class="container mx-auto px-4 ">

        <Link :href="route('admin.products.create')"
              class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
            Create Product
        </Link>

        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">id</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QTY</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <template v-for="product in productsData">
                <ProductItem :product @product_deleted='updateProductsData'></ProductItem>
                <template v-if="product.children" v-for="productChild in product.children">
                    <ProductItem :product = "productChild" :is-child = "true" @product_deleted='updateProductsData' ></ProductItem>
                </template>
            </template>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
