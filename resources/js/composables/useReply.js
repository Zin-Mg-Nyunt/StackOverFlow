import axios from 'axios';
import { inject, ref } from 'vue';

const useReply = () => {
    let route = inject('route');
    let replies = ref({ data: [] });
    let isReplying = ref(false);
    let replyBody = ref('');
    let submitting = ref(false);
    let isLoaded = ref(false);

    const loadReply = async (id) => {
        let response = await axios.get(route('answer.replies', id));
        replies.value = response.data;
        isLoaded.value = true;
    };
    const handleReply = async (parent_id, question_id) => {
        submitting.value = true;
        try {
            let response = await axios.post(
                route('answer.store', question_id),
                {
                    parent_id,
                    body: replyBody.value,
                },
            );
            replies.value.data.push(response.data);
            replyBody.value = '';
        } catch (error) {
            console.log(error);
        } finally {
            submitting.value = false;
            isReplying.value = false;
        }
    };
    return {
        loadReply,
        handleReply,
        replies,
        isReplying,
        replyBody,
        submitting,
        isLoaded,
    };
};
export default useReply;
