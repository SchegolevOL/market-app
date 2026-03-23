<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import WindowSuccessMessage from "@/Components/Admin/General/WindowSuccessMessage.vue";


export default {
    name: "Replicate",
    components: {
        WindowSuccessMessage,
        Link
    },
    layout: AdminLayout,
    props: {
        categories: Array,
        productGroups: Array,
        params: Array,
        cloneProduct: Array,
    },

    data() {
        return {
            paramOption: {
                paramObject: {},
            },
            entries: {
                product: this.cloneProduct,
                images: [],
                params: this.cloneProduct.params,
                _method: 'patch',
            },
            imagesView: [],
            success: false,
        }
    },


    methods: {
        updateProduct() {
            axios.post(route('admin.products.update', this.entries.product.id), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }

            }).then(res => {
                this.entries.product = res.data;
                this.entries.images = [];
                this.imagesView = [];
                this.$refs.image_input.value = null;
                this.$nextTick(() => {
                    this.success = true;
                })
            })
        },
        updateProductToIndex() {
            axios.post(route('admin.products.update', this.entries.product.id), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }

            }).then(res => {
                window.location.replace(route('admin.products.index'));
            })
        },
        addImages(e) {
            var tmp = Array.from(e.target.files)
            this.entries.images = this.entries.images.concat(tmp)
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
                    this.entries.product.images = this.entries.product.images.filter(productImage => productImage.id !== image.id)
                    this.imagesView = [];
                }
            )
        },
        deleteImagePreview(image) {
            this.entries.images.splice(image.item, 1)
            this.imagesView.splice(image.item, 1)
        },
        setParam() {
            var param = {
                id: this.paramOption.paramObject.id,
                title: this.paramOption.paramObject.title,
                value: this.paramOption.value,
            }

            if (this.entries.params.every(enParam => enParam.id !== param.id || enParam.value !== param.value)) {
                this.entries.params.push(param)
                this.paramOption = {paramObject: {}}
            }
        },
        deleteParam(paramEntries) {
            this.entries.params = this.entries.params.filter(param => param.id !== paramEntries.id || param.value !== paramEntries.value)
        },

    },
    watch: {
        entries: {
            handler(new_val, old_val) {
                this.success = false
            },
            deep: true
        }
    }


}
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Клонировать товар
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Создайте копию товара с возможностью изменения
                    </p>
                </div>
                <Link :href="route('admin.products.index')"
                      class="inline-flex items-center gap-2 px-5 py-2.5 font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-600 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Назад
                </Link>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Main Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Основная информация</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Название</label>
                                <input v-model="entries.product.title" type="text" id="title"
                                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                       placeholder="Введите название" required>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</label>
                                <textarea v-model="entries.product.description" id="description" rows="3"
                                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                          placeholder="Введите описание"></textarea>
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Контент</label>
                                <textarea v-model="entries.product.content" id="content" rows="4"
                                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                          placeholder="Введите контент" required></textarea>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Цена</label>
                                    <input v-model="entries.product.price" type="number" id="price"
                                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="0" required>
                                </div>
                                <div>
                                    <label for="old_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Старая цена</label>
                                    <input v-model="entries.product.old_price" type="number" id="old_price"
                                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="0" required>
                                </div>
                                <div>
                                    <label for="qty" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кол-во</label>
                                    <input v-model="entries.product.qty" type="number" id="qty"
                                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="0" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="article" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Артикул</label>
                                    <input v-model="entries.product.article" type="number" id="article"
                                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="0" required>
                                </div>
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Категория</label>
                                    <select v-model="entries.product.category_id" id="category_id"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        <option :value="null" selected disabled>Выберите категорию</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="product_group_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Группа товаров</label>
                                    <select v-model="entries.product.product_group_id" id="product_group_id"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        <option :value="null" selected disabled>Выберите группу</option>
                                        <option v-for="productGroup in productGroups" :key="productGroup.id" :value="productGroup.id">{{ productGroup.title }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Params -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Параметры</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="paramObject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Выберите параметр</label>
                                <select v-model="paramOption.paramObject" id="paramObject"
                                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <option :value="{}" selected disabled>Выберите параметр</option>
                                    <option v-for="param in params" :key="param.id" :value="param">{{ param.title }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Значение</label>
                                <input v-model="paramOption.value" type="text"
                                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                       placeholder="Введите значение" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Действие</label>
                                <a href="#" @click.prevent="setParam"
                                   class="inline-flex items-center justify-center w-full h-[42px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-all duration-200">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Добавить
                                </a>
                            </div>
                        </div>

                        <!-- Selected Params -->
                        <div class="flex flex-wrap gap-2">
                            <div v-for="paramEntries in entries.params" :key="paramEntries.id + paramEntries.value">
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                    {{ paramEntries.title }} - {{ paramEntries.value }}
                                    <button @click.prevent="deleteParam(paramEntries)" type="button"
                                            class="inline-flex items-center p-0.5 text-indigo-600 hover:bg-indigo-200 dark:text-indigo-400 dark:hover:bg-indigo-800 rounded-full transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Загрузить изображения</h3>
                        <div class="rounded-lg border-2 border-dashed border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 p-6 text-center">
                            <label for="upload" class="cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-indigo-500"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="mt-2 block text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                    Нажмите для загрузки файлов
                                </span>
                            </label>
                            <input ref="image_input" multiple id="upload" type="file" class="hidden"
                                   @change="addImages" accept="image/*"/>
                        </div>

                        <!-- Existing Images -->
                        <div v-if="cloneProduct.images && cloneProduct.images.length > 0" class="mt-6">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Текущие изображения</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div v-for="image in entries.product.images" :key="image.id" class="relative group rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                    <img :src="image.url" alt="Image" class="w-full h-40 object-cover">
                                    <button @click.prevent="deleteImage(image)"
                                            class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 transition-all duration-200 shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Image Previews -->
                        <div v-if="imagesView.length > 0" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            <div v-for="image in imagesView" :key="image.item" class="relative group rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <img :src="image.url" alt="Preview" class="w-full h-40 object-cover">
                                <button @click.prevent="deleteImagePreview(image)"
                                        class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 transition-all duration-200 shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button @click.prevent="updateProduct"
                                class="inline-flex items-center gap-2 px-6 py-2.5 font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Сохранить
                        </button>
                        <button @click.prevent="updateProductToIndex"
                                class="inline-flex items-center gap-2 px-6 py-2.5 font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Сохранить и перейти к списку
                        </button>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Предпросмотр</h3>
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-2 text-sm">Изображения появятся здесь после загрузки</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <div v-if="success">
                <WindowSuccessMessage :message="'Товар успешно обновлен'"/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
