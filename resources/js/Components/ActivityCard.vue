<template>
    <div class="bg-gray-900 rounded-md shadow p-2 text-white mb-2">
        <div
            class="flex items-center justify-between bg-gray-800 rounded-md p-1"
            :class="{ 'mb-2' : $slots['content'] }"
        >
            <div class="flex items-center text-sm sm:text-base">
                <slot name="icon"></slot>

                <slot name="title"></slot>
            </div>

            <div class="hidden sm:block text-xs text-gray-400 mr-2">
                <slot name="date"></slot>
            </div>
        </div>

        <slot name="content"></slot>
    </div>
</template>

<script>
export default {};
</script>