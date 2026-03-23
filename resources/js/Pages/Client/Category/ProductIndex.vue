<script lang="ts">
import {defineComponent} from 'vue'
import ProductItem from "@/Components/Client/Product/ProductItem.vue";
import ClientLayout from "@/Layouts/ClientLayout.vue";
import {Link} from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Client/Category/Breadcrumb.vue";
import axios from 'axios';

export default defineComponent({
    name: "ProductIndex",
    layout: ClientLayout,
    components: {
        Breadcrumb,
        Link,
        ProductItem
    },
    props: {
        products: Array,
        bredCrumbs: Array,
        category: {},
        params: Array,
        categoryChildren: Array,
    },
    data() {
        return {
            filters: {
                integer: {
                    from: {},
                    to: {}
                },
                select: {},
                checkbox: {},

            },
            productsData: this.products,
            paramsData: this.params,
            isFilterOpen: false,
            searchQuery: '',
            selectedSort: 'popular'
        }
    },
    computed: {
        filteredProducts() {
            return this.productsData || [];
        }
    },
    methods: {
        setFilter(param, value) {
            if (this.filters.checkbox[param.id]) {
                this.toggleItem(this.filters.checkbox[param.id], value)
                return;
            }
            this.filters.checkbox[param.id] = [];
            this.filters.checkbox[param.id].push(value);
        },
        toggleItem(array, value) {
            let index = array.indexOf(value);
            index === -1 ? array.push(value) : array.splice(index, 1);
        },
        getPosts() {
            this.clear(this.filters.integer.from)
            this.clear(this.filters.integer.to)

            axios.get(route('client.categories.products.index', this.category.id), {
                params: this.filters
            })
                .then(res => {
                    this.productsData = res.data;
                })
        },
        clear(obj) {
            Object.keys(obj).forEach(key => {
                if (!obj[key]) {
                    delete obj[key];
                }
            })
        },
        getParamTitle(paramId) {
            const param = this.paramsData.find(p => p.id === paramId);
            return param ? param.title : '';
        }
    }

})
</script>

