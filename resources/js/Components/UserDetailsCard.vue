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

                    <form
                        v-if="
                            $page.props.auth && $page.props.auth.id !== user.id
                        "
                        @submit.prevent="follow"
                    >
                        <button
                            v-if="!user.follow"
                            type="submit"
                            class="bg-gray-600 hover:bg-gray-500 px-3 py-0.5 rounded-sm shadow text-white font-bold"
                        >
                            Follow
                        </button>

                        <button
                            v-else
                            type="submit"
                            class="px-3 py-0.5 rounded-sm shadow text-white font-bold"
                            :class="[
                                hoverButton
                                    ? 'bg-red-700 hover:bg-red-600'
                                    : 'bg-green-700 hover:bg-green-600',
                            ]"
                            @mouseenter="hoverButton = true"
                            @mouseleave="hoverButton = false"
                        >
                            <span v-if="hoverButton">Unfollow</span>
                            <span v-else>Following</span>
                        </button>
                    </form>
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
                    :href="route('user.likes', user.username)"
                    :class="[
                        route().current('user.likes', user.username)
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
export default {
    components: {},

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
