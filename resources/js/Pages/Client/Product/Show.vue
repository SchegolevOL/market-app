<script>


import ClientLayout from "@/Layouts/ClientLayout.vue";
import ProductItem from "@/Components/Client/Product/ProductItem.vue";
import ImagesPreview from "@/Components/Client/Product/ImagesPreview.vue";
import {Link} from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Client/Category/Breadcrumb.vue";
import AddQuantity from "@/Components/Client/Product/AddQuantity.vue";

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
    data() {
        return {
            quantity: 1,
        }

    },
    methods: {
        changeQty(quantityData) {
            this.quantity = quantityData

        }
    }
}
</script>

<template>

    <div class="grid grid-cols-5 grid-rows-3 gap-4">
        <div class="col-span-1">
            <nav>
                product
            </nav>
        </div>


        <div class="col-span-3 ...">
            <article class=" border-gray-50 p-4">

                <div class="bg-gray-50 text-gray-800 antialiased">
                    <main class=" mx-auto">
                        <!-- Breadcrumb / Header -->
                        <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                            <div class="">
                                <Breadcrumb :bred-crumbs="bredCrumbs" :current="product.title"/>
                            </div>
                        </nav>

                        <section class="grid grid-cols-2 lg:grid-cols-2 gap-8 items-start">
                            <!-- LEFT: Images -->
                            <div class="space-y-4">
                                <ImagesPreview :images="product.images"
                                               :discount="(((product.old_price-product.price)/product.price)*100).toFixed(2)"
                                               :is-hit="true"/>

                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Description</h3>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ product.description }}</p>
                                </div>
                            </div>


                            <!-- RIGHT: Product Info -->

                            <div class="flex">

                                <aside class="sticky top-6">
                                    <div class="rounded-xl shadow p-6 lg:p-8">
                                        <h1 class="text-2xl lg:text-3xl font-extrabold leading-tight">{{
                                                product.title
                                            }}</h1>

                                        <div class="mt-4 flex items-end gap-4">
                                            <div>
                                                <div class="text-3xl lg:text-4xl font-extrabold price-shadow">
                                                    {{ product.price }}
                                                </div>
                                                <div class="text-sm text-gray-400 line-through">{{
                                                        product.old_price
                                                    }}
                                                </div>
                                                <div v-if="product.old_price > product.price"
                                                     class="text-sm text-green-600 font-medium mt-1">You save
                                                    {{ product.old_price - product.price }}
                                                </div>
                                                <div class="text-xs text-gray-400 mt-1">Inclusive of all taxes</div>
                                            </div>

                                            <div class="ml-auto text-right">
                                                <button aria-label="Add to wishlist"
                                                        class="p-2 rounded-md border hover:bg-gray-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-pink-500"
                                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path
                                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.656 3.172 11.83a4 4 0 010-5.656z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <!--     Content                           -->
                                        <div class="mt-5 border rounded-lg p-4 bg-gray-50 flex items-center gap-4">
                                            <div class="flex-1 text-sm">
                                                <div class="font-medium">Content</div>
                                                <div class="text-xs text-gray-500">{{ product.content }}</div>
                                            </div>

                                        </div>
                                        <!-- Delivery & Stock -->
                                        <div class="mt-5 border rounded-lg p-4 bg-gray-50 flex items-center gap-4">
                                            <div class="flex-1 text-sm">
                                                <div class="font-medium">Delivery in 10-15 mins</div>
                                                <div class="text-xs text-gray-500">Shipment of 1 item</div>
                                            </div>
                                            <div class="text-sm font-medium text-green-600">In Stock</div>
                                        </div>

                                        <!-- Quantity & Add -->
                                        <div class="mt-5">
                                            <label for="qty" class="block text-sm font-medium text-gray-700 mb-2">Quantity
                                                <span
                                                    class="text-xs text-gray-400">({{
                                                        product.qty
                                                    }} available)</span></label>
                                            <div class="flex items-center gap-3">
                                                <AddQuantity @quantity_change='changeQty'/>

                                                <button id="addToCart"
                                                        class="ml-auto flex-1 lg:flex-none bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg px-6 py-3 shadow">
                                                    🛒 Add
                                                </button>
                                            </div>
                                            <p class="text-xs text-gray-400 mt-2">Max order limit: <strong
                                                class="text-gray-700">10 per customer</strong></p>
                                        </div>

                                        <hr class="my-6"/>

                                        <dl class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-600">
                                            <div>
                                                <dt class="text-xs text-gray-500">Category</dt>
                                                <dd class="mt-1">{{ product.category.title }}</dd>
                                            </div>
                                            <
                                                <dt class="text-xs text-gray-500">Product group</dt>
                                                <dd class="mt-1">{{ product.product_group.title }}</dd>
                                            </div>
                                            <div v-if="paramProducts.length>0">
                                                <dt class="text-xs text-gray-500">Shipment</dt>
                                                <dd v-for="paramProduct in paramProducts" class="mt-1 flex">
                                            <span
                                                class="inline-block px-3 py-1 rounded-full text-xs bg-green-50 text-green-700">
                                                {{ paramProduct.title }}:
                                            </span>
                                                    <div v-if="paramProduct.data.length>0" class="flex">
                                                        <div v-for="paramProductData in paramProduct.data" class="">
                                                            <Link v-if="paramProductData.param.label ==='color'"
                                                                  :href="route('client.products.show', paramProductData.product_id)"
                                                                  :class="[paramProductData.product_id === product.id?'inline-block px-3 py-2 rounded-full text-xs border-2 border-blue-600 mr-1 w-8 h-6':'inline-block px-3 py-2 rounded-full text-xs border border-green-600 mr-1 w-8 h-6']"
                                                                  :style="`background: ${paramProductData.value}; `"
                                                                  ></Link>
                                                            <Link v-if="paramProductData.param.label !=='color'"
                                                                  :class="[paramProductData.product_id === product.id?'inline-block px-3 py-1 rounded-full text-xs border-2 border-blue-600 mr-1':'inline-block px-3 py-1 rounded-full text-xs border border-green-600 mr-1']"
                                                                  :href="route('client.products.show', paramProductData.product_id)">{{
                                                                    paramProductData.value
                                                                }}</Link>
                                                        </div>


                                                    </div>
                                                </dd>


                                            </div>
                                            <div>
                                                <dt class="text-xs text-gray-500">Params:</dt>
                                                <dd v-for="param in product.params" class="mt-1 flex">
                                            <span
                                                class="inline-block px-3 py-1 rounded-full text-xs bg-green-50 text-green-700">
                                                {{ param.title }}:
                                            </span>


                                                    <span v-if="param.label!=='color'"
                                                          class="inline-block px-3 py-1 rounded-full text-xs text-green-700 border border-green-600 mr-1 bg-green-50"
                                                          v-for="value in param.value"> {{ value }}</span>
                                                    <span v-if="param.label==='color'"
                                                          :style="`background: ${value}; width: 32px; height: 16px;`"
                                                          class=" inline-block px-3 py-3 rounded-full text-xs border border-green-600 mr-1"
                                                          v-for="value in param.value"></span>
                                                </dd>

                                            </div>
                                        </dl>

                                    </div>


                                    <!-- Mobile sticky CTA -->
                                    <div id="mobileCta" class="fixed left-0 right-0 bottom-4 px-4 lg:hidden">
                                        <div class="max-w-3xl mx-auto">
                                            <button id="mobileAdd"
                                                    class="w-full bg-green-600 text-white rounded-full py-3 font-semibold shadow-lg">
                                                🛒 Add to Cart — ₹450
                                            </button>
                                        </div>
                                    </div>

                                </aside>


                            </div>
                        </section>
                    </main>


                </div>
            </article>
        </div>
        <div v-if="product.group_products.length>0" class="col-span-1 border">
            <div class="">Похожие товары</div>
            <div v-for="product in product.group_products" class="border-gray-900">

                <ProductItem :product="product"/>
            </div>
        </div>
    </div>


</template>

<style scoped>

</style>
