<script setup lang="ts">
import { computed } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { UserPlus, Calendar as CalendarIcon } from 'lucide-vue-next';
import { formatCurrency, calculateNights } from '@/lib/utils';

const props = defineProps<{
    form: any;
    hotelPrice: number;
}>();

const emit = defineEmits(['submit']);

const totalNights = computed(() => calculateNights(props.form.check_in_date, props.form.check_out_date));

const totalPrice = computed(() => {
    const total = totalNights.value * props.hotelPrice;
    return formatCurrency(total);
});

const formattedBasePrice = computed(() => formatCurrency(props.hotelPrice));
</script>

<template>
    <form @submit.prevent="$emit('submit')" class="bg-white dark:bg-neutral-900 border rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 space-y-8">
            <div class="space-y-4">
                <h3 class="text-sm font-bold flex items-center gap-2 border-b pb-2 text-neutral-400 uppercase tracking-tighter">
                    <UserPlus class="w-4 h-4" /> Información del Cliente
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <Label for="guest_name">Nombre completo</Label>
                        <Input id="guest_name" placeholder="Jhon Doe" v-model="form.guest_name" :class="{'border-red-500': form.errors.guest_name}" />
                        <span v-if="form.errors.guest_name" class="text-xs text-red-600">{{ form.errors.guest_name }}</span>
                    </div>
                    <div class="space-y-2">
                        <Label for="guest_email">Email</Label>
                        <Input id="guest_email" placeholder="jhondoe@holiday.com" v-model="form.guest_email" type="email" />
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
                        <span v-if="form.errors.check_out_date" class="text-xs text-red-600">{{ form.errors.check_out_date }}</span>
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

            <Button type="submit" :disabled="form.processing" class="h-12 px-10">
                {{ form.processing ? 'Registrando...' : 'Confirmar Reserva' }}
            </Button>
        </footer>
    </form>
</template>
