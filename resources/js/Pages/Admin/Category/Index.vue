<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";


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
            categoriesData: this.categories
        }
    },
    methods: {
        deleteCategory(category) {
            axios.delete(route('admin.categories.destroy', category.id))
                .then(res => {
                    console.log(category)
                    this.categoriesData = this.categoriesData.filter(categoryData => categoryData.id !== category.id)
                })
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
            <tr v-for="category in categoriesData">
                <td class="px-6 py-4 whitespace-nowrap">{{ category.id }}</td>
                <Link :href="route('admin.categories.show', category)">
                    <td class="px-6 py-4 whitespace-nowrap">{{ category.title }}</td>
                </Link>

                <td class="px-6 py-4 whitespace-nowrap">{{ category.parent }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
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
