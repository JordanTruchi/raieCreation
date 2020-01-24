import Vue from 'vue';
import router from './router';
import App from 'Component/App.vue';
import vuetify from './plugins/vuetify.js'; // path to vuetify export
Vue.use(vuetify);

// launch Vue
export default new Vue({
  el: '#app',
  vuetify,
  router,
  render: h => h(App)
});
