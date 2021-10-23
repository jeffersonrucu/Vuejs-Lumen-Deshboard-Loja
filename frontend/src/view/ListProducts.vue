<template>
  <div class="products">
    <v-text-field
      label="Pesquisar pelo código ou nome"
    ></v-text-field>

    <v-simple-table
      fixed-header
      height="75vh"
    >
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">
              Código
            </th>
            <th class="text-left">
              Nome
            </th>
            <th class="text-left">
              Quantidade
            </th>
            <th class="text-left">
              Preço
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item, index in desserts"
            :key="item.name"
            @click="infProduct(index)"
          >
            <td>{{ item.barcode }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.amount }}</td>
            <td>
              <money class="money" v-model="item.value" v-bind="money" disabled></money>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>

    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
        class="z-999"
      >
        <v-card>
          <v-card-title>
            <span class="text-h5">Dados do Produto</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <p> imagem </p>
                  <div class="img" :style="{ 'background-image': 'url('  + trataUrl(productSelect.image) + ')' }"></div>
                </v-col>
                <v-col cols="12">
                  <p> código do produto </p>
                  <input type="text" :value="productSelect.barcode" disabled>
                </v-col>
                <v-col cols="12">
                  <p> nome do produto </p>
                  <input type="text" v-model="productSelect.name">
                </v-col>
                <v-col cols="6">
                  <p>quantidade</p>
                  <input type='number' v-model="productSelect.amount">
                </v-col>
                <v-col cols="6">
                  <p>preço</p>
                  <money v-model="productSelect.value" v-bind="money"></money>
                </v-col>
              </v-row>
            </v-container>
            <small>Cuidado ao fazer as alterações das informações do usúario</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog = false"
            >
              Fechar
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="save"
            >
              Salvar
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="deleteProduct"
            >
              Excluir
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>

<script>
import { Money } from 'v-money'
import axios from 'axios'

export default {
  components: {
    Money
  },
  data () {
    return {
      desserts: [],
      dialog: false,
      productSelect: '',
      money: {
        decimal: ',',
        thousands: '.',
        prefix: 'R$ ',
        precision: 2,
        masked: false
      },
      status: null,
      error: null
    }
  },
  created () {
    axios
      .get('http://localhost:8010/products', {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      })
      .then((response) => {
        this.acess = true
        this.desserts = response.data
      })
      .catch(error => {
        this.error = error.response.data
      })

    if (localStorage.token === null) {
      this.acess = false
    } else {
      axios
        .get('http://localhost:8010/checktoken', {
          headers: {
            token: localStorage.token,
            id: localStorage.id
          }
        })
        .then((response) => {
          this.acess = true
        })
        .catch(error => {
          this.acess = false
          this.error = error.response.data
        })
    }
  },
  watch: {
    error () {
      if (this.error.error === 'Sessão expirado') {
        localStorage.token = null
        this.$router.go(0)
      }
    }
  },
  methods: {
    infProduct (index) {
      this.dialog = !this.dialog
      this.productSelect = this.desserts[index]
    },
    save () {
      this.dialog = false

      var data = {
        id: this.productSelect.id,
        name: this.productSelect.name,
        value: this.productSelect.value,
        amount: this.productSelect.amount
      }

      const config = {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      }

      axios
        .post('http://localhost:8010/product/modif', data, config)
        .then((response) => {
          this.status = response.data
        })
        .catch(error => {
          this.error = error.response.data
        })
    },
    attProduct () {
      axios
        .get('http://localhost:8010/products', {
          headers: {
            token: localStorage.token,
            id: localStorage.id
          }
        })
        .then((response) => {
          this.acess = true
          this.desserts = response.data
        })
        .catch(error => {
          this.error = error.response.data
        })
    },
    deleteProduct () {
      this.dialog = false
      var data = {
        id: this.productSelect.id
      }

      const config = {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      }

      axios
        .post('http://localhost:8010/product/delete', data, config)
        .then((response) => {
          this.status = response.data
          this.attProduct()
        })
        .catch(error => {
          this.error = error.response.data
        })
    },
    trataUrl (url) {
      url = "'" + url + "'"
      return url
    }
  }
}
</script>

<style>

</style>
