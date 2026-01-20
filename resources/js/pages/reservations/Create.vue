<script setup lang="ts">
import { computed } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Hotel } from '@/types/hotel';

// Shadcn UI
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

// Icons
import {
    Calendar as CalendarIcon,
    UserPlus,
    MapPin,
    Star,
    Mail,
    Users,
    Info
} from 'lucide-vue-next';
import HotelSummaryCard from '@/components/HotelSummaryCard.vue';

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


// Calcula cuántas noches hay entre check-in y check-out
const totalNights = computed(() => {
    if (!form.check_in_date || !form.check_out_date) return 0;
    const start = new Date(form.check_in_date);
    const end = new Date(form.check_out_date);
    const diff = end.getTime() - start.getTime();
    const nights = Math.ceil(diff / (1000 * 60 * 60 * 24));
    return nights > 0 ? nights : 0;
});

const totalPrice = computed(() => {
    const total = totalNights.value * props.hotel.price_per_night;
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(total);
});

const formattedBasePrice = computed(() => {
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(props.hotel.price_per_night);
});

const submitReservation = () => {
    form.post('/reservations', {
        preserveScroll: true,
        onSuccess: () => {
            // Opcional: limpiar el formulario o mostrar una notificación
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
                    <form @submit.prevent="submitReservation" class="bg-white dark:bg-neutral-900 border rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6 space-y-8">

                            <div class="space-y-4">
                                <h3 class="text-sm font-bold flex items-center gap-2 border-b pb-2 text-neutral-400 uppercase tracking-tighter">
                                    <UserPlus class="w-4 h-4" /> Información del Cliente
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <Label for="guest_name">Nombre completo</Label>
                                        <Input id="guest_name" v-model="form.guest_name" placeholder="Ej. John Doe" :class="{'border-red-500': form.errors.guest_name}" />
                                        <span v-if="form.errors.guest_name" class="text-xs text-red-600">{{ form.errors.guest_name }}</span>
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="guest_email">Email</Label>
                                        <Input id="guest_email" v-model="form.guest_email" type="email" placeholder="john@example.com" />
                                        <span v-if="form.errors.guest_email" class="text-xs text-red-600">{{ form.errors.guest_email }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-sm font-bold flex items-center gap-2 border-b pb-2 text-neutral-400 uppercase tracking-tighter">
                                    <CalendarIcon class="w-4 h-4" /> Detalles de Estancia
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="space-y-2">
                                        <Label>Check-in</Label>
                                        <Input v-model="form.check_in_date" type="date" />
                                        <span v-if="form.errors.check_in_date" class="text-xs text-red-600">{{ form.errors.check_in_date }}</span>
                                    </div>
                                    <div class="space-y-2">
                                        <Label>Check-out</Label>
                                        <Input v-model="form.check_out_date" type="date" :min="form.check_in_date" />
                                        <span v-if="form.errors.check_in_date" class="text-xs text-red-600">{{ form.errors.check_in_date }}</span>
                                    </div>
                                    <div class="space-y-2">
                                        <Label>Huéspedes</Label>
                                        <Input v-model.number="form.guest_count" type="number" min="1" />
                                        <span v-if="form.errors.guest_count" class="text-xs text-red-600">{{ form.errors.guest_count }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <footer class="bg-neutral-100 dark:bg-neutral-800 border-t p-6 flex items-center justify-between">
                            <div class="flex gap-8">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-neutral-400 uppercase">Por noche</span>
                                    <span class="font-bold text-lg text-neutral-500">{{ formattedBasePrice }}</span>
                                </div>
                                <div class="flex flex-col border-l pl-8">
                                    <span class="text-[10px] font-bold text-neutral-500 uppercase">Total a pagar</span>
                                    <span class="font-extrabold text-2xl text-neutral-800 dark:text-neutral-200">{{ totalPrice }}</span>
                                </div>
                            </div>

                            <Button
                                type="submit"
                                :disabled="form.processing"
                                class="bg-neutral-900 dark:bg-neutral-200 hover:bg-neutral-700 dark:hover:bg-neutral-400 h-12 px-10 text-base transition-colors cursor-pointer"
                            >
                                <span v-if="form.processing">Registrando...</span>
                                <span v-else>Confirmar Reserva</span>
                            </Button>
                        </footer>
                    </form>
                </main>
            </div>
        </div>
    </AppLayout>
</template>
