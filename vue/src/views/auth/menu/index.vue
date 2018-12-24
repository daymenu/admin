<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.search" placeholder="菜单名称" style="width: 200px;" class="filter-item"/>
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="search">搜索</el-button>
      <el-button v-if="hasPrimission('authMenuAdd')" class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="create">添加</el-button>
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
      <el-table-column label="菜单名称" prop="title" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.title }}</span>
        </template>
      </el-table-column>
      <el-table-column label="父菜单" prop="pName" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.pName }}</span>
        </template>
      </el-table-column>
      <el-table-column label="路由名称" prop="name" align="center">
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
          <el-button v-if="hasPrimission('authMenuApi')" type="success" size="mini" @click="apiShow(scope.row)">接口</el-button>
          <el-button v-if="hasPrimission('authMenuEdit')" type="primary" size="mini" @click="edit(scope.row)">编辑</el-button>
          <el-button v-if="hasPrimission('authMenuDelete')" size="mini" type="danger" @click="deleteRow(scope.row)">删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="父菜单" prop="pId">
          <el-cascader
            v-model="temp.pIds"
            :options="pIdOptions"
            :props="pIdProps"
            :show-all-levels="false"
            placeholder="请选择父菜单"
            filterable
            change-on-select
          />
        </el-form-item>
      </el-form>
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="路由名称" prop="name">
          <el-input v-model="temp.name" type="text" placeholder="请输入路由名称"/>
        </el-form-item>
      </el-form>
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="菜单名称" prop="title">
          <el-input v-model="temp.title" type="text" placeholder="菜单名称"/>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogStatus==='create'?store():update()">{{ dialogStatus==='create'?'添加':'修改' }}</el-button>
        <el-button @click="dialogFormVisible = false">取消</el-button>
      </div>
    </el-dialog>

    <el-dialog :visible.sync="apiFormVisible" title="修改接口信息">
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="请选择接口" prop="pId">
          <el-tree
            ref="tree"
            :data="apiTree"
            :props="apiProps"
            show-checkbox
            default-expand-all
            node-key="id"
            highlight-current/>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="updateApi()">修改</el-button>
        <el-button @click="apiFormVisible = false">取消</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { getList, store, update, destroy, menuSelect, addApis, apiIds } from '@/api/auth/menu'
import { apiTree } from '@/api/auth/api'
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
      pIdOptions: [],
      pIdProps: { label: 'title', value: 'id' },
      apiProps: { label: 'name', value: 'id' },
      apiTree: [],
      menuId: 0,
      selectedApi: [],
      temp: {
        id: undefined,
        pId: 0,
        pIds: [],
        name: '',
        title: ''
      },
      dialogFormVisible: false,
      apiFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '修改',
        create: '添加'
      },
      rules: {
        name: [{ required: true, message: '请填写路由名称', trigger: 'blur' }],
        title: [{ required: true, message: '请填写菜单名称', trigger: 'blur' }]
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
    getMenuSelect() {
      menuSelect().then(response => {
        // const menus = [{ id: 0, title: '作为一级菜单' }]
        // this.pIdOptions = menus.concat(response.data)
        this.pIdOptions = response.data
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
        route: '',
        pId: 0,
        pIds: [],
        url: '',
        status: 1
      }
    },
    foramtTemp() {
      const index = this.temp.pIds.length - 1
      if (index < 0) {
        this.temp.pId = 0
      } else {
        this.temp.pId = this.temp.pIds[index]
      }
    },
    create() {
      this.resetTemp()
      this.getMenuSelect()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    store() {
      console.log(this.temp)
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.foramtTemp()
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
      this.getMenuSelect()
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    update() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.foramtTemp()
          const tempData = Object.assign({}, this.temp)
          tempData.timestamp = +new Date(tempData.timestamp) // change Thu Nov 30 2017 16:41:05 GMT+0800 (CST) to 1512031311464
          update(tempData.id, tempData).then((response) => {
            for (const v of this.list) {
              if (v.id === this.temp.id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, response.data)
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
    apiShow(row) {
      this.apiFormVisible = true
      apiTree().then((response) => {
        this.apiTree = response.data
      })

      apiIds(row.id).then((response) => {
        this.$refs.tree.setCheckedKeys(response.data)
      })
      this.menuId = row.id
    },
    updateApi() {
      const keys = this.$refs.tree.getCheckedKeys()
      const pkeys = this.$refs.tree.getNodePath()
      console.log(pkeys)
      addApis({ menuId: this.menuId, apis: keys }).then((response) => {
        this.apiFormVisible = false
        this.$notify({
          title: '成功',
          message: '更新成功',
          type: 'success',
          duration: 2000
        })
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
