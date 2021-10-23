<template>
  <div class="vendas">
    <div class="box-product">
      <div class="box-inf">
        <div>
          <p> código do produto </p>
          <input type='text' mask="############" v-model="idProduct" >
          <barcode
            v-model="idProduct"
            class="mt-2"
            tag="img"
          >
            Nem código digitado
          </barcode>
        </div>

        <v-btn
          color="#29CC97"
          class="btn-date mt-2"
          @click.prevent="generateAndDownloadBarCode(idProduct)"
        >
        Baixar
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script>
import VueBarcode from 'vue-barcode'
import { generateAndDownloadBarcodeInPDF } from '@/generateBarcode.js'

export default {
  components: {
    barcode: VueBarcode
  },

  data () {
    return {
      idProduct: '1232123'
    }
  },
  methods: {
    generateAndDownloadBarCode (id) {
      generateAndDownloadBarcodeInPDF(id)
    }
  }
}
</script>

<style>

</style>
