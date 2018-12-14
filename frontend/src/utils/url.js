import Vue from 'vue'

export function apiUrl () {
  let url = document.head.querySelector('meta[name=api_url]').content

  return url ? url : '/'
}
