<template>
  <div class="visao-geral">
    <v-row>
      <div
          v-for="dado, index in dados"
          :key="index"
          class="col-sm-6 col-md-4"
        >
          <div class="box-data">
            <div class="card-details">
              <p class="title">{{ dado.title }}</p>
              <p class="information">{{ dado.information }}</p>
            </div>
          </div>
      </div>
    </v-row>

   <div class="add-center">
      <div class="box-grafic">
        <h2 class="title-grafic">Quantidade de Vendas {{ typeGrafic }}</h2>
          <span>ano: </span>
          <v-menu
            bottom
            origin="center center"
            transition="scale-transition"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                v-bind="attrs"
                v-on="on"
                class="btn-date"
              >
                {{ dateSelect }}
              </v-btn>
            </template>

            <v-list>
              <v-list-item
                v-for="(item, i) in dateGrafic"
                :key="i"
              >
                <v-list-item-title @click="specificDate(i)"> <span class="select-date">{{ item }}</span> </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>

        <div class="grafic">
          <apexchart width="100%" height="400" type="area" :options="options" :series="series" ref="realtimeChart"></apexchart>
        </div>
      </div>
   </div>

    <!-- <div class="box-data">
      <div v-for="dado, index in dados" :key="index">
        <div class="card-details">
          <p class="title">{{ dado.title }}</p>
          <p class="information">{{ dado.information }}</p>
        </div>
      </div>
    </div> -->
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      dados: [
        { title: 'Vendas', information: 60 },
        { title: 'Clientes', information: 25 },
        { title: 'Faturamento', information: 'R$00,00' }
      ],
      typeGrafic: 'Anual',
      dateGrafic: [2021, 2020],
      options: {
        chart: {
          id: 'vuechart-history'
        },
        xaxis: {
          categories: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']
        }
      },
      series: [
        {
          name: 'Quantidade Vendidas',
          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        }
      ],
      dateSelect: '2021'
    }
  },
  methods: {
    specificDate (index) {
      this.dateSelect = this.dateGrafic[index]
      axios
        .get(`http://localhost:8010/sold/grafic/${this.dateSelect}`, {
          headers: {
            token: localStorage.token,
            id: localStorage.id
          }
        })
        .then((response) => {
          console.log(response.data)
          this.series[0] = response.data
          this.updateSeriesLine()
        })
        .catch(error => {
          this.error = error.response.data
        })
    },
    updateSeriesLine () {
      this.$refs.realtimeChart.updateSeries([{
        data: this.series[0].data
      }], false, true)
    }
  },
  created () {
    this.dateSelect = this.dateGrafic[0]

    axios
      .get('http://localhost:8010/product/count', {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      })
      .then((response) => {
        this.dados[1].information = response.data
      })
      .catch(error => {
        this.error = error.response.data
      })

    axios
      .get('http://localhost:8010/clients/count', {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      })
      .then((response) => {
        this.dados[2].information = response.data
      })
      .catch(error => {
        this.error = error.response.data
      })

    axios
      .get('http://localhost:8010/sold/value', {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      })
      .then((response) => {
        this.dados[3].information = response.data
      })
      .catch(error => {
        this.error = error.response.data
      })

    axios
      .get('http://localhost:8010/sold/count', {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      })
      .then((response) => {
        this.dados[0].information = response.data
      })
      .catch(error => {
        this.error = error.response.data
      })

    axios
      .get(`http://localhost:8010/sold/grafic/${this.dateSelect}`, {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      })
      .then((response) => {
        console.log(response.data)
        this.series[0] = response.data
        this.updateSeriesLine()
      })
      .catch(error => {
        this.error = error.response.data
      })
  }
}
</script>
