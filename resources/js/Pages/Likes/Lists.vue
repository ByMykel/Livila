<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

                <likes-navbar :user="user"></likes-navbar>

                <movies-list-card
                    v-for="list in lists"
                    :key="list.id"
                    :movies-list="list"
                ></movies-list-card>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";
import MoviesListCard from "@/Components/MoviesList/MoviesListCard";
import BasePagination from "@/Components/BasePagination";
import LikesNavbar from "@/Components/LikesNavbar";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        MoviesListCard,
        BasePagination,
        LikesNavbar,
    },

    props: {
        user: Object,
        lists: Object,
        page: Object,
    },

    mounted() {
        document.title = `${this.user.username} liked lists - Livila`;
    },
};
</script>
