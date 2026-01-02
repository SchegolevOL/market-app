<script lang="ts">
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    name: "ProductCard",
    components: {Link},
    props:{
        product:{}
    },
    data(){
        return{

        }
    }
})
</script>

<template>
<div>




    <div class="max-w-md mx-auto rounded-md overflow-hidden shadow-md hover:shadow-lg ">
        <div class="relative">

            <img v-if="product.images.length>0" class="max-w-full bg-cover size-80" :src="product.images[0].url" alt="Product Image">
            <img v-if="product.images.length==0" class="max-w-full  bg-cover size-80" src="/storage/Client/ImagesDefault/defaultImagesProduct.png" alt="Product Image">
            <div class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 m-2 rounded-md text-sm font-medium">SALE</div>
            <div class="absolute -0 right-0 bg-red-500 text-white px-2 py-1 m-2 rounded-md text-sm font-medium">SALE</div>
        </div>
        <div class="p-4">
            <Link :href="route('client.products.show', product.id)">
            <h3 class="text-lg font-medium mb-2">{{product.title}}</h3>
            </Link>
            <p class="text-gray-600 text-sm mb-4">{{product.content}}</p>
            <div class="flex items-center justify-between">
                <span class="font-bold text-lg">{{product.price}}</span>
                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-1 rounded text-sm">
                    Buy Now
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
