require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue'
// ルーティングの定義をインポートする
import router from './router'
// ルートコンポーネントをインポートする
import App from './App.vue'
import Navbar from './components/Navbar.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI);
Vue.use(VueAxios, axios)
Vue.component('nav-bar',Navbar)
new Vue({
  el: '#app',
  router, // ルーティングの定義を読み込む
  // components: { App }, // ルートコンポーネントの使用を宣言する
  // template: '<App />' // ルートコンポーネントを描画する
})

