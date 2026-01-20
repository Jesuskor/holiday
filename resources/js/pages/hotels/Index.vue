<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Hotel } from '@/types/hotel';
import HotelCard from '@/components/HotelCard.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Hoteles',
        href: '/',
    },
];

const props = defineProps<{
    hotels: {
        data: Hotel[];
    };
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
        </div>
    </AppLayout>
</template>
