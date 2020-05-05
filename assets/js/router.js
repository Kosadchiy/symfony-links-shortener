import Vue from "vue";
import VueRouter from 'vue-router';
import Main from './views/Main';
import Register from './views/Register';
import Login from './views/Login';

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes: [
    {
      path: '/',
      name: 'main',
      component: Main
    },
    {
      path: '/register',
      name: 'register',
      component: Register
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    { path: "*", redirect: "/" }
  ]
});