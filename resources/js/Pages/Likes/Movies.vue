<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <user-details-card :user="user"></user-details-card>

                <div
                    class="border-b border-gray-800 mt-5 p-1 flex justify-between mb-5"
                >
                    <div class="text-gray-400">
                        <a
                            :href="route('user.likes.movies', user.username)"
                            class="hover:text-white mr-3"
                            :class="{
                                'text-indigo-400': route().current(
                                    'user.likes.movies',
                                    user.username
                                ),
                            }"
                            >Movies</a
                        >
                        <a
                            :href="route('user.likes.reviews', user.username)"
                            class="hover:text-white mr-3"
                            :class="{
                                'text-indigo-400': route().current(
                                    'user.likes.reviews',
                                    user.username
                                ),
                            }"
                            >Reviews</a
                        >
                        <a
                            :href="route('user.likes.lists', user.username)"
                            class="hover:text-white mr-3"
                            :class="{
                                'text-indigo-400': route().current(
                                    'user.likes.lists',
                                    user.username
                                ),
                            }"
                            >Lists</a
                        >
                    </div>
                </div>

                <movies-showcase :movies="movies" />

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetailsCard from "@/Components/UserDetailsCard";
import MoviesShowcase from "@/Components/MoviesShowcase";
import BasePagination from "@/Components/BasePagination";

export default {
    components: {
        AppLayout,
        UserDetailsCard,
        MoviesShowcase,
        BasePagination
    },
    
    props: {
        user: Object,
        movies: Object,
        page: Object
    },
};
</script>
