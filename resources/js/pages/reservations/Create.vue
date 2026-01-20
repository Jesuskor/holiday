<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Hotel } from '@/types/hotel';
import HotelSummaryCard from '@/components/HotelSummaryCard.vue';
import HotelReservationForm from '@/components/HotelReservationForm.vue';

const props = defineProps<{
    hotel: Hotel;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Hoteles', href: '/hotels' },
    { title: 'Nueva Reservación', href: '#' },
];

const form = useForm({
    hotel_id: props.hotel.id,
    guest_name: '',    // Antes: customer_name
    guest_email: '',   // Antes: customer_email
    check_in_date: '', // Antes: check_in
    check_out_date: '',// Antes: check_out
    guest_count: 1,    // Antes: num_guests
});


const submitReservation = () => {
    form.post('/reservations', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error('Errores en el formulario:', errors);
        }
    });
};
</script>

<template>
    <Head :title="`Reservar - ${hotel.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-6 max-w-7xl mx-auto">

            <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b pb-6">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-neutral-200">Crear reservación manual</h1>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Ingresa los datos para bloquear habitación y generar folio.</p>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <HotelSummaryCard :hotel="hotel" />
                <main class="lg:col-span-2">
                    <HotelReservationForm
                        :form="form"
                        :hotel-price="Number(hotel.price_per_night)"
                        @submit="submitReservation"
                    />
                </main>
            </div>
        </div>
    </AppLayout>
</template>
