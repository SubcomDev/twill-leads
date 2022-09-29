<template>
    <section class="py-32 bg-white overflow-hidden">
        <div class="container px-4 mx-auto">
            <div class="text-center max-w-xl mx-auto">
                <div class="mb-6 relative mx-auto w-16 h-16 bg-blue-600 rounded-full">
                    <div class="absolute left-1/2 top-1/2 transform -translate-y-1/2 -translate-x-1/2">
                        <svg width="40" height="40" viewbox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.00098 13.3335L18.152 22.1008C19.2716 22.8473 20.7303 22.8473 21.85 22.1008L35.001 13.3335M8.33431 31.6668H31.6676C33.5086 31.6668 35.001 30.1744 35.001 28.3335V11.6668C35.001 9.82588 33.5086 8.3335 31.6676 8.3335H8.33431C6.49336 8.3335 5.00098 9.82588 5.00098 11.6668V28.3335C5.00098 30.1744 6.49336 31.6668 8.33431 31.6668Z"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="mb-3 text-6xl md:text-7xl text-center font-bold font-heading tracking-px-n leading-tight">
                    {{ title }}
                </h2>
                <p class="mb-11 font-medium text-gray-600 leading-relaxed">
                    {{ description }}
                </p>
                <form class="mb-9" id="form" ref="form" @submit="sendData">
                    <p v-if="errors.length">
                        <span v-for="error in errors" v-show="elementVisible" class="text-red-700">
                            {{ error }}
                        </span>
                    </p>
                    <p v-if="success.length">
                        <span v-for="suc in success" v-show="elementSVisible" class="text-green-700">
                            {{ suc }}
                        </span>
                    </p>

                    <input type="checkbox" id="checkbox" v-model="checked" required />
                    <label class="ml-2" for="checkbox">
                        <a href="/privacy-policy">{{ privacy }}</a></label>
                    <div class="my-5">
                        <input
                            class="px-4 py-3 w-full text-gray-500 font-medium text-center placeholder-gray-500 outline-none border border-gray-300 rounded-lg focus:ring focus:ring-indigo-300"
                            @change="isEmailValid" v-model="email" placeholder="La tua mail*" required type="email" />
                    </div>

                    <div class="my-10 text-center">
                        <button
                            class="py-4 px-6 w-full text-white font-semibold border border-blue-700 rounded-xl shadow-4xl focus:ring focus:ring-blue-300 bg-blue-600 hover:bg-blue-700 transition ease-in-out duration-200">
                            {{ "Subscribe Now" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
export default {
    name: "NewsletterForm",

    /**
     *
     */
    props: {
        title: {
            type: String,
            default: null,
        },
        description: {
            type: String,
            default: null,
        },
        privacy: {
            type: String,
            default: null,
        },

        locale: {
            type: String,
            default: "it",
        },
    },
    /**
     *
     */

    data() {
        return {
            checked: false,
            email: "",
            wrongEmail: false,
            form_valid: false,
            text: "",
            errors: [],
            success: [],
            elementVisible: true,
            elementSVisible: true,
        };
    },

    mounted() { },

    watch: {
        email(value) {
            // binding this to the data value in the email input
            this.email = value;
        },
    },
    /**
     *
     */
    methods: {
        /**
         *
         *
         */
        sendData: function (e) {
            e.preventDefault();
            let form = new FormData();

            form.append("email", this.email);

            axios
                .post("/leads/register?locale=" + this.locale, form)
                .then((response) => {
                    if (response.status == 200) {
                        this.success.push(response.data.message);
                        setTimeout(() => (this.elementSVisible = false), 5000);
                    }
                    this.$refs.form.reset();
                    this.email = "";
                })
                .catch((error) => {
                    this.errors.push(error.response.data.message);
                    setTimeout(
                        () => ((this.elementVisible = false), (this.errors = [])),
                        5000
                    );

                    if ((this.elementVisible = true))
                        setTimeout(() => (this.elementVisible = false), 5000);
                });
        },
    },
};
</script>

<style scoped>

</style>
