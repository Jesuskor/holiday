<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Hotel } from '@/types/hotel';
import HotelCard from '@/components/HotelCard.vue';
import { PaginatedCollection } from '@/types/pagination';
import Pagination from '@/components/Pagination.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Hoteles',
        href: '/',
    },
];

const props = defineProps<{
    hotels: PaginatedCollection<Hotel>;
}>();

</script>

<template>
    <Head title="Hoteles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                <HotelCard
                    v-for="hotel in hotels.data"
                    :key="hotel.id"
                    :hotel="hotel"
                />
            </div>
            <Pagination :links="hotels.meta.links" />
        </div>
    </AppLayout>
</template>
