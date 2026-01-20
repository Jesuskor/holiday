import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';

export function useHotelFilters(initialFilters: { city?: string }) {
    const selectedCity = ref(initialFilters.city || '');
    const isLoading = ref(false);

    const hasFilters = computed(() => !!selectedCity.value)

    const applyFilters = () => {
        router.get('/hotels', { city: selectedCity.value }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            only: ['hotels', 'filters'],
            onBefore: () => {
                isLoading.value = true
            },
            onFinish: () => {
                isLoading.value = false
            }
        })
    }

    const handleFilterChange = (type: 'city', value: string) => {
        if (type === 'city') {
            selectedCity.value = value === 'all' ? '' : value;
        }
        applyFilters();
    }

    const clearFilters = () => {
        selectedCity.value = '';
        router.get('/hotels', {}, {
            preserveState: true,
            replace: true,
            onBefore: () => {
                isLoading.value = true
            },
            onFinish: () => {
                isLoading.value = false
            }
        })
    }

    return {
        selectedCity,
        hasFilters,
        isLoading,
        handleFilterChange,
        clearFilters,
    }
}
