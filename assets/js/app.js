import Vue from "vue";
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/reset.css'
import "element-ui/lib/theme-chalk/index.css";
import App from "./components/App";

Vue.use(ElementUI);

if (document.getElementById('app')) {
  new Vue({
    components: { App },
    template: "<App/>"
  }).$mount("#app");
}
