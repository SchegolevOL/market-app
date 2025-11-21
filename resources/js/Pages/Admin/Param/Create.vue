<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";


export default {
    name: "Create",
    components: {
        Link
    },
    layout: AdminLayout,
    props: {
        filterTypes: Array,
    },
    data() {
        return {
            emit: {
                param: {
                    title: null,
                    filter_type: null,

                },
            },


        }
    },
    methods: {
        storeParam() {

            axios.post(route('admin.params.store'), this.emit)
                .then(res => {
                        this.emit.param = {
                            filter_type: null
                        };
                    }
                )
        },
        storeParamToIndex() {
            axios.post(route('admin.params.store'), this.emit)
                .then(res => {
                    window.location.replace(route('admin.params.index'));
                })
        },

    }


}
</script>

<template>
    <div class="bg-white border-4 rounded-lg shadow relative m-10">

        <div class="flex items-start justify-between p-5 border-b rounded-t">
            <h3 class="text-xl font-semibold">
                Create Param
            </h3>
            <Link :href="route('admin.params.index')"
                  class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                Back Index
            </Link>
        </div>

        <div class="p-6 space-y-6">

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                        <input v-model="emit.param.title" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter Title”" required="">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="category" class="text-sm font-medium text-gray-900 block mb-2">Filter Type</label>

                        <select v-model="emit.param.filter_type"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                id="service" name="service">
                            <option selected disabled>Select Filter Type</option>
                            <option v-for="filter in filterTypes" :value="filter['value']">{{
                                    filter['title']
                                }}
                            </option>

                        </select>


                    </div>


                </div>

        </div>

        <div class="p-6 border-t border-gray-200 rounded-b">

            <button @click.prevent="storeParam"
                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="submit">Create
            </button>
            <button @click.prevent="storeParamToIndex"
                    class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="submit">Create to Index
            </button>
        </div>


    </div>
</template>

<style scoped>

</style>
