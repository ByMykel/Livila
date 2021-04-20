<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <welcome-card v-if="!$page.props.auth"></welcome-card>

                <activity-stream
                    v-else
                    :followActiveMembers="followActiveMembers"
                    :activities="activities"
                ></activity-stream>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/ReviewCard";
import WelcomeCard from "@/Components/WelcomeCard";
import ActivityStream from "@/Components/ActivityStream";

export default {
    components: {
        AppLayout,
        ReviewCard,
        WelcomeCard,
        ActivityStream,
    },

    props: {
        followActiveMembers: Boolean,
        activities: Object,
    },

    methods: {},
};
</script>
