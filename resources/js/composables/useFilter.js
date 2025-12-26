import { router, usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { ref, watch } from 'vue';

const useFilter = () => {
    let page = usePage();

    const search = ref(page.props.filters?.search ?? '');
    const slug = ref(page.props.filters?.tag ?? null);
    const handleSearch = debounce((value) => {
        router.get(
            '/',
            {
                ...page.props.filters,
                search: value,
            },
            {
                preserveScroll: true,
            },
        );
    }, 400);

    watch(search, (value) => {
        handleSearch(value);
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
