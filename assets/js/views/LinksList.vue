<style lang="scss" scoped>
  .table-card {
    border: 1px solid #ebebeb;
    margin-top: 25px;
    padding: 20px;
    border-radius: 3px;
    transition: .2s;
  }
</style>
<template>
  <div>
    <el-row :gutter="10" type="flex" class="row-bg" justify="center">
      <shorten-form />
    </el-row>
    <el-row :gutter="10" type="flex" class="row-bg" justify="center">
      <el-table
        class="table-card"
        :data="tableData"
        style="width: 100%">
        <el-table-column
          prop="url"
          label="Url">
        </el-table-column>
        <el-table-column
          prop="short_url"
          label="Short url">
        </el-table-column>
        <el-table-column
          prop="created_at"
          label="Created at">
        </el-table-column>
        <el-table-column
          label="Operations">
          <template>
            <el-button type="primary" icon="el-icon-edit" size="small" circle></el-button>
            <el-button type="success" icon="el-icon-pie-chart" size="small" circle></el-button>
            <el-button type="danger" icon="el-icon-delete" size="small" circle></el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        tableData: [{
          url: 'ewfwefwe',
          short_url: 'Toasdm',
          created_at: '21.02.2020'
        }, {
          url: 'ewfwefwe',
          short_url: 'Toasdm',
          created_at: '21.02.2020'
        }, {
          url: 'ewfwefwe',
          short_url: 'Toasdm',
          created_at: '21.02.2020'
        }, {
          url: 'ewfwefwe',
          short_url: 'Toasdm',
          created_at: '21.02.2020'
        },]
      }
    }
  }
</script>