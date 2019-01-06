import Vue from 'vue'

export function apiUrl () {
  let url = document.head.querySelector('meta[name=api_url]').content

  return url ? url : '/'
}

export function apiPath () {
  let url = document.head.querySelector('meta[name=api_path]').content

  return url ? url : '/'
}
