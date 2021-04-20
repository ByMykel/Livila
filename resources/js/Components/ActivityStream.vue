<template>
    <div>
        <div class="mx-auto text-center text-white my-6">
            <h1 v-if="followActiveMembers" class="break-words">
                Welcome back, {{ $page.props.auth.username }}. Here’s what your
                friends have been watching…
            </h1>

            <div v-else>
                <h1>
                    Welcome back, {{ $page.props.auth.username }}. Here’s what
                    we’ve been watching…
                </h1>
                <h3 class="text-gray-300">
                    This homepage will become customized as you follow active
                    members.
                </h3>
            </div>
        </div>

        <activity-handler
            v-for="activity in activities"
            :key="activity.id"
            :activity="activity"
        ></activity-handler>
    </div>
</template>

<script>
import ActivityHandler from "@/Components/ActivityHandler";

export default {
    components: {
        ActivityHandler,
    },

    props: {
        followActiveMembers: Boolean,
        activities: Object,
    },
};
</script>