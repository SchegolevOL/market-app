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
            selectType: String,
            categoryParams: [],
        }
    },


    methods: {
        loadCategoryParams() {
            if (this.entries.product.category_id) {
                axios.get(route('admin.categories.params', this.entries.product.category_id))
                    .then(res => {
                        this.categoryParams = res.data;
                        this.paramOption.paramObject = {};
                    })
                    .catch(err => {
                        console.error(err);
                        this.categoryParams = [];
                    });
            } else {
                this.categoryParams = [];
                this.paramOption.paramObject = {};
            }
        },
        storeProduct() {
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
            var tmp = Array.from(e.target.files)
            this.entries.images = this.entries.images.concat(tmp)
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
                label: this.paramOption.paramObject.label,
                value: this.paramOption.value,

            }
            if (this.entries.params.every(enParam => enParam.id !== param.id || enParam.value !== param.value)) {
                this.entries.params.push(param)
                this.paramOption = {paramObject: {}}
            }


        },
        deleteImage(image) {
            this.entries.images.splice(image.item, 1)
            this.imagesView.splice(image.item, 1)
        },
        deleteParam(paramEntries) {
            this.entries.params = this.entries.params.filter(param => param.id !== paramEntries.id || param.value !== paramEntries.value)
        },

    },
    watch: {
        'entries.product.category_id': {
            handler() {
                this.loadCategoryParams();
            },
        },
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
                        Создать товар
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Добавьте новый товар в каталог
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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Категория</label>
                                    <select v-model="entries.product.category_id"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        <option :value="null" selected disabled>Выберите категорию</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                                    </select>
                                    <div v-if="errors['product.category_id']" v-for="error in errors['product.category_id']">
                                        <InputErrorValidate :error="error"/>
                                    </div>
                                </div>
                                <div v-if="entries.product.category_id !== null">
                                    <label for="product_group_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Группа товаров</label>
                                    <select v-model="entries.product.product_group_id"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        <option :value="null" selected disabled>Выберите группу</option>
                                        <option v-for="productGroup in productGroups" :key="productGroup.id" :value="productGroup.id">{{ productGroup.title }}</option>
                                    </select>
                                    <div v-if="errors['product.product_group_id']" v-for="error in errors['product.product_group_id']">
                                        <InputErrorValidate :error="error"/>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Название</label>
                                <input v-model="entries.product.title" type="text" id="title"
                                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                                       placeholder="Введите название" required>
                                <div v-if="errors['product.title']" v-for="error in errors['product.title']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</label>
                                <textarea v-model="entries.product.description" id="description" rows="3"
                                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                                          placeholder="Введите описание"></textarea>
                                <div v-if="errors['product.description']" v-for="error in errors['product.description']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Контент</label>
                                <textarea v-model="entries.product.content" id="content" rows="4"
                                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 placeholder-gray-400"
                                          placeholder="Введите контент" required></textarea>
                                <div v-if="errors['product.content']" v-for="error in errors['product.content']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Stock -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Цена и наличие</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Цена</label>
                                <input v-model="entries.product.price" type="number" id="price"
                                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                       placeholder="0" required>
                                <div v-if="errors['product.price']" v-for="error in errors['product.price']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>
                            <div>
                                <label for="old_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Старая цена</label>
                                <input v-model="entries.product.old_price" type="number" id="old_price"
                                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                       placeholder="0" required>
                                <div v-if="errors['product.old_price']" v-for="error in errors['product.old_price']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>
                            <div>
                                <label for="qty" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кол-во</label>
                                <input v-model="entries.product.qty" type="number" id="qty"
                                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                       placeholder="0" required>
                                <div v-if="errors['product.qty']" v-for="error in errors['product.qty']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>
                            <div>
                                <label for="article" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Артикул</label>
                                <input v-model="entries.product.article" type="number" id="article"
                                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                       placeholder="0" required>
                                <div v-if="errors['product.article']" v-for="error in errors['product.article']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Params -->
                    <div v-if="entries.product.category_id !== null" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Параметры</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="paramObject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Выберите параметр</label>
                                <select v-model="paramOption.paramObject" id="paramObject"
                                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <option :value="{}" selected disabled>Выберите параметр</option>
                                    <option v-for="param in categoryParams" :key="param.id" :value="param">{{ param.title }}</option>
                                </select>
                                <div v-if="errors['product.param']" v-for="error in errors['product.param']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Значение</label>
                                <div v-if="paramOption.paramObject.filter_type_title === 'integer' || paramOption.paramObject.filter_type_title === 'checkbox' && paramOption.paramObject.label !== 'color'">
                                    <input v-model="paramOption.value" type="number"
                                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="Введите значение" required>
                                </div>
                                <div v-if="paramOption.paramObject.filter_type_title === 'select'">
                                    <input v-model="paramOption.value" type="text"
                                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                           placeholder="Введите значение" required>
                                </div>
                                <div v-if="paramOption.paramObject.label === 'color'">
                                    <input v-model="paramOption.value" type="color" list="colors"
                                           class="h-10 w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <datalist id="colors">
                                        <option value="#ff0000" label="Red"/>
                                        <option value="#008000" label="Green"/>
                                        <option value="#0000ff" label="Blue"/>
                                        <option value="#000001" label="Black"/>
                                        <option value="#ffffff" label="White"/>
                                        <option value="#454545" label="Grey"/>
                                        <option value="#ffea00" label="Yellow"/>
                                        <option value="#ff7b00" label="Orange"/>
                                        <option value="#8000ff" label="Purple"/>
                                        <option value="#b93c3c" label="Pink"/>
                                    </datalist>
                                </div>
                                <div v-if="errors['product.params']" v-for="error in errors['product.params']">
                                    <InputErrorValidate :error="error"/>
                                </div>
                            </div>
                            <div v-if="Object.keys(paramOption.paramObject).length !== 0">
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
                            <div v-for="params in entries.params" :key="params.id + params.value">
                                <span v-if="params.label !== 'color'"
                                      class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                    {{ params.title }} - {{ params.value }}
                                    <button @click.prevent="deleteParam(params)" type="button"
                                            class="inline-flex items-center p-0.5 text-indigo-600 hover:bg-indigo-200 dark:text-indigo-400 dark:hover:bg-indigo-800 rounded-full transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </span>
                                <span v-if="params.label === 'color'"
                                      class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                    {{ params.title }} -
                                    <span :style="`background: ${params.value};`"
                                          class="inline-block w-4 h-4 rounded-full border border-gray-300"></span>
                                    <button @click.prevent="deleteParam(params)" type="button"
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
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Изображения</h3>
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
                            <div v-if="errors['product.images']" v-for="error in errors['product.images']">
                                <InputErrorValidate :error="error"/>
                            </div>
                        </div>

                        <!-- Image Previews -->
                        <div v-if="imagesView.length > 0" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            <div v-for="image in imagesView" :key="image.item" class="relative group rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <img :src="image.url" alt="Preview" class="w-full h-40 object-cover">
                                <button @click.prevent="deleteImage(image)"
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
                        <button @click.prevent="storeProduct"
                                class="inline-flex items-center gap-2 px-6 py-2.5 font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Создать
                        </button>
                        <button @click.prevent="storeProductToIndex"
                                class="inline-flex items-center gap-2 px-6 py-2.5 font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Создать и перейти к списку
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
        </div>
    </div>
</template>

<style scoped>

</style>
