<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="postForm" :rules="rules" class="form-container" label-width="80px">
      <div class="createPost-main-container">
        <el-row>
          <!-- <Warning /> -->
          <el-col :span="12">
            <el-form-item label="姓名" prop="name">
              <el-input v-model="postForm.name" type="text" placeholder="请输入姓名" clearable/>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item label="用户名" prop="user_name">
              <el-input v-model="postForm.user_name" type="text" placeholder="请输入用户名"/>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item label="昵称" prop="nick_name">
              <el-input v-model="postForm.nick_name" type="text" placeholder="请输入昵称"/>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item label="邮箱" prop="email">
              <el-input v-model="postForm.email" type="email" placeholder="请输入邮箱号"/>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item label="密码" prop="password">
              <el-input v-model="postForm.password" type="password" placeholder="请输入密码，可以是数字或者字母，字符数为6~20"/>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
            <el-form-item label="确认密码" prop="repassword">
              <el-input v-model="postForm.repassword" type="password" placeholder="请再次输入密码"/>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="24">
            <el-form-item label="所属角色" prop="role">
              <el-checkbox-group v-model="postForm.roles">
                <el-checkbox v-for="(roleName, roleId) in roles" :label="roleId" :key="roleId">{{ roleName }}</el-checkbox>
              </el-checkbox-group>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="24">
            <el-button type="primary" @click="submitForm">{{ btnName }}</el-button>
            <el-button @click="goList">取消</el-button>
          </el-col>
        </el-row>
      </div>
    </el-form>

  </div>
</template>

<script>
import { store, show, update } from '@/api/auth/admin'
import { roleKv } from '@/api/auth/role'
import { validatPassword } from '@/utils/validate'

const defaultForm = {
  id: undefined,
  name: '',
  email: '',
  nick_name: '',
  user_name: '',
  password: '',
  repassword: '',
  avatar: '',
  roles: [],
  status: 1
}

export default {
  name: 'AadminDetail',
  components: { },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    var vPassword = (rule, value, callback) => {
      if (!validatPassword(value)) {
        callback(new Error('请输入数字或字母并且在6~20个字符的密码'))
      } else {
        if (this.postForm.repassword !== '') {
          this.$refs.postForm.validateField('repassword')
        }
        callback()
      }
    }
    var vRePassword = (rule, value, callback) => {
      if (!validatPassword(value)) {
        callback(new Error('请再次输入密码'))
      } else if (value !== this.postForm.password) {
        callback(new Error('两次输入密码不一致!'))
      } else {
        callback()
      }
    }
    return {
      postForm: Object.assign({}, defaultForm),
      loading: false,
      userListOptions: [],
      rules: {
        name: [{ required: true, message: '请填写姓名', trigger: 'blur' }],
        user_name: [{ required: true, message: '请填写姓名', trigger: 'blur' }],
        email: [{ required: true, type: 'email', message: '请填写正确的邮箱地址', trigger: 'blur' }],
        nick_name: [{ required: true, message: '请填写昵称', trigger: 'blur' }],
        password: [{ required: true, validator: vPassword, trigger: 'blur' }],
        repassword: [{ required: true, validator: vRePassword, trigger: 'blur' }]
      },
      roles: [],
      postFormRoute: {}
    }
  },
  computed: {
    btnName: function() {
      return this.isEdit ? '编辑' : '添加'
    }
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    } else {
      this.postForm = Object.assign({}, defaultForm)
    }

    // Why need to make a copy of this.$route here?
    // Because if you enter this page and quickly switch tag, may be in the execution of the setTagsViewTitle function, this.$route is no longer pointing to the current page
    // https://github.com/PanJiaChen/vue-element-admin/issues/1221
    this.postFormRoute = Object.assign({}, this.$route)
  },
  methods: {
    fetchData(id) {
      roleKv().then(response => {
        this.roles = response.data
      }).catch(error => {
        console.log(error)
      })
      show(id).then((response) => {
        this.postForm = response.data
      }).catch(error => {
        console.log(error)
      })
    },
    goList() {
      this.$router.back()
    },
    submitForm() {
      this.$refs.postForm.validate(valid => {
        if (valid) {
          this.loading = true
          if (this.isEdit) {
            update(this.postForm.id, this.postForm).then((res) => {
              this.$notify({
                title: '成功',
                message: '修改成功',
                type: 'success',
                duration: 2000
              })
              this.goList()
            }).catch(error => {
              console.log(error)
            })
          } else {
            store(this.postForm).then((res) => {
              this.$notify({
                title: '成功',
                message: '创建成功',
                type: 'success',
                duration: 2000
              })
              this.goList()
            }).catch(error => {
              console.log(error)
            })
          }

          this.loading = false
        } else {
          console.log('error submit!!')
          return false
        }
      })
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "src/styles/mixin.scss";
.createPost-container {
  position: relative;
  .createPost-main-container {
    padding: 40px 45px 20px 50px;
    .postInfo-container {
      position: relative;
      @include clearfix;
      margin-bottom: 10px;
      .postInfo-container-item {
        float: left;
      }
    }
    .editor-container {
      min-height: 500px;
      margin: 0 0 30px;
      .editor-upload-btn-container {
        text-align: right;
        margin-right: 10px;
        .editor-upload-btn {
          display: inline-block;
        }
      }
    }
  }
  .word-counter {
    width: 40px;
    position: absolute;
    right: -10px;
    top: 0px;
  }
}
</style>
