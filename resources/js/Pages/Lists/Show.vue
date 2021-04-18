<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <!-- <div class="flex justify-center mb-2">
                    <a
                        class="inline-flex items-center px-4 py-2 border border-gray-900 text-sm font-medium rounded-md text-white bg-gray-800 hover:text-indigo-500"
                        :href="route('lists.edit', list.id)"
                    >
                        Edit your list
                    </a>
                </div> -->

                <div class="bg-gray-900 p-2 rounded-md shadow mb-5">
                    <h2 class="text-white break-words text-lg">
                        {{ list.name }}
                    </h2>
                    <p class="text-gray-400 break-words mt-1">
                        {{ list.description }}
                    </p>

                    <p class="text-white text-sm mt-3">{{ watched }}</p>

                    <div
                        class="text-center bg-gray-800 rounded-sm mt-1 relative h-4"
                    >
                        <div
                            class="text-xs rounded-sm absolute top-0 h-4 flex items-center justify-center text-white"
                            :class="[
                                progressWatched === 100
                                    ? 'bg-green-500'
                                    : 'bg-indigo-500',
                                [progressWatched ? '' : 'ml-4'],
                            ]"
                            :style="progressWatchedStyle"
                        >
                            {{ progressWatched }}%
                        </div>
                    </div>
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

        progressWatchedStyle() {
            return "width: " + this.progressWatched + "%";
        },

        progressWatched() {
            return this.movies.length
                ? parseInt(
                      (parseInt(this.watchedMoviesCount) /
                          parseInt(this.movies.length)) *
                          100
                  )
                : 0;
        },
    },
};
</script>
