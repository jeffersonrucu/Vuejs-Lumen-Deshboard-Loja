<template>
  <div class="vendas">
    <mask-input type='text' mask="#########" class="id-product" placeholder="Código do produto" v-model="idProduct"/>
    <div class="box-product">
      <div class="img" :style="{ 'background-image': 'url('  + trataUrl(imageProduct) + ')' }"></div>

      <div class="box-inf">
        <div>
          <p> produto </p>
          <input type='text' v-model="product.name" disabled/>
        </div>
        <div>
          <p> valor </p>
          <money v-model="product.price" v-bind="money" disabled></money>
        </div>
        <div>
          <p> dinheiro do cliente </p>
          <money v-model="userMoney" v-bind="money"></money>
        </div>
        <div>
          <p> troco </p>
          <money v-model="troco"  v-bind="money" disabled/>
        </div>
        <div>
          <p>quantidade no estoque</p>
          <input type='text' v-model="product.amount" disabled/>
        </div>
        <!-- <div>
          <p>Cores</p>
          <div class="colors">
            <div
              class="color"
              v-for="color in product.colors" :key="color"
              :style="'background-color:' + color"
            >
            </div>
          </div>
        </div> -->
        <v-btn
          v-bind="attrs"
          v-on="on"
          color="#29CC97"
          class="btn-date"
          v-if="btnSale && estoque"
          @click="sale"
        >
        Vender
        </v-btn>
        <v-btn
          v-bind="attrs"
          v-on="on"
          color="#29CC97"
          class="btn-date"
          disabled
          v-if="estoque === false"
        >
        Sem Estoque
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script>
import { TheMask } from 'vue-the-mask'
import { Money } from 'v-money'
import axios from 'axios'

export default {
  components: {
    'mask-input': TheMask,
    Money
  },
  data () {
    return {
      myCroppa: {},
      imageProduct: '',
      idProduct: '',
      product: {
        price: '00.00',
        // colors: ['#72A4C9', '#E80000', '#ECD829', '#FFFFFF', '#1B1B1B'],
        name: '',
        amount: ''
      },
      money: {
        decimal: ',',
        thousands: '.',
        prefix: 'R$ ',
        precision: 2,
        masked: false
      },
      userMoney: null,
      troco: null,
      btnSale: false,
      status: null,
      error: null,
      estoque: true
    }
  },
  methods: {
    uploadCroppedImage () {
      this.myCroppa.generateBlob((blob) => {
        // write code to upload the cropped image file (a file is a blob)
      }, 'image/jpeg', 0.8) // 80% compressed jpeg file
    },
    attProduct (barcode) {
      axios
        .get(`http://localhost:8010/product/${barcode}`)
        .then((response) => {
          this.product = {
            price: response.data.value,
            // colors: ['#72A4C9', '#E80000', '#ECD829', '#FFFFFF', '#1B1B1B'],
            name: response.data.name,
            amount: response.data.amount,
            id: response.data.id
          }
          this.imageProduct = response.data.image
          this.btnSale = true
        })
        .catch(error => {
          this.error = error.response.data
        })
    },
    sale () {
      // sold
      var data = {
        id: this.product.id
      }

      const config = {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      }

      if (this.product.amount <= 0) {
        this.estoque = false
      } else {
        axios
          .post('http://localhost:8010/sold', data, config)
          .then((response) => {
            this.status = response.data
            this.attProduct(this.idProduct)
          })
          .catch(error => {
            this.error = error.response.data
          })
      }
    },
    trataUrl (url) {
      url = "'" + url + "'"
      return url
    }
  },
  watch: {
    idProduct () {
      if (this.idProduct.length === 9) {
        axios
          .get(`http://localhost:8010/product/${this.idProduct}`)
          .then((response) => {
            this.product = {
              price: response.data.value,
              // colors: ['#72A4C9', '#E80000', '#ECD829', '#FFFFFF', '#1B1B1B'],
              name: response.data.name,
              amount: response.data.amount,
              id: response.data.id
            }
            this.imageProduct = response.data.image
            this.btnSale = true
          })
          .catch(error => {
            this.error = error.response.data
          })
      }
    },
    userMoney () {
      this.troco = this.userMoney - this.product.price
    },
    product () {
      if (this.product.amount <= 0) {
        this.estoque = false
      }
    }
  }
}
</script>

<style>

</style>
