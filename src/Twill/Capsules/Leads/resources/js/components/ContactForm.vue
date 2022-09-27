<template>
    <div  class="container">
        <div class="row mt-5 mb-5">
            <div class="md:px-8 lg:px-72">
                <section class="bg-white">
                    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                        <form v-if="success.length == 0" ref="form" class="space-y-8" id="contactUSForm" >
                            <div>
                                <input  autoComplete="chrome-off" autoCorrect="chrome-off" autoCapitalize="chrome-off"
                                    type="text" id="contact_name"
                                    class="form-control rounded-[8px] active-header w-full form-control mb-2.5 "
                                    placeholder="Nome*" v-model="first_name" 
                                    :class="[errorClass.first_name, (errorClass.first_name === true) ? 'error' : '']"
                                    />
                            </div>
                            <div>
                                <input autoComplete="chrome-off" autoCorrect="chrome-off" autoCapitalize="chrome-off"
                                    type="text" id="contact_surname"
                                    class="form-control rounded-[8px] active-header w-full form-control mb-2.5"
                                    placeholder="Cognome*" v-model="last_name"
                                    :class="[errorClass.last_name, (errorClass.last_name === true) ? 'error' : '']"
                                    />
                            </div>
                            <div>
                                <input autoComplete="chrome-off" autoCorrect="chrome-off" autoCapitalize="chrome-off"
                                    type="email" id="contact_email"
                                    class="form-control rounded-[8px] active-header w-full form-control mb-2.5"
                                    placeholder="Email*" v-model="email"
                                    :class="[errorClass.email, (errorClass.email === true) ? 'error' : '']"
                                    />
                            </div>
                            <div class="input-field relative flex items-center">
                                <input autocomplete="chrome-off" type="tel" id="phone_number"
                                    class="form-control rounded-[8px] active-header w-full form-control mb-2.5 "
                                    placeholder="Telefono Facoltativo" v-model="phone_nr"
                                    pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                                    :class="[errorClass.phone_nr, (errorClass.phone_nr === true) ? 'error' : '']"
                                    />
                                <label for="phone_number" class="absolute left-[14px] bottom-[19px]">
                                    <span class="fs-18 primary-color">Telefono</span>
                                    <span class="fs-10 primary-color ml-1.5">Facoltativo</span>
                                </label>
                            </div>

                            <div class="input-field relative flex items-center">
                                <input autocomplete="chrome-off" type="text" v-model="company" id="azienda"
                                    class="form-control rounded-[8px] active-header w-full form-control mb-2.5"
                                    placeholder=" " />
                                <label for="azienda" class="absolute left-[14px] bottom-[19px]">
                                    <span class="fs-18 primary-color">Azienda</span>
                                    <span class="fs-10 primary-color ml-1.5">Facoltativo</span>
                                </label>
                            </div>

                            <textarea autocomplete="chrome-off" type="text" rows="7" id="ham" v-model="message"
                                class="form-control rounded-[8px] active-header w-full form-control mb-2.5"
                                placeholder="Messaggio*"></textarea>
                            <div class="container relative flex flex-col items-center">
                                <button  
                                    @click.prevent="sendData" 
                                    style="
                                        width: 96px;
                                        height: 44px;
                                        border: 1px solid #e7e9ff;
                                        border-radius: 30px;
                                    "
                                    :class="text-gray-500">
                                    Send
                                </button>
                              
                            </div>
                            <p v-if="errors.length">
                                <span v-for="error in errors" v-show="elementVisible" class="text-red-700">
                                    {{ error }}
                                </span>
                            </p>
                        </form>
                        <p v-if="success.length">
                            <span v-for="suc in success" v-show="elementSVisible" class="text-green-700">
                                {{ suc }}
                            </span>
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "ContactForm",

    /**
     *
     */
    props: {
        first_name: {
            type: String,
            default: null,
        },
        last_name: {
            type: String,
            default: null,
        },
        company: {
            type: String,
            default: null,
        },

        phone_nr: {
            type: Number,
            default: null,
        },

        message: {
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
            elementVisible: true,
            elementSVisible: true,
            errorClass:{
                first_name: false,
                last_name: false,
                email: false,
                phone_nr: false,
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
            this.$attrs["email"];
          
            
            axios
                .post(
                    "contact-us/store?locale=" + this.locale,
                    {
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email: this.email,
                        company: this.company,
                        phone_nr: this.phone_nr,
                        message: this.message,
                        base_email: this.$attrs["email"],
                    },

                    this.handleMailResponse
                )
                .then((response) => {

                    if (response.status == 200) {
                        this.success.push(response.data.message);
                        setTimeout(() => (this.elementSVisible = false), 7000);
                    }
                   
                })
                .catch((error) => {

                    if(this.first_name == ''){
                        this.errorClass.first_name = true
                    }

                    if(this.last_name == ''){
                        this.errorClass.last_name = true
                    }

                    if(this.email == ''){
                        this.errorClass.email = true
                    }

                    if(this.phone_nr == ''){
                        this.errorClass.phone_nr = true
                    }

                    this.errors.push(error.response.data.message);
                    setTimeout(() => (this.elementVisible = false), 7000);
                });

            this.$refs.form.reset();
        },
    },
};
</script>

<style scoped>
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

.form-control.error:focus-visible {
    outline: 1px solid #fd343b;
}

.form-control.error::placeholder,
.form-control.error {
    color: #fd343b;
}
</style>
