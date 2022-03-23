import { createWebHistory, createRouter } from "vue-router";
import ExampleComponent from "./components/ExampleComponent.vue";
import Example2 from "./components/Example2.vue";

const routes = [
  {
    path: "/",
    name: "ExampleComponent",
    component: ExampleComponent,
  },
  {
    path: "/about",
    name: "Example2",
    component: Example2,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

// import Vue from "vue";
// const Vue = require("vue");
// import VueRouter from "vue-router";

// import ExampleComponent from "./components/ExampleComponent.vue";
// import Example2 from "./components/Example2.vue";

// // Vue.use(VueRouter);

// const routes = [
//     {
//         path: "/",
//         component: ExampleComponent,
//         name:"home",
//     },
//     {
//         path: "/second",
//         component: Example2,
//         name:"second",
//     },
// ];

// const router = new VueRouter({
//     routes,
//     mode:"history",
// });

// console.log("hello");

// export default router;