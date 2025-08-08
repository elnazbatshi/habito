
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// ایمپورت استور کانتر
import { useCounterStore } from '@/stores/counter';
import HabitModal from "@/Components/HabitModal.vue";

const counter = useCounterStore();

// Modal state
const isOpen = ref(false);

// Function to close modal
const closeModal = () => {
    isOpen.value = false;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-center  w-full">
                <h3 dir="rtl" class="text-xl font-semibold leading-tight text-gray-800">
                    به Habito خوش اومدی! 😍
                </h3>
            </div>
        </template>

        <div class="float-right my-2">
            <!-- دکمه باز کردن مودال -->
            <button
                @click="isOpen = true"
                class="mr-2 px-4 text-xl text-black rounded border border-gray-300 hover:bg-gray-100"
            >
                +
            </button>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                
                </div>
            </div>
        </div>

        <!-- Habit Modal -->
        <HabitModal :show="isOpen" @close="closeModal" />
    </AuthenticatedLayout>
</template>
