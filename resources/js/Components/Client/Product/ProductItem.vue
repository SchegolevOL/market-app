<script lang="ts">
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    name: "ProductCard",
    components: {Link},
    props: {
        product: {}
    },
    data() {
        return {
            discount: (((this.product.old_price-this.product.price)/this.product.price)*100).toFixed(2),
            isFavorite: false,
            quantity: 1,
            currentImageIndex: 0,
            isAddingToCart: false,
            showQuickAdd: false
        }
    },
    computed: {
        hasDiscount() {
            return this.discount > 0 && this.discount < 100;
        },
        discountPercent() {
            return Math.abs(Math.round(this.discount));
        },
        images() {
            return this.product.images && this.product.images.length > 0 
                ? this.product.images 
                : [{url: '/storage/Client/ImagesDefault/defaultImagesProduct.png'}];
        }
    },
    methods: {
        increment() {
            this.quantity++
        },
        decrement() {
            if (this.quantity > 1) this.quantity--
        },
        toggleFavorite() {
            this.isFavorite = !this.isFavorite
        },
        nextImage() {
            this.currentImageIndex = (this.currentImageIndex + 1) % this.images.length;
        },
        prevImage() {
            this.currentImageIndex = (this.currentImageIndex - 1 + this.images.length) % this.images.length;
        },
        addToCart() {
            this.isAddingToCart = true;
            setTimeout(() => {
                this.isAddingToCart = false;
                this.quantity = 1;
            }, 1000);
        }
    }
})
</script>

