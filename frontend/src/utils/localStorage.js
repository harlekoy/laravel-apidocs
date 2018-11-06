export function getSavedState(key) {
  return JSON.parse(window.localStorage.getItem(key))
}

export function saveState(key, state) {
  window.localStorage.setItem(key, JSON.stringify(state))
}
