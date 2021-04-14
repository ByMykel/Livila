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

        <div class="bg-gray-800 mt-5 p-2 rounded">
            <div class="flex justify-around text-gray-400">
                <a
                    :href="route('user', user.username)"
                    class="hover:text-white"
                    :class="{
                        'text-indigo-400': route().current(
                            'user',
                            user.username
                        ),
                    }"
                    >Profile</a
                >
                <a
                    :href="route('user.watched', user.username)"
                    class="hover:text-white"
                    :class="{
                        'text-indigo-400': route().current(
                            'user.watched',
                            user.username
                        ),
                    }"
                    >Watched</a
                >
                <a
                    :href="route('user.lists', user.username)"
                    class="hover:text-white"
                    :class="{
                        'text-indigo-400': route().current(
                            'user.lists',
                            user.username
                        ),
                    }"
                    >Lists</a
                >
                <a
                    :href="route('user.likes', user.username)"
                    class="hover:text-white"
                    :class="{
                        'text-indigo-400': route().current(
                            'user.likes',
                            user.username
                        ),
                    }"
                    >Likes</a
                >
                <a
                    :href="route('user.reviews', user.username)"
                    class="hover:text-white"
                    :class="{
                        'text-indigo-400': route().current(
                            'user.reviews',
                            user.username
                        ),
                    }"
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
