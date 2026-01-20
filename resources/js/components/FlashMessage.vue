<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { CheckCircle2, X, AlertCircle } from 'lucide-vue-next';

const page = usePage();
const flash = computed(() => page.props.flash as { success?: string; error?: string });
const isVisible = ref(false);

// Observar cambios en los mensajes flash para mostrar la alerta
watch(() => flash.value, (newVal) => {
    if (newVal.success || newVal.error) {
        isVisible.value = true;
    }
}, { immediate: true });
</script>

<template>
    <transition
        enter-active-class="transform transition duration-300 ease-out"
        enter-from-class="-translate-y-4 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="isVisible && (flash.success || flash.error)"
             :class="[
                 'p-4 rounded-lg flex items-center justify-between shadow-sm border',
                 flash.success ? 'bg-emerald-50 border-emerald-200 text-emerald-800 dark:bg-emerald-950/30 dark:border-emerald-800 dark:text-emerald-400' : 'bg-red-50 border-red-200 text-red-800 dark:bg-red-950/30 dark:border-red-800 dark:text-red-400'
             ]">
            <div class="flex items-center gap-3">
                <CheckCircle2 v-if="flash.success" class="w-5 h-5" />
                <AlertCircle v-else class="w-5 h-5" />
                <p class="text-sm font-medium">{{ flash.success || flash.error }}</p>
            </div>
            <button @click="isVisible = false" class="p-1 rounded-full transition-colors hover:bg-black/5 dark:hover:bg-white/5">
                <X class="w-4 h-4" />
            </button>
        </div>
    </transition>
</template>
