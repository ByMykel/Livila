<template>
    <div
        v-show="video"
        class="bg-black-300 p-2 rounded-md shadow my-5 relative"
    >
        <iframe
            height="480"
            class="mx-auto w-full rounded-md shadow"
            :src="src"
            :title="video.name"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
        ></iframe>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        videos: Object,
    },

    computed: {
        video() {
            for (let video of this.videos) {
                if (video.site === "YouTube") {
                    return video;
                }
            }

            return false;
        },

        src() {
            return "https://www.youtube.com/embed/" + this.video.key;
        },
    },
};
</script>
