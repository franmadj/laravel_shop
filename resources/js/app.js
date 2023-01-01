import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Toaster from '@meforma/vue-toaster';
import * as ConfirmDialog from 'vuejs-confirm-dialog'
import 'tw-elements';
import { vfmPlugin } from 'vue-final-modal'
import store from './store'






require('./bootstrap');

// 5. Create and mount the root instance.
const app = createApp(App)


app.directive('click-outside', {
    beforeMount: function(element, binding, vnode) {

        console.log(element, binding, vnode)

        element.clickOutsideEvent = function(event) { //  check that click was outside the el and his children
            if (!(element === event.target || element.contains(event.target))) { // and if it did, call method provided in attribute value
                //vnode.context[binding.expression](event);
                binding.value(); //run the arg
            }
        };
        document.body.addEventListener('click', element.clickOutsideEvent)
    },
    beforeUnmount: function(element) {
        document.body.removeEventListener('click', element.clickOutsideEvent)
    }
})







app.use(router)
app.use(Toaster)
app.use(ConfirmDialog)
app.use(vfmPlugin)
app.use(store)



app.mount('#app')