<template>
    <apexcharts height="420px" type="line" :options="chartOptions" :series="series"></apexcharts>
</template>

  <script>
  import VueApexCharts from 'vue3-apexcharts';

  export default {
    name: 'IncidentsMaintenancesGraph',
    props: {
        serieIncidents: Array,
        serieMaintenances: Array,
        serieMonths: Array,
    },
    components: {
      apexcharts: VueApexCharts,
    },
    computed: {

    },
    data: function() {
        return {
            chartOptions: {
                chart: {
			        height: '420px',
                    toolbar: {
                        show: false
                    }
                },
                grid: {
                    show: true,
                    borderColor: '#F3F4F6',
                    strokeDashArray: 1,
                    padding: {
                        left: 35,
                        bottom: 15
                    }
                },
                xaxis: {
                    categories: this.serieMonths,
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 500,
                        },
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 500,
                        }
                    },
                },
                markers: {
                    size: 5,
                    strokeColors: '#ffffff',
                    hover: {
                        size: undefined,
                        sizeOffset: 3
                    }
                },
                legend: {
                    fontSize: '14px',
                    fontWeight: 500,
                    fontFamily: 'Inter, sans-serif',
                },

            },
            series: [
                {
                    name: 'Incidents',
                    data: this.serieIncidents,
                    color: '#f87272'
                },
                {
                    name: 'Maintenances',
                    data: this.serieMaintenances,
				    color: '#fbbd23'
                }
            ]
        }
      }
  }
  </script>
