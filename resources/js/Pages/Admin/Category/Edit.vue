<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";


export default {
    name: "Edit",
    components: {
        Link
    },
    layout: AdminLayout,
    props: {
        categories: Array,
        category:{},
    },

    methods: {
        updateCategory() {


            axios.patch(route('admin.categories.update', this.category), this.category)
                .then(res => {


                })
        },
        updateCategoryToIndex() {
            axios.post(route('admin.categories.update'), this.category)
                .then(function () {
                        window.location.replace(route('admin.categories.index'));

                    }
                )
        },

    }


}
</script>

<template>
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <h1>Edit Category</h1>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8">


            <!-- Product Info -->
            <div class="space-y-6">
                <Link :href="route('admin.categories.index')"
                      class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                    Back Index
                </Link>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <h1>Create Category</h1>
                </div>
                <div class="">
                    <div >
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                        <input v-model="category.title" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter Title”" required="">
                    </div>
                    <div class="col-span-6 sm:col-span-3 py-4">
                        <label for="category" class="text-sm font-medium text-gray-900 block mb-2">Category</label>

                        <select v-model="category.parent_id"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                id="service" name="service">
                            <option selected :value=null>Main Category</option>
                            <option v-for="category in categories" :value="category.id">{{ category.title }}</option>

                        </select>
                        <label for="example1" class="mb-1 block text-sm font-medium text-gray-700">Upload file</label>


                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">

                        <button @click.prevent="updateCategory"
                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="submit">Create
                        </button>
                        <button @click.prevent="updateCategoryToIndex"
                                class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="submit">Create to Index
                        </button>
                    </div>
                </div>


            </div>
        </div>


    </main>
</template>

<style scoped>

</style>
