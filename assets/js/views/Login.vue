<style lang="scss" scoped>
  #login__form {
    &__container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 70vh;
      button {
        width: 100%;
      }
    }
  }
</style>
<template>
  <el-row id="login__form__container" type="flex" class="row-bg" justify="center">
    <el-col :span="6"  type="flex" class="row-bg" justify="center">
      <el-form label-width="auto" :model="loginForm" status-icon :rules="rules" ref="loginForm">
        <el-form-item 
          label="Email" 
          prop="email" 
          :error="errors.email ? errors.email.join(' | ') : ''"
        >
          <el-input v-model="loginForm.email"></el-input>
        </el-form-item>
        <el-form-item 
          label="Password" 
          prop="password" 
          :error="errors.password ? errors.password.join(' | ') : ''"
        >
          <el-input type="password" v-model="loginForm.password" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm('loginForm')">Login</el-button>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>
<script>
  import { post } from '../utils/api';
  import { fillFormErrors, isAuth } from '../utils/helpers';
  import Cookies from 'js-cookie';
  import { mapActions } from 'vuex';
  export default {
    data() {
      return {
        loginForm: {
          email: '',
          password: ''
        },
        rules: {
          email: [
            { required: true, message: 'Please input email.', trigger: 'blur' },
          ],
          password: [
            { required: true, message: 'Please input password.', trigger: 'blur' },
          ]
        },
        errors: {}
      };
    },
    methods: {
      ...mapActions(['getUser']),
      submitForm: async function (formName) {
        this.$refs[formName].validate( async (valid) => {
          if (!valid) {
            return false;
          } else {
            this.errors = {};
            const response = await post('/api/login', this.$refs[formName].model);
            if (response.status === 200) {
              Cookies.set('token', response.data.token);
              await this.getUser();
              this.$router.push({ path: 'links' });
            } else if (response.data.violations && response.data.violations.length) {
              fillFormErrors.call(this, response.data.violations);
            }
          }
        });
      }
    },
    mounted () {
      if (isAuth()) {
        this.$router.push({ path: 'links' });
      }
    }
  }
</script>