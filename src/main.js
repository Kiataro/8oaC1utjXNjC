import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './App.vue'
import locale from 'element-ui/lib/locale/lang/ru-RU'
import VueMask from 'v-mask'
import axios from 'axios'


Vue.use(VueMask);
Vue.use(ElementUI, { locale });

new Vue({
  el: '#app',
  render: h => h(App)
})
