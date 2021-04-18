<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <welcome-card v-if="!$page.props.auth"></welcome-card>

                <activity-base
                    v-else
                    :followActiveMembers="followActiveMembers"
                    :activities="activities"
                ></activity-base>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/ReviewCard";
import WelcomeCard from "@/Components/WelcomeCard";
import ActivityBase from "@/Components/ActivityBase";

export default {
    components: {
        AppLayout,
        ReviewCard,
        WelcomeCard,
        ActivityBase,
    },

    props: {
        followActiveMembers: Boolean,
        activities: Object,
    },

    methods: {},
};
</script>
