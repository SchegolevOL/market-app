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
        }
    }
})
</script>

<template>
    <div
        class="relative flex flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md max-w-xs m-4">
        <Link :href="route('client.products.show', product.id)" class="relative mx-3 mt-3 flex h-40 overflow-hidden rounded-xl">
            <img v-if="product.images.length>0" class="object-contain w-full h-full" :src="product.images[0].url"
                 alt="Product Image">
            <img v-if="product.images.length==0" class="object-contain w-full h-full"
                 src="/storage/Client/ImagesDefault/defaultImagesProduct.png" alt="Product Image">
            <div  v-if="discount>0" class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 m-2 rounded-md text-sm font-medium">
                SALE
            </div>

        </Link>
        <div class="flex flex-col flex-grow mt-2 px-3 pb-3">
            <Link :href="route('client.products.show', product.id)" class="block relative group">
                <h5 class="text-xs tracking-tight text-slate-900 font-bold flex items-center">{{ product.title }}</h5>
                <span class="ml-1"></span>
            </Link>


            <div class="mt-auto">

                <div class="flex flex-col items-start">
        <span class="text-xl font-bold text-red-600">
          {{ product.price }}
        </span>
                    <div class="flex items-center">
          <span v-if="discount!==0" class="text-lg text-gray-500 line-through">
            {{product.old_price}}
          </span>
                        <span v-if="discount>0" class="bg-[#0CAA91] text-white text-xs font-bold px-2 py-0.5 rounded ml-1">-{{discount}}%</span>
                        <span v-if="discount<0" class="bg-red-700 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">+{{-discount}}%</span>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-3">
                    <div class="flex items-center space-x-2">
                        <button
                            class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300 focus:outline-none"
                            disabled
                        >-
                        </button>
                        <input
                            type="number"
                            min="1"
                            value="1"
                            class="w-14 text-center border rounded focus:outline-none"
                            readonly
                        />
                        <button
                            class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300 focus:outline-none"
                            disabled
                        >+
                        </button>
                    </div>
                    <button
                        class="bg-[#0CAA91] text-white p-3 rounded-full flex items-center justify-center shadow-lg transform transition-transform duration-300 hover:scale-105 hover:bg-[#078c6d] focus:outline-none"
                        style="width: 50px; height: 50px;"
                    >
                        <img src="https://www.freeiconspng.com/uploads/cart-icon-16.png" alt="Carrito" class="w-6 h-6">
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!--    <div>
            <div class="max-w-md mx-auto rounded-md overflow-hidden shadow-md hover:shadow-lg ">
                <div class="relative">

                    <img v-if="product.images.length>0" class="max-w-full bg-cover size-80" :src="product.images[0].url"
                         alt="Product Image">
                    <img v-if="product.images.length==0" class="max-w-full  bg-cover size-80"
                         src="/storage/Client/ImagesDefault/defaultImagesProduct.png" alt="Product Image">
                    <div class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 m-2 rounded-md text-sm font-medium">
                        SALE
                    </div>
                    <div class="absolute -0 right-0 bg-red-500 text-white px-2 py-1 m-2 rounded-md text-sm font-medium">
                        SALE
                    </div>
                </div>
                <div class="p-4">
                    <Link :href="route('client.products.show', product.id)">
                        <h3 class="text-lg font-medium mb-2">{{ product.title }}</h3>
                    </Link>
                    <p class="text-gray-600 text-sm mb-4">{{ product.content }}</p>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-lg">{{ product.price }}</span>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-1 rounded text-sm">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>-->
</template>

<style scoped>

</style>
