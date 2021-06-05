<template>
    <div class="mb-6">
        <div class="flex justify-between flex-col sm:flex-row">
            <div class="flex justify-center sm:justify-start">
                <div
                    v-show="showSkeletonProfilePhoto"
                    class="w-12 h-12 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-md bg-black-300 animate-pulse"
                ></div>
                <img
                    v-show="!showSkeletonProfilePhoto"
                    class="w-12 h-12 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-md"
                    :src="user.profile_photo_url"
                    @load="showSkeletonProfilePhoto = false"
                />

                <div class="ml-2">
                    <p class="test-base font-semibold text-white">
                        {{ user.username }}
                    </p>

                    <user-follow-button :user="user"></user-follow-button>
                </div>
            </div>

            <div
                class="flex text-sm sm:text-base text-black-100 space-x-3 justify-center sm:justify-end mt-4 sm:mt-0"
            >
                <a
                    class="flex flex-col justify-center items-center hover:text-indigo-300 cursor-pointer"
                    :href="route('user.watched', user)"
                >
                    <span class="font-bold">{{ user.watched_count }}</span>
                    <span>Watched</span>
                </a>
                <a
                    class="flex flex-col justify-center items-center hover:text-indigo-300 cursor-pointer"
                    :href="route('user.lists', user)"
                >
                    <span class="font-bold">{{ user.lists_movies_count }}</span>
                    <span>Lists</span>
                </a>
                <a
                    class="flex flex-col justify-center items-center hover:text-indigo-300 cursor-pointer"
                    :href="route('user.reviews', user)"
                >
                    <span class="font-bold">{{ user.reviews_count }}</span>
                    <span>Reviews</span>
                </a>
                <a
                    class="flex flex-col justify-center items-center hover:text-indigo-300 cursor-pointer"
                    :href="route('user.following', user)"
                >
                    <span class="font-bold">{{ user.following_count }}</span>
                    <span>Following</span>
                </a>
                <a
                    class="flex flex-col justify-center items-center hover:text-indigo-300 cursor-pointer"
                    :href="route('user.followers', user)"
                >
                    <span class="font-bold">{{ user.followers_count }}</span>
                    <span>Followers</span>
                </a>
            </div>
        </div>

        <div class="bg-black-300 mt-5 p-2 rounded">
            <div
                class="flex justify-around text-black-100 text-sm sm:text-base"
            >
                <a
                    :href="route('user', user.username)"
                    :class="[
                        route().current('user', user.username)
                            ? 'text-indigo-400'
                            : 'hover:text-white',
                    ]"
                    >Profile</a
                >
                <a
                    :href="route('user.watched', user.username)"
                    :class="[
                        route().current('user.watched', user.username)
                            ? 'text-indigo-400'
                            : 'hover:text-white',
                    ]"
                    >Watched</a
                >
                <a
                    :href="route('user.lists', user.username)"
                    :class="[
                        route().current('user.lists', user.username)
                            ? 'text-indigo-400'
                            : 'hover:text-white',
                    ]"
                    >Lists</a
                >
                <a
                    :href="route('user.likes.movies', user.username)"
                    :class="[
                        route().current('user.likes.movies', user.username) ||
                        route().current('user.likes.reviews', user.username) ||
                        route().current('user.likes.lists', user.username)
                            ? 'text-indigo-400'
                            : 'hover:text-white',
                    ]"
                    >Likes</a
                >
                <a
                    :href="route('user.reviews', user.username)"
                    :class="[
                        route().current('user.reviews', user.username)
                            ? 'text-indigo-400'
                            : 'hover:text-white',
                    ]"
                    >Reviews</a
                >
            </div>
        </div>
    </div>
</template>

<script>
import UserFollowButton from "@/Components/UserFollowButton";

export default {
    components: {
        UserFollowButton,
    },

    props: {
        user: Object,
    },

    data() {
        return {
            hoverButton: false,
            showSkeletonProfilePhoto: true,
        };
    },

    methods: {
        follow() {
            this.$inertia.post(
                route("user.follow", this.user),
                {},
                {
                    preserveState: false,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },
    },
};
</script>
