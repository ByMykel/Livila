<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <movie-details-card
                    :movie="movie"
                    hideBackdrop
                ></movie-details-card>

                <div
                    class="mt-10 mb-2 text-black-100 px-1 font-semibold text-base"
                >
                    Cast
                </div>

                <cast-showcase :castMembers="castMembers"></cast-showcase>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import CastShowcase from "@/Components/Cast/CastShowcase";
import MovieDetailsCard from "@/Components/Movies/MovieDetailsCard";

export default {
    components: {
        AppLayout,
        CastShowcase,
        MovieDetailsCard,
    },

    props: {
        movie: Object,
        castMembers: Object,
    },
};
</script>