<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-teal-600 via-emerald-600 to-teal-700 overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            </div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <!-- Breadcrumb -->
                    <nav v-if="bredCrumbs && bredCrumbs.length > 0" class="flex items-center justify-center gap-2 text-sm text-teal-100 mb-4">
                        <Link :href="route('client.cards.index')" class="hover:text-white transition-colors">
                            Главная
                        </Link>
                        <span>/</span>
                        <template v-for="(breadcrumb, index) in bredCrumbs" :key="breadcrumb.id">
                            <Link
                                v-if="index < bredCrumbs.length - 1"
                                :href="route('client.categories.products.index', breadcrumb.id)"
                                class="hover:text-white transition-colors"
                            >
                                {{ breadcrumb.title }}
                            </Link>
                            <span v-else class="text-white font-medium">{{ breadcrumb.title }}</span>
                            <span v-if="index < bredCrumbs.length - 1">/</span>
                        </template>
                    </nav>

                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        {{ category.title }}
                    </h1>
                    <p v-if="category.description" class="text-teal-100 text-lg mb-8 max-w-2xl mx-auto">
                        {{ category.description }}
                    </p>
                    <p v-else class="text-teal-100 text-lg mb-8 max-w-2xl mx-auto">
                        Откройте для себя наши лучшие предложения по невероятным ценам
                    </p>

                    <!-- Search Bar -->
                    <div class="max-w-2xl mx-auto">
                        <div class="relative">
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Поиск товаров..."
                                class="w-full px-6 py-4 pl-14 rounded-2xl border-0 shadow-xl bg-white/95 backdrop-blur-sm text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-teal-300 focus:outline-none text-lg"
                            />
                            <svg
                                class="absolute left-5 top-1/2 -translate-y-1/2 h-6 w-6 text-gray-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Mobile Filter Toggle -->
                <button
                    @click="isFilterOpen = !isFilterOpen"
                    class="lg:hidden flex items-center justify-center gap-2 px-6 py-3 bg-white rounded-xl shadow-md border border-gray-200 text-gray-700 hover:bg-gray-50 transition-all"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Фильтры
                </button>

                <!-- Sidebar Filters -->
                <aside
                    :class="[
                        'lg:w-64 flex-shrink-0',
                        isFilterOpen ? 'block' : 'hidden lg:block'
                    ]"
                >
                    <div class="sticky top-24 space-y-6">
                        <!-- Subcategories -->
                        <div v-if="categoryChildren && categoryChildren.length > 0" class="bg-white rounded-2xl shadow-md border border-gray-100 p-5">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Подкатегории
                            </h3>
                            <div class="space-y-2">
                                <Link
                                    v-for="child in categoryChildren"
                                    :key="child.id"
                                    :href="route('client.categories.products.index', child.id)"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-teal-600 transition-all duration-200"
                                >
                                    <span class="text-lg">📁</span>
                                    {{ child.title }}
                                </Link>
                            </div>
                        </div>

                        <!-- Dynamic Filters from Params -->
                        <template v-for="param in paramsData" :key="param.id">
                            <!-- Checkbox Filter -->
                            <div v-if="param.filter_type === 3" class="bg-white rounded-2xl shadow-md border border-gray-100 p-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    {{ param.title }}
                                </h3>
                                <div class="space-y-2">
                                    <label
                                        v-for="value in param.param_values"
                                        :key="value"
                                        class="flex items-center gap-3 cursor-pointer group"
                                    >
                                        <input
                                            @change="setFilter(param, value)"
                                            type="checkbox"
                                            :value="value"
                                            class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500"
                                        />
                                        <span v-if="param.label !== 'color'" class="text-sm text-gray-600 group-hover:text-gray-900">
                                            {{ value }}
                                        </span>
                                        <span
                                            v-if="param.label === 'color'"
                                            class="w-6 h-6 rounded-full border-2 border-gray-200 shadow-sm"
                                            :style="`background: ${value};`"
                                        ></span>
                                    </label>
                                </div>
                            </div>

                            <!-- Integer Range Filter -->
                            <div v-if="param.filter_type === 1" class="bg-white rounded-2xl shadow-md border border-gray-100 p-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ param.title }}
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <input
                                            v-model="filters.integer.from[param.id]"
                                            placeholder="От"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                        />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input
                                            v-model="filters.integer.to[param.id]"
                                            placeholder="До"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                        />
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Apply Filter Button -->
                        <button
                            @click="getPosts()"
                            class="w-full px-4 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl font-medium hover:from-teal-600 hover:to-emerald-700 transition-all shadow-md"
                        >
                            Применить фильтры
                        </button>

                        <!-- Reset Button -->
                        <button
                            @click="filters = { integer: { from: {}, to: {} }, select: {}, checkbox: {} }"
                            class="w-full px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-all"
                        >
                            Сбросить
                        </button>
                    </div>
                </aside>

                <!-- Products Grid -->
                <article class="flex-1">
                    <!-- Results Info & Sort -->
                    <div class="flex items-center justify-between mb-6 bg-white rounded-xl shadow-md border border-gray-100 px-6 py-4">
                        <p class="text-gray-600">
                            <span class="font-bold text-gray-900">{{ filteredProducts.length }}</span> товаров найдено
                        </p>
                        <div class="flex items-center gap-3">
                            <label class="text-sm text-gray-600">Сортировать:</label>
                            <select
                                v-model="selectedSort"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white"
                            >
                                <option value="popular">По популярности</option>
                                <option value="cheap">Сначала дешёвые</option>
                                <option value="expensive">Сначала дорогие</option>
                                <option value="new">Новинки</option>
                            </select>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                        <ProductItem
                            v-for="product in filteredProducts"
                            :key="product.id"
                            :product="product"
                        />
                    </div>

                    <!-- Empty State -->
                    <div v-if="filteredProducts.length === 0" class="text-center py-16">
                        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Товары не найдены</h3>
                        <p class="mt-2 text-gray-500">Попробуйте изменить параметры поиска или фильтрации</p>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        <nav class="flex items-center gap-2">
                            <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 disabled:opacity-50">
                                ← Назад
                            </button>
                            <button class="px-4 py-2 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-medium shadow-md">
                                1
                            </button>
                            <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">
                                2
                            </button>
                            <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">
                                3
                            </button>
                            <span class="px-2 text-gray-400">...</span>
                            <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">
                                10
                            </button>
                            <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">
                                Вперёд →
                            </button>
                        </nav>
                    </div>
                </article>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
