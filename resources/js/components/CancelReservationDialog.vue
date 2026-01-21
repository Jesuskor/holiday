<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';

const props = defineProps<{
    reservationId: number | null;
}>();

// Sincronización bidireccional del estado abierto/cerrado
const open = defineModel<boolean>('open');

const form = useForm({});

const handleCancel = () => {
    if (!props.reservationId) return;

    form.patch(`/reservations/${props.reservationId}/cancel`, props.reservationId), {
        onSuccess: () => {
            open.value = false;
        },
    };
};
</script>

<template>
    <AlertDialog :open="open" @update:open="open = $event">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>¿Confirmar cancelación?</AlertDialogTitle>
                <AlertDialogDescription>
                    Esta acción marcará la reservación como cancelada. Esta acción no se puede deshacer.
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel :disabled="form.processing">Volver</AlertDialogCancel>
                <AlertDialogAction
                    @click.prevent="handleCancel"
                    :disabled="form.processing"
                    class="bg-red-600 dark:bg-red-400 dark:text-red-950 dark:hover:bg-red-700 cursor-pointer hover:bg-red-700"
                >
                    {{ form.processing ? 'Cancelando...' : 'Confirmar Cancelación' }}
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
