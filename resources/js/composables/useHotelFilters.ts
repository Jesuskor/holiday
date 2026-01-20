import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';

export function useHotelFilters(initialFilters: { city?: string, stars?: any }) {
    const selectedCity = ref(initialFilters.city || '');
    const selectedStars = ref(initialFilters.stars ? parseInt(initialFilters.stars) : 0);
    const isLoading = ref(false);

    const hasFilters = computed(() => !!selectedCity.value || selectedStars.value > 0)

    const applyFilters = () => {
        router.get('/hotels', { city: selectedCity.value, stars: selectedStars.value }, {
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

    const handleFilterChange = (type: 'city' | 'stars', value: string) => {
        if (type === 'city') {
            selectedCity.value = value === 'all' ? '' : value;
        } else if (type === 'stars') {
            selectedStars.value = value === 'all' ? 0 : parseInt(value);
        }
        applyFilters();
    }

    const clearFilters = () => {
        selectedCity.value = '';
        selectedStars.value = 0;
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
        selectedStars,
        hasFilters,
        isLoading,
        handleFilterChange,
        clearFilters,
    }
}
