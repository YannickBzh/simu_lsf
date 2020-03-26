<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>


export default {
  name: 'App',
  props: ['url']
}
</script>

<style>
  @import url('https://fonts.googleapis.com/css?family=Heebo:400,700&display=swap');
  #app {
    font-family: 'Heebo', sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
  }
  .container-fluid {
    padding: 0 !important;
  }
</style>
