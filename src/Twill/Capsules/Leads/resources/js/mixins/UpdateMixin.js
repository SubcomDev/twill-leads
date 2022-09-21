export default {
    data: () => ({

    }),
    methods: {

    },
    computed: {

    },

    mounted() {
        this.$root.component_updated = Math.random()*100 ;

    },

    /**
     *
     */
    updated() {
        this.$root.component_updated = Math.random()*100 ;
    },
  }