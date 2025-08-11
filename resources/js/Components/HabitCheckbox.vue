<template>
    <div class="habit-status">
        <button
            @click="cycleStatus"
            :class="[
                'flex h-8 w-8 items-center justify-center rounded-full border-2 transition-colors',
                statusClass
            ]"
            :title="statusTitle"
        >
            <svg v-if="status === 'completed'" class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0
                      01-1.414 0l-4-4a1 1 0
                      011.414-1.414L8 12.586l7.293-7.293a1 1 0
                      011.414 0z"
                      clip-rule="evenodd"/>
            </svg>
            <span v-else-if="status === 'skipped'" class="text-white font-bold">–</span>
            <span v-else-if="status === 'missed'" class="text-white font-bold">×</span>
        </button>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    userHabitId: { type: Number, required: true },
    date: { type: String, required: true },
    initialStatus: { type: String, default: null }
});

const status = ref(props.initialStatus || 'missed'); // پیش‌فرض missed

const form = useForm({
    user_habit_id: props.userHabitId,
    date: props.date,
    status: status.value,
    notes: ''
});



const statusClass = computed(() => {
    switch (status.value) {
        case 'completed': return 'border-green-500 bg-green-500';
        case 'skipped':   return 'border-yellow-500 bg-yellow-500';
        case 'missed':    return 'border-red-500 bg-red-500';
    }
});

const statusTitle = computed(() => {
    switch (status.value) {
        case 'completed': return '✅ انجام شده - کلیک برای گذر به "Skipped"';
        case 'skipped':   return '⏭ رد شده - کلیک برای گذر به "Missed"';
        case 'missed':    return '❌ فراموش شده - کلیک برای گذر به "Completed"';
    }
});

const statusCycle = ['missed', 'completed', 'skipped'];
const cycleStatus = () => {
    const currentIndex = statusCycle.indexOf(status.value);
    const nextIndex = (currentIndex + 1) % statusCycle.length;
    status.value = statusCycle[nextIndex];
    form.status = status.value;

    form.post('/habits/log', {
        preserveScroll: true
    });
};
</script>
