import Vue from 'vue'

//Main pages
import Navbar from './views/Navbar.vue';
import Articles from './views/Articles.vue';


const app = new Vue({
    el: '#app',
    components: {
        Articles,
        Navbar,
    }
});
