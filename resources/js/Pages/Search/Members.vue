<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <search-showcase
                    type="Lists"
                    :query="query"
                    :total-results="members.total"
                >
                    <user-card
                        v-for="member in members.data"
                        :key="member.id"
                        :user="member"
                    ></user-card>
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
import MoviesListCard from "@/Components/MoviesList/MoviesListCard";
import UserCard from "@/Components/Users/UserCard";

export default {
    components: {
        AppLayout,
        MoviesSearchShowcase,
        BasePagination,
        SearchShowcase,
        MoviesListCard,
        UserCard,
    },

    props: {
        query: String,
        members: Object,
        page: Object,
    },

    data() {
        return {
            showOptions: false,
        };
    },

    mounted() {
        document.title = `Search members - Livila`;
    },
};
</script>
