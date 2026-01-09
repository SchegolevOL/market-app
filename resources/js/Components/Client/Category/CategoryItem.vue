<script lang="ts">
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    name: "CategoryItem",
    components: {Link},
    props:{
        category:{}
    },
    data(){
        return{

        }
    }
})
</script>

<template>
<div>



    <Link :href="route('client.categories.products.index', category.id)">
    <div class="max-w-md mx-auto rounded-md overflow-hidden shadow-md hover:shadow-lg ">
        <div class="relative">

            <img v-if="category.images.length>0" class="max-w-full bg-cover size-80" :src="category.images[0].url" alt="Category Image">


        </div>
        <div class="p-4 text-center">

            <h3 class="text-lg font-medium mb-2">{{category.title}}</h3>



        </div>

    </div>
    </Link>
</div>
</template>

<style scoped>

</style>
