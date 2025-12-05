<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import WindowSuccessMessage from "@/Components/Admin/General/WindowSuccessMessage.vue";

export default {
    name: "Show",
    components: {WindowSuccessMessage, Link},
    layout: AdminLayout,
    props: {
        product: {}
    },


}
</script>

<template>

    <div class="grid grid-cols-3 gap-4">
        <div class="">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Create Product</h1>
            </div>
        </div>
        <div class="">

        </div>
        <div class="">
            <Link :href="route('admin.products.index')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Back Index
            </Link>
        </div>
        <div class="col-span-2 ...">
            <div class="space-y-6">

                <div class="">
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                        <input disabled v-model="product.title" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter Title" required="">
                    </div>
                    <div>
                        <label for="product-name"
                               class="text-sm font-medium text-gray-900 block mb-2">Description</label>
                        <textarea disabled v-model="product.description" type="text" name="" id=""
                                  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                  placeholder="Enter description”"></textarea>
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Content</label>
                        <textarea disabled v-model="product.content" type="text"
                                  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                  placeholder="Enter content" required=""></textarea>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Price</label>
                            <input disabled v-model="product.price" type="number" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter price" required="">
                        </div>
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Old
                                Price</label>
                            <input disabled v-model="product.old_price" type="number" name="product-name"
                                   id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter old price" required="">
                        </div>
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">QTY</label>
                            <input disabled v-model="product.qty" type="number" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter QTY" required="">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="product-name"
                                   class="text-sm font-medium text-gray-900 block mb-2">Article</label>
                            <input disabled v-model="product.article" type="number" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter article" required="">
                        </div>


                        <div class="">
                            <label for="product_parent"
                                   class="text-sm font-medium text-gray-900 block mb-2">Category</label>

                            <input disabled v-model="product.category.title"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"/>




                        </div>
                        <div class="">
                            <label for="product_parent"
                                   class="text-sm font-medium text-gray-900 block mb-2">Product Group</label>

                            <input disabled v-model="product.product_group.title"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" />




                        </div>
                    </div>
                    <!--Params-->

                    <div>
                        <div class="container mx-auto p-2">
                            <div class="px-2 py-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <h1>Params Product</h1>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <div v-for="param in product.params">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ param.title }} - {{ param.value }}


            </span>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>


            </div>
        </div>

        <div class="">
            <div v-if="product.images.length !==0">
                <div class="px-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <h1>Images</h1>
                </div>
                <!--        Images View     -->
                <div v-for="image in product.images" class="relative">
                    <div class="py-4 px-2 w-40">
                        <div class="">
                            <img :src="image.url" alt="" class="">

                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>


</template>

<style scoped>

</style>
