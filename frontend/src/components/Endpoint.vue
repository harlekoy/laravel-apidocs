<template>
<div
  :class="anchorClass"
  class="my-4 border-2 rounded overflow-hidden accordion"
>
  <a
    @click.prevent="toggle"
    href="#"
    class="relative flex items-center text-grey-darkest p-2 bg-grey-lighter"
  >
    <button
      :class="buttonClass"
      class="w-24 uppercase rounded text-white p-2 text-center font-bold"
    >{{ api.method }}</button>
    <h3 class="ml-4 tracking-wide text-md">
      {{ api.endpoint }}<span class="font-light text-grey-darker">{{ strQueryParams }}</span>
    </h3>
    <span class="ml-4">{{ api.description }}</span>

    <svg
      :class="{
        'rotate-1/2': !show
      }"
      class="w-4 h-4 text-grey-darkest fill-current absolute pin-r mr-6" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 284.929 284.929" style="enable-background:new 0 0 284.929 284.929;" xml:space="preserve">
      <path d="M282.082,195.285L149.028,62.24c-1.901-1.903-4.088-2.856-6.562-2.856s-4.665,0.953-6.567,2.856L2.856,195.285 C0.95,197.191,0,199.378,0,201.853c0,2.474,0.953,4.664,2.856,6.566l14.272,14.271c1.903,1.903,4.093,2.854,6.567,2.854 c2.474,0,4.664-0.951,6.567-2.854l112.204-112.202l112.208,112.209c1.902,1.903,4.093,2.848,6.563,2.848 c2.478,0,4.668-0.951,6.57-2.848l14.274-14.277c1.902-1.902,2.847-4.093,2.847-6.566 C284.929,199.378,283.984,197.188,282.082,195.285z"/>
    </svg>
  </a>

  <div
    :class="accordionClass"
    class="overflow-hidden"
  >
    <Headers />
    <QueryParameters v-model="queryParams" />

    <Parameters
      ref="params"
      v-model="json"
      @executed="request"
    />

    <Response :json="response" />
  </div>
</div>
</template>

<script>
import axios from 'axios'
import Headers from '@/components/Headers'
import Parameters from '@/components/Parameters'
import qs from 'qs'
import QueryParameters from '@/components/QueryParameters'
import Response from '@/components/Response'
import { isEmpty, get } from 'lodash'
import { mapGetters } from 'vuex'
import { success, fail } from '@/utils/toast'

export default {
  components: {
    Headers,
    Parameters,
    QueryParameters,
    Response,
  },

  props: {
    api: {
      type: Object,
    },
  },

  data () {
    return {
      methodColors: {
        post: 'green',
        put: 'orange',
        get: 'blue',
        delete: 'red-light',
      },
      queryParams: {},
      response: {},
      json: {},
      show: false,
    }
  },

  watch: {
    api: {
      immediate: true,
      handler (current) {
        this.json = current
      }
    },
  },

  computed: {
    ...mapGetters([
      'config',
    ]),

    anchorClass () {
      return {
        [`border-${this.color}`]: true,
      }
    },

    buttonClass () {
      return {
        [`bg-${this.color}`]: true
      }
    },

    color () {
      return this.methodColors[this.api.method.toLowerCase()]
    },

    accordionClass () {
      return {
        'h-0': !this.show,
      }
    },

    strQueryParams () {
      if (!isEmpty(this.queryParams)) {
        return '?'+qs.stringify(this.queryParams)
      }
    }
  },

  methods: {
    toggle () {
      this.show = !this.show
    },

    async request (url, body) {
      try {
        const { data: response } = await axios({
          method: this.json.method,
          url: url,
          params: this.queryParams,
          data: body
        })

        success({
          text: 'Responded',
        })

        this.response = response
      } catch ({ response: { data } }) {
        let message = get(data, 'message', 'Something went wrong!')

        fail({
          title: '',
          text: message,
        })
      }

      this.$refs.params.finish()
    }
  }
}
</script>

<style scope>
.overflow-hidden {
  transition: 0.3s ease all;
}

.description {
  @apply mb-2
}
</style>
