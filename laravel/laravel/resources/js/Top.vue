<template>
    <div>
      <nav class="navbar bg-white border-bottom navbar-light">
        <router-link class="navbar-brand mr-auto" :to="{ name: 'home' }">予約システム</router-link>

        <router-link class="btn nav-button" :to="{name: 'basket'}">
          カート
          <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket }}</span>
        </router-link>
      </nav>

      <div class="container mt-4 mb-4 pr-4 pl-4">
        <router-view></router-view>
      </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
  data() {
    return {
      lastSearch: this.$store.state.lastSearch
    };
  },
  beforeCreate(){
    this.$store.dispatch('loadStoredState')
  },
  computed: {
    ...mapState({
      lastSearchComputed: "lastSearch"
    }),
    ...mapGetters({
      itemsInBasket: "itemsInBasket"
    }),
    somethingElse() {
      return 1 + 2;
    }
  }
};
</script>
