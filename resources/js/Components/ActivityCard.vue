<template>
    <div class="bg-black-300 rounded-md shadow p-2 text-white mb-2">
        <div
            class="flex items-center justify-between bg-black-400 rounded-md p-1"
            :class="{ 'mb-2' : $slots['content'] }"
        >
            <div class="flex items-center text-sm sm:text-base">
                <slot name="icon"></slot>

                <slot name="title"></slot>
            </div>

            <div class="hidden sm:block text-xs text-black-100 mr-2">
                <slot name="date"></slot>
            </div>
        </div>

        <slot name="content"></slot>
    </div>
</template>

<script>
export default {};
</script>