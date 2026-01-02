<script lang="ts">


import {defineComponent} from "vue";

export default defineComponent({
    name: "ImagesPreview",
    props: {
        images: Array,
        discount: String,
        isHit: false,

    },
    data() {
        return {
            imagePreview: this.images[0],
        }
    },
    methods: {}
})
</script>

<template>
    <div class="rounded-xl overflow-hidden bg-white p-6 shadow-sm">
        <div class="relative">
                <span
                    v-if="discount"
                    class="absolute left-4 top-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500 text-white shadow">{{
                        discount
                    }}% OFF</span>
            <span
                v-if="isHit"
                class="absolute left-4 top-12 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-600 text-white shadow">It`s Hit</span>


            <img
                :src="imagePreview.url"
                alt="Plums" class="w-full h-96 object-cover rounded-lg"/>
        </div>
        <div class="mt-4 flex gap-3 items-center">
            <div v-for="image in images">

                <button :class="imagePreview.id === image.id ? 'border-green-900' : 'border-transparent'"
                        class="w-16 h-16 rounded-md border p-1 flex items-center justify-center bg-white relative">
                    <img
                        :src="image.url"
                        @click="imagePreview = image"

                        alt="thumb" class="w-full h-full object-cover rounded-sm border"/>
                </button>



            </div>
            <div class="text-sm text-gray-500">High-resolution images • 4 views</div>
        </div>
    </div>
</template>

<style scoped>

</style>
