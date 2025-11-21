<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";


export default {
    name: "Edit",
    components: {
        Link
    },
    layout: AdminLayout,
    props:{
        categories:Array,
        category:Object,
    },

    methods:{
        updateCategory(){
            console.log(this.categories);
            axios.patch(route('admin.categories.update', this.category.id), this.category)
                .then(res=>{


                })
        },
        updateCategoryToIndex(){
            axios.post(route('admin.categories.update'))
                .then(function () {


                    }

                )
        },
    }


}
</script>

<template>
    <div class="bg-white border-4 rounded-lg shadow relative m-10">

        <div class="flex items-start justify-between p-5 border-b rounded-t">
            <h3 class="text-xl font-semibold">
                Edit Category
            </h3>
            <Link :href="route('admin.categories.index')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Back Index
            </Link>
        </div>

        <div class="p-6 space-y-6">
            <form action="#">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                        <input v-model="category.title" type="text" name="product-name" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Enter Title”" required="">
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="category" class="text-sm font-medium text-gray-900 block mb-2">Category</label>

                        <select v-model="category.parent_id"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                id="service" name="service">
                            <option :value=null>Main Category</option>
                            <option v-for="category in categories" :value="category.id">{{category.title}}</option>

                        </select>


                    </div>
                    <div class="mx-auto max-w-xs">
                        <label for="example1" class="mb-1 block text-sm font-medium text-gray-700">Upload file</label>
                        <input id="example1" type="file" class="mt-2 block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-teal-500 file:py-2 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-teal-700 focus:outline-none disabled:pointer-events-none disabled:opacity-60" />
                    </div>

                </div>
            </form>
        </div>

        <div class="p-6 border-t border-gray-200 rounded-b">

            <button @click.prevent = "updateCategory" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Update</button>
            <button @click.prevent = "updateCategoryToIndex" class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Update to Index</button>
        </div>


    </div>
</template>

<style scoped>

</style>

