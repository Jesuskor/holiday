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
        href: '/',
    },
];

const props = defineProps<{
    hotels: PaginatedCollection<Hotel>;
    cities: string[];
    filters: { city?: string, stars?: number }
}>();

const { selectedCity, selectedStars, isLoading, handleFilterChange } = useHotelFilters(props.filters)

const STAR_OPTIONS = [5, 4, 3, 2, 1];

// TODO:
// Visualizar estados: error, carga, vacío
// Extraer a un componente el area de filtrado

</script>

<template>
    <Head title="Hoteles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <div class="flex items-center justify-end gap-2">
                <small class="text-neutral-400 dark:text-neutral-500">Filtrar por</small>
                <Select :model-value="selectedCity || 'all'" @update:model-value="handleFilterChange('city', $event)" class="w-full" :disabled="isLoading">
                    <SelectTrigger class="w-[180px]">
                        <SelectValue placeholder="Selecciona una ciudad..." />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Listado de ciudades</SelectLabel>
                            <SelectItem value="all">Todas las ciudades</SelectItem>
                            <SelectItem v-for="city in cities" :value="city" :key="city">
                                {{ city }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select :model-value="String(selectedStars || 'all')" @update:model-value="handleFilterChange('stars', $event)">
                    <SelectTrigger class="w-[180px]">
                        <SelectValue placeholder="Estrellas" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="all">Todas las estrellas</SelectItem>
                            <SelectItem v-for="star in STAR_OPTIONS" :value="String(star)" :key="star">
                                {{ star }} estrellas
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>

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
