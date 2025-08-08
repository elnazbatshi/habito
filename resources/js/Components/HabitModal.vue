<script setup>
import { ref } from 'vue';
import Modal from './Modal.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const modalStep = ref('choice'); // 'choice', 'create-habit', 'quit-habit'

// Function to close modal
const closeModal = () => {
    emit('close');
    modalStep.value = 'choice'; // Reset to initial step
};

// Function to handle choice selection
const selectChoice = (choice) => {
    modalStep.value = choice;
};


// Function to go back to choice step
const goBackToChoice = () => {
    modalStep.value = 'choice';
};
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" dir="rtl">
                    {{ modalStep === 'choice' ? 'انتخاب کنید' :
                       modalStep === 'create-habit' ? 'ساخت عادت جدید' : 'ترک عادت' }}
                </h3>
                <button
                    @click="closeModal"
                    class="text-gray-400 hover:text-gray-600"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Choice Step -->
            <div v-if="modalStep === 'choice'" class="space-y-4" dir="rtl">
                <p class="text-gray-600 mb-6">چه کاری می‌خواهید انجام دهید؟</p>

                <div class="grid grid-cols-1 gap-4">
                    <button
                        @click="selectChoice('create-habit')"
                        class="p-4 border-2 border-blue-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors"
                    >
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <h4 class="font-medium text-gray-900">ساخت عادت جدید</h4>
                                <p class="text-sm text-gray-600">عادت مثبتی را شروع کنید</p>
                            </div>
                        </div>
                    </button>

                    <button
                        @click="selectChoice('quit-habit')"
                        class="p-4 border-2 border-red-200 rounded-lg hover:border-red-400 hover:bg-red-50 transition-colors"
                    >
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <h4 class="font-medium text-gray-900">ترک عادت</h4>
                                <p class="text-sm text-gray-600">عادت منفی را کنار بگذارید</p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Create Habit Step -->
            <div v-if="modalStep === 'create-habit'" class="space-y-4" dir="rtl">
                <div class="mb-4">
                    <button
                        @click="goBackToChoice"
                        class="flex items-center text-blue-600 hover:text-blue-800"
                    >
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        بازگشت
                    </button>
                </div>

                <div>
                    <label for="habit-name" class="block text-sm font-medium text-gray-700 mb-2">
                        نام عادت
                    </label>
                    <input
                        type="text"
                        id="habit-name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="مثال: ورزش روزانه"
                    />
                </div>

                <div>
                    <label for="habit-description" class="block text-sm font-medium text-gray-700 mb-2">
                        توضیحات
                    </label>
                    <textarea
                        id="habit-description"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="توضیحات مربوط به عادت..."
                    ></textarea>
                </div>

                <div>
                    <label for="habit-frequency" class="block text-sm font-medium text-gray-700 mb-2">
                        تکرار
                    </label>
                    <select
                        id="habit-frequency"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="daily">روزانه</option>
                        <option value="weekly">هفتگی</option>
                        <option value="monthly">ماهانه</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 mt-6" dir="rtl">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300"
                    >
                        انصراف
                    </button>
                    <button
                        class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700"
                    >
                        ذخیره عادت
                    </button>
                </div>
            </div>

            <!-- Quit Habit Step -->
            <div v-if="modalStep === 'quit-habit'" class="space-y-4" dir="rtl">
                <div class="mb-4">
                    <button
                        @click="goBackToChoice"
                        class="flex items-center text-blue-600 hover:text-blue-800"
                    >
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        بازگشت
                    </button>
                </div>

                <div>
                    <label for="quit-habit-name" class="block text-sm font-medium text-gray-700 mb-2">
                        نام عادتی که می‌خواهید ترک کنید
                    </label>
                    <input
                        type="text"
                        id="quit-habit-name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="مثال: سیگار کشیدن"
                    />
                </div>

                <div>
                    <label for="quit-habit-reason" class="block text-sm font-medium text-gray-700 mb-2">
                        دلیل ترک
                    </label>
                    <textarea
                        id="quit-habit-reason"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="چرا می‌خواهید این عادت را ترک کنید؟"
                    ></textarea>
                </div>

                <div>
                    <label for="quit-habit-alternative" class="block text-sm font-medium text-gray-700 mb-2">
                        جایگزین (اختیاری)
                    </label>
                    <input
                        type="text"
                        id="quit-habit-alternative"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="مثال: به جای سیگار، پیاده‌روی"
                    />
                </div>

                <div class="flex justify-end space-x-3 mt-6" dir="rtl">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300"
                    >
                        انصراف
                    </button>
                    <button
                        class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700"
                    >
                        ثبت ترک عادت
                    </button>
                </div>
            </div>
        </div>
    </Modal>
</template>
