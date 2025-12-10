<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";


export default {
    name: "Index",
    layout: AdminLayout,
    components: {
        Link,
    },
    props: {
        productGroups: Array,
    },
    data() {
        return {
            productGroupsData: this.productGroups,
            isSearch: false,
            filter: {},
        }
    },
    methods: {
        deleteProduct(productGroup) {
            console.log(this.productGroup)
            axios.delete(route('admin.product-groups.destroy', productGroup.id))
                .then(res => {
                    console.log(this.productGroupsData)
                    this.productGroupsData = this.productGroupsData.filter(productGroupData => productGroupData.id !== productGroup.id)


                })
        },
        search() {
            console.log(this.filter);
            axios.get(route('admin.product-groups.index'), {
                params: this.filter
            })
                .then(res => {
                    this.productGroupsData = res.data
                })
        },
        resetFilter(){
            this.filter= {};
            this.productGroupsData = this.productGroups;
        }
    }
}
</script>

<template>
    <div class="grid grid-cols-6 gap-4">
        <div class="col-span-4 col-start-2 ...">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <h1>Index Product Group</h1>
                </div>
            </div>
        </div>
        <div class="col-start-1 col-end-3 ...">

            <Link :href="route('admin.product-groups.create')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Create Product Group
            </Link>
        </div>
        <div class="col-span-2 col-end-7 ...">
            <button @click.prevent="isSearch=!isSearch"
                    class="ml-4 px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-green active:bg-blue-600 transition duration-150 ease-in-out">
                Filters
            </button>
        </div>
        <div class="col-start-1 col-end-7 ...">
            <div v-if="isSearch" class="px-5 flex">

                <input
                       v-model="filter.title"
                       @input.prevent="search"
                       type="text"
                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-80 p-2.5"
                       placeholder="Enter Title”" required="">
                <button @click.prevent="resetFilter"
                        class="ml-4 px-4 py-2 font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-500 focus:outline-none focus:shadow-outline-green active:bg-yellow-600 transition duration-150 ease-in-out">
                    Reset Filter
                </button>
            </div>
        </div>
        <div class="col-start-1 col-end-7 ...">

            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">id</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="productGroup in productGroupsData">
                    <td class="px-6 py-4 whitespace-nowrap">{{ productGroup.id }}</td>
                    <Link :href="route('admin.product-groups.show', productGroup)">
                        <td class="px-6 py-4 whitespace-nowrap">{{ productGroup.title }}</td>
                    </Link>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <Link :href="route('admin.product-groups.edit', productGroup)"
                              class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                            Edit
                        </Link>
                        <button @click="deleteProduct(productGroup)"
                                class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                            Delete
                        </button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>


</template>

<style scoped>

</style>
