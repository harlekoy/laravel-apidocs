<template>
<div>
  <h3 class="border-t block bg-grey-lighter py-2 px-4 shadow text-grey-darker">Parameters</h3>
  <div class="flex flex-col p-4">
    <div class="flex pb-3 border-b w-full mb-2">
      <div class="w-1/3">Name</div>
      <div class="w-2/3">Description</div>
    </div>

    <div
      v-for="(param, index) in routeParams"
      :key="index"
      class="flex items-start my-2"
    >
      <div class="w-1/3 font-bold">{{ param }}<span class="m-1 text-red font-bold">*</span></div>
      <div class="w-2/3">
        <!-- <div class="description">
          ID of pet to return
        </div> -->

        <input
          v-model="params[param]"
          class="p-2 rounded"
          type="text"
          :placeholder="param"
        />
      </div>
    </div>

    <div v-if="value.method !== 'GET'" class="flex items-start my-2">
      <div class="w-1/3 font-bold">body<span class="m-1 text-red font-bold">*</span></div>
      <div class="w-2/3">
        <!-- <div class="description">
          Pet object that needs to be added to the store
        </div> -->
        <CodeEditor v-model="data" />
      </div>
    </div>

    <div class="flex">
      <div class="w-1/3"></div>
      <div class="w-2/3">
        <button
          @click.prevent="onExecute"
          :class="{
            'btn-loading': loader
          }"
          class="bg-blue-light py-2 px-4 mt-2 shadow text-lg font-bold text-white rounded"
        >Execute</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import CodeEditor from '@/components/CodeEditor'
import { trim, each } from 'lodash'
import { mapGetters } from 'vuex'

export default {
  props: {
    value: {
      type: Object,
      default () {
        return {}
      }
    },

    load: {
      type: Boolean,
      default: false,
    }
  },

  components: {
    CodeEditor,
  },

  watch: {
    value: {
      immediate: true,
      handler (current) {
        this.json = current
      }
    },

    load: {
      immediate: true,
      handler (current) {
        this.loader = current
      }
    },

    json (current) {
      this.$emit('input', current)
    },

    params (current) {
      this.$set(this.json, 'parameters', current)
    }
  },

  data () {
    return {
      json: {},
      data: {},
      params: {},
      loader: false,
    }
  },

  computed: {
    ...mapGetters(['config']),

    routeParams () {
      let params = this.json.endpoint.match(/\{\w+\}/g)

      if (params) {
        return params.map((field) => {
          return trim(field, '{}')
        })
      }

      return []
    },

    url () {
      let endpoint = this.json.endpoint

      each(this.routeParams, (param) => {
        endpoint = endpoint.replace('{'+param+'}', this.params[param])
      })

      return this.config.api_url+endpoint
    }
  },

  methods: {
    onExecute () {
      this.loader = true
      this.$emit('executed', this.url, this.data)
    },

    finish () {
      this.loader = false
    }
  }
}
</script>
