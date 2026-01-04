import { router } from '@inertiajs/vue3';
import { inject, ref } from 'vue';

const useLike = () => {
    const route = inject('route');
    let processing = ref(false);
    const like = (likeable_type, likeable_id) => {
        router.post(
            route('like.toggle'),
            {
                likeable_type,
                likeable_id,
            },
            {
                preserveScroll: true,
                onBefore: () => (processing.value = true),
                onFinish: () => (processing.value = false),
            },
        );
    };
    return { like, processing };
};

export default useLike;
