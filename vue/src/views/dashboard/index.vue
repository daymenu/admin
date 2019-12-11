<template>
  <div class="dashboard-container">
    <!-- <div class="dashboard-text">欢迎使用后台管理系统</div> -->
    <el-row :gutter="20">
      <el-col :span="6">
        <el-card class="box-card">
          <svg-icon icon-class="money" class="money" />
          <span class="box-right">
            <div class="count-title">收入</div>
            <count-to :start-val="money.startVal" :end-val="money.endVal" :duration="3000" :suffix="'元'"/>
          </span>
        </el-card>
      </el-col>
      <el-col :span="6">
        <el-card class="box-card">
          <svg-icon icon-class="message" class="message" />
          <span class="box-right">
            <div class="count-title">消息</div>
            <count-to :start-val="message.startVal" :end-val="message.endVal" :duration="3000" :prefix="''"/>
          </span>
        </el-card>
      </el-col>
      <!-- <el-col :span="6">
        <el-card class="box-card">
          <svg-icon icon-class="people" class="people" />
          <span class="box-right">
            <div class="count-title">New Visits</div>
            <count-to :startVal="people.startVal" :endVal="people.endVal" :duration="3000"/>
          </span>
        </el-card>
      </el-col>
      <el-col :span="6">
        <el-card class="box-card">
          <svg-icon icon-class="shopping" class="shopping" />
          <span class="box-right">
            <div class="count-title">Shoppings</div>
            <count-to :startVal="shopping.startVal" :endVal="shopping.endVal" :duration="3000"/>
          </span>
        </el-card>
      </el-col> -->
    </el-row>
    <div class="line-chart">
      <line-chart :chartData="lineChartData"/>
    </div>
  </div>
</template>

<script>
import countTo from 'vue-count-to'
import lineChart from './components/lineChart'

const lineChartData = {
  newVisitis: {
    expectedData: [100, 120, 161, 134, 105, 160, 165],
    actualData: [120, 82, 91, 154, 162, 140, 145]
  },
  messages: {
    expectedData: [200, 192, 120, 144, 160, 130, 140],
    actualData: [180, 160, 151, 106, 145, 150, 130]
  },
  purchases: {
    expectedData: [80, 100, 121, 104, 105, 90, 100],
    actualData: [120, 90, 100, 138, 142, 130, 130]
  },
  shoppings: {
    expectedData: [130, 140, 141, 142, 145, 150, 160],
    actualData: [120, 82, 91, 154, 162, 140, 130]
  }
}

export default {
  name: 'Dashboard',
  components: {
    countTo,
    lineChart
  },
  data() {
    return {
      money: {
        startVal: 0,
        endVal: 82239
      },
      people: {
        startVal: 0,
        endVal: 23242
      },
      message: {
        startVal: 0,
        endVal: 2116
      },
      shopping:{
        startVal: 0,
        endVal: 12332
      },
      lineChartData: lineChartData.newVisitis
    }
  },
  methods: {
    initData() {
      console.log('init')
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard {
  &-container {
    padding: 30px;
    background: #f1f1f1;
  }
  &-text {
    font-size: 30px;
    line-height: 46px;
  }
}
.svg-icon{
  font-size: 40px;
  &.money{
    color:aquamarine;
  }
  &.people{
    color:lightblue;
  }
  &.shopping{
    color:green;
  }
  &.message{
    color:tomato;
  }
}
.box-right{
  float:right;
  font-size: 18px;
  text-align:right;
  font-weight: 300;
   .count-title{
    color:rgba($color: #000000, $alpha: 0.6);
    margin-bottom: 6px;
  }
}
.line-chart{
  margin:30px auto;
  padding: 20px 0;
  background: #fff;
  border-radius: 4px;
}

</style>
