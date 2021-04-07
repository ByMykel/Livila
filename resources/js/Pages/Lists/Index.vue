<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-900 rounded-md shadow p-2 text-white">
                    <movies-list-card
                        v-for="list in popularLists"
                        :key="list.id"
                        :movies-list="list"
                    ></movies-list-card>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesListCard from "@/Components/MoviesListCard";

export default {
    components: {
        AppLayout,
        MoviesListCard,
    },

    props: {
        popularLists: Object,
    },
};
</script>
