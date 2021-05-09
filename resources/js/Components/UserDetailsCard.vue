<template>
    <div class="mb-6">
        <div class="flex justify-between">
            <div class="flex">
                <img
                    class="w-28 rounded-md"
                    :src="user.profile_photo_url"
                    alt=""
                />

                <div class="ml-2">
                    <p class="text-xl font-semibold text-white">
                        {{ user.username }}
                    </p>

                    <user-follow-button :user="user"></user-follow-button>
                </div>
            </div>
        </div>

        <div class="bg-black-300 mt-5 p-2 rounded">
            <div class="flex justify-around text-black-100">
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
