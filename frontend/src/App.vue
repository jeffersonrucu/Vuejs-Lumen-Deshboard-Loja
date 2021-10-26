<template>
  <v-app>
    <div id="login" v-if="register === false">
      <v-content class="height-100vh">
         <v-container fluid fill-height >
            <v-layout align-center justify-center aligh-center>
               <v-flex xs12 sm8 md4>
                  <v-card class="elevation-12">
                     <v-toolbar dark color="primary">
                        <v-toolbar-title>Login</v-toolbar-title>
                     </v-toolbar>
                     <v-card-text>
                        <v-form>
                          <v-text-field
                            label="E-mail"
                            type="text"
                            v-model="user.email"
                          ></v-text-field>
                          <v-text-field
                            label="Senha"
                            type="password"
                            v-model="user.password"
                          ></v-text-field>
                          <v-alert
                            dense
                            outlined
                            type="error"
                            v-if="error != null"
                          >
                            {{error.error}}
                          </v-alert>
                          <a @click="register = !register">registrar-se</a>
                        </v-form>
                     </v-card-text>
                     <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="login">Entrar</v-btn>
                     </v-card-actions>
                  </v-card>
               </v-flex>
            </v-layout>
         </v-container>
      </v-content>
    </div>

    <div id="login" v-if="register === true">
      <v-content class="height-100vh">
         <v-container fluid fill-height >
            <v-layout align-center justify-center aligh-center>
               <v-flex xs12 sm8 md4>
                  <v-card class="elevation-12">
                     <v-toolbar dark color="primary">
                        <v-toolbar-title>Registrar-se</v-toolbar-title>
                     </v-toolbar>
                     <v-card-text>
                        <v-form>
                          <v-text-field
                            label="Nome"
                            type="text"
                            v-model="user.name"
                            required
                          ></v-text-field>
                          <v-text-field
                            label="E-mail"
                            type="text"
                            v-model="user.email"
                            required
                          ></v-text-field>
                          <v-text-field
                            label="Senha"
                            type="password"
                            v-model="user.password"
                            required
                          ></v-text-field>
                        </v-form>
                     </v-card-text>
                     <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="registerUser">Registrar</v-btn>
                     </v-card-actions>
                  </v-card>
               </v-flex>
            </v-layout>
         </v-container>
      </v-content>
    </div>

    <div v-else-if="acess === true">
      <app-sidebar></app-sidebar>
      <div class="margin-default">
        <app-namepage></app-namepage>
        <transition name="fade" mode="out-in">
          <router-view name="dashboard"/>
        </transition>
      </div>
    </div>
  </v-app>
</template>

<script>
import Sidebar from './components/Sidebar'
import NamePage from './components/NamePage'
import axios from 'axios'

export default {
  name: 'App',
  components: {
    'app-sidebar': Sidebar,
    'app-namepage': NamePage
  },
  data () {
    return {
      acess: false,
      register: false,
      user: {
        name: '',
        email: '',
        password: ''
      },
      status: null,
      error: null
    }
  },
  watch: {
    error () {
      if (this.error.error === 'Sessão expirado') {
        localStorage.token = null
      }
    }
  },
  created () {
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
          this.register = null
          this.acess = true
        })
        .catch(error => {
          this.error = error.response.data
        })
    }
  },
  methods: {
    login () {
      const that = this

      if (this.user.email === '' || this.user.password === '') {
        this.error = { error: 'Digite seus dados nos campos acima' }
      } else {
        axios
          .post('http://localhost:8010/user/authentication', {
            email: this.user.email,
            password: this.user.password
          })
          .then((response) => {
            localStorage.id = response.data.id
            localStorage.token = response.data.token
            this.register = null
            this.acess = true
          })
          .catch((error) => {
            that.error = error.response.data
          })
      }
    },
    registerUser () {
      var that = this
      axios
        .post('http://localhost:8010/user/register', {
          name: this.user.name,
          email: this.user.email,
          password: this.user.password
        })
        .then((response) => {
          this.register = !this.register
        })
        .catch((error) => {
          that.error = error.response.data
        })
    }
  }
}
</script>

<style lang="scss" >
  @import "./assets/sass/main.scss";

  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
  .fade-enter-active,
  .fade-leave-active {
    transition: all .5s ease
  }
</style>
