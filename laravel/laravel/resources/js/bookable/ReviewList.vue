<template>
    <div style="padding: 1.25rem">
        <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">レビュー一覧</h6>

        <div v-if="loading">読み込み中...</div>
        <div v-else>
            <div class="border-bottom d-none d-md-block" v-for="(review, index) in reviews" :key="index">
                <div class="row">
                    <div class="col-md-12">{{ fromNow(review.created_at) }}</div>
                </div>
                <div class="row pt-4 pb-4">
                    <div class="col-md-12">{{ review.content }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    props:{
        bookableId: [String, Number]
    },
    data() {
        return{
            loading: false,
            reviews: null
        }
    },
    async created(){
        this.loading = true;
        const response = await axios.get(`/api/bookables/${this.bookableId}/reviews`);
        this.reviews = response.data.data;
        this.loading = false
    },
    methods: {
        fromNow(value) {
            return moment(value).fromNow();
        }
    }
};
</script>
