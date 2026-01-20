<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
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
import { formatCurrency, formatDate } from '@/lib/utils';
import { PaginatedCollection } from '@/types/pagination';
import Pagination from '@/components/Pagination.vue';
import { Reservation } from '@/types/reservation';
import FlashMessage from '@/components/FlashMessage.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button'

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Reservaciones', href: '/reservations' },
];

const props = defineProps<{
    reservations: PaginatedCollection<Reservation>;
}>();

const STATUS_MAP = {
    pending: {
        label: 'Pendiente',
        class: 'bg-amber-100 text-amber-700 hover:bg-amber-100 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200 dark:border-amber-800'
    },
    confirmed: {
        label: 'Confirmada',
        class: 'bg-emerald-100 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/30 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800'
    },
    cancelled: {
        label: 'Cancelada',
        class: 'bg-red-100 text-red-700 hover:bg-red-100 dark:bg-red-950/30 dark:text-red-400 border-red-200 dark:border-red-800'
    },
} as const;

</script>

<template>
    <Head :title="`Reservar`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-6 w-full">
            <div class="space-y-6 w-full">

                <FlashMessage />

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
                            <TableRow v-for="res in reservations.data" :key="res.id">
                                <TableCell>{{ res.hotel.name }}</TableCell>
                                <TableCell>{{ res.guest_name }}</TableCell>
                                <TableCell>{{ formatDate(res.check_in_date) }}</TableCell>
                                <TableCell>{{ formatDate(res.check_out_date) }}</TableCell>
                                <TableCell class="text-right font-bold">
                                    {{ formatCurrency(res.total_price) }}
                                </TableCell>
                                <TableCell class="text-right font-bold">
                                    <Badge
                                        v-if="STATUS_MAP[res.status]"
                                        :class="STATUS_MAP[res.status].class"
                                        variant="outline"
                                    >
                                        {{ STATUS_MAP[res.status].label }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <button class="text-xs text-blue-600 hover:underline">Cancelar</button>
                                </TableCell>
                            </TableRow>

                            <TableRow v-if="reservations.data.length === 0">
                                <TableCell colspan="6" class="h-24 text-center text-neutral-500">
                                    No hay reservaciones registradas.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                    <Pagination :links="reservations.meta.links" />

                </div>
            </div>
        </div>
    </AppLayout>
</template>
