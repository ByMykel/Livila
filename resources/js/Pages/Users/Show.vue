<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 pb-72">
                <user-details-card :user="user"></user-details-card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";
import BasePagination from "@/Components/BasePagination";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        BasePagination,
    },

    props: {
        user: Object,
    },

    mounted() {
        document.title = `${this.user.username} user - Livila`;
    },
};
</script>
