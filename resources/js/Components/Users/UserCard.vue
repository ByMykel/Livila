<template>
    <div class="bg-black-300 flex mb-2 rounded-md p-2 text-white">
        <img class="rounded-full w-12 h-12" :src="user.profile_photo_url" />
        <div class="flex items-center justify-between ml-3 w-full">
            <div>
                <a
                    class="text-white hover:text-indigo-400"
                    :href="route('user', user.username)"
                >
                    {{ user.username }}
                </a>
                <div class="text-black-100 text-sm">
                    {{ user.followers_count }} followers
                </div>
            </div>
            <div>
                <user-follow-button :user="user"></user-follow-button>
            </div>
        </div>
    </div>
</template>

<script>
import UserFollowButton from "@/Components/UserFollowButton";

export default {
    components: {
        UserFollowButton
    },

    props: {
        user: Object,
    },
};
</script>