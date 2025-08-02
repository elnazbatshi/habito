<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<!--<template>-->
<!--    <Head title="Dashboard" />-->

<!--    <AuthenticatedLayout>-->
<!--        <template #header>-->
<!--            <h2-->
<!--                class="text-xl font-semibold leading-tight text-gray-800"-->
<!--            >-->
<!--                داشبورد-->
<!--            </h2>-->
<!--        </template>-->

<!--        <div class="py-12">-->
<!--            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">-->
<!--                <div-->
<!--                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"-->
<!--                >-->
<!--                    <div class="p-6 text-gray-900">-->
<!--                        به Habito خوش اومدی!-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </AuthenticatedLayout>-->
<!--</template>-->
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// ایمپورت استور کانتر
import { useCounterStore } from '@/stores/counter';

const counter = useCounterStore();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                داشبورد
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        به Habito خوش اومدی!
                    </div>

                    <div class="mt-4">
                        <p>عدد فعلی: {{ counter.count }}</p>
                        <button @click="counter.increment" class="mr-2 px-4 py-2 bg-blue-500 text-white rounded">+</button>
                        <button @click="counter.decrement" class="px-4 py-2 bg-red-500 text-white rounded">-</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