<template>
    <div
        class="group relative flex flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">

        <!-- Top Actions -->
        <div class="absolute top-3 right-3 z-20 flex gap-2">
            <!-- Favorite Button -->
            <button
                @click="toggleFavorite"
                class="p-2.5 bg-white/95 backdrop-blur-sm rounded-full shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-110"
                :class="isFavorite ? 'text-red-500' : 'text-gray-400 hover:text-red-400'"
            >
                <transition name="heart">
                    <svg
                        key="heart"
                        class="h-5 w-5"
                        fill="none"
                        :class="isFavorite ? '' : 'stroke-current'"
                        viewBox="0 0 24 24"
                        :stroke="isFavorite ? 'currentColor' : 'currentColor'"
                        stroke-width="2"
                    >
                        <path
                            v-if="!isFavorite"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                        />
                        <path
                            v-else
                            fill="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                        />
                    </svg>
                </transition>
            </button>
        </div>

        <!-- Product Image with Gallery -->
        <Link :href="route('client.products.show', product.id)" class="relative block overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
            <div class="relative aspect-square overflow-hidden">
                <!-- Main Image -->
                <transition name="fade" mode="out-in">
                    <img
                        :key="currentImageIndex"
                        class="object-contain w-full h-full group-hover:scale-110 transition-transform duration-700 ease-out"
                        :src="images[currentImageIndex]?.url"
                        :alt="product.title"
                    />
                </transition>

                <!-- Image Navigation Arrows (on hover) -->
                <div v-if="images.length > 1" class="absolute inset-0 flex items-center justify-between px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button
                        @click.prevent="prevImage"
                        class="p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-all transform hover:scale-110"
                    >
                        <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        @click.prevent="nextImage"
                        class="p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-all transform hover:scale-110"
                    >
                        <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Image Dots Indicator -->
                <div v-if="images.length > 1" class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                    <span
                        v-for="(img, idx) in images"
                        :key="idx"
                        class="w-2 h-2 rounded-full transition-all duration-300"
                        :class="idx === currentImageIndex ? 'bg-teal-600 w-4' : 'bg-white/60'"
                    ></span>
                </div>

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                    <span v-if="hasDiscount" class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-3 py-1.5 rounded-xl text-xs font-bold shadow-lg flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                        </svg>
                        -{{ discountPercent }}%
                    </span>
                    <span v-if="product.is_new" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-3 py-1.5 rounded-xl text-xs font-bold shadow-lg">
                        NEW
                    </span>
                    <span v-if="product.is_bestseller" class="bg-gradient-to-r from-amber-400 to-orange-500 text-white px-3 py-1.5 rounded-xl text-xs font-bold shadow-lg">
                        🔥 ХИТ
                    </span>
                </div>

                <!-- Quick Add Overlay -->
                <div 
                    class="absolute inset-0 bg-black/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center"
                >
                    <button
                        @click.prevent="addToCart"
                        class="px-6 py-3 bg-white text-gray-900 rounded-xl font-semibold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200 flex items-center gap-2"
                    >
                        <svg v-if="!isAddingToCart" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <svg v-else class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ isAddingToCart ? 'Добавлено!' : 'Быстрый заказ' }}
                    </button>
                </div>
            </div>
        </Link>

        <!-- Product Info -->
        <div class="flex flex-col flex-grow p-5">
            <!-- Category Badge -->
            <div v-if="product.category" class="mb-2">
                <span class="text-xs font-medium text-teal-600 bg-teal-50 px-2.5 py-1 rounded-lg">
                    {{ product.category }}
                </span>
            </div>

            <!-- Title -->
            <Link :href="route('client.products.show', product.id)" class="group/link">
                <h5 class="text-base font-bold text-gray-800 line-clamp-2 group-hover/link:text-teal-600 transition-colors duration-200 min-h-[3rem]">
                    {{ product.title }}
                </h5>
            </Link>

            <!-- Rating -->
            <div class="flex items-center gap-2 mt-3">
                <div class="flex items-center">
                    <span v-for="i in 5" :key="i" class="relative">
                        <svg
                            :class="[
                                'w-4 h-4',
                                i <= (product.rating || 4) ? 'text-yellow-400 fill-current' : 'text-gray-200 fill-current'
                            ]"
                            viewBox="0 0 20 20"
                        >
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </span>
                </div>
                <span class="text-xs text-gray-500">({{ product.review_count || 0 }} отзывов)</span>
                <span v-if="product.sold_count" class="text-xs text-gray-400">• {{ product.sold_count }} продано</span>
            </div>

            <!-- Price Section -->
            <div class="mt-auto pt-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-3xl font-bold bg-gradient-to-r from-teal-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        {{ Number(product.price).toLocaleString() }} ₽
                    </span>
                    <span v-if="hasDiscount && product.old_price" class="text-sm text-gray-400 line-through">
                        {{ Number(product.old_price).toLocaleString() }} ₽
                    </span>
                </div>

                <!-- Stock Status -->
                <div v-if="product.in_stock !== undefined" class="mt-2 flex items-center gap-2">
                    <span
                        class="w-2 h-2 rounded-full"
                        :class="product.in_stock ? 'bg-green-500 animate-pulse' : 'bg-red-500'"
                    ></span>
                    <span
                        class="text-xs font-medium"
                        :class="product.in_stock ? 'text-green-600' : 'text-red-600'"
                    >
                        {{ product.in_stock ? 'В наличии' : 'Нет в наличии' }}
                    </span>
                    <span v-if="product.stock_quantity && product.in_stock" class="text-xs text-gray-400">
                        ({{ product.stock_quantity }} шт.)
                    </span>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="flex items-center gap-2.5 mt-4">
                    <div class="flex items-center border-2 border-gray-100 rounded-xl overflow-hidden hover:border-teal-200 transition-colors">
                        <button
                            @click="decrement"
                            class="px-3 py-2.5 bg-gray-50 hover:bg-teal-50 text-gray-600 hover:text-teal-600 transition-all duration-200"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                            </svg>
                        </button>
                        <div class="w-12 text-center">
                            <span class="text-sm font-bold text-gray-700">{{ quantity }}</span>
                        </div>
                        <button
                            @click="increment"
                            class="px-3 py-2.5 bg-gray-50 hover:bg-teal-50 text-gray-600 hover:text-teal-600 transition-all duration-200"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>

                    <button
                        @click="addToCart"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-teal-500 via-emerald-500 to-teal-600 hover:from-teal-600 hover:via-emerald-600 hover:to-teal-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 relative overflow-hidden"
                        :disabled="isAddingToCart"
                    >
                        <span v-if="isAddingToCart" class="absolute inset-0 bg-white/20"></span>
                        <svg v-if="!isAddingToCart" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <svg v-else class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ isAddingToCart ? 'Добавляем...' : 'В корзину' }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Decorative Gradient Border on Hover -->
        <div class="absolute inset-0 rounded-3xl border-2 border-transparent group-hover:border-teal-200 transition-colors duration-500 pointer-events-none"></div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.heart-enter-active {
    animation: heartBeat 0.4s ease-in-out;
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    25% { transform: scale(1.3); }
    50% { transform: scale(1); }
    75% { transform: scale(1.3); }
    100% { transform: scale(1); }
}
</style>
