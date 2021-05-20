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
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                    clip-rule="evenodd"
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
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z"
                                    clip-rule="evenodd"
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
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M10 12a2 2 0 100-4 2 2 0 000 4z"
                                ></path>
                                <path
                                    fill-rule="evenodd"
                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                    clip-rule="evenodd"
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
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                    clip-rule="evenodd"
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
