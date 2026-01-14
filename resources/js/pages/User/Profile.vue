<script setup>
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { inject, ref } from 'vue';
import formatTime from '../../composables/formatDate';
import Pagination from '../components/Pagination.vue';

let route = inject('route');
let page = usePage();
const { profileUser, stats, questions, answers, savedQuestions } = defineProps({
    profileUser: Object,
    stats: Object,
    questions: Array,
    savedQuestions: Object,
    answers: Object,
});

let questionOrAnswer = ref(page.props.state ?? 'q');
const showModal = ref(false);

const stateValue = (value) => {
    questionOrAnswer.value = value;
    router.get(route('user.profile', profileUser.id), {
        state: value,
    });
};

const formatNumber = (num) => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'k';
    }
    return num.toString();
};

// Profile update form
const profileForm = useForm({
    name: profileUser.name,
    email: profileUser.email,
    profile_photo_path: profileUser.profile_photo_path
        ? profileUser.profile_photo_path
        : null,
});
// image preview
let imagePreview = ref(profileUser.profile_photo_path);
let file = ref(null);
const previewImage = (e) => {
    file.value = e.target.files[0];
    if (file.value) {
        profileForm.profile_photo_path = file.value;
        imagePreview.value = URL.createObjectURL(file.value);
    }
};

const deleteProfilePhoto = () => {
    profileForm.profile_photo_path = null;
};

const updateProfile = () => {
    profileForm.post(route('update.profile', profileUser.id), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false;
            file.value = null;
            profileForm.reset();
        },
    });
};

// Password update form
const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    passwordForm.put(route('user-password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            passwordForm.reset();
        },
    });
};

const closeModal = () => {
    file.value = null;
    showModal.value = false;
    profileForm.reset();
    passwordForm.reset();
    imagePreview.value = profileUser.profile_photo_path;
};
</script>

