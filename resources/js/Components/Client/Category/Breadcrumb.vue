<script lang="ts">
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    name: "Breadcrumb",
    components: {Link},
    props: {
        bredCrumbs: Array,
        current: String,
    }
})
</script>

<template>
    <aside class="py-4 px-4 border-gray-900">
        <nav>
            <Link :href="route('client.categories.index')">
                Categories >
            </Link>
            <template v-for="bredCrumb in bredCrumbs">
                <Link :href="route('client.categories.products.index', bredCrumb.id)">
                    {{ bredCrumb.title }}
                </Link>
                <span>/</span>
            </template>
            <span>{{ current }}</span>
        </nav>
    </aside>
</template>

<style scoped>

</style>
