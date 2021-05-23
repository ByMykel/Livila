<template>
    <div
        v-show="video"
        class="bg-black-300 p-2 rounded-md shadow my-5 relative mt-10"
    >
        <iframe
            height="480"
            class="mx-auto w-full rounded-md shadow h-64 sm:h-80 md:h-106 lg:h-122"
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
