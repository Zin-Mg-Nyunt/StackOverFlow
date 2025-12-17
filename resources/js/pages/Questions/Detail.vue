<script setup>
import { Link } from '@inertiajs/vue3';
import formatTime from '../../composables/formatDate';

let { question, relatedQuestions } = defineProps({
    question: Object,
    relatedQuestions: Array,
});
console.log(relatedQuestions);
// Mock data for answers (replace with real data when backend is ready)
const answers = [
    {
        id: 1,
        body: 'This is a great solution! You can use the `useForm` helper from Inertia to handle form submissions. Make sure to include proper validation on the backend.',
        author: { name: 'John Doe' },
        votes: 12,
        created_at: '2024-01-15T10:30:00Z',
        isAccepted: true,
    },
    {
        id: 2,
        body: 'Another approach would be to use the Form component directly. It provides better integration with Inertia and handles errors automatically.',
        author: { name: 'Jane Smith' },
        votes: 8,
        created_at: '2024-01-15T11:45:00Z',
        isAccepted: false,
    },
];

// Mock tags for the question
const questionTags = ['inertiajs', 'vue3', 'laravel', 'forms', 'validation'];
</script>

<template>
    <div class="space-y-6">
        <!-- Question Header -->
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
                <h1
                    class="text-3xl leading-tight font-bold text-zinc-900 dark:text-zinc-50"
                >
                    {{ question.title }}
                </h1>
                <div class="mt-3 flex flex-wrap items-center gap-3">
                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                        Asked
                        <span
                            class="font-semibold text-zinc-700 dark:text-zinc-300"
                        >
                            {{ formatTime(question.created_at) }}
                        </span>
                    </span>
                    <span
                        class="h-1 w-1 rounded-full bg-zinc-300 dark:bg-zinc-600"
                    />
                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                        Modified
                        <span
                            class="font-semibold text-zinc-700 dark:text-zinc-300"
                        >
                            {{ formatTime(question.updated_at) }}
                        </span>
                    </span>
                    <span
                        class="h-1 w-1 rounded-full bg-zinc-300 dark:bg-zinc-600"
                    />
                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                        Viewed
                        <span
                            class="font-semibold text-zinc-700 dark:text-zinc-300"
                        >
                            1,234 times
                        </span>
                    </span>
                </div>
            </div>
            <button
                class="rounded-lg bg-gradient-to-r from-sky-500 via-indigo-500 to-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/30 transition hover:brightness-105"
            >
                Ask Question
            </button>
        </div>

        <!-- Question Content -->
        <div
            class="rounded-2xl border border-zinc-200 bg-white/90 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
        >
            <div class="flex gap-6 p-6">
                <!-- Voting Section -->
                <div class="flex w-16 shrink-0 flex-col items-center gap-4">
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-400"
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
                    <span
                        class="text-xl font-bold text-zinc-900 dark:text-zinc-50"
                    >
                        42
                    </span>
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-400"
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
                    <button
                        class="mt-2 flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-400 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-500 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-500"
                        title="Bookmark"
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
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"
                            />
                        </svg>
                    </button>
                    <button
                        class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-400 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-500 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-500"
                        title="Share"
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
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Question Body -->
                <div class="flex-1 space-y-4">
                    <div
                        class="prose prose-zinc dark:prose-invert prose-p:text-zinc-700 dark:prose-p:text-zinc-300 prose-code:text-sky-600 dark:prose-code:text-sky-400 max-w-none"
                    >
                        <p class="text-zinc-700 dark:text-zinc-300">
                            {{ question.body }}
                        </p>
                    </div>

                    <!-- Tags -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            v-for="tag in questionTags"
                            :key="tag"
                            class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700 transition hover:bg-sky-100 hover:text-sky-800 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20"
                        >
                            {{ tag }}
                        </span>
                    </div>

                    <!-- Question Actions -->
                    <div
                        class="flex flex-wrap items-center justify-between gap-4 border-t border-zinc-200 pt-4 dark:border-zinc-800"
                    >
                        <div class="flex flex-wrap items-center gap-4">
                            <button
                                class="text-sm text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                            >
                                Share
                            </button>
                            <button
                                class="text-sm text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                            >
                                Edit
                            </button>
                            <button
                                class="text-sm text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                            >
                                Follow
                            </button>
                        </div>

                        <!-- Author Info -->
                        <div
                            class="rounded-lg bg-sky-50/50 px-4 py-3 dark:bg-sky-500/5"
                        >
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                asked
                                <span
                                    class="font-semibold text-zinc-700 dark:text-zinc-300"
                                >
                                    {{ formatTime(question.created_at) }}
                                </span>
                            </p>
                            <div class="mt-2 flex items-center gap-2">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-sky-500 to-indigo-500 text-xs font-bold text-white"
                                >
                                    {{
                                        question.author?.name
                                            ?.slice(0, 2)
                                            .toUpperCase() || 'U'
                                    }}
                                </span>
                                <div>
                                    <p
                                        class="text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                                    >
                                        {{
                                            question.author?.name || 'Anonymous'
                                        }}
                                    </p>
                                    <p
                                        class="text-xs text-zinc-500 dark:text-zinc-400"
                                    >
                                        1,234 reputation
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Answers Section -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">
                    {{ answers.length }} Answers
                </h2>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">
                        Sorted by:
                    </span>
                    <select
                        class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-700 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:focus:border-sky-500 dark:focus:ring-sky-500/30"
                    >
                        <option>Highest score (default)</option>
                        <option>Trending (recent votes count more)</option>
                        <option>Date modified (newest first)</option>
                        <option>Date created (oldest first)</option>
                    </select>
                </div>
            </div>

            <!-- Answers List -->
            <div
                v-for="answer in answers"
                :key="answer.id"
                class="rounded-2xl border border-zinc-200 bg-white/90 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
                :class="{
                    'ring-2 ring-emerald-500/30 dark:ring-emerald-500/50':
                        answer.isAccepted,
                }"
            >
                <div class="flex gap-6 p-6">
                    <!-- Voting Section -->
                    <div class="flex w-16 shrink-0 flex-col items-center gap-4">
                        <button
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-400"
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
                        <span
                            class="text-xl font-bold text-zinc-900 dark:text-zinc-50"
                        >
                            {{ answer.votes }}
                        </span>
                        <button
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-400"
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
                        <div
                            v-if="answer.isAccepted"
                            class="mt-2 flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-500 text-white"
                            title="Accepted answer"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                    </div>

                    <!-- Answer Body -->
                    <div class="flex-1 space-y-4">
                        <div
                            class="prose prose-zinc dark:prose-invert prose-p:text-zinc-700 dark:prose-p:text-zinc-300 prose-code:text-sky-600 dark:prose-code:text-sky-400 max-w-none"
                        >
                            <p class="text-zinc-700 dark:text-zinc-300">
                                {{ answer.body }}
                            </p>
                        </div>

                        <!-- Answer Actions -->
                        <div
                            class="flex flex-wrap items-center justify-between gap-4 border-t border-zinc-200 pt-4 dark:border-zinc-800"
                        >
                            <div class="flex flex-wrap items-center gap-4">
                                <button
                                    class="text-sm text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                                >
                                    Share
                                </button>
                                <button
                                    class="text-sm text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                                >
                                    Edit
                                </button>
                                <button
                                    class="text-sm text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                                >
                                    Follow
                                </button>
                            </div>

                            <!-- Author Info -->
                            <div
                                class="rounded-lg bg-sky-50/50 px-4 py-3 dark:bg-sky-500/5"
                            >
                                <p
                                    class="text-xs text-zinc-500 dark:text-zinc-400"
                                >
                                    answered
                                    <span
                                        class="font-semibold text-zinc-700 dark:text-zinc-300"
                                    >
                                        {{ formatTime(answer.created_at) }}
                                    </span>
                                </p>
                                <div class="mt-2 flex items-center gap-2">
                                    <span
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-sky-500 to-indigo-500 text-xs font-bold text-white"
                                    >
                                        {{
                                            answer.author.name
                                                .slice(0, 2)
                                                .toUpperCase()
                                        }}
                                    </span>
                                    <div>
                                        <p
                                            class="text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                                        >
                                            {{ answer.author.name }}
                                        </p>
                                        <p
                                            class="text-xs text-zinc-500 dark:text-zinc-400"
                                        >
                                            5,678 reputation
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Answer Section -->
        <div
            class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
        >
            <h3 class="mb-4 text-xl font-bold text-zinc-900 dark:text-zinc-50">
                Your Answer
            </h3>
            <div class="space-y-4">
                <div>
                    <label
                        class="mb-2 block text-sm font-semibold text-zinc-700 dark:text-zinc-300"
                    >
                        Answer
                    </label>
                    <textarea
                        rows="10"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-50 dark:placeholder:text-zinc-600 dark:focus:border-sky-500 dark:focus:ring-sky-500/30"
                        placeholder="Enter your answer here. Use markdown formatting for code blocks, lists, and more."
                    ></textarea>
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                        Use markdown to format your answer. Code blocks are
                        supported.
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        class="rounded-lg bg-gradient-to-r from-sky-500 via-indigo-500 to-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/30 transition hover:brightness-105"
                    >
                        Post Your Answer
                    </button>
                    <button
                        class="rounded-lg border border-zinc-200 px-6 py-3 text-sm font-semibold text-zinc-700 transition hover:border-zinc-300 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800"
                    >
                        Preview
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Questions -->
        <div
            class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
        >
            <h3 class="mb-4 text-xl font-bold text-zinc-900 dark:text-zinc-50">
                Related Questions
            </h3>
            <div class="space-y-3">
                <Link
                    v-for="related in relatedQuestions"
                    :key="related.id"
                    :href="'/questions/' + related.id"
                    class="group flex items-center justify-between rounded-lg border border-zinc-200 p-4 transition hover:border-sky-300 hover:bg-sky-50/50 dark:border-zinc-700 dark:hover:border-sky-500/60 dark:hover:bg-sky-500/5"
                >
                    <span
                        class="flex-1 text-sm font-semibold text-zinc-900 transition group-hover:text-sky-600 dark:text-zinc-50 dark:group-hover:text-sky-400"
                    >
                        {{ related.title }}
                    </span>
                    <div
                        class="ml-4 flex items-center gap-3 text-xs text-zinc-500 dark:text-zinc-400"
                    >
                        <span
                            class="rounded-full bg-sky-50 px-2 py-1 font-semibold text-sky-600 dark:bg-sky-500/10 dark:text-sky-400"
                        >
                            {{ related.votes }} votes
                        </span>
                        <span
                            class="rounded-full bg-emerald-50 px-2 py-1 font-semibold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400"
                        >
                            {{ related.answers }} answers
                        </span>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
