<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Show",
    components: {Link},
    layout: AdminLayout,
    props: {
        param: {}
    },


}
</script>

<template>
    <div class="grid grid-cols-3 gap-4">
        <div class="">
            <!--      Page name      -->
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Show Category</h1>
            </div>

        </div>
        <div class="">

        </div>
        <div class="">
            <!--       Navigation buttons       -->
            <Link :href="route('admin.params.index')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Back Index
            </Link>
        </div>
        <div class="col-span-2">
            <!--        Form fields     -->
            <div class="">


                <!-- Product Info -->
                <div class="space-y-6">


                    <div class="">
                        <div >
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                            <input disabled v-model="param.title" type="text" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter Title”" required="">
                        </div>
                        <div class="col-span-6 sm:col-span-3 py-4">
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Parent Category</label>
                            <input disabled v-model="param.filter_type_title" type="text" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter Title”" required="">





                        </div>

                    </div>


                </div>
            </div>
        </div>
        <div class="">
            <!--        Image output        -->

        </div>

    </div>








</template>

<style scoped>

</style>
