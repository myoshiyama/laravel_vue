require('./bootstrap');

import { createApp } from 'vue';
import Top from "./Top.vue";
import router from "./routes";
// import moment from "moment";
// import StarRating from "./shared/components/StarRating.vue";

createApp(Top).use(router).mount('#app');

// app.use("fromNow", value => moment(value).fromNow());

// Top.component("star-rating", StarRating);
