
/**
 *
 * AXIOS WRAPPER
 *
 */
export default {

    /**
     *
     */
    data() {

        return {

            responseType: '',
        }

    },
    mounted() {

    },

    methods: {

        /**
         *
         * @param {string} method
         * @param {string} url
         * @param {FormData} data
         * @param {Function} callback
         * @param  {...any} args
         */
        call: function (method, url, data = new FormData(), headers = [], callback, ...args) {
            /**
             * for internal call
             */
            if (url.charAt(0) == '/' && this.$root.base_url !== '/') {
                url = this.$root.base_url + url;
            }

            headers = {
                'Accept': 'application/json',
                //'Authorization': `Bearer ${Token.getToken()}`,

            }

            let options = {
                method: method,
                url: url,
                data: data,
                headers: headers,
                responseType: this.responseType
            }

            this.axios(options)
                .then(function (response) {

                    callback(response, ...args)

                }).catch(e => {
                    this.handleError(e);
                    callback(e.response, ...args)
                });

        },

        /**
         *
         * @param {String} url
         * @param {Function} callback
         * @param  {...any} args
         */
        get: function (url, callback, ...args) {
            this.call('get', url, null, null, callback, ...args);
        },

        /**
         *
         * @param {String} url
         * @param {Function} callback
         * @param  {...any} args
         */
        getBlob: function (url, callback, ...args) {
            /**
             * for internal call
             */
            if (url.charAt(0) == '/' && this.$root.base_url !== '/') {
                url = this.$root.base_url + url;
            }

            let headers = {
                'Accept': 'application/json',
            }

            let options = {
                method: 'GET',
                url: url,
                headers: headers,
                responseType: 'blob'
            }

            this.axios(options)
                .then(function (response) {

                    callback(response, ...args)

                }).catch(e => {

                    this.handleError(e);

                });
        },

        /**
         *
         * @param {String} url
         * @param {FormData} form
         * @param {Function} callback
         * @param  {...any} args
         */
        post: function (url, form = new FormData(), callback, ...args) {

            this.call('post', url, form, null, callback, ...args);
        },

        /**
         *
         * @param {String} url
         * @param {Function} callback
         * @param  {...any} args
         */
        delete: function (url, callback, ...args) {
            this.call('delete', url, [], null, callback, ...args);
        },

        /**
         *
         * @param {String} url
         * @param {FormData} form
         * @param {Function} callback
         * @param  {...any} args
         */
        patch: function (url, form = new FormData(), callback, ...args) {
            this.call('patch', url, form, null, callback, ...args);
        },

        /**
         *
         * @param {String} url
         * @param {Form} form
         * @param {Function} callback
         * @param  {...any} args
         */
        upload: function (url, form = new FormData(), callback, ...args) {
            let headers = {
                'Content-Type': 'multipart/form-data'
            };

            this.call('post', url, form, headers, callback, ...args);
        },

        /**
         *
         * @param {Error} error
         */
        handleError: function (error) {

            let message = error.response.statusText;

            let status = error.response.status;

            if (error.response.hasOwnProperty('data')) {
                message = error.response.data;
            }

            if (error.response.data.hasOwnProperty('message')) {
                message = error.response.data.message;
            }

            if (error.response.data.hasOwnProperty('errors')) {
                message = error.response.data.errors;
            }

            // this.$notify({ type: 'type-error', text: message })

            this.handleErrorStatusCode(status);
        },

        /**
         *
         * @param {int} code
         */
        handleErrorStatusCode: function (code) {
            switch (code) {
                case 404:
                    break;
                case 401:
                    if (Token.getToken()) {
                        //this.$store.dispatch('token/removeToken')
                    }
                    break;
                default:
                    break;
            }
        },
    }
}
