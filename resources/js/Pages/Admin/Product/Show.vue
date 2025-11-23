<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Show",
    components: {Link},
    layout: AdminLayout,
    props: {
        product: {}
    },


}
</script>

<template>

    <div class="grid grid-cols-3 gap-4">
        <div class="">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <h1>Show Product</h1>
                </div>
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
            <div class="space-y-6 ">

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
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Price</label>
                        <input disabled v-model="product.price" type="number" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter price" required="">
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Old Price</label>
                        <input disabled v-model="product.old_price" type="number" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter old price" required="">
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">QTY</label>
                        <input disabled v-model="product.qty" type="number" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter QTY" required="">
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">QTY</label>
                        <input disabled v-model="product.article" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter article" required="">
                    </div>


                    <div class="col-span-6 sm:col-span-3 py-4">
                        <label for="product_parent"
                               class="text-sm font-medium text-gray-900 block mb-2">Category</label>

                        <input disabled v-model="product.category_id"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               id="service" name="service"/>


                    </div>
                    <div class="col-span-6 sm:col-span-3 py-4">
                        <label for="product_parent"
                               class="text-sm font-medium text-gray-900 block mb-2">Product Group</label>

                        <input disabled v-model="product.product_group_id"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               id="service" name="service"/>


                    </div>
                    <!--Params-->
                    <!--                    <div class="col-span-6 sm:col-span-3 py-4">
                                            <label for="product_parent"
                                                   class="text-sm font-medium text-gray-900 block mb-2">Product Group</label>

                                            <select v-model="params"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                                <option :value="null" selected disabled>Select Product Parent</option>
                                                <option v-for="productGroup in productGroups" :value="productGroup.id">{{ productGroup.title }}</option>
                                            </select>

                                        </div>-->


                </div>


            </div>
        </div>
        <div class="">
            <div v-for="image in product.images" class="flex">
               <div class="py-4 px-2">
                   <button class=" border bg-red-600 text-white right-0">
                       Delete
                   </button>
                   <img :src="image.url" alt="" class="">
               </div>

            </div>

        </div>

    </div>




</template>

<style scoped>

</style>