<template>
    <Head title="User Profile" />

    <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
        <!-- Profile Header -->
        <div
            class="rounded-2xl border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900"
        >
            <div class="mx-auto max-w-screen-2xl px-6 py-8">
                <div
                    class="flex flex-col gap-6 md:flex-row md:items-start md:gap-8"
                >
                    <!-- Avatar -->
                    <div
                        class="flex items-center justify-center md:flex-shrink-0"
                    >
                        <div
                            class="flex h-32 w-32 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-sky-500 via-indigo-500 to-blue-600 text-4xl font-bold text-white shadow-lg shadow-sky-500/20"
                        >
                            <img
                                v-if="profileUser.profile_photo_path"
                                :src="profileUser.profile_photo_path"
                                :alt="profileUser.name"
                                class="h-full w-full object-center"
                            />
                            <span v-else>{{
                                profileUser.name.charAt(0).toUpperCase()
                            }}</span>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="flex-1 space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h1
                                    class="text-center text-3xl font-bold text-zinc-900 md:text-left dark:text-zinc-50"
                                >
                                    {{ profileUser.name }}
                                </h1>
                                <p
                                    class="mt-1 text-center text-sm text-zinc-600 md:text-left dark:text-zinc-400"
                                >
                                    {{ profileUser.email }}
                                </p>
                            </div>
                            <button
                                @click="showModal = true"
                                class="group flex cursor-pointer flex-col items-center"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-zinc-500 transition-colors group-hover:text-zinc-900 dark:text-zinc-400 dark:group-hover:text-zinc-50"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 3.487a2.06 2.06 0 0 1 2.913 2.913l-9.54 9.54-3.244.33a1 1 0 0 1-1.098-1.098l.33-3.244 9.54-9.54z"
                                    />
                                </svg>
                                <p
                                    class="text-xs text-zinc-500 transition-colors group-hover:text-zinc-900 dark:text-zinc-400 dark:group-hover:text-zinc-50"
                                >
                                    Edit Profile
                                </p>
                            </button>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                            <div
                                class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <div
                                    class="text-2xl font-bold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ formatNumber(stats.reputation) }}
                                </div>
                                <div
                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                                >
                                    Reputation
                                </div>
                            </div>
                            <div
                                class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <div
                                    class="text-2xl font-bold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ stats.questions }}
                                </div>
                                <div
                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                                >
                                    Questions
                                </div>
                            </div>
                            <div
                                class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <div
                                    class="text-2xl font-bold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ stats.answers }}
                                </div>
                                <div
                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                                >
                                    Answers
                                </div>
                            </div>
                            <div
                                class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <div
                                    class="text-2xl font-bold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ formatNumber(stats.views) }}
                                </div>
                                <div
                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                                >
                                    Profile Views
                                </div>
                            </div>
                        </div>

                        <!-- Member Since -->
                        <div
                            class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400"
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
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                            <span
                                >Member since
                                {{ formatTime(profileUser.created_at) }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Tabs -->
        <div class="mx-auto max-w-screen-2xl px-6 py-8">
            <div class="mb-6 border-b border-zinc-200 dark:border-zinc-800">
                <nav class="-mb-px flex gap-6">
                    <button
                        class="px-1 pb-4 text-sm font-semibold transition hover:text-zinc-900 dark:hover:text-zinc-50"
                        :class="{
                            'border-b-2 border-sky-500 text-sky-600 dark:text-sky-400':
                                questionOrAnswer == 'q',
                        }"
                        @click="stateValue('q')"
                    >
                        Questions ({{ stats.questions }})
                    </button>
                    <button
                        class="px-1 pb-4 text-sm font-semibold transition hover:text-zinc-900 dark:hover:text-zinc-50"
                        :class="{
                            'border-b-2 border-sky-500 text-sky-600 dark:text-sky-400':
                                questionOrAnswer == 'a',
                        }"
                        @click="stateValue('a')"
                    >
                        Answers ({{ stats.answers }})
                    </button>
                    <button
                        class="px-1 pb-4 text-sm font-semibold transition hover:text-zinc-900 dark:hover:text-zinc-50"
                        :class="{
                            'border-b-2 border-sky-500 text-sky-600 dark:text-sky-400':
                                questionOrAnswer == 'sq',
                        }"
                        @click="stateValue('sq')"
                    >
                        Saved Questions ({{ stats.savedQuestions }})
                    </button>
                </nav>
            </div>
            <!-- Questions Section -->
            <div class="space-y-4" v-if="questionOrAnswer == 'q'">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">
                    Recent Questions
                </h2>

                <div
                    v-if="questions.length === 0"
                    class="rounded-xl border border-zinc-200 bg-white p-8 text-center dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <p class="text-zinc-600 dark:text-zinc-400">
                        No questions yet. Start asking questions to help the
                        community!
                    </p>
                </div>

                <article
                    v-for="question in questions"
                    :key="question.id"
                    class="group rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div class="flex gap-4">
                        <div
                            class="flex w-22 shrink-0 flex-col items-start gap-2 text-xs font-semibold text-zinc-500 dark:text-zinc-400"
                        >
                            <div
                                class="rounded-lg bg-sky-500/10 px-3 py-1.5 text-center text-sky-600 ring-1 ring-sky-500/30 dark:text-sky-200"
                            >
                                {{ question.votes_count || 0 }} votes
                            </div>
                            <div
                                class="rounded-lg bg-emerald-500/10 px-3 py-1.5 text-center text-emerald-600 ring-1 ring-emerald-500/30 dark:text-emerald-200"
                            >
                                {{ question.answers_count || 0 }} answers
                            </div>
                            <div
                                class="rounded-lg bg-zinc-100 px-3 py-1.5 text-center text-zinc-700 ring-1 ring-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700"
                            >
                                {{ question.views || 0 }} views
                            </div>
                        </div>
                        <div class="flex-1 space-y-3">
                            <Link
                                :href="route('questions.detail', question.slug)"
                                class="block text-lg leading-snug font-semibold text-zinc-900 transition hover:text-sky-600 dark:text-zinc-50 dark:hover:text-sky-400"
                            >
                                {{ question.title }}
                            </Link>
                            <p
                                class="line-clamp-2 text-sm text-zinc-600 dark:text-zinc-400"
                            >
                                {{ question.body }}
                            </p>
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    v-for="tag in question.tags"
                                    :key="tag.id"
                                    class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700 transition hover:bg-sky-50 hover:text-sky-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-sky-500/10 dark:hover:text-sky-200"
                                >
                                    {{ tag.name }}
                                </span>
                            </div>
                            <div
                                class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400"
                            >
                                <span>{{
                                    formatTime(question.created_at)
                                }}</span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Answers Section -->
            <div class="space-y-4" v-if="questionOrAnswer == 'a'">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-xl font-bold text-zinc-900 dark:text-zinc-50"
                    >
                        Recent Answers
                    </h2>
                    <Pagination :links="answers.links" />
                </div>

                <div
                    v-if="answers.data.length === 0"
                    class="rounded-xl border border-zinc-200 bg-white p-8 text-center dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <p class="text-zinc-600 dark:text-zinc-400">
                        No answers yet. Start answering questions to help the
                        community!
                    </p>
                </div>

                <article
                    v-for="answer in answers.data"
                    :key="answer.id"
                    class="group rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div class="space-y-3">
                        <Link
                            :href="
                                route(
                                    'questions.detail',
                                    answer.question.slug +
                                        '#answer-' +
                                        answer.id,
                                )
                            "
                            class="block text-lg leading-snug font-semibold text-zinc-900 transition hover:text-sky-600 dark:text-zinc-50 dark:hover:text-sky-400"
                        >
                            {{ answer.question.title }}
                        </Link>
                        <p
                            class="line-clamp-3 text-sm text-zinc-600 dark:text-zinc-400"
                        >
                            {{ answer.body }}
                        </p>
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                v-for="tag in answer.question.tags"
                                :key="tag.id"
                                class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700 transition hover:bg-sky-50 hover:text-sky-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-sky-500/10 dark:hover:text-sky-200"
                            >
                                {{ tag.name }}
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400"
                        >
                            <span
                                >Answered
                                {{ formatTime(answer.created_at) }}</span
                            >
                        </div>
                    </div>
                </article>
            </div>

            <!-- Saved Questions Section -->
            <div class="space-y-4" v-if="questionOrAnswer == 'sq'">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-xl font-bold text-zinc-900 dark:text-zinc-50"
                    >
                        Saved Questions
                    </h2>
                    <Pagination :links="savedQuestions.links" />
                </div>
                <div
                    v-if="savedQuestions.length === 0"
                    class="rounded-xl border border-zinc-200 bg-white p-8 text-center dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <p class="text-zinc-600 dark:text-zinc-400">
                        No questions yet. Start save questions for later!
                    </p>
                </div>

                <article
                    v-for="question in savedQuestions.data"
                    :key="question.id"
                    class="group rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div class="flex gap-4">
                        <div
                            class="flex w-22 shrink-0 flex-col items-start gap-2 text-xs font-semibold text-zinc-500 dark:text-zinc-400"
                        >
                            <div
                                class="rounded-lg bg-sky-500/10 px-3 py-1.5 text-center text-sky-600 ring-1 ring-sky-500/30 dark:text-sky-200"
                            >
                                {{ question.votes_count || 0 }} votes
                            </div>
                            <div
                                class="rounded-lg bg-emerald-500/10 px-3 py-1.5 text-center text-emerald-600 ring-1 ring-emerald-500/30 dark:text-emerald-200"
                            >
                                {{ question.answers_count || 0 }} answers
                            </div>
                            <div
                                class="rounded-lg bg-zinc-100 px-3 py-1.5 text-center text-zinc-700 ring-1 ring-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700"
                            >
                                {{ question.views || 0 }} views
                            </div>
                        </div>
                        <div class="flex-1 space-y-3">
                            <Link
                                :href="route('questions.detail', question.slug)"
                                class="block text-lg leading-snug font-semibold text-zinc-900 transition hover:text-sky-600 dark:text-zinc-50 dark:hover:text-sky-400"
                            >
                                {{ question.title }}
                            </Link>
                            <p
                                class="line-clamp-2 text-sm text-zinc-600 dark:text-zinc-400"
                            >
                                {{ question.body }}
                            </p>
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    v-for="tag in question.tags"
                                    :key="tag.id"
                                    class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700 transition hover:bg-sky-50 hover:text-sky-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-sky-500/10 dark:hover:text-sky-200"
                                >
                                    {{ tag.name }}
                                </span>
                            </div>
                            <div
                                class="flex items-center justify-between gap-2 text-xs text-zinc-500 dark:text-zinc-400"
                            >
                                <span>{{
                                    formatTime(question.created_at)
                                }}</span>
                                <span>
                                    saved at -
                                    {{ formatTime(question.pivot.created_at) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Edit Profile Modal -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                @click.self="closeModal"
            >
                <Transition
                    enter-active-class="transition ease-out duration-200"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-150"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="showModal"
                        class="relative max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-800 dark:bg-zinc-900"
                    >
                        <!-- Modal Header -->
                        <div
                            class="sticky top-0 flex items-center justify-between border-b border-zinc-200 bg-white px-6 py-4 dark:border-zinc-800 dark:bg-zinc-900"
                        >
                            <h2
                                class="text-xl font-bold text-zinc-900 dark:text-zinc-50"
                            >
                                Edit Profile
                            </h2>
                            <button
                                @click="closeModal"
                                class="rounded-lg p-1 text-zinc-500 transition-colors hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-zinc-50"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Content -->
                        <div class="space-y-6 p-6">
                            <!-- Profile Photo Upload -->
                            <div class="space-y-4">
                                <h3
                                    class="text-lg font-semibold text-zinc-900 dark:text-zinc-50"
                                >
                                    Profile Picture
                                </h3>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-sky-500 via-indigo-500 to-blue-600 text-2xl font-bold text-white"
                                    >
                                        {{ console.log(imagePreview) }}
                                        <img
                                            v-if="imagePreview"
                                            :src="imagePreview"
                                            alt="Preview"
                                            class="h-full w-full object-center"
                                        />
                                        <span v-else>{{
                                            profileUser.name
                                                .charAt(0)
                                                .toUpperCase()
                                        }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <label
                                                class="block w-full cursor-pointer rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-50 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700"
                                            >
                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    @change="previewImage"
                                                    class="hidden"
                                                />
                                                {{
                                                    file
                                                        ? file.name
                                                        : 'Choose Photo'
                                                }}
                                            </label>

                                            <button
                                                type="button"
                                                @click="deleteProfilePhoto"
                                                class="flex cursor-pointer flex-col items-center gap-1 rounded-lg border border-red-300 bg-white p-1 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 dark:border-red-900 dark:bg-zinc-950 dark:text-red-300 dark:hover:bg-red-900/40"
                                                title="Remove Profile Photo"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="22"
                                                    height="22"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        fill="currentColor"
                                                        d="M7.616 20q-.667 0-1.141-.475T6 18.386V6h-.5q-.213 0-.356-.144T5 5.499t.144-.356T5.5 5H9q0-.31.23-.54t.54-.23h4.46q.31 0 .54.23T15 5h3.5q.213 0 .356.144t.144.357t-.144.356T18.5 6H18v12.385q0 .666-.475 1.14t-1.14.475zM17 6H7v12.385q0 .269.173.442t.443.173h8.769q.269 0 .442-.173t.173-.442zm-6.692 11q.213 0 .357-.144t.143-.356v-8q0-.213-.144-.356T10.307 8t-.356.144t-.143.356v8q0 .213.144.356q.144.144.356.144m3.385 0q.213 0 .356-.144t.143-.356v-8q0-.213-.144-.356Q13.904 8 13.692 8q-.213 0-.357.144t-.143.356v8q0 .213.144.356t.357.144M7 6v13z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                        <p
                                            class="mt-1 text-xs text-zinc-500 dark:text-zinc-400"
                                        >
                                            JPG, PNG or GIF. Max size 2MB
                                        </p>
                                        <p
                                            v-if="
                                                profileForm.errors
                                                    .profile_photo_path
                                            "
                                            class="mt-1 text-sm text-red-600 dark:text-red-400"
                                        >
                                            {{
                                                profileForm.errors
                                                    .profile_photo_path
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Name and Email Form -->
                            <div class="space-y-4">
                                <h3
                                    class="text-lg font-semibold text-zinc-900 dark:text-zinc-50"
                                >
                                    Personal Information
                                </h3>
                                <form @submit.prevent="updateProfile">
                                    <div class="space-y-4">
                                        <div>
                                            <label
                                                for="name"
                                                class="block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                                            >
                                                Name
                                            </label>
                                            <input
                                                id="name"
                                                type="text"
                                                v-model="profileForm.name"
                                                class="mt-1 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-zinc-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-50 dark:focus:border-sky-400 dark:focus:ring-sky-400"
                                                required
                                            />
                                            <p
                                                v-if="profileForm.errors.name"
                                                class="mt-1 text-sm text-red-600 dark:text-red-400"
                                            >
                                                {{ profileForm.errors.name }}
                                            </p>
                                        </div>

                                        <div>
                                            <label
                                                for="email"
                                                class="block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                                            >
                                                Email
                                            </label>
                                            <input
                                                id="email"
                                                type="email"
                                                v-model="profileForm.email"
                                                class="mt-1 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-zinc-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-50 dark:focus:border-sky-400 dark:focus:ring-sky-400"
                                                required
                                            />
                                            <p
                                                v-if="profileForm.errors.email"
                                                class="mt-1 text-sm text-red-600 dark:text-red-400"
                                            >
                                                {{ profileForm.errors.email }}
                                            </p>
                                        </div>

                                        <div class="flex justify-end">
                                            <button
                                                type="submit"
                                                :disabled="
                                                    profileForm.processing
                                                "
                                                class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-sky-700 disabled:opacity-50 dark:bg-sky-500 dark:hover:bg-sky-600"
                                            >
                                                {{
                                                    profileForm.processing
                                                        ? 'Saving...'
                                                        : 'Save Changes'
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Password Change Form -->
                            <div
                                class="space-y-4 border-t border-zinc-200 pt-6 dark:border-zinc-800"
                            >
                                <h3
                                    class="text-lg font-semibold text-zinc-900 dark:text-zinc-50"
                                >
                                    Change Password
                                </h3>
                                <form @submit.prevent="updatePassword">
                                    <div class="space-y-4">
                                        <div>
                                            <label
                                                for="current_password"
                                                class="block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                                            >
                                                Current Password
                                            </label>
                                            <input
                                                id="current_password"
                                                type="password"
                                                v-model="
                                                    passwordForm.current_password
                                                "
                                                class="mt-1 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-zinc-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-50 dark:focus:border-sky-400 dark:focus:ring-sky-400"
                                                required
                                            />
                                            <p
                                                v-if="
                                                    passwordForm.errors
                                                        .current_password
                                                "
                                                class="mt-1 text-sm text-red-600 dark:text-red-400"
                                            >
                                                {{
                                                    passwordForm.errors
                                                        .current_password
                                                }}
                                            </p>
                                        </div>

                                        <div>
                                            <label
                                                for="password"
                                                class="block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                                            >
                                                New Password
                                            </label>
                                            <input
                                                id="password"
                                                type="password"
                                                v-model="passwordForm.password"
                                                class="mt-1 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-zinc-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-50 dark:focus:border-sky-400 dark:focus:ring-sky-400"
                                                required
                                            />
                                            <p
                                                v-if="
                                                    passwordForm.errors.password
                                                "
                                                class="mt-1 text-sm text-red-600 dark:text-red-400"
                                            >
                                                {{
                                                    passwordForm.errors.password
                                                }}
                                            </p>
                                        </div>

                                        <div>
                                            <label
                                                for="password_confirmation"
                                                class="block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                                            >
                                                Confirm New Password
                                            </label>
                                            <input
                                                id="password_confirmation"
                                                type="password"
                                                v-model="
                                                    passwordForm.password_confirmation
                                                "
                                                class="mt-1 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-zinc-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-50 dark:focus:border-sky-400 dark:focus:ring-sky-400"
                                                required
                                            />
                                        </div>

                                        <div class="flex justify-end">
                                            <button
                                                type="submit"
                                                :disabled="
                                                    passwordForm.processing
                                                "
                                                class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-sky-700 disabled:opacity-50 dark:bg-sky-500 dark:hover:bg-sky-600"
                                            >
                                                {{
                                                    passwordForm.processing
                                                        ? 'Updating...'
                                                        : 'Update Password'
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </div>
</template>

<style></style>
