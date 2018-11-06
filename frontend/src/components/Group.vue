<template>
<div>
  <a @click="toggle" class="text-grey-darkest" href="#">
    <h2
      :class="{
        'border-b': !show
      }"
      class="relative mb-4 py-3 pl-2 hover:bg-grey-lighter rounded-none hover:rounded hover:border-0"
    >
      {{ group.name }}
      <span class="text-sm font-light">{{ group.description }}</span>

      <svg class="h-5 w-5 fill-current text-grey absolute pin-r pin-t mt-4 mr-6" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="408px" height="408px" viewBox="0 0 408 408" style="enable-background:new 0 0 408 408;" xml:space="preserve">
        <path d="M204,102c28.05,0,51-22.95,51-51S232.05,0,204,0s-51,22.95-51,51S175.95,102,204,102z M204,153c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S232.05,153,204,153z M204,306c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S232.05,306,204,306z"/>
      </svg>
    </h2>
  </a>

  <Endpoint
    v-if="show"
    v-for="(api, index) in group.endpoints"
    :key="index"
    :api="api"
  />
</div>
</template>

<script>
import Endpoint from '@/components/Endpoint'
import { mapGetters } from 'vuex'

export default {
  props: {
    group: {
      type: Object,
      default () {
        return {}
      }
    }
  },

  components: {
    Endpoint,
  },

  mounted () {
    this.show = this.config.group_open
  },

  data () {
    return {
      show: true,
      // endpoints: [
      //   {
      //     method: 'post',
      //     endpoint: '/pets',
      //     description: 'Add new pet to the store'
      //   }, {
      //     method: 'put',
      //     endpoint: '/pets/{pet}',
      //     description: 'Update an existing pet'
      //   }, {
      //     method: 'get',
      //     endpoint: '/pets',
      //     description: 'Get list of pets'
      //   }, {
      //     method: 'delete',
      //     endpoint: '/pets/{pet}',
      //     description: 'Delete a pet'
      //   }
      // ]
    }
  },

  computed: {
    ...mapGetters(['config']),
  },

  methods: {
    toggle () {
      this.show = !this.show
    }
  }
}
</script>
