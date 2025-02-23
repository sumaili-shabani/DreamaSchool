// src/plugins/vuetify.js

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)
export default new Vuetify({
    icons: {
        iconfont: 'md' || 'mdi'
    },
    theme: {
        dark: false,
        light:false
    },
})