<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

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
import MoviesListCard from "@/Components/MoviesListCard";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        MoviesListCard
    },
    
    props: {
        user: Object,
        lists: Object,
    },
};
</script>
