<template>
  <div class="cliente">
    <div>
      <p> nome do cliente </p>
      <input type='text' v-model="clients.name">
    </div>
    <div class="mt-5">
      <p> e-mail do cliente </p>
      <input type='email' v-model="clients.email">
    </div>
    <div class="mt-5">
      <p>celular do cliente</p>
      <mask-input type='text' mask="+## (##) #####-####" v-model="clients.cellPhone" />
    </div>
    <div class="mt-5">
      <v-alert
        dense
        text
        type="success"
        v-show="status"
      >
      <strong>Cliente</strong> cadastrando com <strong>sucesso !</strong>
      </v-alert>
    </div>
    <v-btn
      v-bind="attrs"
      v-on="on"
      color="#1867C0"
      class="btn-date mt-5"
      @click="register"
    >
    Cadastrar
    </v-btn>
  </div>
</template>

<script>
import { TheMask } from 'vue-the-mask'
import axios from 'axios'

export default {
  components: {
    'mask-input': TheMask
  },

  data () {
    return {
      clients: {
        name: '',
        email: '',
        cellPhone: ''
      },
      status: false
    }
  },
  watch: {
    status () {
      var that = this
      setTimeout(function () {
        that.status = false
      }, 2000)
    }
  },
  methods: {
    register () {
      var data = {
        name: this.clients.name,
        email: this.clients.email,
        cell_phone: this.clients.cellPhone
      }

      const config = {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      }

      axios
        .post('http://localhost:8010/client/register', data, config)
        .then(response => {
          this.status = response.data
          this.clients = {
            name: '',
            email: '',
            cellPhone: ''
          }
          this.status = true
        })
        .catch(error => {
          this.error = error.response
        })
    }
  }
}
</script>

<style>

</style>
