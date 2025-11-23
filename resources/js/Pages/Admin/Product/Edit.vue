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
        product: {},
        categories: Array,
        productGroups: Array,
    },
    data() {
        return {
            entries: {
                product: this.product,

                images: null,
                _method: 'patch',
            },

            //
            //params:[],
        }


    },


    methods: {
        updateProduct() {
            console.log(this.entries);

            axios.post(route('admin.products.update', this.entries.product.id), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }

            }).then(res => {

                console.log(res);
                this.entries.product.images = res.data.images

            })

        },
        updateProductToIndex() {
            axios.patch(route('admin.products.update', this.entries.product), this.entries)
                .then(function () {
                        window.location.replace(route('admin.products.index'));

                    }
                )
        },
        addImages(e) {

            this.entries.images = e.target.files

        },
        deleteImage(image) {
            axios.delete(route('admin.images.destroy', image.id)).then(
                res => {
                    this.product.images = this.product.images.filter(productImage => productImage.id !== image.id)
                }
            )
        }

    }


}
</script>

<template>

    <div class="grid grid-cols-3 gap-4">
        <div class="">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Update Product</h1>
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
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Price</label>
                        <input v-model="entries.product.price" type="number" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter price" required="">
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Old Price</label>
                        <input v-model="entries.product.old_price" type="number" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter old price" required="">
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">QTY</label>
                        <input v-model="entries.product.qty" type="number" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter QTY" required="">
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">QTY</label>
                        <input v-model="entries.product.article" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter article" required="">
                    </div>


                    <div class="col-span-6 sm:col-span-3 py-4">
                        <label for="product_parent"
                               class="text-sm font-medium text-gray-900 block mb-2">Category</label>

                        <select v-model="entries.product.category_id"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                id="service" name="service">

                            <option v-for="category in categories" :value="category.id">{{ category.title }}</option>

                        </select>

                    </div>
                    <div class="col-span-6 sm:col-span-3 py-4">
                        <label for="product_parent"
                               class="text-sm font-medium text-gray-900 block mb-2">Product Group</label>

                        <select v-model="entries.product.product_group_id"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                id="service" name="service">

                            <option v-for="productGroup in productGroups" :value="productGroup.id">{{
                                    productGroup.title
                                }}
                            </option>

                        </select>

                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Select
                            Images</label>
                        <input type="file"
                               multiple
                               @change="addImages"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
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


                    <!--                    <div>
                                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Select Images</label>
                                            <input type="file"
                                                   @change="addImages"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                        </div>-->
                    <div class="p-6 border-t border-gray-200 rounded-b">

                        <button @click.prevent="updateProduct"
                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="submit">Update
                        </button>
                        <button @click.prevent="updateProductToIndex"
                                class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="submit">Update to Index
                        </button>
                    </div>
                </div>


            </div>
        </div>
        <div class="">
            <div v-for="image in product.images" class="">
                <div class="py-4">
                    <button @click.prevent="deleteImage(image)" class="flex border bg-red-600 text-white right-0">
                        Delete
                    </button>
                    <img :src="image.url" alt="" class="">
                </div>

            </div>

        </div>

    </div>


    <div class="container mx-auto px-4 py-4">

    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 ">
        <div class="grid md:grid-cols-2 gap-8">


            <!-- Product Info -->

        </div>


    </main>
</template>

<style scoped>

</style>
