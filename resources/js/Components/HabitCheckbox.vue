<template>
    <div class="habit-checkbox">
        <button
            @click="toggleHabit"
            :class="[
                'flex h-6 w-6 items-center justify-center rounded border-2 transition-colors',
                isCompleted
                    ? 'border-green-500 bg-green-500'
                    : 'border-gray-300 hover:border-gray-400',
            ]"
            :title="buttonTitle"
        >
            <svg
                v-if="isCompleted"
                class="h-4 w-4 text-white"
                fill="currentColor"
                viewBox="0 0 20 20"
            >
                <path
                    fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"
                />
            </svg>
        </button>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    userHabitId: {
        type: Number,
        required: true,
    },
    date: {
        type: String,
        required: true,
    },
    initialStatus: {
        type: String,
        default: null,
    },
});

const form = useForm({
    user_habit_id: props.userHabitId,
    date: props.date,
    status: 'completed',
    notes: '',
});

const isCompleted = computed(() => props.initialStatus === 'completed');

const buttonTitle = computed(() => {
    if (isCompleted.value) {
        return 'انجام شده - کلیک برای لغو';
    }
    return 'کلیک برای علامت‌گذاری به عنوان انجام شده';
});

const toggleHabit = () => {
    const newStatus = isCompleted.value ? 'skipped' : 'completed';
    form.status = newStatus;

    form.post('/habits/log', {
        preserveScroll: true,
        onSuccess: () => {
            // Success - form will be reset automatically
        },
        onError: (errors) => {
            console.error('Error logging habit:', errors);
        },
    });
};
</script>
