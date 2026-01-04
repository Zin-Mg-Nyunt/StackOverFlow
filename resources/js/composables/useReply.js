import axios from 'axios';
import { inject, ref } from 'vue';

const useReply = () => {
    let route = inject('route');
    let replies = ref({});
    const loadReply = async (id) => {
        let response = await axios.get(route('answer.replies', id));
        replies.value[id] = response.data;
    };
    return { loadReply, replies };
};
export default useReply;
