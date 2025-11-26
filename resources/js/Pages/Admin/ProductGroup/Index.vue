<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";


export default {
    name: "Index",
    layout: AdminLayout,
    components:{
        Link,
    },
    props:{
        productGroups:Array,
    },
    data(){
        return{
           productGroupsData: this.productGroups
        }
    },
    methods:{
        deleteProduct(productGroup)
        {
            console.log(this.productGroup)
            axios.delete(route('admin.product-groups.destroy', productGroup.id))
                .then(res=>{
                    console.log(this.productGroupsData)
                    this.productGroupsData = this.productGroupsData.filter(productGroupData => productGroupData.id !== productGroup.id)


                })
        }
    }
}
</script>

<template>


    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <h1>Index Product Group</h1>
        </div>
    </div>

    <div class="container mx-auto px-4 ">

        <Link :href="route('admin.product-groups.create')"
               class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
        Create Product Group
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
            <tr v-for="productGroup in productGroupsData">
                <td class="px-6 py-4 whitespace-nowrap">{{productGroup.id}}</td>
                <Link :href="route('admin.product-groups.show', productGroup)">
                    <td class="px-6 py-4 whitespace-nowrap">{{productGroup.title}}</td>
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
</template>

<style scoped>

</style>
