<template>
  <div class="top-page">
    <h2>{{this.$store.state.page }}</h2>
    <div class="box-avatar">
      <v-divider
        vertical
      ></v-divider>
      <p>{{ user }}</p>
      <v-avatar
        size="36"
      >
        <img
          src="https://cdn.vuetifyjs.com/images/john.jpg"
          alt="Jefferson"
        >
      </v-avatar>
    </div>
  </div>
</template>

<script>

export default {
  data () {
    return {
      page: '',
      user: 'Jefferson Oliveira'
    }
  },
  created () {
    this.page = this.$store.state.page
  }
}
</script>
