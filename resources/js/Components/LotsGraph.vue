<template>
    <apexcharts height="420px" type="bar" :options="chartOptions" :series="series"></apexcharts>
</template>

  <script>
  import VueApexCharts from 'vue3-apexcharts';

  export default {
    name: 'LotsGraph',
    props: {
        crudeOilYield: Array,
        soyHullYield: Array,
        crushedWaste: Array,
        nonCompliantBaggedTvpYield: Array,
        extrusionWaste: Array,
        lotWaste: Array,
        lots: Array,
    },
    components: {
      apexcharts: VueApexCharts,
    },
    data: function() {
        return {
            chartOptions: {
                chart: {
                    fontFamily: 'Inter, sans-serif',
			        foreColor: '#4B5563',
                    toolbar: {
                        show: false
                    }
                },
                xaxis: {
                    categories: this.lots,
                    labels: {
                        style: {
                            colors: ['#6B7280'],
                            fontSize: '14px',
                            fontWeight: 500,
                        },
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                },
                yaxis: {
                    show: true,
                    labels: {
                        formatter: function (value) {
                            return value + '%';
                        }
                    },
                },
                fill: {
                    opacity: 1
                },
                plotOptions: {
                    bar: {
                        columnWidth: '90%',
                        borderRadius: 3
                    }
                },
                tooltip: {
                    shared : true,
                    intersect: false,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'Inter, sans-serif'
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 1
                        }
                    }
                },
                stroke: {
                    show: true,
                    width: 5,
                    colors: ['transparent']
                },
                grid: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    fontSize: '14px',
                    fontWeight: 500,
                    fontFamily: 'Inter, sans-serif',
                    labels: {
                        colors: ['#6B7280']
                    },
                    itemMargin: {
                        horizontal: 10
                    }
                },
            },
            series: [
                {
                    name: 'Rendement Huile Brute',
                    color: '#1A56DB',
                    data: this.crudeOilYield
                },
                {
                    name: 'Rendement de coques',
                    color: '#FDBA8C',
                    data: this.soyHullYield
                },
                {
                    name: 'Freinte trituration',
                    color: '#17B0BD',
                    data: this.crushedWaste
                },
                {
                    name: 'Rendement PVT non-conforme',
                    color: '#fbbd23',
                    data: this.nonCompliantBaggedTvpYield
                },
                {
                    name: 'Freinte à l\'extrusion',
                    color: '#f87272',
                    data: this.extrusionWaste
                },
                {
                    name: 'Freinte total du lot',
                    color: '#7e3af2',
                    data: this.lotWaste
                }
            ]
        }
      }
  }
  </script>
