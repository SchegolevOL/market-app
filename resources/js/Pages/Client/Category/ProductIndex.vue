<script lang="ts">
import {defineComponent} from 'vue'
import ProductItem from "@/Components/Client/Product/ProductItem.vue";
import ClientLayout from "@/Layouts/ClientLayout.vue";

export default defineComponent({
    name: "ProductIndex",
    layout: ClientLayout,
    components: {ProductItem
    },
    props:{
        products:{}
    }

})
</script>

<template>
    <div class="flex">



        <aside class="w-1/4 border-gray-900 min-h-screen">
            <nav>
                products
            </nav>
        </aside>
        <article class="w-3/4 border-gray-50 p-4">
            <div class="grid grid-cols-4 gap-4">
                <div v-for="product in products" class="mx-2 my-2 ">
                    <ProductItem :product="product"/>
                </div>

            </div>
        </article>
    </div>
</template>

<style scoped>

</style>
