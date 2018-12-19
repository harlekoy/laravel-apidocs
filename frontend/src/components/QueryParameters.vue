<template>
<div class="relative">
  <a
    @click.prevent="toggle"
    href="#"
    class="flex font-bold items-center border-t block bg-grey-lighter py-2 px-4 shadow text-grey-darker"
  >{{ title }}
  <svg
    :class="{
      'rotate-1/2': !show
    }"
    class="w-3 h-3 text-grey-dark fill-current absolute pin-r mr-6" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 284.929 284.929" style="enable-background:new 0 0 284.929 284.929;" xml:space="preserve">
    <path d="M282.082,195.285L149.028,62.24c-1.901-1.903-4.088-2.856-6.562-2.856s-4.665,0.953-6.567,2.856L2.856,195.285 C0.95,197.191,0,199.378,0,201.853c0,2.474,0.953,4.664,2.856,6.566l14.272,14.271c1.903,1.903,4.093,2.854,6.567,2.854 c2.474,0,4.664-0.951,6.567-2.854l112.204-112.202l112.208,112.209c1.902,1.903,4.093,2.848,6.563,2.848 c2.478,0,4.668-0.951,6.57-2.848l14.274-14.277c1.902-1.902,2.847-4.093,2.847-6.566 C284.929,199.378,283.984,197.188,282.082,195.285z"/>
  </svg>
  </a>
  <div v-show="show" class="flex flex-col p-4">
    <div class="flex items-start my-2">
      <div class="w-1/3 font-bold"></div>
      <div class="w-2/3">
        <CodeEditor v-model="json" />
      </div>
    </div>
  </div>
</div>
</template>

<script>
import CodeEditor from '@/components/CodeEditor'

export default {
  props: {
    value: {
      type: Object,
      default () {
        return {}
      }
    },

    title: {
      type: String,
      default () {
        return 'Query Parameters'
      }
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

    json (current) {
      this.$emit('input', current)
    }
  },

  data () {
    return {
      json: {},
      show: false,
    }
  },

  methods: {
    toggle () {
      this.show = !this.show
    }
  }
}
</script>
