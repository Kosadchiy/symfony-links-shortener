import Vue from "vue";
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/reset.css'
import "element-ui/lib/theme-chalk/index.css";
import App from "./App";
import router from './router';

Vue.use(ElementUI);

if (document.getElementById('app')) {
  new Vue({
    router,
    components: { App },
    template: "<App/>"
  }).$mount("#app");
}
