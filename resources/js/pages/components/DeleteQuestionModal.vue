<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { ref } from 'vue';

const props = defineProps({
    questionTitle: {
        type: String,
        default: 'this question',
    },
});

const emit = defineEmits(['confirm']);

const isOpen = ref(false);
const isDeleting = ref(false);

const handleConfirm = () => {
    isDeleting.value = true;
    emit('confirm', () => {
        // Callback for when delete is complete
        isDeleting.value = false;
        isOpen.value = false;
    });
};
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent
            class="max-w-md border-zinc-200 bg-white/95 backdrop-blur-sm dark:border-zinc-800 dark:bg-zinc-900/95"
        >
            <DialogHeader class="space-y-4">
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-red-100 to-red-200 dark:from-red-900/30 dark:to-red-800/30"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8 text-red-600 dark:text-red-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                        />
                    </svg>
                </div>
                <DialogTitle
                    class="text-center text-xl font-bold text-zinc-900 dark:text-zinc-50"
                >
                    Delete Question?
                </DialogTitle>
                <DialogDescription
                    class="text-center text-sm leading-relaxed text-zinc-600 dark:text-zinc-400"
                >
                    Are you sure you want to delete
                    <span class="font-semibold text-zinc-900 dark:text-zinc-50">
                        "{{ questionTitle }}"
                    </span>
                    ? This action cannot be undone and will permanently remove
                    the question and all associated data.
                </DialogDescription>
            </DialogHeader>

            <div
                class="rounded-xl border border-red-200/60 bg-gradient-to-br from-red-50/80 to-red-100/40 p-4 dark:border-red-800/50 dark:from-red-900/20 dark:to-red-800/10"
            >
                <div class="flex items-start gap-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 shrink-0 text-red-600 dark:text-red-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                        />
                    </svg>
                    <p
                        class="text-xs leading-relaxed font-medium text-red-700 dark:text-red-300"
                    >
                        Warning: This will permanently delete your question,
                        including all answers, votes, and comments associated
                        with it. This action cannot be reversed.
                    </p>
                </div>
            </div>

            <DialogFooter class="gap-2 sm:gap-2">
                <DialogClose as-child>
                    <button
                        type="button"
                        :disabled="isDeleting"
                        class="flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:border-zinc-300 hover:bg-zinc-50 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:border-zinc-600 dark:hover:bg-zinc-700"
                        @click="isOpen = false"
                    >
                        Cancel
                    </button>
                </DialogClose>
                <button
                    type="button"
                    @click="handleConfirm"
                    :disabled="isDeleting"
                    class="flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-red-500 via-red-600 to-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-red-500/30 transition hover:from-red-600 hover:via-red-700 hover:to-red-700 hover:brightness-105 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <svg
                        v-if="isDeleting"
                        class="h-4 w-4 animate-spin"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                    </svg>
                    <span>{{
                        isDeleting ? 'Deleting...' : 'Delete Question'
                    }}</span>
                </button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
