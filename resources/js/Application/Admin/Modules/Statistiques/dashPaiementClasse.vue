<template>
    <div>
      <v-card class="pa-2" :loading="loading" :disabled="isloading" outlined tile elevation="2">
        <v-card-text>
          <!-- insertion stat 2 -->
          <div class="chart-wrapper">
            <apexchart
              style="width: 100%;"
              width="100%"
              :type="typechart"
              :options="stat.chartOptions"
              :series="stat.series"
            ></apexchart>
          </div>
          <!-- insertion stat 2 -->
        </v-card-text>
      </v-card>
    </div>
  </template>

  <script>
  import VueApexCharts from "vue-apexcharts";
  import { mapGetters, mapActions } from "vuex";

  export default {
    props: ["typechart"],
    data() {
      return {
        titre: "Statistique exemple",
        stat: {
          chartOptions: {
            chart: {
              id: "vuechart-example",
            },
            xaxis: {
                categories: [],
            },
          },
          series: [
            {
              name: "Vue Chart",
              data: [],
            },
          ],
        },

        loading: false,
        disabled: false,
      };
    },
    computed: {
      ...mapGetters(["isloading"]),
    },
    created() {
      this.my_statistique();
    },

    methods: {
      ...mapActions([
          "getUser",

      ]),
      async my_statistique() {
        this.isLoading(true);
        await axios
          .get(`${this.apiBaseURL}/stat_paiement_classe`)
          .then((res) => {
            var chart = res.data[0];

            this.stat.chartOptions = chart.options;
            this.stat.series = chart.series;
            this.isLoading(false);
            // console.log(chart);
          })
          .catch((err) => {
            this.errMsg();
            this.makeFalse();
            reject(err);
          });
      },
    },
  };
  </script>

  <style scoped>
  div.chart-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  </style>
