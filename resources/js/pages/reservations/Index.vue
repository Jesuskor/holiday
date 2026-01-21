<script setup lang="ts">
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { formatCurrency, formatDate } from '@/lib/utils';
import { PaginatedCollection } from '@/types/pagination';
import Pagination from '@/components/Pagination.vue';
import { Reservation } from '@/types/reservation';
import FlashMessage from '@/components/FlashMessage.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import CancelReservationDialog from '@/components/CancelReservationDialog.vue';
import EmptyState from '@/components/EmptyState.vue';

const props = defineProps<{
    reservations: PaginatedCollection<Reservation>;
}>();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Reservaciones', href: '/reservations' }];

const STATUS_MAP = {
    pending: { label: 'Pendiente', class: 'bg-amber-100 text-amber-700 ...' },
    confirmed: { label: 'Confirmada', class: 'bg-emerald-100 text-emerald-700 ...' },
    cancelled: { label: 'Cancelada', class: 'bg-red-100 text-red-700 ...' },
} as const;

const isCancelDialogOpen = ref(false);
const idToCancel = ref<number | null>(null);

const triggerCancel = (id: number) => {
    idToCancel.value = id;
    isCancelDialogOpen.value = true;
};

const goToCreate = () => router.get('/hotels');
</script>

<template>
    <Head title="Reservaciones" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-6 w-full">
            <FlashMessage />

            <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b pb-6">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Listado de reservaciones</h1>
                    <p class="text-neutral-500 text-sm">Gestiona las reservas y estados de ocupación.</p>
                </div>
            </header>

            <div v-if="reservations.data.length > 0">
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
                            <TableCell class="text-right font-bold">{{ formatCurrency(res.total_price) }}</TableCell>
                            <TableCell class="text-right">
                                <Badge v-if="STATUS_MAP[res.status]" :class="STATUS_MAP[res.status].class" variant="outline">
                                    {{ STATUS_MAP[res.status].label }}
                                </Badge>
                            </TableCell>
                            <TableCell class="text-right">
                                <Button
                                    :class="{ 'opacity-50 disabled': res.status === 'cancelled' }"
                                    :disabled="res.status === 'cancelled'"
                                    variant="destructive" size="sm" @click="triggerCancel(res.id)">
                                    Cancelar
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Pagination class="mt-4" :links="reservations.meta.links" />
            </div>

            <EmptyState
                v-else
                title="Sin reservaciones"
                description="Aún no tienes registros. Comienza creando tu primera reserva."
                icon="book"
            >
                <Button @click="goToCreate">Crear reservación</Button>
            </EmptyState>

            <CancelReservationDialog v-model:open="isCancelDialogOpen" :reservation-id="idToCancel" />
        </div>
    </AppLayout>
</template>
