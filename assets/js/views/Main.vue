<style lang="scss" scoped>
  #link__form {
    &__container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 80vh;
    }
  }
  #short__url {
    font-size: 18px;
  }
</style>
<template>
  <el-row id="link__form__container" :gutter="10" type="flex" class="row-bg" justify="center">
    <el-col :span="20"  type="flex" class="row-bg" justify="center">
      <el-form  :model="link" status-icon :rules="rules" ref="link">
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
      <el-col v-if="shortUrl" id="short__url" :span="24">
        <a target="_blank" :href="shortUrl">{{shortUrl}}</a> &nbsp;
        <el-button @click="onCopyUrl" size="mini" type="primary" icon="el-icon-document-copy" circle></el-button>
      </el-col>
    </el-col>
  </el-row>
</template>

<script>
  import { post } from '../utils/api';
  import { successMessage } from '../utils/message';
  export default {
    data() {
      return {
        shortUrl: null,
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
              this.shortUrl = response.data.url;
            } else if (response.data.violations && response.data.violations.length) {
              this.fillErrors(response.data.violations);
            }
          }
        });
      },
      urlChanged: function () {
        this.disableShortenButton = false;
      },
      onCopyUrl: function () {
        const input = document.createElement('input');
        input.value = this.shortUrl;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        successMessage('Copied to clipboard!');
      },
      fillErrors: function (errors) {
        this.errors = {};
        errors.forEach(error => {
          const propertyPath = error.propertyPath.replace(/[\[\]']+/g, '');
          if (this.errors[propertyPath]) {
            this.errors[propertyPath].push(error.title);
          } else {
            this.errors[propertyPath] = [error.title];
          }
        });
      }
    }
  }
</script>