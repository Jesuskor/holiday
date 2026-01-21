<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { CheckCircle2, X, AlertCircle } from 'lucide-vue-next';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';

const page = usePage();
// Tipado para evitar errores de TS
const flash = computed(() => page.props.flash as { success?: string; error?: string });
const isVisible = ref(false);

watch(() => flash.value, (newVal) => {
    if (newVal?.success || newVal?.error) {
        isVisible.value = true;
    }
}, { immediate: true });

const close = () => {
    isVisible.value = false;
};
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
        <div v-if="isVisible && (flash.success || flash.error)" class="relative">
            <Alert :variant="flash.success ? 'default' : 'destructive'"
                   :class="flash.success ? 'border-emerald-500/50 bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 [&>svg]:text-emerald-600' : ''">
                <CheckCircle2 v-if="flash.success" class="h-4 w-4" />
                <AlertCircle v-else class="h-4 w-4" />

                <AlertTitle>{{ flash.success ? '¡Éxito!' : 'Error' }}</AlertTitle>
                <AlertDescription>
                    {{ flash.success || flash.error }}
                </AlertDescription>

                <button
                    @click="close"
                    class="absolute right-4 top-4 p-1 rounded-full opacity-70 transition-opacity hover:opacity-100"
                >
                    <X class="h-4 w-4" />
                </button>
            </Alert>
        </div>
    </transition>
</template>
