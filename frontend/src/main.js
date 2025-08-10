import Vue from 'vue'
import App from './App.vue'
import PrimeVue from 'primevue/config'
import 'primevue/resources/primevue.min.css'
import 'primeicons/primeicons.css'
import 'primevue/resources/themes/saga-blue/theme.css'
import './assets/main.css'
import router from './router'

Vue.use(PrimeVue)

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')