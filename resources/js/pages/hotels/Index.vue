<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
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
import { Button } from '@/components/ui/button';
import { SearchXIcon } from 'lucide-vue-next'
import HotelCardSkeleton from '@/components/HotelCardSkeleton.vue';

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

const resetFilters = () => {
    handleFilterChange('city', 'all');
    handleFilterChange('stars', 'all');
};

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

                <template v-if="isLoading">
                    <HotelCardSkeleton v-for="n in 4" :key="n" />
                </template>

                <template v-else-if="hotels.data.length > 0">
                    <HotelCard v-for="hotel in hotels.data" :key="hotel.id" :hotel="hotel" />
                </template>

                <div v-else class="col-span-full py-20 flex flex-col items-center justify-center border-2 border-dashed rounded-xl">
                    <SearchXIcon class="w-12 h-12 text-neutral-300" />
                    <h3 class="mt-4 text-lg font-medium">No hay resultados</h3>
                    <p class="text-neutral-500">Intenta ajustar los filtros para encontrar lo que buscas.</p>
                    <Button @click="resetFilters" class="mt-2">Limpiar todos los filtros</Button>
                </div>
            </div>

            <Pagination v-if="!isLoading && hotels.data.length > 0" :links="hotels.meta.links" />
        </div>
    </AppLayout>
</template>
