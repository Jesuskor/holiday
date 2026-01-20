<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { PaginationLink } from '@/types/pagination';

defineProps<{
    links: PaginationLink[];
}>();

</script>

<template>
    <div class="mt-6 flex justify-center items-center gap-2">
        <template v-for="(link, k) in links" :key="k">
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
</template>
