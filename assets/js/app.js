import Vue from "vue";
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/reset.css'
import "element-ui/lib/theme-chalk/index.css";
import router from './router';
import { store } from './store';

Vue.use(ElementUI);
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

if (document.getElementById('app')) {
  new Vue({
    store,
    router,
    template: "<App/>"
  }).$mount("#app");
}
