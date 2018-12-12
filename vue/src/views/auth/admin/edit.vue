<template>
  <div>
    <div class="header">人员编辑</div>
    <admin-detail :is-edit="true"/>
  </div>
</template>

<script>
import AdminDetail from './components/AdminDetail'

export default {
  name: 'AdminEdit',
  components: { AdminDetail }
}
</script>

