<template>
    <div class="flex flex-col">
        <form v-if="success.length == 0" ref="form" id="contactUSForm">
            <input autoComplete="chrome-off" autoCorrect="chrome-off" autoCapitalize="chrome-off" minlength="3"
                type="text" id="contact_name"
                class="form-control rounded-[8px] active-header w-full form-control mb-2.5" placeholder="Nome*"
                @keyup="this.errorClass.first_name = false" v-model="first_name" :class="[
                    errorClass.first_name,
                    errorClass.first_name === true ? 'error' : '',
                ]" />

            <input autoComplete="chrome-off" autoCorrect="chrome-off" autoCapitalize="chrome-off" minlength="3"
                type="text" id="contact_surname"
                class="form-control rounded-[8px] active-header w-full form-control mb-2.5" placeholder="Cognome*"
                @keyup="this.errorClass.last_name = false" v-model="last_name" :class="[
                    errorClass.last_name,
                    errorClass.last_name === true ? 'error' : '',
                ]" />

            <input autoComplete="chrome-off" autoCorrect="chrome-off" autoCapitalize="chrome-off" type="email"
                id="contact_email" class="form-control rounded-[8px] active-header w-full form-control mb-2.5"
                placeholder="Email*" v-model="email" @keyup="ValidateEmail()"
                :class="[errorClass.email, errorClass.email === true ? 'error' : '']" />

            <div class="input-field relative flex items-center">
                <input autocomplete="chrome-off" type="tel" id="phone_number"
                    class="form-control rounded-[8px] active-header w-full form-control mb-2.5"
                    placeholder="Telefono Facoltativo" v-model="phone_nr" :class="[
                        errorClass.phone_nr,
                        errorClass.phone_nr === true ? 'error' : '',
                    ]" />
                <label for="phone_number" class="absolute left-[14px] bottom-[19px]">
                    <span class="fs-18 primary-color">Telefono</span>
                    <span class="fs-10 primary-color ml-1.5">Facoltativo</span>
                </label>
            </div>

            <div class="input-field relative flex items-center">
                <input autocomplete="chrome-off" type="text" v-model="company" id="azienda"
                    class="form-control rounded-[8px] active-header w-full form-control mb-2.5" placeholder=" " />
                <label for="azienda" class="absolute left-[14px] bottom-[19px]">
                    <span class="fs-18 primary-color">Azienda</span>
                    <span class="fs-10 primary-color ml-1.5">Facoltativo</span>
                </label>
            </div>

            <textarea autocomplete="chrome-off" type="text" rows="7" id="ham" minlength="3" v-model="message"
                :class="[errorClass.message, errorClass.message === true ? 'error' : '']"
                @keyup="this.errorClass.message = false"
                class="form-control rounded-[8px] active-header w-full form-control mb-2.5"
                placeholder="Messaggio*"></textarea>
            <div class="flex flex-row">
                <input v-model="privacy_checkbox" type="checkbox" id="checkbox" name="privacy_checkbox" />
                <span style="color: #ff0000; font-weight: bold" class="ml-2" for="checkbox">
                    <label v-html="privacy"></label>
                </span>
            </div>

            <div class="container relative flex flex-col items-center">
                <button @click.prevent="sendData" :disabled="!this.privacy_checkbox || loading" style="height: 44px"
                    :class="[
                        loading,
                        loading === true
                            ? 'inline-flex bg-slate-400 hover:bg-slate-400'
                            : '',
                    ]"
                    class="button items-center text-center px-4 py-2 sm:w-fit bg-blue-700 hover:bg-blue-700 font-semibold leading-6 text-sm shadow rounded-3xl text-white transition ease-in-out duration-150">
                    <svg v-if="loading" class="animate-spin mr-3 h-5 w-5 text-white -ml-1"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <span>{{ this.label }}</span>
                </button>
            </div>
        </form>
        <p v-if="success.length || success_message" class="container relative flex flex-col items-center mt-16">
            <span v-for="suc in success" class="text-green-700 text-2xl">
                {{ suc }}
            </span>
        </p>
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
            default: "Send",
        },
        admin_email: {
            type: String,
            default: "Send",
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
        };
    },

    mounted() { },

    watch: {
        first_name(value) {
            // binding this to the data value in the first_name input
            this.first_name = value;
        },
        last_name(value) {
            // binding this to the data value in the last_name input
            this.last_name = value;
        },
        email(value) {
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
                        if (this.$attrs["success_message"]) {
                            this.success.push(this.$attrs["success_message"]);
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

        ValidateEmail: function () {
            if (!expr.test(this.email)) {
                if (this.email.length >= 1) {
                    this.errorClass.email = true;
                } else {
                    this.errorClass.email = false;
                }
            } else {
                this.errorClass.email = false;
            }
        },
    },
};
</script>

<style scoped>
input[type="checkbox"]:checked+span {
    color: blue !important;
    font-weight: normal !important;
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
