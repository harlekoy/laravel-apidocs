<template>
<div class="bg-white response">
  <h3 class="relative flex items-center border-t block bg-grey-lighter py-2 px-4 shadow text-grey-darker">
    Response
    <span :class="statusClass"
      class="ml-2 text-xs text-grey"
    >({{ displayStatus }})</span>
    <a
      v-if="hasResponse || hasSample"
      href="#"
      @click.prevent=""
      v-clipboard:copy="strJson"
      v-clipboard:success="onCopy"
      class="absolute pin-r mr-20 text-sm flex items-center text-grey hover:text-blue-light"
    >
      Copy
      <svg class="ml-1 w-4 h-4 fill-current" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 561 561" style="enable-background:new 0 0 561 561;" xml:space="preserve">
      <path d="M395.25,0h-306c-28.05,0-51,22.95-51,51v357h51V51h306V0z M471.75,102h-280.5c-28.05,0-51,22.95-51,51v357
          c0,28.05,22.95,51,51,51h280.5c28.05,0,51-22.95,51-51V153C522.75,124.95,499.8,102,471.75,102z M471.75,510h-280.5V153h280.5V510
          z"/>
      </svg>
    </a>

    <a
      v-if="hasResponse"
      href="#"
      @click.prevent="clear"
      class="absolute pin-r mr-4 text-sm flex items-center text-grey hover:text-blue-light"
    >
      Clear
      <svg class="ml-1 w-3 h-3 fill-current" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.9 21.9" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 21.9 21.9">
        <path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"/>
      </svg>
    </a>
  </h3>
  <div v-if="hasResponse || hasSample" class="mt-1">
    <v-jsoneditor
      v-model="json"
      :options="options"
      :plus="false"
      @error="onError"
    />
  </div>
</div>
</template>

<script>
import { isEmpty } from 'lodash'
import { success } from '@/utils/toast'

export default {
  props: {
    value: {
      type: [Object, String],
      default () {
        return {}
      }
    },
    status: {
      type: Number,
    },
    sample: {
      type: Object,
      default () {
        return null
      }
    }
  },

  data () {
    return {
      json: {},
      options: {
        mode: 'tree',
      }
    }
  },

  watch: {
    value: {
      immediate: true,
      handler (current) {
        if (isEmpty(current)) {
          this.json = this.sample
        } else {
          this.json = current
        }
      }
    },

    json (current) {
      this.$emit('input', current)
    }
  },

  computed: {
    hasResponse () {
      return this.status !== null
    },

    hasSample () {
      return !isEmpty(this.sample)
    },

    strJson () {
      return JSON.stringify(this.json)
    },

    displayStatus () {
      if (this.status) {
        return this.status
      }

      if (this.sample) {
        return 'Sample'
      } else {
        return 'Empty'
      }
    },

    statusClass () {
      if (!this.hasResponse) {
        return 'text-grey'
      }

      if (this.status >= 300) {
        return 'text-red-dark'
      } else if (this.status < 300) {
        return 'text-green-dark'
      }
    }
  },

  methods: {
    onError () {
      console.error('Error response')
    },

    onCopy () {
      success({
        title: '',
        text: 'Copied.',
      })
    },

    clear () {
      this.json =  this.sample
      this.$emit('status', null)
      success({
        title: '',
        text: 'Cleared.',
      })
    },
  }
}
</script>

<style lang="scss">
.response {
  .jsoneditor-container {
    @apply bg-white
  }

  .jsoneditor-box .jsoneditor {
    @apply rounded-none border-white
  }

  /deep/ .jsoneditor-tree tr.jsoneditor-highlight {
    @apply bg-grey-lighter
  }
}
</style>
