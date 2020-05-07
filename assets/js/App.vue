<style lang="scss" scoped>
  .main-nav {
    border-bottom: 0;
  }
  .auth-nav {
    border-bottom: 0;
  }
</style>
<template>
  <el-container>
    <el-header style="text-align: right; font-size: 12px">
      <el-row :gutter="20">
        <el-col :span="20">
          <el-menu router class="main-nav" mode="horizontal">
            <el-menu-item :route="{name:'main'}" index="1">
              <img src="../images/logo.png" alt="">
            </el-menu-item>
          </el-menu>
        </el-col>
        <el-col :span="4">
          <el-menu router class="auth-nav" mode="horizontal">
            <el-menu-item :route="{name:'login'}" index="1">Login</el-menu-item>
            <el-menu-item :route="{name:'register'}" index="2">Register</el-menu-item>
          </el-menu>
        </el-col>
      </el-row>
    </el-header>
    <el-main>
      <router-view />
    </el-main>
  </el-container>
</template>