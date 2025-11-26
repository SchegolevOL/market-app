<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";


export default {
    name: "Edit",
    components: {
        Link
    },
    layout: AdminLayout,
    props: {
        filterTypes: Array,
        param:{},
    },

    methods: {
        updateParam() {


            axios.patch(route('admin.params.update', this.param), this.param)
                .then(res => {


                })
        },
        updateParamToIndex() {
            axios.patch(route('admin.params.update', this.param), this.param)
                .then(function () {
                        window.location.replace(route('admin.params.index'));

                    }
                )
        },

    }


}
</script>

<template>
    <div class="grid grid-cols-3 gap-4">
        <div class="">
            <!--      Page name      -->
            <h3 class="text-xl font-semibold">
                Update Param
            </h3>

        </div>
        <div class="">

        </div>
        <div class="">
            <!--       Navigation buttons       -->
            <Link :href="route('admin.params.index')"
                       class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
            Back Index
        </Link>
        </div>
        <div class="col-span-2">
            <!--        Form fields     -->
            <div class="">

                <div class="">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                        <input v-model="param.title" type="text" name="product-name" id="product-name"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Enter Title”" required="">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="category" class="text-sm font-medium text-gray-900 block mb-2">Filter Type</label>

                        <select v-model="param.filter_type"
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
                <div class="p-6 border-t border-gray-200 rounded-b">

                    <button @click.prevent="updateParam"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            type="submit">Create
                    </button>
                    <button @click.prevent="updateParamToIndex"
                            class="m-3 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            type="submit">Create to Index
                    </button>
                </div>
            </div>
        </div>
        <div class="">
            <!--        Image output        -->

        </div>

    </div>






</template>

<style scoped>

</style>
