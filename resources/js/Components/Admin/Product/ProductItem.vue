<script>

import {Link} from "@inertiajs/vue3";
import axios from "axios";


export default {
    name: "ProductItem",
    components: {Link},
    props: {
        product: {},
        isChild: Boolean,

    },
    data() {
        return {
            isClosed: true,
        }
    },
    methods: {

        deleteProduct(product) {

            axios.delete(route('admin.products.destroy', product.id))
                .then(res => {
                    this.$emit('product_deleted', product)

                })
        },
        getProductChildren() {


            axios.get(route('admin.products.children.index', this.product.id))
                .then(res => {
                    this.product.children = res.data;
                    this.isClosed = false;
                })
        },
        closedProductChildren() {

            this.isClosed = true;
            this.product.children = null;


        }
    }

}
</script>

<template>
    <tr :class="[product.parent_id ? 'bg-gray-100' : 'bg-white','px-6 py-4 whitespace-nowrap']">
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <div class="flex items-center justify-center w-10 h-10 mx-auto rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 text-white font-bold text-sm shadow-md">
                {{ product.id }}
            </div>
        </td>
        <Link :href="route('admin.products.show', product)">
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex items-center justify-center gap-2">
                    <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30 group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors duration-200">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-150">
                        {{ product.title }}
                    </span>
                </div>
            </td>
        </Link>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                {{ product.price }} ₽
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <span :class="[
                product.qty === 0 ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' :
                product.qty < 10 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' :
                'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
            ]" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold">
                <span :class="[
                    product.qty === 0 ? 'bg-red-500' :
                    product.qty < 10 ? 'bg-amber-500' :
                    'bg-green-500'
                ]" class="w-1.5 h-1.5 rounded-full mr-1.5"></span>
                {{ product.qty }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <span v-if="product.parent_id"
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>
                Дочерний
            </span>
            <span v-else
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                Главный
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <div class="flex items-center justify-center gap-2">
                <Link :href="route('admin.products.edit', product)"
                      title="Редактировать"
                      class="inline-flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 hover:scale-110">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </Link>

                <button @click="deleteProduct(product)"
                        title="Удалить"
                        class="inline-flex items-center justify-center w-10 h-10 text-red-600 bg-red-50 dark:bg-red-900/30 dark:text-red-400 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 hover:scale-110">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                <div v-if="!product.parent_id"
                     class="inline-flex items-center justify-center w-10 h-10 text-green-600 bg-green-50 dark:bg-green-900/30 dark:text-green-400 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 hover:scale-110">
                    <Link :href="route('admin.products.replicate', product.id)" method="post">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                    </Link>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <svg @click="getProductChildren()" v-if="!product.parent_id && isClosed && product.has_children" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="size-6 cursor-pointer mx-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
            </svg>
            <svg @click="closedProductChildren" v-if="!product.parent_id && !isClosed && product.has_children"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="size-6 cursor-pointer mx-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5"/>
            </svg>

        </td>
    </tr>
</template>

<style scoped>

</style>
