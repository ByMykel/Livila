<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

                <review-card
                    v-for="review in reviews"
                    :key="review.id"
                    :review="review"
                    :showTitle="true"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";
import ReviewCard from "@/Components/ReviewCard";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        ReviewCard,
    },

    props: {
        user: Object,
        reviews: Object,
    },
};
</script>
