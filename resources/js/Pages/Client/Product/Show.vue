<script>
import ClientLayout from "@/Layouts/ClientLayout.vue";
import ProductItem from "@/Components/Client/Product/ProductItem.vue";
import ImagesPreview from "@/Components/Client/Product/ImagesPreview.vue";
import {Link} from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Client/Category/Breadcrumb.vue";
import AddQuantity from "@/Components/Client/Product/AddQuantity.vue";
import {ref} from 'vue';

export default {
    name: "Show",
    layout: ClientLayout,
    components: {
        AddQuantity,
        Breadcrumb,
        Link,
        ImagesPreview,
        ProductItem
    },
    props: {
        product: {},
        bredCrumbs: {},
        paramProducts: Array,
    },
    setup() {
        const quantity = ref(1);
        const isFavorite = ref(false);
        const activeTab = ref('description');

        const toggleFavorite = () => {
            isFavorite.value = !isFavorite.value;
        };

        return {
            quantity,
            isFavorite,
            activeTab,
            toggleFavorite
        };
    },
    data() {
        return {
            selectedColor: null,
            selectedSize: null,
            card: {
                qty: 1,
                product_id: this.product.id,

            },
        }
    },
    computed: {
        discount() {
            if (!this.product.old_price || !this.product.price) return 0;
            return Math.round(((this.product.old_price - this.product.price) / this.product.price) * 100);
        },
        hasDiscount() {
            return this.discount > 0 && this.discount < 100;
        }
    },
    methods: {
        changeQty(quantityData) {
            this.quantity = quantityData
        },
        incrementQty() {
            this.quantity++;
        },
        decrementQty() {
            if (this.quantity > 1) this.quantity--;
        },
        storeCard() {
            axios.post(route('client.cards.store'), this.card)
                .then(res => {
                    console.log(res.data)
                })
        }
    }
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-teal-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav v-if="bredCrumbs && bredCrumbs.length > 0" class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <Link :href="route('client.cards.index')" class="hover:text-teal-600 transition-colors">
                    Главная
                </Link>
                <span class="text-gray-300">/</span>
                <template v-for="(breadcrumb, index) in bredCrumbs" :key="breadcrumb.id">
                    <Link
                        v-if="index < bredCrumbs.length - 1"
                        :href="route('client.categories.products.index', breadcrumb.id)"
                        class="hover:text-teal-600 transition-colors"
                    >
                        {{ breadcrumb.title }}
                    </Link>
                    <span v-else class="text-gray-900 font-medium">{{ breadcrumb.title }}</span>
                    <span v-if="index < bredCrumbs.length - 1" class="text-gray-300">/</span>
                </template>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- LEFT: Images -->
                <div class="space-y-4">
                    <!-- Main Image Container -->
                    <div class="relative bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                        <ImagesPreview
                            :images="product.images"
                            :discount="discount"
                            :is-hit="product.is_bestseller"
                        />
                    </div>

                    <!-- Tabs for Description -->
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="flex border-b border-gray-100">
                            <button
                                @click="activeTab = 'description'"
                                :class="[
                                    'flex-1 px-6 py-4 text-sm font-medium transition-all duration-200',
                                    activeTab === 'description'
                                        ? 'text-teal-600 border-b-2 border-teal-600 bg-teal-50'
                                        : 'text-gray-500 hover:text-gray-700'
                                ]"
                            >
                                Описание
                            </button>
                            <button
                                @click="activeTab = 'specs'"
                                :class="[
                                    'flex-1 px-6 py-4 text-sm font-medium transition-all duration-200',
                                    activeTab === 'specs'
                                        ? 'text-teal-600 border-b-2 border-teal-600 bg-teal-50'
                                        : 'text-gray-500 hover:text-gray-700'
                                ]"
                            >
                                Характеристики
                            </button>
                            <button
                                @click="activeTab = 'reviews'"
                                :class="[
                                    'flex-1 px-6 py-4 text-sm font-medium transition-all duration-200',
                                    activeTab === 'reviews'
                                        ? 'text-teal-600 border-b-2 border-teal-600 bg-teal-50'
                                        : 'text-gray-500 hover:text-gray-700'
                                ]"
                            >
                                Отзывы
                            </button>
                        </div>
                        <div class="p-6">
                            <div v-if="activeTab === 'description'" class="space-y-4">
                                <h3 class="text-lg font-bold text-gray-900">Описание товара</h3>
                                <p class="text-gray-600 leading-relaxed">{{ product.description || 'Описание отсутствует' }}</p>
                                <p v-if="product.content" class="text-gray-600 leading-relaxed">{{ product.content }}</p>
                            </div>
                            <div v-if="activeTab === 'specs'" class="space-y-3">
                                <h3 class="text-lg font-bold text-gray-900">Характеристики</h3>
                                <dl class="space-y-2">
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <dt class="text-sm text-gray-500">Категория</dt>
                                        <dd class="text-sm font-medium text-gray-900">{{ product.category?.title }}</dd>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <dt class="text-sm text-gray-500">Группа товаров</dt>
                                        <dd class="text-sm font-medium text-gray-900">{{ product.product_group?.title }}</dd>
                                    </div>
                                    <div v-if="product.params && product.params.length > 0">
                                        <div v-for="param in product.params" :key="param.id" class="flex justify-between py-2 border-b border-gray-100">
                                            <dt class="text-sm text-gray-500">{{ param.title }}</dt>
                                            <dd class="text-sm font-medium text-gray-900">{{ param.value }}</dd>
                                        </div>
                                    </div>
                                </dl>
                            </div>
                            <div v-if="activeTab === 'reviews'" class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="mt-4 text-gray-500">Отзывы пока отсутствуют</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Product Info -->
                <div class="lg:sticky lg:top-24 lg:self-start space-y-6">
                    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 lg:p-8">
                        <!-- Title -->
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">
                            {{ product.title }}
                        </h1>

                        <!-- Rating -->
                        <div class="flex items-center gap-3 mt-4">
                            <div class="flex items-center">
                                <span v-for="i in 5" :key="i" :class="[
                                    'text-lg',
                                    i <= (product.rating || 4) ? 'text-yellow-400' : 'text-gray-200'
                                ]">★</span>
                            </div>
                            <span class="text-sm text-gray-500">({{ product.review_count || 0 }} отзывов)</span>
                            <span v-if="product.sold_count" class="text-sm text-gray-400">• {{ product.sold_count }} продано</span>
                        </div>

                        <!-- Price Section -->
                        <div class="mt-6 flex items-end gap-4 flex-wrap">
                            <div>
                                <span class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-teal-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    {{ Number(product.price).toLocaleString() }} ₽
                                </span>
                                <div v-if="hasDiscount && product.old_price" class="text-lg text-gray-400 line-through">
                                    {{ Number(product.old_price).toLocaleString() }} ₽
                                </div>
                                <div v-if="hasDiscount" class="inline-flex items-center gap-1 mt-2 px-3 py-1 bg-gradient-to-r from-red-500 to-rose-600 text-white text-sm font-bold rounded-lg">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                    </svg>
                                    -{{ discount }}%
                                </div>
                            </div>
                            <button
                                @click="toggleFavorite"
                                class="ml-auto p-3 rounded-xl border-2 transition-all duration-200 transform hover:scale-110"
                                :class="isFavorite ? 'border-red-200 bg-red-50 text-red-500' : 'border-gray-200 text-gray-400 hover:border-red-300 hover:text-red-400'"
                            >
                                <svg class="h-7 w-7" fill="none" :class="isFavorite ? '' : 'stroke-current'" viewBox="0 0 24 24" :stroke="isFavorite ? 'currentColor' : 'currentColor'" stroke-width="2">
                                    <path v-if="!isFavorite" stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    <path v-else fill="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Stock Status -->
                        <div class="mt-6 flex items-center gap-3 p-4 rounded-xl" :class="product.in_stock ? 'bg-green-50' : 'bg-red-50'">
                            <span
                                class="w-3 h-3 rounded-full"
                                :class="product.in_stock ? 'bg-green-500 animate-pulse' : 'bg-red-500'"
                            ></span>
                            <span
                                class="text-sm font-medium"
                                :class="product.in_stock ? 'text-green-700' : 'text-red-700'"
                            >
                                {{ product.in_stock ? 'В наличии' : 'Нет в наличии' }}
                            </span>
                            <span v-if="product.stock_quantity && product.in_stock" class="text-sm text-gray-500">
                                ({{ product.stock_quantity }} шт.)
                            </span>
                        </div>

                        <!-- Variant Selectors -->
                        <div v-if="paramProducts && paramProducts.length > 0" class="mt-6 space-y-4">
                            <div v-for="paramProduct in paramProducts" :key="paramProduct.id">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ paramProduct.title }}</label>
                                <div class="flex flex-wrap gap-2">
                                    <Link
                                        v-for="paramProductData in paramProduct.data"
                                        :key="paramProductData.id"
                                        :href="route('client.products.show', paramProductData.product_id)"
                                        :class="[
                                            'transition-all duration-200 transform hover:scale-105',
                                            paramProductData.product_id === product.id
                                                ? 'ring-2 ring-teal-500 ring-offset-2'
                                                : ''
                                        ]"
                                    >
                                        <span
                                            v-if="paramProductData.param?.label === 'color'"
                                            class="inline-block w-10 h-10 rounded-xl border-2 shadow-sm cursor-pointer"
                                            :style="`background: ${paramProductData.value};`"
                                            :class="paramProductData.product_id === product.id ? 'border-teal-500' : 'border-gray-200'"
                                        ></span>
                                        <span
                                            v-else
                                            class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-medium cursor-pointer border-2 transition-all"
                                            :class="paramProductData.product_id === product.id
                                                ? 'bg-teal-50 border-teal-500 text-teal-700'
                                                : 'bg-white border-gray-200 text-gray-700 hover:border-teal-300'"
                                        >
                                            {{ paramProductData.value }}
                                        </span>
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity & Add to Cart -->
                        <div class="mt-8 space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Количество</label>
                                <span class="text-xs text-gray-400">Максимум 10 шт. в одни руки</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                    <button
                                        @click="decrementQty"
                                        class="px-4 py-3.5 bg-gray-50 hover:bg-teal-50 text-gray-600 hover:text-teal-600 transition-all"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <span class="w-16 text-center text-lg font-bold text-gray-700">{{ quantity }}</span>
                                    <button
                                        @click="incrementQty"
                                        class="px-4 py-3.5 bg-gray-50 hover:bg-teal-50 text-gray-600 hover:text-teal-600 transition-all"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                <button @click="storeCard"
                                    class="flex-1 flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-teal-500 via-emerald-500 to-teal-600 hover:from-teal-600 hover:via-emerald-600 hover:to-teal-700 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300"
                                >
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Добавить в корзину
                                </button>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-8 pt-6 border-t border-gray-100 space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                <span>Бесплатная доставка от 5000 ₽</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>Гарантия качества</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Возврат в течение 30 дней</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div v-if="product.group_products && product.group_products.length > 0" class="mt-16">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-8 text-center">
                    Похожие товары
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                    <ProductItem
                        v-for="relatedProduct in product.group_products"
                        :key="relatedProduct.id"
                        :product="relatedProduct"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
