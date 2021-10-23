import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '@/view/Home'
import Product from '@/view/Product'
import NewProduct from '@/view/NewProduct'
import NewClient from '@/view/NewClient'
import ListClients from '@/view/ListClients'
import ListProducts from '@/view/ListProducts'
import GenerateBar from '@/view/GenerateBar'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    components: {
      dashboard: Home
    }
  },
  {
    path: '/vendas',
    name: 'Product',
    components: {
      dashboard: Product
    }
  },
  {
    path: '/cadastrar_produto',
    name: 'NewProduct',
    components: {
      dashboard: NewProduct
    }
  },
  {
    path: '/cadastrar_cliente',
    name: 'NewClient',
    components: {
      dashboard: NewClient
    }
  },
  {
    path: '/lista_clientes',
    name: 'ListClients',
    components: {
      dashboard: ListClients
    }
  },
  {
    path: '/lista_produtos',
    name: 'ListProducts',
    components: {
      dashboard: ListProducts
    }
  },
  {
    path: '/gerar_barra',
    name: 'GenerateBar',
    components: {
      dashboard: GenerateBar
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
