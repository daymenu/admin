<template>
  <div>
    <div class="header">人员添加</div>
    <admin-detail :is-edit="false"/>
  </div>
</template>

<script>
import AdminDetail from './components/AdminDetail'

export default {
  name: 'AdminCreate',
  components: { AdminDetail }
}
</script>

