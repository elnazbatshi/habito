<script setup>
import { Head, Link } from '@inertiajs/vue3';



defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-blue-50 text-blue-950 dark:bg-white ">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="/svg/habito-blue-bg.svg"
        />
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-blue-950"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="grid grid-cols-2 items-center gap-2 py-8 lg:grid-cols-3"
                >
                    <div class="flex lg:col-start-2 lg:justify-center">
                        <img src="/images/logo.png" alt="Habit" class="w-44 h-44 object-cover  " />
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-center">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class=" rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-blue-950 dark:hover:text-blue-950/80 dark:focus-visible:ring-white"
                        >

                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                ورود
                            </button>
                        </Link>

                        <template v-else>
                            <div class="flex justify-between">
                                <Link
                                    :href="route('login')"

                                    class="max-h-10  mx-2 border border-red-500 rounded-md px-3 py-2 text-red ring-1 ring-transparent transition hover:text-red-800 focus:outline-none focus-visible:ring-red-300 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus-visible:ring-red-800"

                                >
                                    Login
                                </Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class=" text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 "
                                >
                                    Register
                                </Link>
                            </div>

                        </template>
                    </nav>
                </header>

                <main class="mt-3">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div

                            id="docs-card"
                            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-blue-400 dark: dark:hover:text-blue-950/70 dark:hover:ring-blue-500 dark:focus-visible:ring-[#FF2D20]"
                        >
                            <div
                                id="screenshot-container"
                                class="relative flex w-full flex-1 items-stretch"
                            >
<!--                                <img-->
<!--                                    src="https://laravel.com/assets/img/welcome/docs-light.svg"-->
<!--                                    alt="Laravel documentation screenshot"-->
<!--                                    class="aspect-video h-full w-full flex-1 rounded-[10px] object-cover object-top drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)] dark:hidden"-->
<!--                                    @error="handleImageError"-->
<!--                                />-->
                                <img class="border rounded-lg " src="/images/habit.png"
                                     alt="">
                                <div
                                    class="absolute -bottom-16 -left-16 h-40 w-[calc(100%+8rem)] bg-gradient-to-b from-transparent via-white to-white dark:via-blue-400 dark:to-blue-400"
                                ></div>
                            </div>

                            <div
                                class="relative flex items-center gap-6 lg:items-end"
                            >
                                <div
                                    id="docs-card-content"
                                    class="flex items-start gap-6 lg:flex-col"
                                >
                                    <div class="pt-3 sm:pt-5 lg:pt-0 " dir="rtl">
                                        <h2
                                            class="text-xl font-semibold text-black dark:text-blue-950"
                                        >
                                            «شروع مسیر جدید»
                                        </h2>

                                        <p class="mt-4 text-blue-950 text-sm/relaxed">
                                            با Habito، روند ترک عادت‌های ناپسند تبدیل به یک بازی هیجان‌انگیز می‌شود که انگیزه و تمرکز شما را تا پایان مسیر حفظ می‌کند.
                                        </p>
                                    </div>
                                </div>

                           <img class="pt-3" src="/svg/habitnow-svgrepo-com(3).svg" alt="">
                            </div>
                        </div>

                        <div
                            class="flex items-start
                            gap-4 rounded-lg bg-white p-6
                            shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05]
                            transition duration-300 hover:text-blue-950
                             focus:outline-none focus-visible:ring-[#FF2D20]
                             lg:pb-10 dark:bg-blue-400
                              dark: dark:hover:text-blue-950/70
                              dark:hover:ring-blue-500 dark:focus-visible:ring-[#FF2D20]"
                        >

                            <div class=" sm:pt-5" dir="rtl">
                                <h1 class="text-blue-950 grid text-center my-4 font-bold ">
                                    <strong class="text-blue-950 text-center text-2xl mb-4">Habito</strong>
                                    <br>
                                    یک اپلیکیشن گیمیفای‌شده برای ترک عادت‌های ناپسند و ساختن
                                    عادت‌های سالم و مفیده. با ترکیب روان‌شناسی تغییر رفتار،
                                    طراحی بازی‌محور و ابزارهای پیگیری دقیق، بهت کمک می‌کنه
                                    تو مسیر تغییر بمونی و هر قدم رو با انگیزه برداری.
                                </h1>

                                <h2 class="text-xl  font-bold text-blue-950">🎯 Habito برای کیه؟</h2>
                                <ul class="list-disc pr-6 space-y-2 text-blue-950">
                                    <li>کسی که می‌خواد عادت‌های بد مثل سیگار یا پرخوری رو ترک کنه.</li>
                                    <li>یا عادت‌های خوب مثل ورزش و مطالعه رو بسازه.</li>
                                    <li>و کسی که انگیزه می‌خواد تا وسط راه جا نزنه.</li>
                                </ul>
                            </div>

                        </div>

                        <div
                            class="flex items-start
                            gap-4 rounded-lg bg-white p-6
                            shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05]
                            transition duration-300 hover:text-blue-950
                             focus:outline-none focus-visible:ring-[#FF2D20]
                             lg:pb-10 dark:bg-blue-400
                              dark: dark:hover:text-blue-950/70
                              dark:hover:ring-blue-500 dark:focus-visible:ring-[#FF2D20]"
                        >

                            <div class="pt-3 sm:pt-5" dir="rtl">

                                <h2 class="text-xl font-bold text-blue-950">⚙️ چطور کار می‌کنه؟</h2>
                                <ol class="list-decimal pr-6 space-y-2 text-blue-950">
                                    <li>انتخاب عادت‌ها – عادت‌های خوب یا بدی که می‌خوای روشون کار کنی رو انتخاب می‌کنی.</li>
                                    <li>هدف‌گذاری – زمان، تکرار، میزان سختی و پاداش تعیین می‌کنی.</li>
                                    <li>پیگیری روزانه – هر روز گزارش می‌دی که چطور عمل کردی.</li>
                                    <li>سیستم امتیاز و مراحل – با هر موفقیت، XP و Level می‌گیری و به مراحل بالاتر میری</li>
                                    <li>یادآوری و انگیزه‌بخشی – نوتیفیکیشن‌ها و پیام‌های الهام‌بخش برای اینکه وسط راه رها نکنی.</li>
                                    <li>تحلیل پیشرفت – با نمودارها و گزارش‌ها روند رشدتو ببین و ازش انرژی بگیر.</li>
                                </ol>
                            </div>


                        </div>

                        <div
                            class=" items-start
                            gap-4 rounded-lg bg-white p-6
                            shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05]
                            transition duration-300 hover:text-blue-950
                             focus:outline-none focus-visible:ring-[#FF2D20]
                             lg:pb-10 dark:bg-blue-400
                              dark: dark:hover:text-blue-950/70
                              dark:hover:ring-blue-500 dark:focus-visible:ring-[#FF2D20]"
                        >

                            <div class="pt-3 sm:pt-5" dir="rtl">
                                    <h2 class="text-xl font-bold text-blue-950">🌟 ویژگی‌ها</h2>
                                    <ul class="list-disc pr-6 space-y-2 text-blue-950">
                                        <li>گیمیفیکیشن حرفه‌ای (XP، مراحل، چالش‌ها)</li>
                                        <li>تحلیل پیشرفت با نمودار</li>
                                        <li>یادآوری هوشمند</li>
                                        <li>طراحی ساده و مینیمال</li>
                                        <li>پروفایل و آواتار شخصی</li>
                                    </ul>


                            </div>

                        </div>


                    </div>
                    <div dir="rtl" class="my-4 bg-blue-400 p-4 rounded-xl">
                        <h2 class="text-xl font-bold text-blue-950">🚀 چرا Habito؟</h2>
                        <p class="text-blue-950">
                            چون ترک عادت فقط اراده نمی‌خواد؛ ابزار، انگیزه و مسیر درست هم لازم داره.
                            <br />
                            Habito اون همراهیه که همیشه دنبالش بودی؛ نه قضاوتت می‌کنه، نه جا می‌زنه.
                        </p>
                    </div>
                </main>


            </div>
        </div>
    </div>
</template>
