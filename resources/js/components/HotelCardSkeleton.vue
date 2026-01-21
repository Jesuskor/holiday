<script setup lang="ts">
import { Skeleton } from '@/components/ui/skeleton';
</script>

<template>
    <div class="bg-neutral-100 dark:bg-neutral-900 flex flex-row h-full gap-4 p-3 rounded-xl border border-neutral-100 dark:border-neutral-800">
        <div class="w-1/3 min-w-[140px] rounded-lg overflow-hidden">
            <Skeleton class="w-full h-full min-h-[120px]" />
        </div>

        <div class="flex flex-col justify-between flex-1 py-1 space-y-3">
            <div>
                <div class="flex justify-between items-start">
                    <Skeleton class="h-6 w-3/4" /> <Skeleton class="h-6 w-10" />  </div>
                <Skeleton class="h-4 w-1/2 mt-2" /> <Skeleton class="h-6 w-1/3 mt-4" /> </div>
            <Skeleton class="h-9 w-full rounded-lg" /> </div>
    </div>
</template>
