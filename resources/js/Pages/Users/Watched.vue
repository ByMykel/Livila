<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

                <movies-showcase
                    :movies="watched"
                    :isUser="isUser"
                ></movies-showcase>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";
import MoviesShowcase from "@/Components/Movies/MoviesShowcase";
import BasePagination from "@/Components/BasePagination";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        MoviesShowcase,
        BasePagination,
    },

    props: {
        user: Object,
        watched: Object,
        page: Object,
    },

    computed: {
        isUser() {
            if (!this.$page.props.auth) return false;

            return this.$page.props.auth.id === this.user.id;
        },
    },
};
</script>
