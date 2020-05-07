<template>
  <el-form style="width: 100%"  :model="link" status-icon :rules="rules" ref="link">
    <el-col :span="22">
      <el-form-item :error="errors.url ? errors.url.join(' | ') : ''" prop="url">
        <el-input @input="urlChanged" placeholder="Input your link" v-model="link.url" />
      </el-form-item>
    </el-col>
    <el-col :span="2">
      <el-form-item>
        <el-button @click="shorten" :disabled="disableShortenButton" :loading="loading" type="primary">
          Shorten
        </el-button>
      </el-form-item>
    </el-col>
  </el-form>
</template>
<script>
  import { post } from '../utils/api';
  import { successMessage } from '../utils/message';
  import { fillFormErrors } from '../utils/helpers';
  export default {
    props: {
      onUrlShortened: Function
    },
    data() {
      return {
        loading: false,
        disableShortenButton: false,
        link: {
          url: ''
        },
        rules: {
          url: [
            { required: true, message: 'Please input url', trigger: 'blur' },
          ]
        },
        errors: {}
      };
    },
    methods: {
      shorten: async function () {
        this.$refs['link'].validate( async (valid) => {
          if (!valid) {
            return false;
          } else {
            this.errors = {};
            this.loading = true;
            const response = await post('/api/shorten', this.$refs['link'].model);
            this.loading = false;

            if (response.status === 200) {
              this.disableShortenButton = true;
              this.onUrlShortened(response.data.url);
            } else if (response.data.violations && response.data.violations.length) {
              fillFormErrors.call(this, response.data.violations);
            }
          }
        });
      },
      urlChanged: function () {
        this.disableShortenButton = false;
      }
    }
  }
</script>