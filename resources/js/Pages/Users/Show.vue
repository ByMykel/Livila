<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
    },

    props: {
        user: Object,
        reviews: Object,
        lists: Object,
        watched: Object,
    },
};
</script>
