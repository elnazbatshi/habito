<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

import HabitModal from '@/Components/Dasboard/HabitModal.vue';
import HabitCheckbox from '@/Components/HabitCheckbox.vue';

// Modal state
const isOpen = ref(false);

// Function to close modal
const closeModal = () => {
    isOpen.value = false;
};

// Props from backend
const props = defineProps({
    totalHabits: { type: Number, default: 0 },
    suggestedHabits: { type: Array, default: () => [] },
    userHabits: { type: Array, default: () => [] },
});

// Use real user habits instead of fake data
const habits = computed(() =>
    props.userHabits.map((habit) => ({
        id: habit.id,
        name: habit.custom_title || habit.habit?.title || 'عادت بدون نام',
        status: habit.is_active ? 'active' : 'stalled',
        completionRate: calculateCompletionRate(habit),
        frequency: habit.frequency,
        lastCompleted: getLastCompletedDate(habit),
        streak: calculateStreak(habit),
        color: habit.color || '#3b82f6',
        todayLog: habit.habit_logs?.[0] || null,
    })),
);

// Helper functions
function calculateCompletionRate(habit) {
    // Calculate completion rate based on habit logs
    const logs = habit.habit_logs || [];
    const completedCount = logs.filter(
        (log) => log.status === 'completed',
    ).length;
    const totalCount = logs.length;

    if (totalCount === 0) return 0;
    return Math.round((completedCount / totalCount) * 100);
}

function getLastCompletedDate(habit) {
    const lastCompleted = habit.habit_logs?.find(
        (log) => log.status === 'completed',
    );
    return lastCompleted ? lastCompleted.date : null;
}

function calculateStreak(habit) {
    // Simple streak calculation - can be improved
    const logs = habit.habit_logs || [];
    const completedLogs = logs.filter((log) => log.status === 'completed');
    return completedLogs.length;
}

// Computed properties
const activeHabits = computed(() =>
    habits.value.filter((habit) => habit.status === 'active'),
);
const stalledHabits = computed(() =>
    habits.value.filter((habit) => habit.status === 'stalled'),
);
const averageCompletionRate = computed(() => {
    if (habits.value.length === 0) return 0;
    const total = habits.value.reduce(
        (sum, habit) => sum + habit.completionRate,
        0,
    );
    return Math.round(total / habits.value.length);
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-full items-center justify-center">
                <h3
                    dir="rtl"
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    به Habito خوش اومدی! 😍
                </h3>
            </div>
        </template>

        <div class="float-right my-2">
            <!-- دکمه باز کردن مودال -->
            <button
                @click="isOpen = true"
                class="mr-2 rounded border border-gray-300 px-4 text-xl text-black hover:bg-gray-100"
            >
                +
            </button>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div
                    class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-4"
                    dir="rtl"
                >
                    <div class="rounded-lg bg-white p-6 shadow">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-blue-100 p-2">
                                <svg
                                    class="h-6 w-6 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="mr-4">
                                <p class="text-sm font-medium text-gray-600">
                                    کل عادت‌ها
                                </p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ props.totalHabits }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-green-100 p-2">
                                <svg
                                    class="h-6 w-6 text-green-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="mr-4">
                                <p class="text-sm font-medium text-gray-600">
                                    فعال
                                </p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ activeHabits.length }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-red-100 p-2">
                                <svg
                                    class="h-6 w-6 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="mr-4">
                                <p class="text-sm font-medium text-gray-600">
                                    متوقف شده
                                </p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ stalledHabits.length }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-purple-100 p-2">
                                <svg
                                    class="h-6 w-6 text-purple-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                    ></path>
                                </svg>
                            </div>
                            <div class="mr-4">
                                <p class="text-sm font-medium text-gray-600">
                                    میانگین تکمیل
                                </p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ averageCompletionRate }}%
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Habits Table -->
                <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-900" dir="rtl">
                            لیست عادت‌ها
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200"
                            dir="rtl"
                        >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        امروز
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        نام عادت
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        وضعیت
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        نرخ تکمیل
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        تکرار
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        آخرین تکمیل
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        رکورد
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                    >
                                        عملیات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr
                                    v-for="habit in habits"
                                    :key="habit.id"
                                    class="hover:bg-gray-50"
                                >
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <HabitCheckbox
                                            :user-habit-id="habit.id"
                                            :date="
                                                new Date()
                                                    .toISOString()
                                                    .slice(0, 10)
                                            "
                                            :initial-status="
                                                habit.todayLog?.status
                                            "
                                        />
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ habit.name }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            :class="[
                                                'inline-flex rounded-full px-2 py-1 text-xs font-semibold',
                                                habit.status === 'active'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800',
                                            ]"
                                        >
                                            {{
                                                habit.status === 'active'
                                                    ? 'فعال'
                                                    : 'متوقف شده'
                                            }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="mr-2 h-2 w-16 rounded-full bg-gray-200"
                                            >
                                                <div
                                                    class="h-2 rounded-full transition-all duration-300"
                                                    :class="
                                                        habit.completionRate >=
                                                        80
                                                            ? 'bg-green-500'
                                                            : habit.completionRate >=
                                                                60
                                                              ? 'bg-yellow-500'
                                                              : 'bg-red-500'
                                                    "
                                                    :style="{
                                                        width:
                                                            habit.completionRate +
                                                            '%',
                                                    }"
                                                ></div>
                                            </div>
                                            <span class="text-sm text-gray-900"
                                                >{{
                                                    habit.completionRate
                                                }}%</span
                                            >
                                        </div>
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm text-gray-900"
                                    >
                                        {{
                                            habit.frequency === 'daily'
                                                ? 'روزانه'
                                                : habit.frequency === 'weekly'
                                                  ? 'هفتگی'
                                                  : 'ماهانه'
                                        }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm text-gray-900"
                                    >
                                        {{ habit.lastCompleted }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800"
                                        >
                                            {{ habit.streak }} روز
                                        </span>
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium"
                                    >
                                        <button
                                            class="ml-3 text-blue-600 hover:text-blue-900"
                                        >
                                            ویرایش
                                        </button>
                                        <button
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            حذف
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="mt-8 rounded-lg bg-white p-6 shadow-sm">
                    <h3
                        class="mb-4 text-lg font-medium text-gray-900"
                        dir="rtl"
                    >
                        نمودار نرخ تکمیل عادت‌ها
                    </h3>
                    <div
                        class="flex h-64 items-center justify-center rounded-lg bg-gray-50"
                    >
                        <div class="text-center">
                            <svg
                                class="mx-auto mb-4 h-16 w-16 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                ></path>
                            </svg>
                            <p class="text-gray-500" dir="rtl">
                                نمودار نرخ تکمیل عادت‌ها
                            </p>
                            <p class="mt-2 text-sm text-gray-400" dir="rtl">
                                میانگین تکمیل: {{ averageCompletionRate }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Habit Modal -->
        <HabitModal
            :show="isOpen"
            :suggested-habits="props.suggestedHabits"
            @close="closeModal"
        />
    </AuthenticatedLayout>
</template>
