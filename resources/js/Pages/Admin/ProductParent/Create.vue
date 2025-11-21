<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";


export default {
    name: "Create",
    components: {
        Link
    },
    layout: AdminLayout,
    props: {
        categories: Array
    },
    data() {
        return {

                product_parent: {
                    title: null,

                },



        }
    },
    methods: {
        storeProductParent() {

            axios.post(route('admin.product-parents.store'), this.product_parent)
                .then(res => {
                        this.product_parent.title='';
                        this.product_parent.category_id='';
                    }
                )
        },
        storeProductParentToIndex() {
            axios.post(route('admin.product-parents.store'), this.product_parent)
                .then(res => {
                    window.location.replace(route('admin.product-parents.index'));
                })
        },

    }


}
</script>

<template>
    <div class="bg-white border-4 rounded-lg shadow relative m-10">

        <div class="flex items-start justify-between p-5 border-b rounded-t">
            <h3 class="text-xl font-semibold">
                Create ProductParent
            </h3>
            <Link :href="route('admin.product-parents.index')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Back Index
            </Link>
        </div>

        <div class="p-6 space-y-6">

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                        <input v-model="product_parent.title" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter Title”" required="">
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="category" class="text-sm font-medium text-gray-900 block mb-2">Category</label>

                        <select v-model="product_parent.category_id"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                id="service" name="service">

                            <option v-for="category in categories" :value="category.id">{{ category.title }}</option>

                        </select>

                    </div>



                </div>

        </div>

        <div class="p-6 border-t border-gray-200 rounded-b">

            <button @click.prevent="storeProductParent"
                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="submit">Create
            </button>
            <button @click.prevent="storeProductParentToIndex"
                    class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="submit">Create to Index
            </button>
        </div>


    </div>
</template>

<style scoped>

</style>
