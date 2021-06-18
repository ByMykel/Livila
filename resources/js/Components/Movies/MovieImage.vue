<template>
    <div class="mb-1 pb-4 flex flex-col justify-between h-full">
        <div
            class="relative"
            @mouseenter="show = true"
            @mouseleave="show = false"
        >
            <transition
                enter-active-class="transition ease-out duration-150"
                enter-from-class="transform opacity-0"
                enter-to-class="transform opacity-100"
                leave-active-class="transition ease-in duration-100"
                leave-from-class="transform opacity-100"
                leave-to-class="transform opacity-0"
            >
                <a
                    v-show="show || (movie.watched && !isUser)"
                    :href="route('movies.show', movie.id)"
                    class="
                        absolute
                        w-full
                        h-full
                        cursor-pointer
                        bg-black-400 bg-opacity-70
                        rounded
                    "
                ></a>
            </transition>
            <transition
                enter-active-class="transition ease-out duration-150"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-100"
                leave-from-class="transform opacity-100"
                leave-to-class="transform opacity-0"
            >
                <a
                    v-show="show"
                    :href="route('movies.show', movie.id)"
                    class="absolute w-full h-full cursor-pointer rounded"
                    :class="[show ? 'border-2 border-indigo-500' : '']"
                ></a>
            </transition>
            <button
                v-show="show && $page.props.auth"
                class="absolute left-1 top-1 focus:outline-none"
                @click="like()"
            >
                <svg
                    class="
                        hidden
                        sm:block
                        w-5
                        h-5
                        hover:text-blue-500
                        text-gray-400
                    "
                    :class="{ 'text-red-500': movie.liked }"
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
            </button>
            <button
                v-show="show && $page.props.auth"
                class="absolute right-1 top-1 focus:outline-none"
                @click="watch()"
            >
                <svg
                    class="
                        hidden
                        sm:block
                        w-5
                        h-5
                        hover:text-blue-500
                        text-gray-400
                    "
                    :class="{ 'text-green-500': movie.watched }"
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
            </button>
            <div
                v-show="showSkeletonImage"
                class="bg-black-300 h-44 w-full shadow rounded animate-pulse"
            ></div>
            <img
                v-show="!showSkeletonImage"
                class="max-h-48 w-full shadow rounded"
                :src="poster"
                @load="showSkeletonImage = false"
            />
        </div>
        <div>
            <p
                :title="movie.title"
                :class="{ 'opacity-40': movie.watched && !isUser }"
                class="truncate text-white text-sm font-semibold"
            >
                {{ movie.title }}
            </p>
            <p
                :title="movie.release_date"
                :class="{ 'opacity-40': movie.watched && !isUser }"
                class="truncate text-gray-400 text-xs"
            >
                {{ year }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        movie: Object,
        isUser: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            show: false,
            showSkeletonImage: true,
        };
    },

    computed: {
        poster() {
            if (this.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w500" + this.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },

        year() {
            if (!this.movie.release_date) return "UNKNOWN";

            return new Date(this.movie.release_date).getFullYear();
        },
    },

    methods: {
        like() {
            this.movie.liked = !this.movie.liked;

            this.$inertia.post(
                route("movies.like", this.movie.id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },

        watch() {
            this.movie.watched = !this.movie.watched;

            this.$inertia.post(
                route("movies.watch", this.movie.id),
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
