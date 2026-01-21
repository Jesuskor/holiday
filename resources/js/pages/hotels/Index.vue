<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Hotel } from '@/types/hotel';
import HotelCard from '@/components/HotelCard.vue';
import { PaginatedCollection } from '@/types/pagination';
import Pagination from '@/components/Pagination.vue';
import { useHotelFilters } from '@/composables/useHotelFilters';
import { Button } from '@/components/ui/button';
import HotelCardSkeleton from '@/components/HotelCardSkeleton.vue';
import HotelFilters from '@/components/HotelFilters.vue';
import EmptyState from '@/components/EmptyState.vue';
import SimpleFooter from '@/components/SimpleFooter.vue';

const props = defineProps<{
    hotels: PaginatedCollection<Hotel>;
    cities: string[];
    filters: { city?: string, stars?: number }
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Hoteles', href: '/' },
];

const { selectedCity, selectedStars, isLoading, handleFilterChange } = useHotelFilters(props.filters);

const resetFilters = () => {
    handleFilterChange('city', 'all');
    handleFilterChange('stars', 'all');
};
</script>

<template>
    <Head title="Hoteles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">

            <HotelFilters
                :cities="cities"
                :selected-city="selectedCity"
                :selected-stars="selectedStars"
                :is-loading="isLoading"
                @change="handleFilterChange"
                @reset="resetFilters"
            />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <template v-if="isLoading">
                    <HotelCardSkeleton v-for="n in 4" :key="n" />
                </template>

                <template v-else-if="hotels.data.length > 0">
                    <HotelCard v-for="hotel in hotels.data" :key="hotel.id" :hotel="hotel" />
                </template>

                <EmptyState
                    v-else
                    class="col-span-full"
                    title="No hay resultados"
                    description="Intenta ajustar los filtros para encontrar lo que buscas."
                    icon="search"
                >
                    <Button variant="outline" @click="resetFilters">Limpiar filtros</Button>
                </EmptyState>
            </div>

            <Pagination
                v-if="!isLoading && hotels.data.length > 0"
                :links="hotels.meta.links"
            />

            <SimpleFooter />

        </div>
    </AppLayout>
</template>
