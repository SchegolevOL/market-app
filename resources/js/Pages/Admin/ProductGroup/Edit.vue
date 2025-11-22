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
        productGroup:{

        },
    },

    methods: {
        updateProductGroup() {


            axios.patch(route('admin.product-groups.update', this.productGroup), this.productGroup)
                .then(res => {


                })
        },
        updateProductGroupToIndex() {
            axios.patch(route('admin.product-groups.update', this.productGroup), this.productGroup)
                .then(function () {
                        window.location.replace(route('admin.product-groups.index'));

                    }
                )
        },

    }


}
</script>

<template>
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <h1>Edit Product Group</h1>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8">


            <!-- Product Info -->
            <div class="space-y-6">
                <Link :href="route('admin.product-groups.index')"
                      class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                    Back Index
                </Link>

                <div class="">
                    <div >
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                        <input v-model="productGroup.title" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter Title”" required="">
                    </div>
                    <div class="col-span-6 sm:col-span-3 py-4">
                        <label for="productGroup" class="text-sm font-medium text-gray-900 block mb-2">Category Title</label>

                        <select v-model="productGroup.category_id"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                id="service" name="service">
                            <option v-for="category in categories" :value="category.id">{{ category.title }}</option>

                        </select>



                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">

                        <button @click.prevent="updateProductGroup"
                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="submit">Update
                        </button>
                        <button @click.prevent="updateProductGroupToIndex"
                                class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="submit">Update to Index
                        </button>
                    </div>
                </div>


            </div>
        </div>


    </main>
</template>

<style scoped>

</style>
