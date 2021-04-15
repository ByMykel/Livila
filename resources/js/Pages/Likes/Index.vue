<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

                <div
                    class="border-b border-gray-600 mt-5 mb-2 text-white flex px-1"
                >
                    <a
                        :href="route('user.likes.movies', user.username)"
                        class="hover:text-indigo-400"
                        >{{ user.username }}'s liked movies</a
                    >
                </div>

                <movies-showcase :movies="movies" :all="false" />

                <div
                    class="border-b border-gray-600 mt-5 mb-2 text-white flex px-1"
                >
                    <a
                        :href="route('user.likes.reviews', user.username)"
                        class="hover:text-indigo-400"
                        >{{ user.username }}'s liked reviews</a
                    >
                </div>

                <review-card
                    v-for="review in reviews"
                    :key="review.id"
                    :review="review"
                    :showTitle="true"
                />

                <div
                    class="border-b border-gray-600 mt-5 mb-2 text-white flex px-1"
                >
                    <a
                        :href="route('user.likes.lists', user.username)"
                        class="hover:text-indigo-400"
                        >{{ user.username }}'s liked lists</a
                    >
                </div>

                <movies-list-card
                    v-for="list in lists"
                    :key="list.id"
                    :movies-list="list"
                ></movies-list-card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";
import DescriptionCard from "@/Components/DescriptionCard";
import MoviesShowcase from "@/Components/MoviesShowcase";
import ReviewCard from "@/Components/ReviewCard";
import MoviesListCard from "@/Components/MoviesListCard";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        DescriptionCard,
        MoviesShowcase,
        ReviewCard,
        MoviesListCard,
    },

    props: {
        user: Object,
        lists: Object,
        reviews: Object,
        movies: Object,
    },
};
</script>
