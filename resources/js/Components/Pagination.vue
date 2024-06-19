<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
});

function decodeHtmlEntity(text) {
    const textArea = document.createElement('textarea');
    textArea.innerHTML = text;
    return textArea.value;
}

</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex justify-center mb-1">
            <template v-for="(link,id) in links" :key="id">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                >
                    {{ decodeHtmlEntity(link.label) }}
                </div>
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-yellow-400 focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-blue-700 text-white hover:bg-blue-600': link.active }"
                    :href="link.url"
                >
                    {{ decodeHtmlEntity(link.label) }}
                </Link>
            </template>
        </div>
    </div>
</template>