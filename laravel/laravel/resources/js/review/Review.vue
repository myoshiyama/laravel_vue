<template>
    <div>
        <div v-if="loading">読み込み中...</div>
        <div v-else>
            <div v-if="alreadyReviewed">
                <h3>すでにレビュー済みです！</h3>
            </div>
            <div v-else>
                <div class="form-group">
                    <label for="content" class="text-muted">コメントを入力してください</label>
                    <textarea name="content" cols="30" rows="10" class="form-control" v-model="review.content"></textarea>
                </div>

                <button class="btn btn-lg btn-primary btn-block">送信</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            review:{
                content: null
            },
            existingReview: null,
            loading: false
        };
    },
    created(){
        this.loading = true;
        axios.get(`/api/reviews/${this.$route.params.id}`)
        .then(response => (this.existingReview = response.data.data))
        .catch(err => {

        })
        .then(() => (this.loading = false));
    },
    computed:{
        alreadyReviewed(){
            return this.existingReview !== null;
        }
    }
};
</script>
