<script lang="ts">
import {defineComponent} from 'vue'
import ClientLayout from "@/Layouts/ClientLayout.vue";
import {Link} from "@inertiajs/vue3";
import AddQuantity from "@/Components/Client/Product/AddQuantity.vue";

export default defineComponent({
    name: "Index",
    components: {AddQuantity, Link},
    layout: ClientLayout,
    props: {

    },
    data() {
        return{
            product: {
                qty: 1
            }
        }
    },
    methods: {
        changeQty(quantityData){
            this.product.qty = quantityData
        }
    }
})
</script>

<template>
<div>
    <div class="flex items-center justify-center h-screen">
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded-lg border border-gray-200">
                <thead>
                <tr class="border-b">
                    <th class="px-6 py-4 text-left text-gray-600 font-medium">Product Name</th>
                    <th class="px-6 py-4 text-left text-gray-600 font-medium">Unit Price</th>
                    <th class="px-6 py-4 text-left text-gray-600 font-medium">Qty</th>
                    <th class="px-6 py-4 text-left text-gray-600 font-medium">Total</th>
                    <th class="px-6 py-4 text-left text-gray-600 font-medium">Button</th>
                </tr>
                </thead>
                <tbody>
                <tr class="border-b">
                    <td class="px-6 py-4 flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZHVjdHxlbnwwfHwwfHx8MA%3D%3D" alt="Product" class="w-12 h-12 rounded-md">
                        <div>
                            <p class="text-gray-800 font-medium">Apple Watch Series 8 GPS 45mm</p>
                            <span class="text-green-500 text-sm">UBL</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">$550</td>
                    <td class="px-6 py-4">x3</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">$1,500</td>
                </tr>
                <tr class="border-b">
                    <td class="px-6 py-4 flex items-center gap-4">
                        <img src="https://plus.unsplash.com/premium_photo-1681711647066-ef84575c0d95?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cHJvZHVjdCUyMHBob3RvZ3JhcGh5fGVufDB8fDB8fHww" alt="Product" class="w-12 h-12 rounded-md">
                        <div>
                            <p class="text-gray-800 font-medium">Apple Watch Series 8 GPS 45mm</p>
                            <span class="text-green-500 text-sm">UBL</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">$550</td>
                    <td class="px-6 py-4">x3</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">$1,500</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 flex items-center gap-4">
                        <img src="https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIyLTExL3JtMzYyLTAxYS1tb2NrdXAuanBn.jpg" alt="Product" class="w-12 h-12 rounded-md">
                        <div>
                            <p class="text-gray-800 font-medium">Apple Watch Series 8 GPS 45mm</p>
                            <span class="text-green-500 text-sm">UBL</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">$550</td>
                    <td class="px-6 py-4">
                       <AddQuantity :qty= 'product.qty' @quantity_change = 'changeQty'/>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">$1,500</td>
                    <td class="px-6 py-4 items-center">
                        <Link>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                       </Link>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
