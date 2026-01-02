<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "AddQuantity",
    props: {

    },
    data() {
        return {
            quantityData: 1
        }
    },
    methods: {
        incrementQty()
        {
            if (this.quantityData >= 1) {
                this.quantityData = this.quantityData + 1
                this.$emit('quantity_change', this.quantityData)
            }
        },
        decrementQty()
        {
            if (this.quantityData > 1) {
                this.quantityData = this.quantityData - 1;
                this.$emit('quantity_change', this.quantityData)
            }
        }
    }
})
</script>

<template>
    <div class="flex items-center rounded-lg border overflow-hidden">
        <button @click="decrementQty" id="dec" class="px-4 py-2 text-lg bg-white hover:bg-gray-100">−
        </button>
        <input v-model="quantityData" id="qty" type="number" value="1" min="1" max="10" disabled
               class="w-16 text-center outline-none p-2" aria-label="Quantity"/>
        <button @click="incrementQty" id="inc" class="px-4 py-2 text-lg bg-white hover:bg-gray-100">+
        </button>
    </div>
</template>

<style scoped>

</style>
