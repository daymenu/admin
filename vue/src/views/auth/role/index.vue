<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.search" placeholder="角色名称" style="width: 200px;" class="filter-item"/>
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="search">搜索</el-button>
      <el-button v-if="hasPrimission('authRoleAdd')" class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="create">添加</el-button>
    </div>
    <el-table
      v-loading="listLoading"
      :key="tableKey"
      :data="list"
      element-loading-text="加载中..."
      border
      fit
      highlight-current-row>
      <el-table-column label="ID" prop="id" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="角色名称" prop="name" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="添加时间" prop="created_at" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>
      <el-table-column label="修改时间" prop="created_at" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.updated_at }}</span>
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center" width="230" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button v-if="hasPrimission('authRoleEdit')" type="primary" size="mini" @click="edit(scope.row)">编辑</el-button>
          <el-button v-if="hasPrimission('authRoleDelete')" size="mini" type="danger" @click="deleteRow(scope.row)">删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="角色名称" prop="name">
          <el-input v-model="temp.name" type="text" placeholder="请输入角色名称"/>
        </el-form-item>
      </el-form>
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="菜单" prop="pId">
          <el-tree
            ref="tree"
            :data="menuOptions"
            :props="menuProps"
            show-checkbox
            default-expand-all
            node-key="id"
            highlight-current/>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogStatus==='create'?store():update()">{{ dialogStatus==='create'?'添加':'修改' }}</el-button>
        <el-button @click="dialogFormVisible = false">取消</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { getList, store, update, destroy, menuIds } from '@/api/auth/role'
import { menuSelect } from '@/api/auth/menu'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
import waves from '@/directive/waves' // Waves directive
export default {
  name: 'Api',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 10,
        search: undefined
      },
      statusOptions: ['published', 'draft', 'deleted'],
      menuOptions: [],
      menuProps: { label: 'title', value: 'id' },
      temp: {
        id: undefined,
        name: '',
        menuIds: []
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '修改',
        create: '添加'
      },
      rules: {
        name: [{ required: true, message: '请填写角色名称', trigger: 'blur' }],
        route: [{ required: true, message: '请填写route', trigger: 'blur' }],
        url: [{ required: true, message: '请填写角色链接', trigger: 'blur' }]
      }
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      getList(this.listQuery).then(response => {
        this.list = response.data.data
        this.total = response.data.total
        this.listLoading = false
      }).catch(error => {
        console.log(error)
      })
    },
    search() {
      this.listQuery.page = 1
      this.getList()
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        name: '',
        menuIds: []
      }
    },
    getTree(roleId) {
      menuSelect().then(response => {
        // const menus = [{ id: 0, title: '作为一级菜单' }]
        // this.menuOptions = menus.concat(response.data)
        this.menuOptions = response.data
      })
      menuIds(roleId).then(response => {
        this.$refs.tree.setCheckedKeys(response.data)
      })
    },
    create(row) {
      this.resetTemp()
      this.getTree()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    store() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.temp.menuIds = this.$refs.tree.getCheckedKeys()
          store(this.temp).then((res) => {
            this.list.unshift(res.data)
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '创建成功',
              type: 'success',
              duration: 2000
            })
          }).catch(error => {
            console.log(error)
          })
        }
      })
    },
    edit(row) {
      this.temp = Object.assign({}, row) // copy obj
      this.getTree(this.temp.id)
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    update() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.temp.menuIds = this.$refs.tree.getCheckedKeys()
          const tempData = Object.assign({}, this.temp)
          tempData.timestamp = +new Date(tempData.timestamp) // change Thu Nov 30 2017 16:41:05 GMT+0800 (CST) to 1512031311464
          update(tempData.id, tempData).then(() => {
            for (const v of this.list) {
              if (v.id === this.temp.id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, this.temp)
                break
              }
            }
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '更新成功',
              type: 'success',
              duration: 2000
            })
          }).catch(error => {
            console.log(error)
          })
        }
      })
    },
    deleteRow(row) {
      this.$confirm('是否删除?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        destroy(row.id).then(() => {
          const index = this.list.indexOf(row)
          this.list.splice(index, 1)
        })
        this.$notify({
          title: '成功',
          message: '删除成功',
          type: 'success',
          duration: 2000
        })
      }).catch(() => {
        this.$notify({
          title: '成功',
          message: '删除成功',
          type: 'success',
          duration: 2000
        })
      })
    }
  }
}
</script>
