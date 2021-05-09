<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <activity-stream
                    :followActiveMembers="followActiveMembers"
                    :activities="activities"
                ></activity-stream>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ActivityStream from "@/Components/ActivityStream";
import BasePagination from "@/Components/BasePagination";

export default {
    components: {
        AppLayout,
        ActivityStream,
        BasePagination
    },

    props: {
        followActiveMembers: Boolean,
        activities: Object,
        page: Object
    },
};
</script>
