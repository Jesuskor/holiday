<script setup lang="ts">
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { RotateCcwIcon } from 'lucide-vue-next';

interface Props {
    cities: string[];
    selectedCity?: string;
    selectedStars?: string | number;
    isLoading: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits(['change', 'reset']);

const STAR_OPTIONS = [5, 4, 3, 2, 1];
</script>

<template>
    <div class="flex flex-wrap items-center justify-end gap-3 p-3 rounded-lg">
        <div class="flex items-center gap-2">
            <span class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Ciudad</span>
            <Select
                :model-value="selectedCity || 'all'"
                :disabled="isLoading"
                @update:model-value="emit('change', 'city', $event)"
            >
                <SelectTrigger class="w-[160px] h-9">
                    <SelectValue placeholder="Ciudad" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="all">Todas</SelectItem>
                    <SelectItem v-for="city in cities" :key="city" :value="city">{{ city }}</SelectItem>
                </SelectContent>
            </Select>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Estrellas</span>
            <Select
                :model-value="String(selectedStars || 'all')"
                :disabled="isLoading"
                @update:model-value="emit('change', 'stars', $event)"
            >
                <SelectTrigger class="w-[140px] h-9">
                    <SelectValue placeholder="Estrellas" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="all">Todas</SelectItem>
                    <SelectItem v-for="star in STAR_OPTIONS" :key="star" :value="String(star)">
                        {{ star }} estrellas
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>

        <Button
            variant="ghost"
            size="sm"
            class="h-9 px-2 text-neutral-500 cursor-pointer"
            @click="emit('reset')"
            :disabled="isLoading"
        >
            <RotateCcwIcon class="w-4 h-4 mr-1" />
            Limpiar
        </Button>
    </div>
</template>
