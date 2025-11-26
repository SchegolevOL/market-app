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
        categories: Array,
        productGroups: Array,
    },
    data() {
        return {
            entries: {
                product: {
                    category_id: null,
                    product_group_id: null,


                },
                images: [],
                //params:[],
            },
            imagesView: [],
        }
    },


    methods: {
        storeProduct() {
            console.log(this.entries);

            axios.post(route('admin.products.store'), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }

            })
                .then(res => {


                    this.entries.product = {};
                    this.imagesView = [];


                })

        },
        storeProductToIndex() {

            console.log(this.entries)
            axios.post(route('admin.products.store'), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
                .then(function () {
                        window.location.replace(route('admin.products.index'));

                    }
                )
        },
        addImages(e) {

            this.entries.images = e.target.files

            for (let i = 0; i < this.entries.images.length; i++) {
                this.imagesView[i] = {
                    'item': i,
                    'url': URL.createObjectURL(this.entries.images[i]),
                };
            }

            console.log(this.entries.images)
        },


    }


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
                        <input v-model="entries.product.title" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter Title" required="">
                    </div>
                    <div>
                        <label for="product-name"
                               class="text-sm font-medium text-gray-900 block mb-2">Description</label>
                        <textarea v-model="entries.product.description" type="text" name="" id=""
                                  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                  placeholder="Enter description”"></textarea>
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Content</label>
                        <textarea v-model="entries.product.content" type="text"
                                  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                  placeholder="Enter content" required=""></textarea>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Price</label>
                            <input v-model="entries.product.price" type="number" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter price" required="">
                        </div>
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Old
                                Price</label>
                            <input v-model="entries.product.old_price" type="number" name="product-name"
                                   id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter old price" required="">
                        </div>
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">QTY</label>
                            <input v-model="entries.product.qty" type="number" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter QTY" required="">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="product-name"
                                   class="text-sm font-medium text-gray-900 block mb-2">Article</label>
                            <input v-model="entries.product.article" type="text" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter article" required="">
                        </div>


                        <div class="">
                            <label for="product_parent"
                                   class="text-sm font-medium text-gray-900 block mb-2">Category</label>

                            <select v-model="entries.product.category_id"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    id="service" name="service">
                                <option :value="null" selected disabled>Select Category</option>
                                <option v-for="category in categories" :value="category.id">{{
                                        category.title
                                    }}
                                </option>

                            </select>

                        </div>
                        <div class="">
                            <label for="product_parent"
                                   class="text-sm font-medium text-gray-900 block mb-2">Product Group</label>

                            <select v-model="entries.product.product_group_id"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    id="service" name="service">
                                <option :value="null" selected disabled>Select Product Parent</option>
                                <option v-for="productGroup in productGroups" :value="productGroup.id">{{
                                        productGroup.title
                                    }}
                                </option>

                            </select>

                        </div>
                    </div>
                    <!--Params-->
                    <!--                    <div class="col-span-6 sm:col-span-3 py-4">
                                            <label for="product_parent"
                                                   class="text-sm font-medium text-gray-900 block mb-2">Product Group</label>

                                            <select v-model="entries.params"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                                <option :value="null" selected disabled>Select Product Parent</option>
                                                <option v-for="productGroup in productGroups" :value="productGroup.id">{{ productGroup.title }}</option>
                                            </select>

                                        </div>-->


                    <div class="py-4">
                        <!--          File Upload              -->
                        <div class="rounded-md border border-indigo-500 bg-gray-50 p-4 shadow-md w-36">
                            <label for="upload" class="flex flex-col items-center gap-2 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 fill-white stroke-indigo-500"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-gray-600 font-medium">Upload file</span>
                            </label>
                            <input multiple id="upload" type="file" class="hidden" @change="addImages"/>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">

                        <button @click.prevent="storeProduct"
                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="submit">Create
                        </button>
                        <button @click.prevent="storeProductToIndex"
                                class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="submit">Create to Index
                        </button>
                    </div>
                </div>


            </div>
        </div>
        <div class="">
            <div v-for="image in imagesView" class="flex">
                <div class="py-4 px-2">

                    <img :src="image.url" alt="" class="">
                </div>

            </div>

        </div>

    </div>


</template>

<style scoped>

</style>
