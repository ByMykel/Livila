<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-black-300 p-2 rounded-md shadow mb-5 relative">
                    <div
                        v-show="
                            $page.props.auth &&
                            $page.props.auth.id === list.user_id
                        "
                        class="absolute p-1 top-0 right-0"
                    >
                        <a :href="route('lists.edit', list.id)">
                            <svg
                                class="w-5 h-5 text-white hover:text-indigo-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </a>
                    </div>

                    <h2 class="text-white break-words text-lg">
                        {{ list.name }}
                    </h2>
                    <p class="text-black-100 break-words mt-1">
                        {{ list.description }}
                    </p>

                    <div class="text-white mt-3 flex items-center flex-wrap">
                        <div class="flex items-center mr-4">
                            <svg
                                class="w-5 h-5 text-black-100 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>

                            <a
                                :href="route('user', list.user.username)"
                                class="text-sm hover:text-indigo-400"
                                >{{ list.user.username }}</a
                            >
                        </div>

                        <div class="flex items-center mr-4">
                            <svg
                                class="w-5 h-5 text-black-100 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"
                                ></path>
                            </svg>

                            <div class="text-sm">
                                {{ this.movies.length }}
                            </div>
                        </div>

                        <div
                            v-show="$page.props.auth"
                            class="flex items-center mr-4"
                            :title="watched"
                        >
                            <svg
                                class="w-5 h-5 text-black-100 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                ></path>
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                ></path>
                            </svg>

                            <div class="text-sm flex items-center">
                                {{ watchedMoviesCount }}
                            </div>
                        </div>

                        <div class="flex items-center" @click="like()">
                            <svg
                                class="w-5 h-5 text-black-100 mr-2 hover:text-red-400 cursor-pointer"
                                :class="{ 'text-red-500': list.like }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                ></path>
                            </svg>

                            <div class="text-sm">{{ list.likes_count }}</div>
                        </div>
                    </div>

                    <div
                        v-show="progressWatched && $page.props.auth"
                        class="text-center bg-black-400 rounded-sm mt-1 relative h-4"
                    >
                        <div
                            class="text-xs rounded-sm absolute top-0 h-4 flex items-center justify-center text-white"
                            :class="[
                                progressWatched === 100
                                    ? 'bg-green-500'
                                    : 'bg-indigo-500',
                            ]"
                            :style="progressWatchedStyle"
                        >
                            {{ progressWatched }}%
                        </div>
                    </div>
                </div>

                <movies-showcase :movies="movies"> </movies-showcase>

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
        list: Object,
        movies: Object,
        watchedMoviesCount: Number,
        page: Object,
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

    mounted() {
        document.title = `${this.list.name} list - Livila`;
    },

    methods: {
        like() {
            this.$inertia.post(
                route("lists.like", this.list.id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },
    },
};
</script>
