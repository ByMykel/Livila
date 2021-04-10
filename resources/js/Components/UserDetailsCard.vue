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
                    <button>Seguir</button>
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
};
</script>
