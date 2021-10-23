<template>
  <div class="vendas">
    <div class="box-product">
      <croppa
        :width="300"
        :height="500"
        :prevent-white-space="true"
        :show-remove-button="false"
        placeholder="Imagem do Produto"
        canvas-color="#B2E3FF"
        v-model="myCroppa"
      >
        <img crossOrigin="anonymous"
          :src= imageProduct
          slot="initial"
        >
      </croppa>

      <div class="box-inf">
        <div>
          <p> código do produto </p>
          <mask-input type='text' mask="############" class="id-product" v-model="idProduct" disabled/>
          <barcode
            v-model="idProduct"
            class="mt-2"
            tag="img"
          >
            Can't generate the barcode
          </barcode>
        </div>
        <div>
          <p> produto </p>
          <input type='text' v-model="product.name"/>
        </div>
        <div>
          <p> valor </p>
          <money v-model="product.value" v-bind="money"></money>
        </div>
        <div>
          <p>quantidade no estoque</p>
          <input type='number' v-model="product.amount"/>
        </div>
        <!-- <div>
          <p>Cores</p>
          <div class="colors">
            <div
              class="color"
              v-for="color, index in product.colors" :key="color"
              :style="'background-color:' + color"
              @click="removeColor(index)"
            >
            </div>
             <div
              class="color color-add"
            >
              <span v-if="showColor === false" @click="showColor = !showColor">+</span>
              <span v-if="showColor === true" @click="addColor">x</span>
            </div>
            <v-color-picker
              height="200"
              hide-canvas
              mode="hexa"
              v-show="showColor"
              v-model="picker"
            ></v-color-picker>
          </div>
        </div> -->
        <v-alert
          dense
          outlined
          type="error"
          v-if="error != null"
        >
          {{error.error}}
        </v-alert>
        <v-btn
          v-bind="attrs"
          v-on="on"
          color="#29CC97"
          class="btn-date mt-2"
          @click="register"
        >
        Cadastrar
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script>
import { TheMask } from 'vue-the-mask'
import { Money } from 'v-money'
import VueBarcode from 'vue-barcode'
import { generateAndDownloadBarcodeInPDF } from '@/generateBarcode.js'
import axios from 'axios'
// import jspdf from 'jspdf'

export default {
  components: {
    'mask-input': TheMask,
    barcode: VueBarcode,
    Money
  },

  data () {
    return {
      myCroppa: {},
      imageProduct: '',
      idProduct: '',
      product: {
        value: '',
        colors: [],
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
      picker: null,
      userMoney: null,
      transbordo: null,
      btnSale: false,
      showColor: false,
      status: null,
      error: null
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
    uploadCroppedImage () {
      this.myCroppa.generateBlob((blob) => {
        // write code to upload the cropped image file (a file is a blob)
      }, 'image/jpeg', 0.8) // 80% compressed jpeg file
    },
    addColor () {
      this.showColor = false
      this.product.colors.push(this.picker.hex)
    },
    removeColor (i) {
      this.product.colors.splice(i, 1)
    },
    register () {
      const config = {
        headers: {
          token: localStorage.token,
          id: localStorage.id
        }
      }

      this.myCroppa.generateBlob((blob) => {
        const data = new FormData()
        data.append('barcode', this.idProduct)
        data.append('name', this.product.name)
        data.append('value', this.product.value)
        data.append('amount', this.product.amount)
        data.append('colors', this.product.colors)
        data.append('photo', blob, this.myCroppa.getChosenFile().name)

        axios
          .post('http://localhost:8010/product/register', data, config)
          .then(response => {
            this.status = response.data
            generateAndDownloadBarcodeInPDF(this.idProduct)
            this.product = {
              name: '',
              value: '',
              amount: '',
              colors: ''
            }
            this.myCroppa = []
            this.idProduct = ''
          })
          .catch(error => {
            this.error = error.response
          })
      }, 'image/png', 0.8)
    }
  },
  created () {
    // gerator codebar
    var code = null
    for (var i = 0; i < 9; i++) {
      code += Math.floor(Math.random() * 9 + 1).toString()
    }
    this.idProduct = code
  }
}
</script>

<style>

</style>
