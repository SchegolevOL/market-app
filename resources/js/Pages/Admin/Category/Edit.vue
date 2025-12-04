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
                category: this.category,
                images: [],
                _method:'patch',
            },
            imagesView: [],

        }
    },


    methods: {
        updateCategory() {


            axios.post(route('admin.categories.update', this.entries.category.id), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }

            }).then(res => {


                this.entries.category = res.data;
                this.entries.images = [];


                this.imagesView = [];
                this.$refs.image_input.value = null;



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
        deleteImage(image) {
            axios.delete(route('admin.images.destroy', image.id)).then(
                res => {
                    console.log(this.entries.category.images);
                    console.log(image);

                    this.entries.category.images = this.entries.category.images.filter(categoryImage => categoryImage.id !== image.id)
                    console.log(this.entries.category.images);
                    this.imagesView = [];

                }
            )
        },
        deleteImagePreview(image) {
            this.entries.images.splice(image.item, 1)
            this.imagesView.splice(image.item, 1)
            console.log(this.entries.images);
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
                    <label for="category-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                    <input v-model="category.title" type="text" name="category-name" id="category-name"
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
                        <input ref="image_input" multiple id="upload" type="file" class="hidden" @change="addImages"/>
                    </div>
                </div>
                <div class="p-6 border-t border-gray-200 rounded-b">

                    <button @click.prevent="updateCategory"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            type="submit">Update
                    </button>
                    <button @click.prevent="updateCategoryToIndex"
                            class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            type="submit">Update to Index
                    </button>
                </div>
            </div>


        </div>

        <div class="">
            <!--        Images   -->
            <div class="px-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Images</h1>
            </div>
            <div v-for="image in entries.category.images" class="relative">
                <div class="py-4 px-2 w-52">
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

            <div v-if="imagesView.length!==0">
                <div class="px-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <h1>Images Preview</h1>
                </div>
                <!--        Images View  Preview   -->
                <div v-for="image in imagesView" class="relative">
                    <div class="py-4 px-2 w-52">
                        <div class="">
                            <img :src="image.url" alt="" class="">
                            <div class="absolute top-3 right-2 left-2 mx-2 mt-2 flex justify-between items-center">
                                <button @click.prevent="deleteImagePreview(image)"
                                        class="rounded-md  text-xs bg-red-600 text-white px-2 py-2 uppercase hover:bg-red-100 hover:text-red-600 transition ease-in-out duration-500 w-8">
                                    X
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


</template>

<style scoped>

</style>
