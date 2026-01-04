<script setup>
import { router } from '@inertiajs/vue3';
import { inject } from 'vue';

let route = inject('route');
const { userVote, id } = defineProps({
    userVote: String,
    id: Number,
    type: String,
    upvotesCount: Number,
    downvotesCount: Number,
});

const votes = (value, votable_type, votable_id) => {
    let data = {
        votable_type,
        votable_id,
        value,
    };
    router.post(route('vote.store'), data, {
        preserveScroll: true,
    });
};
</script>
<template>
    <button
        class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-700 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-400"
        :class="
            userVote === 'upvote'
                ? 'bg-sky-200 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400'
                : 'bg-zinc-50 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'
        "
        @click="votes('upvote', type, id)"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 15l7-7 7 7"
            />
        </svg>
    </button>
    <span class="flex items-center justify-between gap-2">
        <span
            class="text-md flex flex-col items-center font-bold text-green-500 dark:text-green-700"
        >
            {{ upvotesCount }}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 24 24"
            >
                <!-- Icon from Material Design Icons by Pictogrammers - https://github.com/Templarian/MaterialDesign/blob/master/LICENSE -->
                <path
                    fill="currentColor"
                    d="M13 20h-2V8l-5.5 5.5l-1.42-1.42L12 4.16l7.92 7.92l-1.42 1.42L13 8z"
                />
            </svg>
        </span>
        <span
            class="text-md flex flex-col items-center font-bold text-red-500 dark:text-red-700"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 24 24"
            >
                <!-- Icon from Material Design Icons by Pictogrammers - https://github.com/Templarian/MaterialDesign/blob/master/LICENSE -->
                <path
                    fill="currentColor"
                    d="M11 4h2v12l5.5-5.5l1.42 1.42L12 19.84l-7.92-7.92L5.5 10.5L11 16z"
                />
            </svg>
            {{ downvotesCount }}
        </span>
    </span>
    <button
        class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-700 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-400"
        :class="
            userVote === 'downvote'
                ? 'bg-sky-200 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400'
                : 'bg-zinc-50 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'
        "
        @click="votes('downvote', type, id)"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
            />
        </svg>
    </button>
</template>

<style></style>
