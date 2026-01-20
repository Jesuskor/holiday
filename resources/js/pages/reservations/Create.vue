<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Hotel } from '@/types/hotel';
import HotelCard from '@/components/HotelCard.vue';
import { PaginatedCollection } from '@/types/pagination';
import Pagination from '@/components/Pagination.vue';
import { useHotelFilters } from '@/composables/useHotelFilters';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Hoteles',
        href: '/hotels',
    },
    {
        title: 'Reservación',
        href: '/hotels/',
    },
];

defineProps<{
    hotel: Hotel[];
}>();


</script>

<template>
    <Head title="Hoteles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            Reservacion {{ hotel }}
        </div>
    </AppLayout>
</template>
