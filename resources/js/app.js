import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Toaster from '@meforma/vue-toaster';
import * as ConfirmDialog from 'vuejs-confirm-dialog'
import 'tw-elements';
import { vfmPlugin } from 'vue-final-modal'





require('./bootstrap');

// 5. Create and mount the root instance.
const app = createApp(App)







app.use(router)
app.use(Toaster)
app.use(ConfirmDialog)
app.use(vfmPlugin)



app.mount('#app')