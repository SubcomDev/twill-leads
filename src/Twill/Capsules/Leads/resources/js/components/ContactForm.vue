<template>
    <div class="flex flex-col">
        <form v-if="success.length == 0" ref="form" id="contactUSForm">
            <input autoComplete="chrome-off" v-model="first_name" autoCorrect="chrome-off" autoCapitalize="chrome-off"
                minlength="3" type="text" id="contact_name" :class="input_class + firstNameClassError"
                placeholder="Nome*" />

            <input autoComplete="chrome-off" autoCorrect="chrome-off" autoCapitalize="chrome-off" minlength="3"
                type="text" id="contact_surname" :class="input_class + lastNameClassError" placeholder="Cognome*"
                v-model="last_name" />

            <input autoComplete="chrome-off" autoCorrect="chrome-off" autoCapitalize="chrome-off" type="email"
                id="contact_email" :class="input_class + emailClassError" placeholder="Email*" v-model="email" />

            <div class="input-field relative flex items-center">
                <input autocomplete="chrome-off" type="tel" id="phone_number" :class="input_class"
                    placeholder="Telefono Facoltativo" v-model="phone_nr" />
                <label for="phone_number" class="absolute left-[14px] bottom-[19px]">
                    <span class="fs-18 primary-color">Telefono</span>
                    <span class="fs-10 primary-color ml-1.5">Facoltativo</span>
                </label>
            </div>

            <div class="input-field relative flex items-center">
                <input autocomplete="chrome-off" type="text" v-model="company" id="azienda" :class="input_class"
                    placeholder=" " />
                <label for="azienda" class="absolute left-[14px] bottom-[19px]">
                    <span class="fs-18 primary-color">Azienda</span>
                    <span class="fs-10 primary-color ml-1.5">Facoltativo</span>
                </label>
            </div>

            <textarea autocomplete="chrome-off" type="text" rows="7" id="ham" minlength="3" v-model="message"
                :class="input_class + messageClassError" placeholder="Messaggio*"></textarea>

            <div class="flex flex-row">
                <input v-model="privacy_checkbox" type="checkbox" id="checkbox" name="privacy_checkbox" />
                <span class="ml-2 text-blue-600" for="checkbox">
                    <label v-html="privacy"></label>
                </span>
            </div>

            <div class="container relative flex flex-col items-center">
                <button @click.prevent="sendData" :disabled="!formValid" style="width: 96px; height: 44px" :class="[
                    loading ? 'bg-zinc-400 hover:bg-zinc-400 cursor-not-allowed' : '',
                ]"
                    class="button items-center text-center px-4 py-2 sm:w-fit bg-primary-color hover:bg-primary-color font-semibold leading-6 text-sm shadow rounded-3xl text-white transition ease-in-out duration-150">
                    <svg v-if="loading" class="animate-spin mr-3 h-5 w-5 text-white ml-5"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <span v-else class="text-lg">{{ this.label }}</span>
                </button>
            </div>
        </form>

        <div v-if="success.length || success_message" class="container relative flex flex-col items-center mt-16">
            <span :key="index" v-for="(suc, index) in success" class="text-green-700 text-2xl">
                {{ suc }}
            </span>
        </div>
    </div>
</template>

<script>
const expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

import axios from "axios";

