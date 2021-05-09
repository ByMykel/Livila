<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <div
                        class="mt-4 mb-2 max-w-3xl text-2xl text-white mx-auto"
                    >
                        Collect, curate, and share. Lists are the perfect way to
                        group films.
                    </div>
                    <a
                        class="inline-flex items-center px-4 py-2 border-2 border-black-300 text-sm font-medium rounded-md text-white bg-black-400 hover:text-indigo-500"
                        :href="route('lists.create')"
                    >
                        Start your own list
                    </a>
                </div>

                <lists-navbar :selected="1"></lists-navbar>

                <movies-list-card
                    v-for="list in recentLists.data"
                    :key="list.id"
                    :movies-list="list"
                ></movies-list-card>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesListCard from "@/Components/MoviesListCard";
import ListsNavbar from "@/Components/ListsNavbar";
import BasePagination from "../../Components/BasePagination.vue";

export default {
    components: {
        AppLayout,
        MoviesListCard,
        ListsNavbar,
        BasePagination,
    },

    props: {
        recentLists: Object,
        page: Object,
    },
};
</script>
