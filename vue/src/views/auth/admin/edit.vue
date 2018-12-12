<template>
  <div>
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

