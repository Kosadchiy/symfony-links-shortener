<style lang="scss" scoped>
  #register__form {
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
  <el-row id="register__form__container" type="flex" class="row-bg" justify="center">
    <el-col :span="6"  type="flex" class="row-bg" justify="center">
      <el-form label-width="auto" :model="registerForm" status-icon :rules="rules" ref="registerForm">
        <el-form-item 
          label="Email" 
          prop="email" 
          :error="errors.email ? errors.email.join(' | ') : ''"
        >
          <el-input v-model="registerForm.email"></el-input>
        </el-form-item>
        <el-form-item 
          label="Password" 
          prop="password" 
          :error="errors.password ? errors.password.join(' | ') : ''"
        >
          <el-input type="password" v-model="registerForm.password" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item 
          label="Confirm" 
          prop="confirm"
          :error="errors.confirm ? errors.confirm.join(' | ') : ''"
        >
          <el-input type="password" v-model="registerForm.confirm" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm('registerForm')">Register</el-button>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>
<script>
  import { post } from '../utils/api';
  import { successMessage } from '../utils/message';
  import { fillFormErrors, isAuth } from '../utils/helpers';
  export default {
    data() {
      return {
        registerForm: {
          email: '',
          password: '',
          confirm: ''
        },
        rules: {
          email: [
            { required: true, message: 'Please input email.', trigger: 'blur' },
          ],
          password: [
            { required: true, message: 'Please input password.', trigger: 'blur' },
          ],
          confirm: [
            { required: true, message: 'Please confirm password.', trigger: 'blur' },
          ]
        },
        errors: {}
      };
    },
    methods: {
      submitForm: async function (formName) {
        this.$refs[formName].validate( async (valid) => {
          if (!valid) {
            return false;
          } else {
            this.errors = {};
            const response = await post('/api/register', this.$refs[formName].model);
            if (response.status === 200) {
              successMessage('Success!');
              this.$router.push({ path: 'login' });
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