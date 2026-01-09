<script lang="ts">
import {defineComponent} from 'vue'

import ClientLayout from "@/Layouts/ClientLayout.vue";
import {Link} from "@inertiajs/vue3";

import CategoryItem from "@/Components/Client/Category/CategoryItem.vue";

export default defineComponent({
    name: "Index",
    layout: ClientLayout,
    components: {
        CategoryItem,
        Link,
    },
    props: {
        categories: Array,
    },
    data() {
        return {}
    },
    methods: {}

})
</script>

<template>

    <div class="flex h-screen bg-gray-100">

        <!-- Main content -->
        <div class="grid grid-cols-6 gap-4">

            <div class="col-start-1 col-end-7">
                <div class="p-4">
                    <div class="">

                        <div class="flex">


                            <article class="w-3/4 border-gray-50 p-4">
                                <div class="grid grid-cols-4 gap-4">
                                    <div v-for="category in categories" class="mx-2 my-2 ">
                                        <Link :href="route('client.categories.index', category.id)">
                                            <CategoryItem :category="category"/>
                                        </Link>
                                    </div>

                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</template>

<style scoped>

</style>
