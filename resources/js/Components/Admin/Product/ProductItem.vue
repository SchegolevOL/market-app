<script>

import {Link} from "@inertiajs/vue3";
import axios from "axios";


export default {
    name: "ProductItem",
    components: {Link},
    props: {
        product: {},
        isChild:Boolean,

    },
    data(){
      return{
          isClosed:true,
      }
    },
    methods: {

        deleteProduct(product) {
            this.$emit('product_deleted', product)
            axios.delete(route('admin.products.destroy', product.id))
                .then(res => {
                    this.$emit('product_deleted', product)

                })
        },
        getProductChildren() {



            axios.get(route('admin.products.children.index', this.product.id))
                .then(res=>{
                    this.product.children = res.data;
                    this.isClosed = false;
                })
        },
        closedProductChildren(){

                this.isClosed = true;
                this.product.children = null;


        }
    }

}
</script>

<template>
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">{{ product.id }}</td>
        <Link :href="route('admin.products.show', product)">
            <td class="px-6 py-4 whitespace-nowrap">{{ product.title }}</td>
        </Link>
        <td class="px-6 py-4 whitespace-nowrap">{{ product.price }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ product.qty }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <Link :href="route('admin.products.edit', product)"
                  class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                Edit
            </Link>

            <button @click="deleteProduct(product)"
                    class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                Delete
            </button>
            <Link :href="route('admin.products.children.create', product)"
                  class="ml-2 px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                Child
            </Link>

        </td>
        <td class="px-6 py-4 whitespace-nowrap" >
            <svg @click="getProductChildren()" v-if="!product.parent_id && isClosed"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="size-6 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
            </svg>
            <svg @click="closedProductChildren"  v-if="!product.parent_id && !isClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>

        </td>
    </tr>
</template>

<style scoped>

</style>
