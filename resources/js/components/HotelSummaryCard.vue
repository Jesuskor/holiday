<script setup lang="ts">
import { MapPin, Star } from 'lucide-vue-next';
import { Label } from '@/components/ui/label';
import { Hotel } from '@/types/hotel';

defineProps<{
    hotel: Hotel;
}>();
</script>

<template>
    <aside class="space-y-4">
        <section class="bg-white dark:bg-neutral-900 border rounded-xl p-5 shadow-sm space-y-4">
            <div class="relative aspect-video rounded-lg overflow-hidden border shadow-inner">
                <div class="absolute top-3 left-3 z-10 bg-black/70 backdrop-blur-md px-2.5 py-1 rounded-full border border-white/20">
                    <div class="flex items-center gap-1.5 text-white">
                        <Star class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400" />
                        <span class="text-xs font-bold">{{ hotel.star_rating }}</span>
                    </div>
                </div>
                <img :src="hotel.image_url" :alt="hotel.name" class="w-full h-full object-cover">
            </div>

            <div class="grid gap-4 pt-2">
                <div>
                    <Label class="text-[10px] text-neutral-400 uppercase tracking-widest">Hotel</Label>
                    <p class="font-semibold text-neutral-800 dark:text-neutral-200">{{ hotel.name }}</p>
                </div>
                <div>
                    <Label class="text-[10px] text-neutral-400 uppercase tracking-widest">Ubicación</Label>
                    <p class="text-sm text-neutral-600 dark:text-neutral-200 flex items-start gap-1.5">
                        <MapPin class="w-4 h-4 text-neutral-400 dark:text-neutral-500 shrink-0" />
                        {{ hotel.city }}, {{ hotel.address }}
                    </p>
                </div>
            </div>
        </section>
    </aside>
</template>
