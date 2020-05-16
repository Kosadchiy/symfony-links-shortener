<style lang="scss">
  body {
    background: ghostwhite; //#f6f6ff
  }
  .el-menu--horizontal>.el-menu-item:not(.is-disabled):hover,
  .el-menu--horizontal>.el-menu-item:not(.is-disabled):focus {
    background: ghostwhite;
  }
  .el-menu.el-menu--horizontal {
    background-color: unset;
    border-bottom: none;
  }
  .header-row {
    display: flex;
    align-items: center;
  }
  .main-nav {
    border-bottom: 0;
  }
  .auth-nav {
    border-bottom: 0;
  }
  .user-info {
    cursor: pointer;
    color: #409EFF;
  }
</style>
<template>
  <el-container>
    <el-header style="text-align: right; font-size: 12px">
      <el-row class="header-row" :gutter="20">
        <el-col :span="20">
          <el-menu router class="main-nav" mode="horizontal">
            <el-menu-item :route="{name:'main'}" index="1">
              <img src="../images/logo.png" alt="">
            </el-menu-item>
          </el-menu>
        </el-col>
        <el-col :span="4">
          <el-menu v-if="!user.email" router class="auth-nav" mode="horizontal">
            <el-menu-item :route="{name:'login'}" index="1">Login</el-menu-item>
            <el-menu-item :route="{name:'register'}" index="2">Register</el-menu-item>
          </el-menu>
          <el-menu v-else class="auth-nav" mode="horizontal">
            <el-dropdown trigger="click" class="user-info">
              <span class="el-dropdown-link">
                {{user.email}}<i class="el-icon-arrow-down el-icon--right"></i>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item @click.native="onLogout" icon="el-icon-switch-button">Logout</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </el-menu>
        </el-col>
      </el-row>
    </el-header>
    <el-main>
      <router-view />
    </el-main>
  </el-container>
</template>
<script>
  import { mapGetters, mapActions } from 'vuex';
  export default {
    computed: {
      ...mapGetters(['user']),
      isAuth: function () {
        return isAuth();
      }
    },
    methods: {
      ...mapActions(['getUser', 'logout']),
      onLogout: function () {
        console.log('asdasd');
        
        this.logout();
        this.$router.push({ path: 'main' });
      }
    },
    mounted () {
      this.getUser();
    }
  }
</script>>