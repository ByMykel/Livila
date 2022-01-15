<template>
    <div
        class="relative p-3 mb-2 overflow-hidden text-white rounded-md shadow bg-black-300"
    >
        <div
            v-show="!isAuthUserReview && review.spoiler && !showSpoiler"
            class="absolute top-0 left-0 flex flex-col items-center justify-center w-full h-full bg-black-300"
        >
            <a
                v-show="showMovieTitleInSpoilerAlert"
                :href="route('movies.show', review.movie.id)"
                class="text-indigo-400 hover:underline"
                >Movie: {{ review.movie.title }} ({{ year }})</a
            >
            <div class="text-black-100">This review may contain spoilers.</div>
            <div
                class="cursor-pointer hover:underline"
                @click="showSpoiler = true"
            >
                Click to see spoiler
            </div>
        </div>

        <div
            v-show="isAuthUserReview || !review.spoiler || showSpoiler"
            class="absolute top-0 right-0 px-2 py-1 text-xs font-medium rounded-bl-md"
            :class="review.recommended ? 'bg-green-500' : 'bg-red-500'"
        >
            <span class="hidden sm:block">{{ isRecommended }}</span>

            <span class="block sm:hidden">
                <span v-if="!review.recommended">
                    <svg
                        class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"
                        ></path>
                    </svg>
                </span>

                <span v-else>
                    <svg
                        class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"
                        ></path>
                    </svg>
                </span>
            </span>
        </div>

        <div class="flex items-center">
            <img
                v-if="showTitle"
                class="w-8 rounded-md sm:w-10"
                :src="poster"
                alt=""
            />

            <img
                v-else
                class="w-8 rounded-full sm:w-10"
                :src="review.user.profile_photo_url"
                alt=""
            />

            <div class="ml-2 text-sm">
                <p>
                    Reviewed by
                    <a
                        class="font-medium hover:text-indigo-400"
                        :href="route('user', review.user.username)"
                    >
                        {{ review.user.username }}
                    </a>
                </p>

                <p class="text-xs text-black-100">
                    {{ review.created_at_human }}
                </p>
            </div>
        </div>

        <div class="my-2 text-sm">
            <h3
                v-show="showTitle"
                class="break-words hover:text-indigo-500 hover:underline"
            >
                <a :href="route('movies.show', review.movie.id)">
                    {{ review.movie.title }}
                </a>
            </h3>

            <p class="break-words text-black-100">{{ review.review }}</p>
        </div>

        <div class="flex text-base">
            <div class="inline-flex items-center">
                <svg
                    @click="like()"
                    class="inline-block w-5 h-5 cursor-pointer text-black-100 hover:text-red-400"
                    :class="{ 'text-red-500 hover:text-red-400': review.like }"
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

                <span class="ml-1">{{ review.likes_count }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        review: Object,
        showTitle: {
            default: false,
            type: Boolean,
        },
        showMovieTitleInSpoilerAlert: {
            default: false,
            type: Boolean,
        },
    },

    data() {
        return {
            showSpoiler: false,
        };
    },

    computed: {
        isAuthUserReview() {
            return (
                this.$page.props.auth &&
                this.$page.props.auth.id === this.review.user.id
            );
        },

        isRecommended() {
            return this.review.recommended ? "Recommended" : "Not Recommended";
        },

        poster() {
            if (this.review.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w780" +
                    this.review.movie.poster_path
                );
            }

            return "/images/placeholder.jpeg";
        },

        year() {
            return new Date(this.review.movie.release_date).getFullYear();
        },
    },

    methods: {
        like() {
            this.$inertia.post(
                route("movies.reviews.like", [
                    this.review.movie,
                    this.review.id,
                ]),
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
