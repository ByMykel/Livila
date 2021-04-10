<template>
    <div class="flex-1 flex justify-between mt-5 items-center">
        <div class="hidden sm:block w-full text-sm text-white">
            Showing page
            <span class="font-medium">{{ page.actual }}</span>
            of
            <span class="font-medium">{{ page.last }}</span>
        </div>

        <div class="flex justify-between w-full sm:justify-end">
            <a
                :href="previousPage"
                class="relative inline-flex items-center px-4 py-2 border border-gray-900 text-sm font-medium rounded-md text-white bg-gray-800 hover:text-indigo-500"
            >
                Previous
            </a>
            <a
                :href="nextPage"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-900 text-sm font-medium rounded-md text-white bg-gray-800 hover:text-indigo-500"
            >
                Next
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        page: Object,
    },

    computed: {
        previousPage() {
            return (
                "?page=" +
                (this.page.actual > 1 ? this.page.actual - 1 : this.page.actual)
            );
        },

        nextPage() {
            return (
                "?page=" +
                (this.page.actual < this.page.last
                    ? this.page.actual + 1
                    : this.page.actual)
            );
        },
    },
};
</script>
