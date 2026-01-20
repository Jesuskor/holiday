<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { computed } from 'vue';
import { CheckCircle2, X } from 'lucide-vue-next';

const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Reservaciones', href: '/reservations' },
];

</script>

<template>
    <Head :title="`Reservar`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-6 w-full">
            <div class="space-y-6 w-full">

                <transition
                    enter-active-class="transform transition duration-300 ease-out"
                    enter-from-class="-translate-y-4 opacity-0"
                    enter-to-class="translate-y-0 opacity-100"
                    leave-active-class="transition duration-200 ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-if="flashSuccess" class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg flex items-center justify-between shadow-sm dark:bg-emerald-950/30 dark:border-emerald-800 dark:text-emerald-400">
                        <div class="flex items-center gap-3">
                            <CheckCircle2 class="w-5 h-5" />
                            <p class="text-sm font-medium">{{ flashSuccess }}</p>
                        </div>
                        <button @click="flashSuccess = null" class="hover:bg-emerald-100 dark:hover:bg-emerald-900 p-1 rounded-full transition-colors">
                            <X class="w-4 h-4" />
                        </button>
                    </div>
                </transition>

                <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b pb-6">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-neutral-200">Listado de reservaciones</h1>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Gestiona las reservas y estados de ocupación.</p>
                    </div>
                </header>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-3 border-2 border-dashed rounded-xl p-20 text-center text-neutral-400">
                        Contenido de reservaciones...
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
