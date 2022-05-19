<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">金額内訳</h6>

        <div
            v-for="(days, price) in price.breakdown"
            :key="price"
            class="pt-2 pb-2 border-bottom border-top d-flex justify-content-between"
        >
            <span>{{ days }} x {{ price }}円</span>
            <span>{{ days * price }}円</span>
        </div>

        <div class="pt-2 font-weight-bolder d-flex justify-content-between">
            <span>合計</span>
            <span>{{ price.total }}円</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        price: Object
    }
};
</script>
