<template>
<div>
  <QueryParameters
  title="Headers"
  v-model="json"
/>
</div>
</template>

<script>
import QueryParameters from '@/components/QueryParameters'
import qs from 'qs'
import { mapGetters, mapActions } from 'vuex'

export default {
  props: {
    value: {
      type: Object,
      default () {
        return {}
      }
    }
  },

  components: {
    QueryParameters,
  },

  watch: {
    json (current) {
      this.setHeaders(current)
    },

    headers: {
      immediate: true,
      handler (current) {
        this.json = current
      }
    }
  },

  data () {
    return {
      json: {},
      show: false,
    }
  },

  computed: {
    ...mapGetters([
      'headers',
    ])
  },

  methods: {
    ...mapActions([
      'setHeaders',
    ]),

    toggle () {
      this.show = !this.show
    }
  }
}
</script>
