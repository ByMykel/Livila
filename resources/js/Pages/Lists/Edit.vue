<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <movies-list-form
                    :editing="true"
                    :list="list"
                    :movies="movies"
                ></movies-list-form>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MoviesListForm from "@/Components/MoviesList/MoviesListForm";

export default {
    components: {
        AppLayout,
        MoviesListForm,
    },

    props: {
        list: Object,
        movies: Object,
    },

    mounted() {
        document.title = `Edit ${this.list.name} - Livila`;
    },
};
</script>
