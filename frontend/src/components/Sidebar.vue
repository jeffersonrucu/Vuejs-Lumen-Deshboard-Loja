<template>
  <div id="sidebar">
    <v-navigation-drawer
      :permanent="$vuetify.breakpoint.mdAndUp"
      absolute
      v-model="drawer"
      class="z-999"
    >
      <!-- <v-icon
        class="d-sm-none close-menu"
        @click.stop="drawer = !drawer"
      >
        mdi-close
      </v-icon> -->
      <v-list-item class="top-sidebar">
        <v-list-item-content>
          <v-list-item-title class="box-logo">
            <img src="@/assets/image/logo.png" width="30px" alt="">
            <h1>Deshboard</h1>
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list
        dense
        nav
      >
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          @click.stop="drawer = !drawer"
          class="items-menu"
        >
          <router-link :to="item.route">
            <v-list-item-icon class="icon-menu" @click="namePage(item.title)">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content @click="namePage(item.title)">
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </router-link>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list
        dense
        nav
      >
        <v-list-item
          v-for="item in itemsRegisters"
          :key="item.title"
          link
          @click.stop="drawer = !drawer"
          class="items-menu"
        >
          <router-link :to="item.route">
            <v-list-item-icon class="icon-menu" @click="namePage(item.title)">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content @click="namePage(item.title)">
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </router-link>
        </v-list-item>
      </v-list>

    </v-navigation-drawer>

    <v-toolbar-side-icon
      class="hidden-md-and-up"
      @click.stop="drawer = !drawer"
    >
      <div id="box-icon-menu">
        <v-icon>mdi-menu</v-icon>
      </div>
    </v-toolbar-side-icon>
  </div>
</template>

<script>

export default {
  data () {
    return {
      drawer: false,
      items: [
        { title: 'Visão Geral', icon: 'mdi-view-dashboard', route: '/' },
        { title: 'Vendas', icon: 'mdi-shopping', route: '/vendas' },
        { title: 'Estoque', icon: 'mdi-cube', route: '/lista_produtos' },
        { title: 'Clientes', icon: 'mdi-account-multiple', route: 'lista_clientes' },
        { title: 'Historico', icon: 'mdi-history', route: '/historico' }
      ],
      itemsRegisters: [
        { title: 'Novos produtos', icon: 'mdi-creation', route: '/cadastrar_produto' },
        { title: 'Novos clientes', icon: 'mdi-account-plus', route: '/cadastrar_cliente' },
        { title: 'Gerar barra', icon: 'mdi-barcode', route: 'gerar_barra' }
        // { title: 'Configuração', icon: 'mdi-cog', route: '/' }
      ],
      right: null
    }
  },
  methods: {
    namePage (name) {
      this.$store.commit('attPage', name)
    }
  }
}
</script>
