<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import WindowSuccessMessage from "@/Components/Admin/General/WindowSuccessMessage.vue";


export default {
    name: "Create",
    components: {
        WindowSuccessMessage,
        Link
    },
    layout: AdminLayout,
    props: {
        categories: Array,
    },
    data() {
        return {
            entries: {
                category: {
                    title: null,
                    parent_id: null,

                },
                images: [],

            },
            imagesView: [],
            success:false,
        }
    },


    methods: {
        storeCategory() {
            console.log(this.entries);

            axios.post(route('admin.categories.store'), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
                .then(res => {
                   this.entries.category = {
                        parent_id: null
                    };
                    this.imagesView=[];
                   this.$nextTick(()=>{
                       this.success = true;
                   })
                    this.categories.push(res.data)
                })

        },
        storeCategoryToIndex() {
            axios.post(route('admin.categories.store'), this.entries)
                .then(function () {
                        window.location.replace(route('admin.categories.index'));

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

        },

    },
    watch:{
        entries:{
            handler(new_val, old_val){
                this.success = false
            },
            deep: true
        }
    }

}
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Создать категорию
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Добавьте новую категорию в каталог
                    </p>
                </div>
                <Link :href="route('admin.categories.index')"
                      class="inline-flex items-center gap-2 px-5 py-2.5 font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-600 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Назад
                </Link>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Название категории
                                </label>
                                <input v-model="entries.category.title" type="text" id="title"
                                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                                       placeholder="Введите название" required>
                            </div>

                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Родительская категория
                                </label>
                                <select v-model="entries.category.parent_id"
                                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <option :value="null">Основная категория</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.title }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Изображения
                                </label>
                                <div class="rounded-lg border-2 border-dashed border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 p-6 text-center">
                                    <label for="upload" class="cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-12 w-12 mx-auto text-indigo-500"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="mt-2 block text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                            Нажмите для загрузки файлов
                                        </span>
                                    </label>
                                    <input id="upload" type="file" class="hidden" @change="addImages" multiple accept="image/*"/>
                                </div>
                            </div>

                            <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button @click.prevent="storeCategory"
                                        class="inline-flex items-center gap-2 px-6 py-2.5 font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-600 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Создать
                                </button>
                                <button @click.prevent="storeCategoryToIndex"
                                        class="inline-flex items-center gap-2 px-6 py-2.5 font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-600 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Создать и перейти к списку
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Preview -->
                <div v-if="imagesView.length !== 0" class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Предпросмотр изображений
                        </h3>
                        <div class="space-y-3">
                            <div v-for="image in imagesView" :key="image.item" class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <img :src="image.url" alt="Preview" class="w-full h-40 object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <div v-if="success">
                <WindowSuccessMessage :message="'Категория успешно создана'"/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
