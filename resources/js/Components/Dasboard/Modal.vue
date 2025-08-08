<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionRoot } from '@headlessui/vue'

const isOpen = ref(false)

const openModal = () => {
    isOpen.value = true
}
const closeModal = () => {
    isOpen.value = false
}
</script>

<template>
    <!-- دکمه گرد با علامت + -->
    <button
        @click="openModal"
        class="fixed bottom-6 right-6 w-12 h-12 flex items-center justify-center bg-blue-500 text-white text-2xl rounded-full shadow-lg hover:bg-blue-600 transition"
    >
        +
    </button>

    <!-- مودال -->
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" class="relative z-50" @close="closeModal">
            <div class="fixed inset-0 bg-black bg-opacity-30" />

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <DialogPanel
                        class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all"
                    >
                        <DialogTitle class="text-lg font-medium leading-6 text-gray-900">
                            انتخاب کنید
                        </DialogTitle>

                        <div class="mt-4 flex flex-col gap-3">
                            <button
                                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                            >
                                میخوام یه عادتی ترک کنم
                            </button>
                            <button
                                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                            >
                                میخوام یه عادتی بسازم
                            </button>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button
                                @click="closeModal"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                            >
                                بستن
                            </button>
                        </div>
                    </DialogPanel>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
