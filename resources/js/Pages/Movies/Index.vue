<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <movies-showcase :movies="popular.results" />

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesShowcase from "@/Components/Movies/MoviesShowcase";
import BasePagination from "@/Components/BasePagination";

export default {
    components: {
        AppLayout,
        MoviesShowcase,
        BasePagination,
    },

    props: {
        popular: Object,
        page: Object,
    },
};
</script>
