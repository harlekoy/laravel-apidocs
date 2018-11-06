import Vue from 'vue'

export function apiUrl () {
  return document.head.querySelector('meta[name=api_url]').content
}
