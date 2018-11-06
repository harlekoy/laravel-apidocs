<template>
  <div id="app">
    <router-view class="pb-8" />

    <BaseFooter />
  </div>
</template>

<script>
import BaseFooter from '@/components/BaseFooter'

export default {
  components: {
    BaseFooter,
  }
}
</script>

<style lang="scss">
@import 'assets/styles/tailwind.postcss';

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

input {
  @apply border border-grey-light
}

input:focus,
button:focus {
  @apply outline-none border border-blue-light
}

.rotate-1\/4 {
  transform: rotate(90deg);
}
.rotate-1\/2 {
  transform: rotate(180deg);
}
.rotate-3\/4 {
  transform: rotate(270deg);
}
</style>
