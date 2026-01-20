<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { computed } from 'vue';
import { CheckCircle2, X } from 'lucide-vue-next';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableFooter,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Reservaciones', href: '/reservations' },
];

interface Reservation {
    id: number,
    hotel: string;
    guest_name: string;
    check_in_date: string;
    check_out_date: string;
    total_price: number;
    status: string;
}

const props = defineProps<{
    reservations: Reservation[];
}>();

// Función para formatear dinero
const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
};

// Función para formatear fechas de forma legible
const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('es-MX', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
};

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

                <div>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Hotel</TableHead>
                                <TableHead>Cliente</TableHead>
                                <TableHead>Check-in</TableHead>
                                <TableHead>Check-out</TableHead>
                                <TableHead class="text-right">Total</TableHead>
                                <TableHead class="text-right">Estado</TableHead>
                                <TableHead class="text-right">Acciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="res in reservations" :key="res.id">
                                <TableCell>{{ res.hotel.name }}</TableCell>
                                <TableCell>{{ res.guest_name }}</TableCell>
                                <TableCell>{{ formatDate(res.check_in_date) }}</TableCell>
                                <TableCell>{{ formatDate(res.check_out_date) }}</TableCell>
                                <TableCell class="text-right font-bold">
                                    {{ formatCurrency(res.total_price) }}
                                </TableCell>
                                <TableCell class="text-right font-bold">
                                    {{ res.status }}
                                </TableCell>
                                <TableCell class="text-right">
                                    <button class="text-xs text-blue-600 hover:underline">Cancelar</button>
                                </TableCell>
                            </TableRow>

                            <TableRow v-if="reservations.length === 0">
                                <TableCell colspan="6" class="h-24 text-center text-neutral-500">
                                    No hay reservaciones registradas.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
