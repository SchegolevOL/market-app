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

            console.log(this.filter)
            /*axios.get(route('admin.categories.index'), this.filter)
                .then(res => {
                    this.categoriesData = res.data
                })*/
        }
    }
}
</script>

<template>


    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <h1>Index Category</h1>
        </div>
    </div>

    <div class="container mx-auto px-4 ">

        <Link :href="route('admin.categories.create')"
              class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
            Create Category
        </Link>
        <button @click.prevent="isSearch=!isSearch"
                class="ml-4 px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-green active:bg-blue-600 transition duration-150 ease-in-out">
            Search
        </button>
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
            <tr v-if="isSearch">
                <td class="px-6 py-4 whitespace-nowrap"></td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="px-5">

                        <input
                            v-model="filter.title"
                            @input.prevent="search"
                            type="text"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                            placeholder="Enter Title”" required="">
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap ">
                    <div class="px-5">

                        <input
                            v-model="filter.parent"
                            @input.prevent="search"
                            type="text"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                            placeholder="Enter Title”" required="">
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap"></td>

            </tr>
            <tr v-for="category in categoriesData" class="w-96">
                <td class="px-6 py-4 whitespace-nowrap">{{ category.id }}</td>

                <td class="px-6 py-4 whitespace-nowrap w-96">
                    <Link :href="route('admin.categories.show', category)">
                        {{ category.title }}
                    </Link>
                </td>


                <td class="px-6 py-4 whitespace-nowrap">{{ category.parent }}</td>
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
</template>

<style scoped>

</style>
