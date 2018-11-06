<template>
  <v-jsoneditor
    v-model="json"
    :options="options"
    :plus="false"
    @error="onError"
  />
</template>

<script>
export default {
  props: {
    value: {
      type: Object,
      default () {
        return {}
      }
    }
  },

  watch: {
    value: {
      immediate: true,
      handler (current) {
        this.json = current
      },
    },

    json (current) {
      this.$emit('input', current)
    }
  },

  data () {
    return {
      json: {},
      options: {
        mode: 'code',
      }
    }
  },

  methods: {
    onError () {
      console.error('json text editor error')
    }
  }
}
</script>

<style>
.jsoneditor-menu {
  @apply hidden
}

.ace_editor.ace-jsoneditor .ace_gutter {
  @apply bg-grey-lightest
}

.ace-jsoneditor .ace_folding-enabled > .ace_gutter-cell {
  @apply bg-grey-lighter
}

.jsoneditor-box .jsoneditor {
  @apply border-grey-light rounded overflow-hidden
}
</style>
