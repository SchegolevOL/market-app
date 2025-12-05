<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "WindowSuccessMessage",
    props:{
        message:String
    }
})
</script>

<template>
    <div class="bg-green-500 py-2 px-4 rounded-md text-white text-center fixed bottom-4 right-4 flex gap-4">
        <p>{{message}}.</p>
        <span class="cursor-pointer font-bold" onclick="return this.parentNode.remove()"><sup>X</sup></span>
    </div>
</template>

<style scoped>

</style>
