<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import WindowSuccessMessage from "@/Components/Admin/General/WindowSuccessMessage.vue";


export default {
    name: "Create",
    components: {
        WindowSuccessMessage,
        Link
    },
    layout: AdminLayout,
    props: {

    },
    data() {
        return {

                productGroup: {
                    title: null,


                },
                success:false,


        }
    },


    methods: {
        storeProductGroup() {
            console.log(this.productGroup);

            axios.post(route('admin.product-groups.store'), this.productGroup)
                .then(res => {


                    this.productGroup = {
                        title:'',

                    };
                    this.$nextTick(()=>{
                        this.success = true;
                    })


                })

        },
        storeProductGroupToIndex() {
            axios.post(route('admin.product-groups.store'), this.productGroup)
                .then(function () {
                        window.location.replace(route('admin.product-parents.index'));

                    }
                )
        },

    },
    watch:{
        productGroup:{
            handler(new_val, old_val){
                this.success=false;
            },
            deep:true
        }
    }


}
</script>

<template>
    <div class="grid grid-cols-3 gap-4">
        <div class="">
            <!--      Page name      -->
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <h1>Create Product Group</h1>
            </div>

        </div>
        <div class="">

        </div>
        <div class="">
            <!--       Navigation buttons       -->
            <Link :href="route('admin.product-groups.index')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Back Index
            </Link>
        </div>
        <div class="col-span-2">
            <!--        Form fields     -->
            <div class="">
                <div>
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                    <input v-model="productGroup.title" type="text" name="product-name" id="product-name"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                           placeholder="Enter Title”" required="">
                </div>

                <div class="p-6 border-t border-gray-200 rounded-b">

                    <button @click.prevent="storeProductGroup"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            type="submit">Create
                    </button>
                    <button @click.prevent="storeProductGroupToIndex"
                            class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            type="submit">Create to Index
                    </button>
                </div>
            </div>
        </div>
        <div class="">
            <!--        Image output        -->

        </div>
        <div v-if="success">
            <WindowSuccessMessage :message="'Product Group Success Create'"/>
        </div>

    </div>






</template>

<style scoped>

</style>
