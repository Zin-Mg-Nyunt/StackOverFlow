import { router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const useFilter = () => {
    let page = usePage();

    const filters = ref({
        search: page.props.filters.search ?? '',
        tag: page.props.filters.tag ?? null,
    });

    watch(
        filters,
        () => {
            router.get('/', filters.value);
        },
        { deep: true },
    );
    return { filters };
};

export default useFilter;
