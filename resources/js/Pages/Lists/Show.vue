<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-900 p-2 rounded-md shadow mb-5 relative overflow-hidden">
                    <div v-show="$page.props.auth.id === list.user_id" class="absolute p-1 top-0 right-0">
                        <a :href="route('lists.edit', list.id)">
                            <svg class="w-5 h-5 text-white hover:text-indigo-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>

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
