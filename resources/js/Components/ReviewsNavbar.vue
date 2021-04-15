<template>
    <div class="border-b border-gray-600 mt-5 mb-5 text-gray-400 flex px-1">
        <a
            :href="route('movies.reviews.index', movie.id)"
            class="hohover:border-b hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b': route().current(
                    'movies.reviews.index',
                    movie.id
                ),
            }"
            >Recent</a
        >
        <a
            :href="route('movies.reviews.popular', movie.id)"
            class="hover:border-b hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b': route().current(
                    'movies.reviews.popular',
                    movie.id
                ),
            }"
            >Popular</a
        >
        <a
            :href="route('movies.reviews.friends', movie.id)"
            class="hover:border-b hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b': route().current(
                    'movies.reviews.friends',
                    movie.id
                ),
            }"
            >Friends</a
        >
    </div>
</template>

<script>
export default {
    props: {
        movie: Object,
    },
};
</script>