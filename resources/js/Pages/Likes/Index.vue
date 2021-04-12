<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

                <description-card
                    v-show="movies.length >= 5"
                    :title="user.username + '\'s liked movies'"
                    :description="
                        'These are the latest movies liked by ' + user.username
                    "
                    :url="route('user.likes.movies', user.username)"
                >
                    <movies-showcase :movies="movies" :all="false" />
                </description-card>

                <description-card
                    v-show="movies.length >= 5"
                    :title="user.username + '\'s liked reviews'"
                    :description="
                        'These are the latest reviews liked by ' + user.username
                    "
                    :url="route('user.likes.reviews', user.username)"
                >
                    <review-card
                        v-for="review in reviews"
                        :key="review.id"
                        :review="review"
                        :showTitle="true"
                    />
                </description-card>

                <description-card
                    v-show="movies.length >= 5"
                    :title="user.username + '\'s liked lists'"
                    :description="
                        'These are the latest lists liked by ' + user.username
                    "
                    :url="route('user.likes.lists', user.username)"
                >
                    <movies-list-card
                        v-for="list in lists"
                        :key="list.id"
                        :movies-list="list"
                    ></movies-list-card>
                </description-card>
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
