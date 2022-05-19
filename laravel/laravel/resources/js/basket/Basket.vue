<template>
    <div>
        <success v-if="success">ご予約ありがとうございます！</success>
        <div class="row" v-else>
           <div class="col-md-4">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase text-secondary font-weight-bolder">カートの中身</h6>
                    <h6 class="badge badge-secondary text-uppercase">
                        <span v-if="itemsInBasket">Items {{ itemsInBasket }}</span>
                        <span v-else>空</span>
                    </h6>
                </div>

                <transition-group name="fade">
                    <div v-for="item in basket" :key="item.bookable.id">
                        <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                            <span>
                                <router-link
                                    :to="{name: 'bookable', params: {id: item.bookable.id}}"
                                >{{ item.bookable.title }}</router-link>
                            </span>
                            <span class="font-weight-bold">{{ item.price.total }}円</span>
                        </div>

                        <div class="pt-2 pb-2 d-flex justify-content-between">
                            <span>利用開始日 {{ item.dates.from }}</span>
                            <span>利用終了日 {{ item.dates.to }}</span>
                        </div>

                        <div class="pt-2 pb-2 text-right">
                            <button 
                                class="btn btn-sm btn-outline-secondary" 
                                @click="$store.dispatch('removeFromBasket', item.bookable.id)"
                            >
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </transition-group>
                <hr />
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button 
                            v-if="itemsInBasket" 
                            type="submit" 
                            lass="btn btn-lg btn-primary btn-block" 
                            @click.prevent="book" 
                            :disabled="loading"
                        >予約！</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import Success from '../shared/components/Success.vue';
import validationErrors from "./../shared/mixins/validationErrors";

export default {
  components: { Success },
    mixins: [validationErrors],
    data(){
        return {
            loading: false,
            bookingAttempted: false
        };
    },
    computed: {
        ...mapGetters(["itemsInBasket"]),
        ...mapState({
            basket: state => state.basket.items
        }),
        success() {
            return !this.loading && 0 === this.itemsInBasket && this.bookingAttempted;
        }
    },
    methods: {
        async book() {
            this.loading = true;
            this.bookingAttempted = false;
            this.errors = null;

            try {
                await axios.post(`/api/checkout`, {
                    bookings: this.basket.map(basketItem => ({
                        bookable_id: basketItem.bookable.id,
                        from: basketItem.dates.from,
                        to: basketItem.dates.to
                    }))
                });
                this.$store.dispatch("clearBasket");
            } catch (error) {
                this.errors = error.response && error.response.data.errors;
            }

            this.loading = false;
            this.bookingAttempted = true;
        }
    }
};
</script>

<style scoped>
h6.badge {
    font-size: 100%;
}

a{
    color: black;
}
</style>