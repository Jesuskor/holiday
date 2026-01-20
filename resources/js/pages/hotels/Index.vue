<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Hotel } from '@/types/hotel';
import HotelCard from '@/components/HotelCard.vue';
import { PaginatedCollection } from '@/types/pagination';

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

            <div class="mt-6 flex justify-center items-center gap-2">
                <template v-for="(link, k) in hotels.meta.links" :key="k">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        v-html="link.label"
                        class="px-4 py-2 text-sm rounded-lg border transition-colors"
                        :class="{
                            'bg-neutral-900 text-white border-neutral-900': link.active,
                            'bg-white text-neutral-700 border-neutral-200 hover:bg-neutral-50': !link.active
                        }"
                    />
                    <span
                        v-else
                        v-html="link.label"
                        class="px-4 py-2 text-sm text-neutral-400 border border-transparent"
                    ></span>
                </template>
            </div>

        </div>
    </AppLayout>
</template>
