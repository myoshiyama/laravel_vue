require('./bootstrap');

import VueRouter from "vue-router";
import router from "./routes";

import { createApp } from 'vue';
// const Vue = require("vue");
// import App from './App.vue'

const app = createApp({})
app.use(router)
app.mount('#app')



// window.Vue = Vue;

// Vue.component("example-component", require("./components/ExampleComponent.vue").default);

// Vue.use(VueRouter);


// const app = new Vue({
//     el: "#app",
//     router,
// });
