<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="my-2">
                    <movies-showcase :movies="popular.results" />

                    <div class="flex justify-between my-4">
                        <a :href="previousPage" class="bg-indigo-500">Previous</a>
                        <span>{{ page }}</span>
                        <a :href="nextPage" class="bg-indigo-500">Next</a>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesShowcase from "@/Components/MoviesShowcase";

export default {
    components: {
        AppLayout,
        MoviesShowcase
    },

    props: {
        popular: Object,
        page: Object
    },

    computed: {
        previousPage() {
            return '?page=' + ((this.page.actual > 1) ? this.page.actual - 1 : this.page.actual);
        },

        nextPage() {
            return '?page=' + ((this.page.actual < this.page.last)  ? (this.page.actual + 1) : this.page.actual);
        }
    },

    methods: {
    },
};
</script>
