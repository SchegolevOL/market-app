<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import InputErrorValidate from "@/Components/Admin/General/InputErrorValidate.vue";


export default {
    name: "Create",
    components: {
        InputErrorValidate,
        Link
    },
    layout: AdminLayout,
    props: {
        categories: Array,
        productGroups: Array,
        params: Array,
    },
    data() {
        return {
            paramOption: {
                paramObject: {},
            },
            entries: {
                product: {
                    category_id: null,
                    product_group_id: null,
                    param: null,

                },
                images: [],
                params: [],
            },
            imagesView: [],
            errors: [],

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


                    this.entries = {
                        product: {
                            category_id: null,
                            product_group_id: null,
                            param: null,

                        },
                        images: [],
                        params: [],
                    };
                    this.imagesView = [];
                    this.$refs.image_input.value = null;

                })
                .catch(e => {
                    this.errors = e.response.data.errors;
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
            console.log(e.target.files);
            var tmp = Array.from(e.target.files)
            this.entries.images = this.entries.images.concat(tmp)
            console.log(this.entries.images)
            for (let i = 0; i < this.entries.images.length; i++) {
                this.imagesView[i] = {
                    'item': i,
                    'url': URL.createObjectURL(this.entries.images[i]),
                };
            }


        },
        setParam() {
            var param = {
                id: this.paramOption.paramObject.id,
                title: this.paramOption.paramObject.title,
                value: this.paramOption.value,

            }
            console.log(!this.entries.params.includes(param))
            if (this.entries.params.every(enParam => enParam.id !== param.id || enParam.value !== param.value)) {
                this.entries.params.push(param)
                this.paramOption = {paramObject: {}}
            }


        },
        deleteImage(image) {
            this.entries.images.splice(image.item, 1)
            this.imagesView.splice(image.item, 1)
            console.log(this.entries.images);
        },
        deleteParam(paramEntries) {
            console.log(paramEntries);
            this.entries.params = this.entries.params.filter(param => param.id !== paramEntries.id || param.value !== paramEntries.value)
            console.log(this.entries.params);

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
                        <div v-if="errors['product.title']" v-for="error in errors['product.title']">
                            <InputErrorValidate :error="error"/>
                        </div>

                    </div>
                    <div>
                        <label for="product-name"
                               class="text-sm font-medium text-gray-900 block mb-2">Description</label>
                        <textarea v-model="entries.product.description" type="text" name="" id=""
                                  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                  placeholder="Enter description”"></textarea>
                        <div v-if="errors['product.description']" v-for="error in errors['product.description']">
                            <InputErrorValidate :error="error"/>
                        </div>
                    </div>
                    <div>
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Content</label>
                        <textarea v-model="entries.product.content" type="text"
                                  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                  placeholder="Enter content" required=""></textarea>
                        <div v-if="errors['product.content']" v-for="error in errors['product.content']">
                            <InputErrorValidate :error="error"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Price</label>
                            <input v-model="entries.product.price" type="number" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter price" required="">
                            <div v-if="errors['product.price']" v-for="error in errors['product.price']">
                                <InputErrorValidate :error="error"/>
                            </div>
                        </div>
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Old
                                Price</label>
                            <input v-model="entries.product.old_price" type="number" name="product-name"
                                   id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter old price" required="">
                            <div v-if="errors['product.old_price']" v-for="error in errors['product.old_price']">
                                <InputErrorValidate :error="error"/>
                            </div>
                        </div>
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">QTY</label>
                            <input v-model="entries.product.qty" type="number" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter QTY" required="">
                            <div v-if="errors['product.qty']" v-for="error in errors['product.qty']">
                                <InputErrorValidate :error="error"/>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="product-name"
                                   class="text-sm font-medium text-gray-900 block mb-2">Article</label>
                            <input v-model="entries.product.article" type="number" name="product-name" id="product-name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter article" required="">
                            <div v-if="errors['product.article']" v-for="error in errors['product.article']">
                                <InputErrorValidate :error="error"/>
                            </div>
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
                            <div v-if="errors['product.category_id']" v-for="error in errors['product.category_id']">
                                <InputErrorValidate :error="error"/>
                            </div>
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
                            <div v-if="errors['product.product_group_id']" v-for="error in errors['product.product_group_id']">
                                <InputErrorValidate :error="error"/>
                            </div>
                        </div>
                    </div>
                    <!--Params-->
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="product_parent"
                                   class="text-sm font-medium text-gray-900 block mb-2">Select Param</label>

                            <select v-model="paramOption.paramObject"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option :value="{}" selected disabled>Select Product Parent</option>
                                <option v-for="param in params" :value="param">{{
                                        param.title
                                    }}
                                </option>
                            </select>
                            <div v-if="errors['product.param']" v-for="error in errors['product.param']">
                                <InputErrorValidate :error="error"/>
                            </div>
                        </div>
                        <div>
                            <label for="product_parent"
                                   class="text-sm font-medium text-gray-900 block mb-2">Value</label>
                            <input v-model="paramOption.value"
                                   type="text"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="Enter Value" required="">
                            <div v-if="errors['product.params']" v-for="error in errors['product.params']">
                                <InputErrorValidate :error="error"/>
                            </div>
                        </div>
                        <div>
                            <label for="product_parent"
                                   class="text-sm font-medium text-gray-900 block mb-2">Value</label>
                            <a href="#"
                               @click.prevent="setParam"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block p-2 w-10">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="size-6">
                                    <path fill-rule="evenodd"
                                          d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                                          clip-rule="evenodd"/>
                                </svg>


                            </a>


                        </div>

                    </div>
                    <div>
                        <div class="container mx-auto p-6">
                            <div class="flex flex-wrap gap-2">
                                <div v-for="paramEntries in entries.params">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ paramEntries.title }} - {{ paramEntries.value }}
                                    <button @click.prevent="deleteParam(paramEntries)" type="button"
                                            class="ml-2 inline-flex items-center p-0.5 text-sm bg-transparent rounded-sm hover:bg-blue-200 dark:hover:bg-blue-800">
                                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </span>
                                </div>
                            </div>
                        </div>
                    </div>

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
                            <input ref="image_input" multiple id="upload" type="file" class="hidden"
                                   @change="addImages"/>
                            <div v-if="errors['product.images']" v-for="error in errors['product.images']">
                                <InputErrorValidate :error="error"/>
                            </div>
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
            <div class="px-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Images</h1>
            </div>
            <!--        Images View     -->
            <div v-for="image in imagesView" class="relative">
                <div class="py-4 px-2 w-80">
                    <div class="">
                        <img :src="image.url" alt="" class="">
                        <div class="absolute top-3 right-2 left-2 mx-2 mt-2 flex justify-between items-center">
                            <button @click.prevent="deleteImage(image)"
                                    class="rounded-md  text-xs bg-red-600 text-white px-2 py-2 uppercase hover:bg-red-100 hover:text-red-600 transition ease-in-out duration-500 w-8">
                                X
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</template>

<style scoped>

</style>
