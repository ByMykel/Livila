<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

                <activity-handler
                    v-for="activity in activities"
                    :key="activity.id"
                    :activity="activity"
                ></activity-handler>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";
import ActivityHandler from "@/Components/Activity/ActivityHandler";
import BasePagination from "@/Components/BasePagination";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        ActivityHandler,
        BasePagination
    },

    props: {
        user: Object,
        activities: Object,
        page: Object
    },
};
</script>
