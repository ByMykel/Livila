<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <movie-details-card
                    :movie="review[0].movie"
                    :review-page="true"
                ></movie-details-card>

                <review-card class="mt-8" :review="review[0]"></review-card>

                <div
                    class="border-b border-gray-600 mt-5 mb-2 text-white flex px-1"
                >
                    Comments
                </div>

                <comments-card-form
                    :movie="review[0].movie"
                    :review="review[0]"
                ></comments-card-form>

                <comments-card
                    v-for="comment in comments"
                    :key="comment.id"
                    :movie="review[0].movie"
                    :review="review[0]"
                    :comment="comment"
                ></comments-card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/ReviewCard";
import MovieDetailsCard from "@/Components/MovieDetailsCard";
import CommentsCard from "@/Components/CommentsCard";
import CommentsCardForm from "@/Components/CommentsCardForm";

export default {
    components: {
        AppLayout,
        ReviewCard,
        MovieDetailsCard,
        CommentsCard,
        CommentsCardForm,
    },

    props: {
        review: Object,
        comments: Object,
    },
};
</script>
