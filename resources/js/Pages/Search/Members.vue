<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <search-showcase
                    type="Lists"
                    :query="query"
                    :total-results="members.total"
                >
                    <div
                        v-for="member in members.data"
                        :key="member.id"
                        class="bg-black-300 flex mb-2 rounded-md p-2 text-white"
                    >
                        <img
                            class="rounded-full w-12 h-12"
                            :src="member.profile_photo_url"
                        />
                        <div
                            class="flex items-center justify-between ml-3 w-full"
                        >
                            <div>
                                <a
                                    class="text-white hover:text-indigo-400"
                                    :href="route('user', member.username)"
                                >
                                    {{ member.username }}
                                </a>
                                <div class="text-black-100 text-sm">
                                    {{ member.followers_count }} followers
                                </div>
                            </div>
                            <div>
                                <user-follow-button
                                    :user="member"
                                ></user-follow-button>
                            </div>
                        </div>
                    </div>
                </search-showcase>

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesSearchShowcase from "@/Components/Movies/MoviesSearchShowcase";
import BasePagination from "@/Components/BasePagination";
import SearchShowcase from "@/Components/SearchShowcase";
import MoviesListCard from "@/Components/MoviesListCard";
import UserFollowButton from "@/Components/UserFollowButton";

export default {
    components: {
        AppLayout,
        MoviesSearchShowcase,
        BasePagination,
        SearchShowcase,
        MoviesListCard,
        UserFollowButton,
    },

    props: {
        query: String,
        members: Object,
        page: Object,
    },

    data() {
        return {
            showOptions: false,
        };
    },
};
</script>
