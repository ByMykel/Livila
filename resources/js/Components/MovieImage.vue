<template>
    <div>
        <title-image :title="movie.title" :show="show" />

        <a
            v-if="border"
            @mouseenter="show = true"
            @mouseleave="show = false"
            :href="route('movies.show', movie.id)"
        >
            <img
                class="duration-100 rounded-sm border-2 hover:border-indigo-500"
                :src="poster"
            />
        </a>

        <a
            v-else
            @mouseenter="show = true"
            @mouseleave="show = false"
            :href="route('movies.show', movie.id)"
        >
            <img
                class="duration-100 max-h-48 object-cover shadow rounded-md hover:border-2 hover:border-indigo-500"
                :src="poster"
            />
        </a>
    </div>
</template>

<script>
import TitleImage from "@/Components/TitleImage";

export default {
    components: {
        TitleImage,
    },

    props: {
        movie: Object,
        border: {
            default: true,
            type: Boolean,
        },
    },

    data() {
        return {
            show: false,
        };
    },

    computed: {
        poster() {
            if (this.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w300" + this.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>
