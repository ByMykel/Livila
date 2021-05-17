<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <search-showcase
                    type="Movies"
                    :query="query"
                    :total-results="movies.total_results"
                >
                    <movies-search-showcase
                        :movies="movies.results"
                    ></movies-search-showcase>
                </search-showcase>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesSearchShowcase from "@/Components/Movies/MoviesSearchShowcase";
import BasePagination from "@/Components/BasePagination";
import SearchShowcase from "@/Components/SearchShowcase";

export default {
    components: {
        AppLayout,
        MoviesSearchShowcase,
        BasePagination,
        SearchShowcase,
    },

    props: {
        query: String,
        movies: Object,
        page: Object,
    },

    data() {
        return {
            showOptions: false,
        };
    },
};
</script>
