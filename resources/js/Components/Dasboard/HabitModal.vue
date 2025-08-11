<script setup>
import { ref } from 'vue';
import Modal from '../Modal.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    suggestedHabits: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['close']);

const modalStep = ref('choice'); // 'choice', 'create-habit', 'quit-habit'

// Inertia form for creating a user habit
const form = useForm({
    habit_id: null,
    custom_title: '',
    custom_desc: '',
    color: '#3b82f6',
    question: '',
    unit: '',
    target: null,
    target_type: 'at_least',
    frequency: 'daily',
    reminder_time: '',
    notes: '',
    start_date: new Date().toISOString().slice(0, 10),
    is_active: true,
});

// Function to close modal
const closeModal = () => {
    emit('close');
    modalStep.value = 'choice';
    form.reset();
};

// Function to handle choice selection
const selectChoice = (choice) => {
    modalStep.value = choice;
};

// Function to go back to choice step
const goBackToChoice = () => {
    modalStep.value = 'choice';
};

const saveCreateHabit = () => {
    form.post('/habits', {
        onSuccess: () => {
            closeModal();
        },
    });
};
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <!-- Header -->
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900" dir="rtl">
                    {{
                        modalStep === 'choice'
                            ? 'انتخاب کنید'
                            : modalStep === 'create-habit'
                              ? 'ساخت عادت جدید'
                              : 'ترک عادت'
                    }}
                </h3>
                <button
                    @click="closeModal"
                    class="text-gray-400 hover:text-gray-600"
                >
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>

            <!-- Choice Step -->
            <div v-if="modalStep === 'choice'" class="space-y-4" dir="rtl">
                <p class="mb-6 text-gray-600">چه کاری می‌خواهید انجام دهید؟</p>

                <div class="grid grid-cols-1 gap-4">
                    <button
                        @click="selectChoice('create-habit')"
                        class="rounded-lg border-2 border-blue-200 p-4 transition-colors hover:border-blue-400 hover:bg-blue-50"
                    >
                        <div
                            class="flex items-center space-x-3 space-x-reverse"
                        >
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100"
                            >
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
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                    ></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <h4 class="font-medium text-gray-900">
                                    ساخت عادت جدید
                                </h4>
                                <p class="text-sm text-gray-600">
                                    عادت مثبتی را شروع کنید
                                </p>
                            </div>
                        </div>
                    </button>

                    <button
                        @click="selectChoice('quit-habit')"
                        class="rounded-lg border-2 border-red-200 p-4 transition-colors hover:border-red-400 hover:bg-red-50"
                    >
                        <div
                            class="flex items-center space-x-3 space-x-reverse"
                        >
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100"
                            >
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
                                        d="M6 18L18 6M6 6l12 12"
                                    ></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <h4 class="font-medium text-gray-900">
                                    ترک عادت
                                </h4>
                                <p class="text-sm text-gray-600">
                                    عادت منفی را کنار بگذارید
                                </p>
                            </div>
                        </div>
                    </button>
                </div>

                <!-- Suggested habits under the buttons -->
                <div class="mt-2">
                    <p class="mb-2 text-sm text-gray-600">پیشنهادها</p>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="h in props.suggestedHabits"
                            :key="h.id"
                            type="button"
                            class="rounded-full border border-gray-300 px-3 py-1 text-sm hover:bg-gray-50"
                            @click="
                                form.custom_title = h.title;
                                form.habit_id = h.id;
                                modalStep = 'create-habit';
                            "
                        >
                            {{ h.title }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Create Habit Step -->
            <form
                v-if="modalStep === 'create-habit'"
                class="space-y-4"
                dir="rtl"
                @submit.prevent="saveCreateHabit"
            >
                <div class="mb-2">
                    <button
                        type="button"
                        @click="goBackToChoice"
                        class="flex items-center text-blue-600 hover:text-blue-800"
                    >
                        <svg
                            class="ml-1 h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            ></path>
                        </svg>
                        بازگشت
                    </button>
                </div>

                <div class="grid grid-cols-1 items-end gap-4 md:grid-cols-4">
                    <div class="md:col-span-3">
                        <label
                            for="habit-name"
                            class="mb-2 block text-sm font-medium text-gray-700"
                            >نام</label
                        >
                        <input
                            type="text"
                            id="habit-name"
                            v-model="form.custom_title"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="مثال: دویدن"
                        />
                        <div
                            v-if="form.errors.custom_title"
                            class="mt-1 text-xs text-red-600"
                        >
                            {{ form.errors.custom_title }}
                        </div>
                    </div>
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                            >رنگ</label
                        >
                        <input
                            type="color"
                            v-model="form.color"
                            class="h-10 w-12 rounded border border-gray-300 p-1"
                        />
                        <div
                            v-if="form.errors.color"
                            class="mt-1 text-xs text-red-600"
                        >
                            {{ form.errors.color }}
                        </div>
                    </div>
                </div>

                <!-- Suggestions under the input -->
                <div  class="mt-2">
                    <p class="mb-2 text-sm text-gray-600">پیشنهادها</p>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="h in props.suggestedHabits"
                            :key="h.id"
                            type="button"
                            class="rounded-full border border-gray-300 px-3 py-1 text-sm hover:bg-gray-50"
                            @click="
                                form.custom_title = h.title;
                                form.habit_id = h.id;
                            "
                        >
                            {{ h.title }}
                        </button>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700"
                        >سوال</label
                    >
                    <input
                        type="text"
                        v-model="form.question"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="مثال: امروز چند مایل دویدی؟"
                    />
                    <div
                        v-if="form.errors.question"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.question }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                            >واحد</label
                        >
                        <input
                            type="text"
                            v-model="form.unit"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="مثال: مایل"
                        />
                        <div
                            v-if="form.errors.unit"
                            class="mt-1 text-xs text-red-600"
                        >
                            {{ form.errors.unit }}
                        </div>
                    </div>
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                            >هدف</label
                        >
                        <input
                            type="number"
                            v-model.number="form.target"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="مثال: 15"
                        />
                        <div
                            v-if="form.errors.target"
                            class="mt-1 text-xs text-red-600"
                        >
                            {{ form.errors.target }}
                        </div>
                    </div>
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700"
                            >بازه</label
                        >
                        <select
                            v-model="form.frequency"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="daily">هر روز</option>
                            <option value="weekly">هفتگی</option>
                            <option value="monthly">ماهانه</option>
                        </select>
                        <div
                            v-if="form.errors.frequency"
                            class="mt-1 text-xs text-red-600"
                        >
                            {{ form.errors.frequency }}
                        </div>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700"
                        >نوع هدف</label
                    >
                    <select
                        v-model="form.target_type"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="at_least">حداقل</option>
                        <option value="at_most">حداکثر</option>
                        <option value="exact">دقیق</option>
                    </select>
                    <div
                        v-if="form.errors.target_type"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.target_type }}
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700"
                        >یادآوری</label
                    >
                    <select
                        v-model="form.reminder_time"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">خاموش</option>
                        <option value="08:00">08:00</option>
                        <option value="12:00">12:00</option>
                        <option value="18:00">18:00</option>
                        <option value="21:00">21:00</option>
                    </select>
                    <div
                        v-if="form.errors.reminder_time"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.reminder_time }}
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700"
                        >یادداشت</label
                    >
                    <textarea
                        rows="3"
                        v-model="form.notes"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="اختیاری"
                    ></textarea>
                    <div
                        v-if="form.errors.notes"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.notes }}
                    </div>
                </div>

                <div
                    class="mt-6 flex justify-end space-x-3 space-x-reverse"
                    dir="rtl"
                >
                    <button
                        type="button"
                        @click="closeModal"
                        class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300"
                    >
                        انصراف
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 disabled:opacity-50"
                    >
                        ذخیره عادت
                    </button>
                </div>
            </form>

            <!-- Quit Habit Step -->
            <div v-if="modalStep === 'quit-habit'" class="space-y-4" dir="rtl">
                <div class="mb-4">
                    <button
                        @click="goBackToChoice"
                        class="flex items-center text-blue-600 hover:text-blue-800"
                    >
                        <svg
                            class="ml-1 h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            ></path>
                        </svg>
                        بازگشت
                    </button>
                </div>
                <p class="text-gray-600">
                    برای نسخه اول، بخش ترک عادت هنوز متصل نشده است.
                </p>
                <div class="flex justify-end">
                    <button
                        @click="goBackToChoice"
                        class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300"
                    >
                        بازگشت
                    </button>
                </div>
            </div>
        </div>
    </Modal>
</template>
