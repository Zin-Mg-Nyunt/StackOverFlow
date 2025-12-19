<script setup>
import InputError from '@/components/InputError.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { inject, ref } from 'vue';

const route = inject('route');

const { question } = defineProps({
    question: Object | null,
});

const form = useForm({
    title: question?.title || '',
    body: question?.body || '',
});

const showPreview = ref(false);

const submit = () => {
    if (question) {
        form.put(route('question.update', question.id), {
            preserveScroll: true,
        });
    } else {
        form.post(route('questions.store'), {
            preserveScroll: true,
        });
    }
};
const goBack = () => {
    window.history.back();
};
// Add tag functionality
// const addTag = (tag) => {
//     if (!form.tags.includes(tag.trim()) && tag.trim()) {
//         form.tags.push(tag.trim());
//     }
// };

// // Remove tag
// const removeTag = (tagToRemove) => {
//     form.tags = form.tags.filter((t) => t !== tagToRemove);
// };

// // Popular tags suggestions
// const popularTags = [
//     'javascript',
//     'vue',
//     'laravel',
//     'inertiajs',
//     'tailwindcss',
//     'php',
//     'mysql',
//     'api',
//     'authentication',
//     'validation',
// ];
</script>

<template>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-50">
                    {{ question ? 'Edit Question' : 'Ask a Question' }}
                </h1>
                <p
                    class="mt-2 text-sm text-zinc-600 dark:text-zinc-400"
                    v-if="!question"
                >
                    Share your knowledge and get help from the community
                </p>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400" v-else>
                    Edit your question
                </p>
            </div>
            <button
                @click="goBack"
                class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:border-zinc-300 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800"
            >
                Cancel
            </button>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Title Section -->
            <div
                class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
            >
                <div class="space-y-4">
                    <div>
                        <label
                            for="title"
                            class="mb-2 block text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                        >
                            Title
                            <span class="text-red-500">*</span>
                        </label>
                        <p
                            class="mb-3 text-xs text-zinc-500 dark:text-zinc-400"
                        >
                            Be specific and imagine you're asking a question to
                            another person
                        </p>
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            required
                            maxlength="200"
                            class="w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-50 dark:placeholder:text-zinc-600 dark:focus:border-sky-500 dark:focus:ring-sky-500/30"
                            placeholder="e.g., How to handle form validation in Inertia.js with Vue 3?"
                        />
                        <div
                            class="mt-2 flex items-center justify-between text-xs"
                        >
                            <InputError :message="form.errors.title" />
                            <span
                                class="text-zinc-500 dark:text-zinc-400"
                                :class="{
                                    'text-red-500 dark:text-red-400':
                                        form.title.length > 180,
                                }"
                            >
                                {{ form.title.length }}/200
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body Section -->
            <div
                class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
            >
                <div class="space-y-4">
                    <div>
                        <label
                            for="body"
                            class="mb-2 block text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                        >
                            Body
                            <span class="text-red-500">*</span>
                        </label>
                        <p
                            class="mb-3 text-xs text-zinc-500 dark:text-zinc-400"
                        >
                            Include all the information someone would need to
                            answer your question
                        </p>
                        <div
                            class="flex gap-2 border-b border-zinc-200 dark:border-zinc-700"
                        >
                            <button
                                type="button"
                                @click="showPreview = false"
                                :class="[
                                    'px-4 py-2 text-sm font-medium transition',
                                    !showPreview
                                        ? 'border-b-2 border-sky-500 text-sky-600 dark:text-sky-400'
                                        : 'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200',
                                ]"
                            >
                                Write
                            </button>
                            <button
                                type="button"
                                @click="showPreview = true"
                                :class="[
                                    'px-4 py-2 text-sm font-medium transition',
                                    showPreview
                                        ? 'border-b-2 border-sky-500 text-sky-600 dark:text-sky-400'
                                        : 'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200',
                                ]"
                            >
                                Preview
                            </button>
                        </div>
                        <div v-if="!showPreview" class="mt-4">
                            <textarea
                                id="body"
                                v-model="form.body"
                                rows="15"
                                required
                                class="w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-50 dark:placeholder:text-zinc-600 dark:focus:border-sky-500 dark:focus:ring-sky-500/30"
                                placeholder="Describe your problem in detail. Include code snippets, error messages, and what you've already tried."
                            ></textarea>
                        </div>
                        <div
                            v-else
                            class="mt-4 min-h-[300px] rounded-lg border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/50"
                        >
                            <div
                                class="prose prose-zinc dark:prose-invert prose-p:text-zinc-700 dark:prose-p:text-zinc-300 max-w-none"
                                v-html="form.body"
                            ></div>
                            <p
                                v-if="!form.body"
                                class="text-sm text-zinc-400 dark:text-zinc-500"
                            >
                                Preview will appear here
                            </p>
                        </div>
                        <div class="mt-2 space-y-2">
                            <InputError :message="form.errors.body" />
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                Use markdown to format your question. Code
                                blocks, lists, and links are supported.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags Section -->
            <!-- <div
                class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
            > -->
            <!-- <div class="space-y-4">
                    <div>
                        <label
                            for="tags"
                            class="mb-2 block text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                        >
                            Tags
                            <span class="text-red-500">*</span>
                        </label>
                        <p
                            class="mb-3 text-xs text-zinc-500 dark:text-zinc-400"
                        >
                            Add up to 5 tags to describe what your question is
                            about
                        </p>
                        <input
                            id="tags"
                            v-model="form.tags"
                            type="text"
                            required
                            class="w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-50 dark:placeholder:text-zinc-600 dark:focus:border-sky-500 dark:focus:ring-sky-500/30"
                            placeholder="e.g., vue, inertiajs, laravel (comma-separated)"
                        />
                        <InputError :message="form.errors.tags" />
                    </div> -->

            <!-- Selected Tags -->
            <!-- <div
                        v-if="form.tags.length > 0"
                        class="flex flex-wrap gap-2"
                    >
                        <span
                            v-for="tag in form.tags"
                            :key="tag"
                            class="group flex items-center gap-2 rounded-full bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700 transition hover:bg-sky-100 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20"
                        >
                            {{ tag }}
                            <button
                                type="button"
                                @click="removeTag(tag)"
                                class="text-sky-600 transition hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-3 w-3"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </span>
                    </div> -->

            <!-- Popular Tags Suggestions -->
            <!-- <div v-if="form.tags.length < 5" class="space-y-2">
                        <p
                            class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                        >
                            Popular tags:
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="tag in popularTags"
                                :key="tag"
                                type="button"
                                @click="addTag(tag)"
                                :disabled="
                                    form.tags.length >= 5 ||
                                    form.tags.includes(tag)
                                "
                                class="rounded-full border border-zinc-200 bg-zinc-50 px-3 py-1 text-xs font-semibold text-zinc-700 transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-600 disabled:cursor-not-allowed disabled:opacity-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:border-sky-500/60 dark:hover:bg-sky-500/10 dark:hover:text-sky-300"
                            >
                                {{ tag }}
                            </button>
                        </div>
                    </div> -->
            <!-- </div> -->
            <!-- </div> -->

            <!-- Submit Section -->
            <div
                class="flex items-center justify-between rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
            >
                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                    <p class="font-medium">
                        Review your question before posting
                    </p>
                    <p class="mt-1 text-xs">
                        Make sure your question is clear and includes all
                        necessary details
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <Link
                        href="/"
                        class="rounded-lg border border-zinc-200 px-6 py-3 text-sm font-semibold text-zinc-700 transition hover:border-zinc-300 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800"
                    >
                        Cancel
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-lg bg-gradient-to-r from-sky-500 via-indigo-500 to-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/30 transition hover:brightness-105 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <span v-if="form.processing">{{
                            question ? 'Updating...' : 'Posting...'
                        }}</span>
                        <span v-else>{{
                            question ? 'Update Question' : 'Post Your Question'
                        }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
