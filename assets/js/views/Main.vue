<style lang="scss" scoped>
  #link__form {
    &__container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 70vh;
    }
  }
  #short__url {
    font-size: 18px;
  }
</style>
<template>
  <el-row id="link__form__container" :gutter="10" type="flex" class="row-bg" justify="center">
    <el-col :span="20"  type="flex" class="row-bg" justify="center">
      <shorten-form :onUrlShortened="setShortUrl" />
      <el-col v-if="shortUrl" id="short__url" :span="24">
        <a target="_blank" :href="shortUrl">{{shortUrl}}</a> &nbsp;
        <el-button @click="onCopyUrl" size="mini" type="primary" icon="el-icon-document-copy" circle></el-button>
      </el-col>
    </el-col>
  </el-row>
</template>

<script>
  import { successMessage } from '../utils/message';
  import { isAuth } from '../utils/helpers';
  export default {
    data() {
      return {
        shortUrl: null
      };
    },
    methods: {
      setShortUrl: function (url) {
        this.shortUrl = url;
      },
      onCopyUrl: function () {
        const input = document.createElement('input');
        input.value = this.shortUrl;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        successMessage('Copied to clipboard!');
      }
    },
    mounted () {
      if (isAuth()) {
        this.$router.push({ path: 'links' });
      }
    }
  }
</script>