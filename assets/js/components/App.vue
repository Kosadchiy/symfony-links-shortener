<template>
  <el-row :gutter="10" type="flex" class="row-bg" justify="center">
    <el-col :span="18">
      <el-input placeholder="Input your link" v-model="url" />
    </el-col>
    <el-col :span="2">
      <el-button v-on:click="shorten" type="primary">Shorten</el-button>
    </el-col>
  </el-row>
</template>

<script>
  import axios from 'axios';
  export default {
    data() {
      return {
        url: ''
      };
    },
    methods: {
      shorten: function () {
        axios.post('/test', {
          url: this.url
        })
        .then(function (response) {
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });       
      }
    }
  }
</script>