export default {
    name: "ContactForm",
    props: {
        success_message: {
            type: String,
            default: "",
        },
        admin_email: {
            type: String,
            default: "",
        },
        locale: {
            type: String,
            default: "it",
        },
        label: {
            type: String,
            default: "Send",
        },
        privacy: {
            type: String,
            default: null,
        },
    },
    /**
     *
     */

    data() {
        return {
            loading: false,
            privacy_checkbox: false,
            email: "",
            first_name: "",
            last_name: "",
            company: "",
            phone_nr: "",
            message: "",
            wrongEmail: false,
            form_valid: false,
            text: "",
            errors: [],
            success: [],
            errorClass: {
                first_name: false,
                last_name: false,
                email: false,
                message: false,
            },

            input_class:
                "form-control rounded-[8px] active-header w-full form-control mb-2.5 ",

            /**
             *
             */
            firstNameLoaded: true,

            /**
             *
             */
            lastNameLoaded: true,

            /**
             *
             */
            emailLoaded: true,

            /**
             *
             */
            messageLoaded: true,
        };
    },

    computed: {
        /**
         *
         */
        firstNameClassError() {
            if (this.firstNameLoaded) return "";

            if (this.first_name.length == 0 || this.errorClass.first_name == true)
                return " error";

            return "";
        },

        /**
         *
         */
        lastNameClassError() {
            if (this.lastNameLoaded) return "";

            if (this.last_name.length == 0 || this.errorClass.last_name == true)
                return " error";

            return "";
        },

        /**
         *
         */
        emailClassError() {
            if (this.emailLoaded) return "";
            if (
                !expr.test(this.email) ||
                this.errorClass.email == true ||
                this.email.length == 0
            )
                return "error";

            return "";
        },

        /**
         *
         */
        messageClassError() {
            if (this.messageLoaded) return "";

            if (this.message.length == 0 || this.errorClass.message == true)
                return " error";

            return "";
        },

        /**
         *
         *
         *
         */
        formValid() {
            if (
                this.first_name.length > 0 &&
                this.last_name.length > 0 &&
                this.message.length > 0 &&
                this.email.length > 0 &&
                this.privacy_checkbox == true
            ) {
                return true;
            }

            return false;
        },
    },

    /**
     *
     */
    mounted() { },

    watch: {
        first_name(value) {
            // binding this to the data value in the first_name input
            if (this.firstNameLoaded == true) {
                this.firstNameLoaded = false;
            }
            this.first_name = value;
        },
        last_name(value) {
            if (this.lastNameLoaded == true) {
                this.lastNameLoaded = false;
            }
            // binding this to the data value in the last_name input
            this.last_name = value;
        },
        email(value) {
            if (this.emailLoaded == true) {
                this.emailLoaded = false;
            }
            // binding this to the data value in the email input
            this.email = value;
        },
        company(value) {
            // binding this to the data value in the company input
            this.company = value;
        },
        phone_nr(value) {
            // binding this to the data value in the phone input
            this.phone_nr = value;
        },
        message(value) {
            if (this.messageLoaded == true) {
                this.messageLoaded = false;
            }
            // binding this to the data value in the message input
            this.message = value;
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
        sendData: function () {
            this.loading = !false;

            axios
                .post(
                    "/leads/contact/store?locale=" + this.locale,
                    {
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email: this.email,
                        company: this.company,
                        phone_nr: this.phone_nr,
                        message: this.message,
                        admin_email: this.admin_email,
                        success_message: this.success_message,
                        locale: this.locale,
                    },

                    this.handleMailResponse
                )
                .then((response) => {
                    if (response.status == 200) {
                        if (this.success_message) {
                            this.success.push(this.success_message);
                        } else {
                            this.success.push(response.data.message);
                        }
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    if (error.response.data.errors.hasOwnProperty("first_name") == true) {
                        this.errorClass.first_name = true;
                    }

                    if (error.response.data.errors.hasOwnProperty("last_name") == true) {
                        this.errorClass.last_name = true;
                    }

                    if (
                        this.email == "" ||
                        error.response.data.errors.hasOwnProperty("email")
                    ) {
                        this.errorClass.email = true;
                    }

                    if (error.response.data.errors.hasOwnProperty("message") == true) {
                        this.errorClass.message = true;
                    }

                    this.errors.push(error.response.data.message);
                });

            // this.$refs.form.reset();
        },
    },
};
</script>

<style scoped>
button:disabled {
    background: #d8e8e9;
    color: #337fff;
}

.form-control {
    padding: 10px 14px 8px;
    outline: 1px solid transparent;
}

.form-control:focus-visible {
    outline: 1px solid #337fff;
}

.form-control:focus-visible+label {
    display: none;
}

.form-control::placeholder,
.form-control {
    font-size: 18px;
    color: #337fff;
}

textarea {
    resize: none;
}

.input-field>label {
    display: none;
}

.input-field>input[type="text"]:placeholder-shown+label {
    display: block;
}

.form-control.error {
    color: #fd343b;
}

.form-control.error+label span {
    color: #fd343b;
}

.form-control.error {
    outline: 1px solid #fd343b;
}

.form-control.error::placeholder,
.form-control.error {
    color: #fd343b;
}

.form-control.error::input,
.form-control.error {
    color: #fd343b;
}
</style>
