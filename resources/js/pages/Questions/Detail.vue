<script setup>
import InputError from '@/components/InputError.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { inject } from 'vue';
import formatTime from '../../composables/formatDate';
import Pagination from '../components/Pagination.vue';
import Vote from '../components/Vote.vue';

const route = inject('route');
let { question, answers, relatedQuestions } = defineProps({
    question: Object,
    userVote: String,
    answers: Object,
    relatedQuestions: Array,
});
const answerForm = useForm({
    body: '',
});
const submitAnswer = () => {
    answerForm.post(route('answer.store', question.id), {
        preserveScroll: true,
        onSuccess: () => {
            answerForm.reset();
        },
    });
};
const sortAnswers = (value) => {
    router.get(
        route('questions.detail', question.id),
        {
            sort: value,
        },
        {
            preserveScroll: true,
        },
    );
};
const votes = (value, votable_type, votable_id) => {
    let data = {
        votable_type,
        votable_id,
        value,
    };
    router.post(route('vote.store', data), {
        preserveScroll: true,
    });
};
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
            <Link
                :href="route('questions.create')"
                class="rounded-lg bg-gradient-to-r from-sky-500 via-indigo-500 to-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/30 transition hover:brightness-105"
            >
                Ask Question
            </Link>
        </div>

        <!-- Question Content -->
        <div
            class="rounded-2xl border border-zinc-200 bg-white/90 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
        >
            <!-- Question Image -->
            <div v-if="question.image_url" class="p-6">
                <div
                    class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800/50"
                >
                    <img
                        :src="question.image_url"
                        :alt="question.title"
                        class="h-auto w-full object-cover transition-transform group-hover:scale-[1.02]"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity group-hover:opacity-100"
                    ></div>
                </div>
            </div>
            <div class="flex gap-6 p-6">
                <!-- Voting Section -->
                <div class="flex w-16 shrink-0 flex-col items-center gap-4">
                    <Vote
                        @votes="(value, type, id) => votes(value, type, id)"
                        :userVote="userVote"
                        :id="question.id"
                        type="question"
                        :upvotesCount="question.upvotes_count"
                        :downvotesCount="question.downvotes_count"
                    />
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
                            v-for="tag in question.tags"
                            :key="tag.id"
                            class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700 transition hover:bg-sky-100 hover:text-sky-800 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20"
                        >
                            {{ tag.name }}
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
                <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-50">
                    {{ answers.data?.length }} of {{ answers.total }} Answers
                </h2>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">
                        Sorted by:
                    </span>
                    <select
                        :value="$page.props.sort ?? 'highest_score'"
                        @change="sortAnswers($event.target.value)"
                        class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-700 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:focus:border-sky-500 dark:focus:ring-sky-500/30"
                    >
                        <option value="highest_score">
                            Highest score (default)
                        </option>
                        <option value="trending">
                            Trending (recent votes count more)
                        </option>
                        <option value="latest">
                            Date modified (newest first)
                        </option>
                        <option value="oldest">
                            Date created (oldest first)
                        </option>
                    </select>
                </div>
            </div>

            <!-- Answers List -->
            <div
                v-for="answer in answers.data"
                :key="answer.id"
                :id="'answer-' + answer.id"
                class="rounded-2xl border border-zinc-200 bg-white/90 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
            >
                <div class="flex gap-6 p-6">
                    <!-- Voting Section -->
                    <div class="flex w-16 shrink-0 flex-col items-center gap-4">
                        <Vote
                            @votes="(value, type, id) => votes(value, type, id)"
                            :userVote="answer.userVote"
                            :id="answer.id"
                            type="answer"
                            :upvotesCount="answer.upvotes_count"
                            :downvotesCount="answer.downvotes_count"
                        />
                    </div>
                    <!-- 
                        userVote: String,
                        id: Number,
                        type: String,
                        upvotesCount: Number,
                        downvotesCount: Number,
                    -->

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
                                            answer.author?.name
                                                .slice(0, 2)
                                                .toUpperCase()
                                        }}
                                    </span>
                                    <div>
                                        <p
                                            class="text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                                        >
                                            {{
                                                answer.author?.name ||
                                                'Anonymous'
                                            }}
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
            <div
                class="mt-4 flex justify-end"
                v-if="answers.total > answers.data.length"
            >
                <Pagination :links="answers.links" />
            </div>
        </div>

        <!-- Your Answer Section -->
        <div
            v-if="$page.props.auth.user"
            class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
        >
            <h3 class="mb-4 text-xl font-bold text-zinc-900 dark:text-zinc-50">
                Your Answer
            </h3>
            <form @submit.prevent="submitAnswer" class="space-y-4">
                <div>
                    <label
                        class="mb-2 block text-sm font-semibold text-zinc-700 dark:text-zinc-300"
                    >
                        Answer
                    </label>
                    <textarea
                        v-model="answerForm.body"
                        rows="10"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-50 dark:placeholder:text-zinc-600 dark:focus:border-sky-500 dark:focus:ring-sky-500/30"
                        placeholder="Enter your answer here. Use markdown formatting for code blocks, lists, and more."
                    ></textarea>
                    <InputError :message="answerForm.errors.body" />
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                        Use markdown to format your answer. Code blocks are
                        supported.
                    </p>
                </div>
                <div class="flex items-center justify-end gap-4">
                    <button
                        type="submit"
                        class="cursor-pointer rounded-lg bg-gradient-to-r from-sky-500 via-indigo-500 to-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/30 transition hover:brightness-105"
                    >
                        Post Your Answer
                    </button>
                </div>
            </form>
        </div>

        <!-- Related Questions -->
        <div
            class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
        >
            <h3 class="mb-4 text-xl font-bold text-zinc-900 dark:text-zinc-50">
                Related Questions
            </h3>
            <div class="space-y-3" v-if="relatedQuestions.length > 0">
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
