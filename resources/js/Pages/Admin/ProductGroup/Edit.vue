<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import WindowSuccessMessage from "@/Components/Admin/General/WindowSuccessMessage.vue";


export default {
    name: "Edit",
    components: {
        WindowSuccessMessage,
        Link
    },
    layout: AdminLayout,
    props: {
        productGroup:{},
        categories:[],
    },
    data(){
        return{
            entries:{
                productGroup: this.productGroup,
            },
            success: false,
        }
    },

    methods: {
        updateProductGroup() {
            axios.patch(route('admin.product-groups.update', this.entries.productGroup.id), this.entries)
                .then(res => {
                    this.$nextTick(()=>{
                        this.success=true;
                    });
                });
        },
        updateProductGroupToIndex() {
            axios.patch(route('admin.product-groups.update', this.entries.productGroup.id), this.entries)
                .then(function () {
                        window.location.replace(route('admin.product-groups.index'));
                    }
                )
        },

    },
    watch:{
        productGroup:{
            handler(new_val, old_val){
                this.success = false;
            },
            deep:true
        }
    }


}
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Редактировать группу товаров
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Измените данные группы товаров
                    </p>
                </div>
                <Link :href="route('admin.product-groups.index')"
                      class="inline-flex items-center gap-2 px-5 py-2.5 font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-600 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Назад
                </Link>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Название группы
                        </label>
                        <input v-model="productGroup.title" type="text" id="title"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                               placeholder="Введите название" required>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Категория
                        </label>
                        <select v-model="entries.productGroup.category_id"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.title }}
                            </option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button @click.prevent="updateProductGroup"
                                class="inline-flex items-center gap-2 px-6 py-2.5 font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Сохранить
                        </button>
                        <button @click.prevent="updateProductGroupToIndex"
                                class="inline-flex items-center gap-2 px-6 py-2.5 font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Сохранить и перейти к списку
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <div v-if="success">
                <WindowSuccessMessage :message="'Группа товаров успешно обновлена'"/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
