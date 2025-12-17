import { router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const useFilter = () => {
    let page = usePage();

    const search = ref(page.props.filters?.search ?? '');
    const slug = ref(page.props.filters?.tag ?? null);

    watch(search, (value) => {
        router.get('/', {
            ...page.props.filters,
            search: value,
        });
    });

    watch(slug, (value) => {
        router.get('/', {
            ...page.props.filters,
            tag: value,
        });
    });

    return { search, slug };
};

export default useFilter;
