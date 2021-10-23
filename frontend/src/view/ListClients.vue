<template>
  <div class="clients">
    <v-text-field
      label="Pesquisar pelo código"
    ></v-text-field>

    <v-simple-table
      fixed-header
      height="75vh"
    >
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">
              Nome
            </th>
            <th class="text-left">
              E-mail
            </th>
            <th class="text-left">
              Telefone
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item, index in desserts"
            :key="item.name"
            @click="infClient(index)"
          >
            <td>{{ item.name }}</td>
            <td>{{ item.email }}</td>
            <td><mask-input class="mask-style" type='text' mask="+## (##) #####-####" v-model="item.cell_phone" /></td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>

    <v-row justify="center" v-if="dialog">
      <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
        class="z-999"
      >
        <v-card>
          <v-card-title>
            <span class="text-h5">Dados do Cliente</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <p> nome do cliente </p>
                  <input type="text" :value="clientSelect.name" disabled>
                </v-col>
                <v-col cols="12">
                  <p> email do cliente </p>
                  <input type="text" v-model="clientSelect.email">
                </v-col>
                <v-col cols="12">
                  <p>celular do cliente</p>
                  <mask-input type='text' v-model="clientSelect.cell_phone" mask="+## (##) #####-####" />
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
              @click="deleteClient"
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
import { TheMask } from 'vue-the-mask'
import axios from 'axios'

export default {
  components: {
    'mask-input': TheMask
  },

  data () {
    return {
      desserts: [
        {
          name: 'Frozen Yogurt',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Ice cream sandwich',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Eclair',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Cupcake',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Gingerbread',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Jelly bean',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Lollipop',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Honeycomb',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Donut',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'KitKat',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Danone',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'Yammu',
          calories: '+55 (11) 98698-3341'
        },
        {
          name: 'mamai',
          calories: '+55 (11) 98698-3341'
        }
      ],
      dialog: false,
      clientSelect: {}
    }
  },
  created () {
    axios
      .get('http://localhost:8010/clients', {
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
    infClient (index) {
      this.dialog = !this.dialog
      this.clientSelect = this.desserts[index]
    },
    save () {
      this.dialog = false

      var data = {
        id: this.clientSelect.id,
        email: this.clientSelect.email,
        cell_phone: this.clientSelect.cell_phone
      }

      const config = {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      }

      axios
        .post('http://localhost:8010/client/modif', data, config)
        .then((response) => {
          this.status = response.data
        })
        .catch(error => {
          this.error = error.response.data
        })
    },
    attClient () {
      axios
        .get('http://localhost:8010/clients', {
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
    deleteClient () {
      this.dialog = false

      var data = {
        id: this.clientSelect.id
      }

      const config = {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      }

      axios
        .post('http://localhost:8010/client/delete', data, config)
        .then((response) => {
          this.status = response.data
          this.attClient()
        })
        .catch(error => {
          this.error = error.response.data
        })
    }
  }
}
</script>

<style>

</style>
