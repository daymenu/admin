<template>
  <div :class="className" :style="{width:width,height:height}"/>
</template>

<script>
import echarts from 'echarts';
require('echarts/theme/roma')
export default {
  name: "lineChart",
  data() {
    return {
      chart: null
    };
  },
  props: {
    className: {
      type: String,
      default: "chart"
    },
    width: {
      type: String,
      default: "100%"
    },
    height: {
      type: String,
      default: "300px"
    },
    chartData: {
      type: Object,
      required: true
    }
  },
  mounted () {
    this.$nextTick(() => {
      this.initCharts()
    });
  },
  beforeDestroy () {
    if (this.chart) {
      return
    }
    this.chart.dispose()
    this.chart = null
  },
  watch: {
    chartData: {
      deep: true,
      handler(val) {
        this.setOptions(val)
      }
    }
  },
  methods: {
    initCharts() {
      console.log(this.chartData)
      this.chart = echarts.init(this.$el, 'roma');
      this.setOptions(this.chartData);
    },
    setOptions({ expectedData, actualData } = {}) {
      this.chart.setOption({
        xAxis: {
          data: ["周一", "周二1", "周三", "周四", "周五", "周六", "周日"],
          name: 'zhou',
          boundaryGap: false,
          axisTick: {
            show: false
          }
        },
        grid: {
          left: 20,
          right: 20,
          bottom: 20,
          top: 30,
          containLabel: true
        },
        yAxis:{
          axisTick: {
            show: false
          }
        },
        legend: {
          data: ['expected','actual']
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross'
          },
          padding: [5, 10]
        },
        series: [{
          name: 'expected',
          type: 'line',
          itemStyle: {
            normal: {
              color: '#FF005A',
              lineStyle: {
                color: '#FF005A',
                width: 2
              }
            }
          },
          smooth: true,
          data: expectedData,
          animationDuration: 2800,
          animationEasing: 'cubicInOut'
        },{
          name: 'actual',
          smooth: true,
          type: 'line',
          itemStyle: {
            normal: {
              color: '#3888fa',
              lineStyle: {
                color: '#3888fa',
                width: 2
              },
              areaStyle: {
                color: '#f3f8ff'
              }
            }
          },
          data: actualData,
          animationDuration: 2800,
          animationEasing: 'quadraticOut'
        }]
      });
    }
  }
};
</script>
