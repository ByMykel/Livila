<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <a
                        class="inline-flex items-center px-4 py-2 border border-gray-900 text-sm font-medium rounded-md text-white bg-gray-800 hover:text-indigo-500"
                        :href="route('lists.create')"
                    >
                        Start your own list
                    </a>
                </div>

                <movies-list-card
                    v-for="list in popularLists"
                    :key="list.id"
                    :movies-list="list"
                ></movies-list-card>
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
