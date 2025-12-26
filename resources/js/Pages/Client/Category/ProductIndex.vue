<script lang="ts">
import {defineComponent} from 'vue'
import ProductItem from "@/Components/Client/Product/ProductItem.vue";
import ClientLayout from "@/Layouts/ClientLayout.vue";
import {Link} from "@inertiajs/vue3";
import {data} from "autoprefixer";

export default defineComponent({
    name: "ProductIndex",
    layout: ClientLayout,
    components: {
        Link,
        ProductItem
    },
    props: {
        products: Array,
        bredCrumbs: Array,
        category: {},
        params: Array,
    },
    data() {
        return {
            filters: {
                integer: {
                    from: {},
                    to: {}
                },
                select: {},
                checkbox: {}
            },
            productsData: this.products,
            paramsData: this.params,
        }
    },
    methods: {
        setFilter(param, value) {
            console.log(param, value)
            if (this.filters.checkbox[param.id]) {
                this.toggleItem(this.filters.checkbox[param.id], value)
                return;
            }
            this.filters.checkbox[param.id] = [];
            this.filters.checkbox[param.id].push(value);
        },
        toggleItem(array, value) {
            let index = array.indexOf(value);
            index === -1 ? array.push(value) : array.splice(index, 1);
        },
        getPosts() {
            this.clear(this.filters.integer.from)
            this.clear(this.filters.integer.to)

           axios.get(route('client.categories.products.index', this.category.id), {
                params: this.filters

            })
                .then(res => {

                this.productsData = res.data;

            })
        },
        clear(obj){

            Object.keys(obj).forEach(key => {
                if (!obj[key]) {
                    delete obj[key];

                }
            })
        }
    }

})
</script>

<template>

    <div class="flex h-screen bg-gray-100">

        <!-- sidebar -->
        <div class="hidden md:flex flex-col w-64 rounded-2xl">

            <div class="flex flex-col flex-1 overflow-y-auto border-x-green-700">
                <nav class="flex flex-col flex-1 overflow-y-auto  px-2 py-4 gap-10 rounded-2xl">
                    <div class="">
                        <template v-for="param in paramsData">
                            <div v-if="param.filter_type === 3" class="border-b border-gray-800">
                                <div>
                                    <h3>{{ param.title }} :</h3>
                                </div>
                                <div>

                                    <div v-for="value in param.param_values" class="mb-2 flex items-center">

                                        <input @change="setFilter(param, value)" type="checkbox" :value="value"
                                               :id="value"/>
                                        <label class="px-2 text-sm text-gray-800" :for="value">{{ value }}</label>
                                    </div>
                                </div>
                            </div>
                            <div v-if="param.filter_type === 1" class="border-b border-gray-800">
                                <div>
                                    <h3>{{ param.title }} :</h3>
                                </div>
                                <div>

                                    <div class="mb-2 items-center">
                                        <div class="flex text-center">
                                            <div class="p-2 px-1 m-2">От:</div>
                                            <input v-model="filters.integer.from[param.id]"
                                                   class="border-gray-200 border p-2 rounded px-1 m-2"
                                                   type="text"/>
                                        </div>
                                        <div class="flex">
                                            <div class="p-2 px-1 m-2">До:</div>
                                            <input v-model="filters.integer.to[param.id]"
                                                   class="border-gray-200 border p-2 rounded px-1 m-2"
                                                   type="text"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="param.filter_type === 4" class="border-b border-gray-800">
                                <div>
                                    <h3>{{ param.title }} :</h3>
                                </div>
                                <div>

                                    <div class="mb-2 items-center">
                                        <label>От</label>
                                        <input class="border-gray-200 border  rounded px-1 m-2" type="color"
                                               value="#ffff"/>
                                        <label>До</label>
                                        <input class="border-gray-200 border  rounded px-1 m-2" type="color"
                                               value="null"/>
                                    </div>
                                    <div v-for="value in param.param_values" class="mb-2 flex items-center">
                                        <input type="checkbox" :value="value" :id="value"/>
                                        <label class="px-2 text-sm text-gray-800" :for="value">{{value}}</label>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="px-2 py-2">
                            <a @click.prevent="getPosts()"
                                href="#"
                               class="block bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-1 rounded text-sm text-center">Фильтр</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main content -->
        <div class="grid grid-cols-6 gap-4">

            <div class="col-start-1 col-end-7">
                <aside class="py-4 px-4 border-gray-900">
                    <nav>
                        <template v-for="bredCrumb in bredCrumbs">
                            <Link :href="route('client.categories.products.index', bredCrumb.id)">
                                {{ bredCrumb.title }}
                            </Link>
                            <span>/</span>
                        </template>
                        <span>{{ category.title }}</span>
                    </nav>
                </aside>
            </div>
            <div class="col-start-1 col-end-7">
                <div class="p-4">
                    <div class="">

                        <div class="flex">


                            <article class="w-3/4 border-gray-50 p-4">
                                <div class="grid grid-cols-4 gap-4">
                                    <div v-for="product in productsData" class="mx-2 my-2 ">
                                        <ProductItem :product="product"/>
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
