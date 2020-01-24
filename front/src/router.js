import Vue from 'vue';
import Router from 'vue-router';
import Home from 'Component/Home.vue';

Vue.use(Router);
// Router pour gérer les différentes routes à terme
const router = new Router({
  mode: '',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
      props: false,
      meta: { needAuth: false }
    }
  ]
});
export default router;
