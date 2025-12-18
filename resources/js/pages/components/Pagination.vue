<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    links: Array,
});

const previousLink = computed(() => {
    // Find the link that contains "Previous" in its label
    return props.links.find(
        (link) =>
            link.label &&
            (link.label.includes('Previous') ||
                link.label.includes('&laquo;') ||
                link.label.includes('«')),
    );
});

const nextLink = computed(() => {
    // Find the link that contains "Next" in its label
    return props.links.find(
        (link) =>
            link.label &&
            (link.label.includes('Next') ||
                link.label.includes('&raquo;') ||
                link.label.includes('»')),
    );
});
</script>
<template>
    <div class="flex items-center justify-center gap-3">
        <Link
            v-if="previousLink"
            :href="previousLink.url ?? ''"
            class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:border-sky-500/60 dark:hover:bg-sky-500/10 dark:hover:text-sky-300"
            :class="{
                'pointer-events-none opacity-50': !previousLink.url,
            }"
            :preserve-scroll="true"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
            <span>Previous</span>
        </Link>

        <Link
            v-if="nextLink"
            :href="nextLink.url ?? ''"
            class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:border-sky-500/60 dark:hover:bg-sky-500/10 dark:hover:text-sky-300"
            :class="{
                'pointer-events-none opacity-50': !nextLink.url,
            }"
            :preserve-scroll="true"
        >
            <span>Next</span>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </Link>
    </div>
</template>

<style></style>
