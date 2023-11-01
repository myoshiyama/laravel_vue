import { createWebHistory, createRouter } from "vue-router";
import Bookables from "./bookables/Bookables";
import Bookable from "./bookable/Bookable";
import Review from "./review/Review";
import Basket from "./basket/Basket";

export const routes = [
  {
    path: "/",
    component: Bookables,
    name: "home",
  },
  {
    path: "/bookable/:id",
    component: Bookable,
    name: "bookable",
  },
  {
    path: "/review/:id",
    component: Review,
    name: "review"
  },
  {
    path: "/basket",
    component: Basket,
    name: "basket"
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;