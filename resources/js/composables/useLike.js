import axios from 'axios';
import { inject, ref } from 'vue';

const useLike = () => {
    const route = inject('route');
    let processing = ref(false);
    const like = async (likeable_type, likeable_id, item) => {
        let response = await axios.post(
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
        item.likes_count = response.data.likes_count;
        item.isLiked = response.data.isLiked;
    };
    return { like, processing };
};

export default useLike;
