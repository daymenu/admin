<template>
  <div>
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

