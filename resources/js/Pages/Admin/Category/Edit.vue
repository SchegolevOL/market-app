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
        category: {},
    },
    data() {
        return {
            entries: {
                category: {},
                images: [],
            },
            imagesView: [],
        }
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

        addImages(e) {

            this.entries.images = e.target.files

            for (let i = 0; i < this.entries.images.length; i++) {
                this.imagesView[i] = URL.createObjectURL(this.entries.images[i]);

            }

        },
    }


}
</script>

<template>

    <div class="grid grid-cols-3 gap-4">
        <div class="">
            <!--      Page name      -->
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Edit Category</h1>
            </div>

        </div>
        <div class="">

        </div>
        <div class="">
            <!--       Navigation buttons       -->
            <Link :href="route('admin.categories.index')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Back Index
            </Link>
        </div>
        <div class="col-span-2">
            <!--        Form fields     -->


            <div class="">
                <div>
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                    <input v-model="category.title" type="text" name="product-name" id="product-name"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                           placeholder="Enter Title”" required="">
                </div>
                <div class="">
                    <label for="category" class="text-sm font-medium text-gray-900 block mb-2">Parent Category</label>

                    <select v-model="category.parent_id"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                            id="service" name="service">
                        <option selected :value=null>Main Category</option>
                        <option v-for="category in categories" :value="category.id">{{ category.title }}</option>

                    </select>


                </div>
                <div class="py-4">
                    <!--          File Upload              -->
                    <div class="rounded-md border border-indigo-500 bg-gray-50 p-4 shadow-md w-36">
                        <label for="upload" class="flex flex-col items-center gap-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-10 w-10 fill-white stroke-indigo-500"
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

        <div class="">
            <!--        Image output        -->
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Images</h1>
            </div>
            <div v-for="image in category.images" class="">

                <img :src="image.url" alt="" class="">
            </div>

        </div>
        <div class="grid grid-cols-2">
        <div v-if="imagesView.length !==0" >
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Preload new Images</h1>
            </div>
            <div class="py-4">


                <div v-for="image in imagesView" class="">
                    <button @click.prevent="deleteImage(image)" class="flex border bg-red-600 text-white right-0">
                        Delete
                    </button>

                    <div class="py-4">
                        <img :src="image" alt="" class="">
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>


</template>

<style scoped>

</style>
