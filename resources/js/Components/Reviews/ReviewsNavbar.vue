<template>
    <div class="border-b border-black-300 mt-5 mb-5 text-black-100 flex px-1">
        <a
            :href="route('movies.reviews.index', movie.id)"
            class="hover:border-b hover:text-white px-3 border-black-100"
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
            class="hover:border-b hover:text-white px-3 border-black-100"
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
            class="hover:border-b hover:text-white px-3 border-black-100"
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