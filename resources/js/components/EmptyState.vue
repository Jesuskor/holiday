<script setup lang="ts">
import { SearchX, Inbox, BookX, AlertCircle } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    title: string;
    description?: string;
    // Permitimos pasar el nombre de un icono o el componente del icono directamente
    icon?: 'search' | 'empty' | 'book' | 'error';
}

const props = defineProps<Props>();

const iconComponent = computed(() => {
    switch (props.icon) {
        case 'search': return SearchX;
        case 'book': return BookX;
        case 'error': return AlertCircle;
        default: return Inbox;
    }
});
</script>

<template>
    <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed p-12 text-center animate-in fade-in zoom-in duration-300">
        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-neutral-50 dark:bg-neutral-900">
            <component :is="iconComponent" class="h-10 w-10 text-neutral-400" />
        </div>

        <h3 class="mt-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
            {{ title }}
        </h3>

        <p v-if="description" class="mt-2 mb-6 max-w-sm text-sm text-neutral-500 dark:text-neutral-400">
            {{ description }}
        </p>

        <div class="flex gap-3">
            <slot />
        </div>
    </div>
</template>
