import './bootstrap';
import '../css/app.css'; 
import {createApp} from 'vue/dist/vue.esm-bundler';
// import Select2 from 'vue3-select2-component';
import DailyTable from './components/DailyTable.vue';
import ProductSearch from './components/ProductSearch.vue';
import MedicinesSearch from './components/MedicinesSearch.vue';
import UserSearch from './components/UserSearch.vue';
import DiscardedSaleSearch from './components/DiscardedSaleSearch.vue';

const app = createApp({
    components: {
        DailyTable,
        ProductSearch,
        MedicinesSearch,
        UserSearch,
        DiscardedSaleSearch,
    },
});

// app.component("Select2",Select2)

app.mount("#app");
