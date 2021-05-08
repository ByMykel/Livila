<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <!-- <welcome-card v-if="!$page.props.auth"></welcome-card> -->
                <welcome-card></welcome-card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import WelcomeCard from "@/Components/WelcomeCard";
export default {
    components: {
        AppLayout,
        WelcomeCard,
    },

    props: {},

    methods: {},
};
</script>
