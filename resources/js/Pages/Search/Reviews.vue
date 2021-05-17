<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <search-showcase
                    type="Reviews"
                    :query="query"
                    :total-results="reviews.total"
                >
                    <review-card
                        v-for="review in reviews.data"
                        :key="review.id"
                        :review="review"
                        showTitle
                    ></review-card>
                </search-showcase>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesSearchShowcase from "@/Components/Movies/MoviesSearchShowcase";
import BasePagination from "@/Components/BasePagination";
import SearchShowcase from "@/Components/SearchShowcase";
import ReviewCard from '../../Components/ReviewCard.vue';

export default {
    components: {
        AppLayout,
        MoviesSearchShowcase,
        BasePagination,
        SearchShowcase,
        ReviewCard,
    },

    props: {
        query: String,
        reviews: Object,
        page: Object,
    },

    data() {
        return {
            showOptions: false,
        };
    },
};
</script>
