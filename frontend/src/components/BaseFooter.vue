<template>
<p class="py-8 text-center text-xs bg-grey-lightest border-t">
    <a href="https://www.betprophet.co/" class="text-blue">Betprophet</a>
    <span class="px-1">&middot;</span>
    &copy; {{ year }} Dynamic Bets - By Harlequin Doyon, Germaine Abellanosa.
    <span class="px-1">&middot;</span>
    {{ config.version }}
</p>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters([
      'config'
    ]),

    year () {
      return (new Date).getFullYear()
    }
  }
}
</script>
