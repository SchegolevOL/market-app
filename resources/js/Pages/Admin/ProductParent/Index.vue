<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";


export default {
    name: "Index",
    layout: AdminLayout,
    components: {
        Link,
    },
    props: {
        productParents: Array,

    },
    data() {
        return {
            productParentsData: this.productParents
        }
    },
    methods: {
        deleteProductParent(productParent) {
            axios.delete(route('admin.product-parents.destroy', productParent.id))
                .then(res => {
                    this.productParentsData = this.productParentsData.filter(productParentData => productParentData.id !== productParent.id)
                })
        }
    }
}
</script>

<template>

    <div>
        <Link :href="route('admin.product-parents.create')"
              class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
            Create ProductParent
        </Link>

        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr>

                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">id</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="productParent in productParentsData">


                <td class="px-6 py-4 whitespace-nowrap">{{ productParent.id }}</td>
                <Link :href="route('admin.product-parents.show', productParent.id)" class=" py-6 whitespace-nowrap flex px-6">
                    <td >{{ productParent.title }}</td>
                </Link>


                <td class="px-6 py-4 whitespace-nowrap">

                    <Link :href="route('admin.product-parents.edit', productParent)"
                          class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                        Edit
                    </Link>
                    <button @click="deleteProductParent(productParent)"
                            class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                        Delete
                    </button>
                </td>

            </tr>

            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
