<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";


export default {
    name: "Index",
    layout: AdminLayout,
    components: {
        Link,
    },
    props: {
        categories: Array,
    },
    data() {
        return {
            categoriesData: this.categories,
            isSearch: false,
            filter: {},
        }
    },
    methods: {
        deleteCategory(category) {
            axios.delete(route('admin.categories.destroy', category.id))
                .then(res => {
                    console.log(category)
                    this.categoriesData = this.categoriesData.filter(categoryData => categoryData.id !== category.id)
                })
        },
        search() {


            axios.get(route('admin.categories.index'), {
                params: this.filter
            })
                .then(res => {
                    this.categoriesData = res.data
                })
        },
        resetFilter(){
            this.filter={};
            this.categoriesData=this.categories;
        }
    }
}
</script>

<template>
    <div class="grid grid-cols-6 gap-4">
        <div class="col-span-4 col-start-2 ...">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <h1>Index Category</h1>
                </div>
            </div>
        </div>
        <div class="col-start-1 col-end-3 ...">
            <Link :href="route('admin.categories.create')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Create Category
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
                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-80 p-2.5"
                       placeholder="Enter Title”" required="">
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>

                </thead>
                <tbody class="bg-white divide-y divide-gray-200">

                <tr v-for="category in categoriesData" class="w-96">
                    <td class="px-6 py-4 whitespace-nowrap">{{ category.id }}</td>

                    <td class="px-6 py-4 whitespace-nowrap w-96">
                        <Link :href="route('admin.categories.show', category)">
                            {{ category.title }}
                        </Link>
                    </td>


                    <td class="px-6 py-4 whitespace-nowrap">{{ category.parent_title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap  w-96">
                        <Link :href="route('admin.categories.edit', category)"
                              class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                            Edit
                        </Link>
                        <button @click="deleteCategory(category)"
                                class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                            Delete
                        </button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>




</template>

<style scoped>

</style>
