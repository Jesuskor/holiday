<script setup lang="ts">
import { Hotel } from '@/types/hotel';

// Definimos que este componente recibe un objeto tipo Hotel
defineProps<{
    hotel: Hotel;
}>();
</script>

<template>
    <article class="group bg-neutral-100 dark:bg-neutral-900 dark:border-neutral-800 flex flex-row h-full gap-4 text-neutral-800 dark:text-neutral-300 hover:text-neutral-100 hover:bg-neutral-800 transition-all duration-300 p-3 rounded-xl border border-neutral-100">

        <div class="w-1/3 min-w-[140px] rounded-lg overflow-hidden relative">
            <img :src="hotel.image_url" :alt="`Foto principal del hotel ${hotel.name}`" class="w-full h-full object-cover">
        </div>

        <div class="flex flex-col justify-between flex-1 py-1">
            <div>
                <div class="flex justify-between items-start">
                    <h3 class="font-semibold text-xl leading-tight">
                        {{ hotel.name }}
                    </h3>
                    <span class="font-medium text-sm flex items-center bg-neutral-800 text-neutral-200 group-hover:bg-neutral-300 group-hover:text-neutral-800 px-2 py-0.5 rounded">
                        {{ hotel.star_rating }} ★
                    </span>
                </div>

                <p class="text-neutral-600 dark:text-neutral-400 group-hover:text-neutral-400 mt-1 text-sm">
                    {{ hotel.city }}
                </p>

                <p class="font-bold text-lg mt-2">
                    ${{ hotel.price_per_night }}
                    <small class="text-neutral-600 group-hover:text-neutral-400 dark:text-neutral-400 font-normal text-xs">p/noche</small>
                </p>
            </div>

            <a :href="`/hotels/${hotel.id}`"
               class="mt-3 dark:bg-neutral-800 block text-center bg-neutral-900 text-white hover:bg-neutral-300 group-hover:bg-neutral-100 dark:group-hover:bg-neutral-300 group-hover:text-neutral-900 transition-colors py-2 rounded-lg font-medium text-sm">
                Reservar
            </a>
        </div>
    </article>
</template>
