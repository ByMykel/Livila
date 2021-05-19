<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

                <likes-navbar :user="user"></likes-navbar>

                <review-card
                    v-for="review in reviews"
                    :key="review.id"
                    :review="review"
                    :showTitle="true"
                    showMovieTitleInSpoilerAlert
                />

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";
import ReviewCard from "@/Components/Reviews/ReviewCard";
import BasePagination from "@/Components/BasePagination";
import LikesNavbar from "@/Components/LikesNavbar";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        ReviewCard,
        BasePagination,
        LikesNavbar,
    },

    props: {
        user: Object,
        reviews: Object,
        page: Object,
    },
};
</script>
