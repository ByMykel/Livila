<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <cast-details-card :cast="actor"></cast-details-card>

                <div
                    class="mt-10 mb-2 text-black-100 px-1 font-semibold text-base"
                >
                    Movies
                </div>

                <movies-showcase :movies="movies"></movies-showcase>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesShowcase from "@/Components/Movies/MoviesShowcase";
import CastDetailsCard from "@/Components/Cast/CastDetailsCard";

export default {
    components: {
        AppLayout,
        CastDetailsCard,
        MoviesShowcase,
    },

    props: {
        actor: Object,
        movies: Object,
    },
};
</script>
