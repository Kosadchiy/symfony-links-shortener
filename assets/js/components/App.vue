<template>
  <el-row :gutter="10" type="flex" class="row-bg" justify="center">
    <el-form :model="link" status-icon :rules="rules" ref="link">
      <el-col :span="18">
        <el-form-item :error="errors.url ? errors.url.join(' | ') : ''" prop="url">
          <el-input placeholder="Input your link" v-model="link.url" />
        </el-form-item>
      </el-col>
      <el-col :span="2">
        <el-form-item>
          <el-button @click="shorten" type="primary">Shorten</el-button>
        </el-form-item>
      </el-col>
    </el-form>
  </el-row>
</template>

<script>
  import axios from 'axios';
  export default {
    data() {
      return {
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
        this.$refs['link'].validate((valid) => {
          if (!valid) {
            return false;
          }
        });

        axios.post('/shorten', this.$refs['link'].model)
        .then(function (response) {
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error.response.data);
          
          this.onError(error.response.data);
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