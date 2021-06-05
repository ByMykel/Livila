<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <user-details-card :user="user"></user-details-card>

                <user-card
                    v-for="member in followers"
                    :key="member.id"
                    :user="member"
                ></user-card>

                <div
                    v-if="!followers.length"
                    class="text-black-100 font-bold text-center"
                >
                    No followers yet
                </div>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "../../Components/UserDetailsCard.vue";
import UserCard from "../../Components/Users/UserCard.vue";
import BasePagination from "../../Components/BasePagination.vue";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        UserCard,
        BasePagination
    },

    props: {
        user: Object,
        followers: Object,
        page: Object,
    },
};
</script>
