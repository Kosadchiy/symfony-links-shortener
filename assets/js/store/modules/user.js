import { get } from '../../utils/api';
import Cookies from 'js-cookie';

export default {
  actions: {
    async getUser (ctx) {
      if (Cookies.get('token')) {
        const response = await get('/api/user');
        ctx.commit('updateUser', response.data.user);
      } else {
        ctx.commit('updateUser', {
          email: null
        });
      }
    },
    logout (ctx) {
      Cookies.remove('token');
      ctx.commit('updateUser', {
        email: null
      });
    }
  },
  mutations: {
    updateUser (state, user) {
      state.email = user.email;
    }
  },
  state: {
    email: null
  },
  getters: {
    user (state) {
      return state;
    }
  }
}
