<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <search-showcase
                    type="Lists"
                    :query="query"
                    :total-results="lists.total"
                >
                    <movies-list-card
                        v-for="list in lists.data"
                        :key="list.id"
                        :movies-list="list"
                    ></movies-list-card>
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
import MoviesListCard from "@/Components/MoviesListCard";

export default {
    components: {
        AppLayout,
        MoviesSearchShowcase,
        BasePagination,
        SearchShowcase,
        MoviesListCard,
    },

    props: {
        query: String,
        lists: Object,
        page: Object,
    },

    data() {
        return {
            showOptions: false,
        };
    },
};
</script>
