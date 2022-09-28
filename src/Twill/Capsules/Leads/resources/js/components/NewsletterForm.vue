<template>
    <div class="container">
        <div class="flex flex-col justify-center pb-12 lg:pb-40 items-center">
            <div class="md:px-8 lg:px-72">
                <h1 class="text-center font-inter font-semibold text-4xl text-gray-900 mt-12 lg:mt-40">
                    {{ title }}
                </h1>
                <p class="text-center mt-12 lg:mt-40">{{ description }}</p>
                <form id="form" ref="form" @submit="sendData">
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
                        <input class="form-control border-gray-500 border-2 h-10" @change="isEmailValid" v-model="email"
                            placeholder="La tua mail*" required type="email" />
                    </div>

                    <div class="my-10 text-center">
                        <button class="bg-blue-200 md:px-3 border-blue-500 lg:w-48 w-full h-10 rounded-sm font-bold">
                            {{ "Add" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                        setTimeout(() => (this.elementSVisible = false), 7000);
                    }
                    this.$refs.form.reset();
                    this.email = "";
                })
                .catch((error) => {
                    this.errors.push(error.response.data.message);
                    setTimeout(() => (this.elementVisible = false), 7000);
                });
        },
    },
};
</script>

<style scoped>

</style>
