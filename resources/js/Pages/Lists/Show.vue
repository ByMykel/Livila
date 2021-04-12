<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center mb-1">
                    <a
                        class="inline-flex items-center px-4 py-2 border border-gray-900 text-sm font-medium rounded-md text-white bg-gray-800 hover:text-indigo-500"
                        :href="route('lists.edit', list.id)"
                    >
                        Edit your list
                    </a>
                </div>

                <div class="bg-gray-900 p-2 rounded-md shadow text-white mb-5">
                    <h2 class="text-indigo-400">{{ list.name }}</h2>
                    <p class="break-words mt-2">{{ list.description }}</p>
                    <p>{{ watched }}</p>
                </div>

                <movies-showcase :movies="movies"> </movies-showcase>
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
        MoviesShowcase,
    },

    props: {
        list: Object,
        movies: Object,
        watchedMoviesCount: Number,
    },

    computed: {
        watched() {
            return `You’ve watched ${this.watchedMoviesCount} of ${this.movies.length}`;
        },
    },
};
</script>
