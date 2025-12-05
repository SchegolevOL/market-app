<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "InputErrorValidate",
    props:{
        error:String
    }
})
</script>

<template>
    <p class="text-red-500 text-sm mt-0" >{{ error }}</p>
</template>

<style scoped>

</style>
