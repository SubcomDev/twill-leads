import Leads from './leads.js'



const App = {

    el: '#app',

    vuetify: new Vuetify(),

    components: {
        'app-leads': Leads,
    },

    mounted() {
        console.log('Application mounted.')
    }
}


window.addEventListener('load', () => {
    new Vue(App)
})
