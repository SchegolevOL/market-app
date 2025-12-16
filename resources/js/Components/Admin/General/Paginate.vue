<script>
export default {
    name: "Paginate",
    props:{
        meta:{}
    },
    data(){
        return{
            filter:{}
        }
    }

}
</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#"
               class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#"
               class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ meta.from }}</span>
                    to
                    <span class="font-medium">{{ meta.to }}</span>
                    of
                    <span class="font-medium">{{ meta.total }}</span>
                    results
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 flex justify-center items-center p-5">
                <div class="flex justify-center items-center mt-8">
                    <a class="bg-transparent text-gray-700 dark:text-gray-200 font-semibold border border-gray-300  px-2 py-1 rounded-md focus:outline-none dark:border-none">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 20 20">
                            <path d="M10 18l-8-8 8-8 1.414 1.414L4.828 10l6.586 6.586L10 18z"/>
                        </svg>
                    </a>
                    <div v-for="page in meta.links" class="flex mx-4 gap-2">
                        <a @click.prevent="filter.page = page.label "
                           href="#" v-html="page.label"
                           v-bind:class="{'bg-gray-600 text-gray-50':page.active}"
                           class=" bg-transparent text-gray-700 dark:text-gray-200 font-semibold min-w-[40px] border border-gray-300 px-2 py-1 rounded-md focus:outline-none">

                        </a>
                    </div>
                    <button
                        class="bg-transparent text-gray-700 dark:text-gray-200 font-semibold border border-gray-300  px-2 py-1 rounded-md focus:outline-none dark:border-none">
                        <svg class="h-6 w-6  fill-current" viewBox="0 0 20 20">
                            <path d="M10 2l8 8-8 8-1.414-1.414L15.172 10l-6.586-6.586L10 2z"/>
                        </svg>
                    </button>
                    <span class="mx-4 dark:text-gray-400">Page</span>
                    <select v-model="filter.per_page"
                            class="border border-gray-300 rounded-md px-2 py-1 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>

                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
