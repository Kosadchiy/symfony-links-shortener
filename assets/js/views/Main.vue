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
  import axios from 'axios';
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
      shorten: function () {
        this.$refs['link'].validate((valid) => {
          if (!valid) {
            return false;
          }
        });

        this.loading = true;
        axios.post('/shorten', this.$refs['link'].model)
        .then((response) => {
          this.loading = false;
          this.disableShortenButton = true;
          this.shortUrl = response.data.url;
        })
        .catch((error) => {
          this.loading = false;
          this.onError(error.response.data);
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
        this.$message({
          showClose: true,
          message: 'Copied to clipboard!',
          type: 'success'
        });
      },
      onError: function (data) {
        this.$message({
          showClose: true,
          message: data.title,
          type: 'error'
        });
        if (data.violations.length) {
          this.fillErrors(data.violations);
        }
      },
      fillErrors: function (errors) {
        this.errors = {};
        errors.forEach(error => {
          if (this.errors[error.propertyPath]) {
            this.errors[error.propertyPath].push(error.title);
          } else {
            this.errors[error.propertyPath] = [error.title];
          }
        });
      }
    }
  }
</script>