import './bootstrap';

import { createApp } from 'vue';
import LaravelVuePagination from 'laravel-vue-pagination';
import store from './store'
import router from './routes/index'
import VueSweetalert2 from "vue-sweetalert2";
import vSelect from "vue-select";
import Toast from "vue-toastification";
import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-select/dist/vue-select.css';
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
const app = createApp();



app.use(Toast);
app.use(router)
app.use(store)
app.use(VueSweetalert2)
app.component('Pagination', LaravelVuePagination)
app.component("v-select", vSelect);
app.mount('#app')
