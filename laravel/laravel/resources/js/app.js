require('./bootstrap');

import { createApp } from 'vue';
import { createStore } from 'vuex'
import Top from "./Top.vue";
import router from "./routes";
import storeDefinition from "./store";
// import moment from "moment";
import FatalError from "./shared/components/FatalError";
import Success from "./shared/components/Success";
// import StarRating from "./shared/components/StarRating";
import ValidationErrors from "./shared/components/ValidationErrors";

// createApp(Top).use(router).mount('#app');

const store = createStore({ storeDefinition });

const app = createApp({Top})
app.use(router);
app.use(store);
app.component("top-view", Top);
app.component("success", Success);
app.component("fatal-error", FatalError);
app.component("v-errors", ValidationErrors);
app.mount("#app");




// app.use("fromNow", value => moment(value).fromNow());

// Top.component("star-rating", StarRating);
