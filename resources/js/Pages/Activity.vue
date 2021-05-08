<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <activity-stream
                    :followActiveMembers="followActiveMembers"
                    :activities="activities"
                ></activity-stream>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ActivityStream from "@/Components/ActivityStream";

export default {
    components: {
        AppLayout,
        ActivityStream,
    },

    props: {
        followActiveMembers: Boolean,
        activities: Object,
    },
};
</script>
