<template>
<p class="py-8 text-center text-xs bg-grey-lightest border-t">
    <a href="https://www.linkedin.com/in/harlequin-doyon-6a0318100/" class="text-blue">Harlequin</a>
    <span class="px-1">&middot;</span>
    &copy; {{ year }} Laravel Cebu - By Harlequin Doyon.
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
