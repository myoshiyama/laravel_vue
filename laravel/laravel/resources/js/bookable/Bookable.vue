<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading && bookable">
                        <h2>{{ bookable.title }}</h2>
                        <hr />
                        <article>{{ bookable.description }}</article>
                    </div>
                    <div v-else>読み込み中...</div>
                </div>
            </div>

            <review-list :bookable-id="this.$route.params.id"></review-list>
        </div>
        <div class="col-md-4 pb-4">
            <availability
                :bookable-id="this.$route.params.id"
                @availability="checkPrice($event)"
                class="mb-4"
            ></availability>

            <transition name="fade">
                <price-breakdown key="hoge" v-if="price" :price="price" class="mb-4"></price-breakdown>
            </transition>

            <transition name="fade">
                <button
                    key="huge"
                    class="btn btn-outline-secondary btn-block"
                    v-if="price"
                    @click="addToBasket"
                    :disabled="inBasketAlready"
                >カートに入れる</button>
            </transition>

            <button
                key="hoge"
                class="btn btn-outline-secondary btn-block"
                v-if="inBasketAlready"
                @click="removeFromBasket"
            >カートから出す</button>

            <div
                v-if="inBasketAlready"
                class="mt-4 text-muted warning"
            >すでにこの本をカゴに追加したようですが、日付を変更したい場合はカートから出し日付を変更した上で再度カートに入れてください。</div>
        </div>
    </div>
</template>

<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";
import { mapState } from 'vuex';
import axios from 'axios';

export default {
    components: {
        Availability,
        ReviewList,
        PriceBreakdown
    },
    data(){
        return {
            bookable: { title: '' },
            loading: false,
            price: null
        };
    },
    created() {
        this.loading = true;
        axios.get(`/api/bookables/${this.$route.params.id}`).then(response => {
            console.log(response.data.data);
            this.bookable = response.data.data;
            this.loading = false;
        })
        .catch(error => {
            this.loading = false; // エラー時も loading を false に設定
            console.error('データの読み込みエラー', error);
        });
    },
    computed: {
        ...mapState({
            lastSearch: "lastSearch",
        }),
        inBasketAlready() {
            if (null === this.bookable) {
                return false;
            }

            return this.$store.getters.inBasketAlready(this.bookable.id);
        }
    },
    methods: {
         async checkPrice(hasAvailability) {
            if (!hasAvailability){
                this.price = null;
                return;
            }

            try {
                this.price = (await axios.get(
                    `/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`
                )).data.data;
            } catch (err) {
                this.price = null;
            }
        },
        addToBasket() {
            this.$store.dispatch("addToBasket", {
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch
            });
        },
        removeFromBasket() {
            this.$store.dispatch("removeFromBasket", this.bookable.id);
        }
    }
};
</script>

<style scoped>
 .warning {
     font-size: 0.7rem;
 }
</style>
