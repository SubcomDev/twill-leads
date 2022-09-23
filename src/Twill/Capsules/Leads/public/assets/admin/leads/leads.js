const template = `
<v-app>
    <div class="v-application">
        <v-container>
            <v-toolbar class="mt-5 mb-5 pa-0" flat   color="transparent">
                <v-toolbar-title><h2 class="text-lg-h6">Contatti</h2></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-text-field
                    v-if="leads.length >= 0"
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Cerca"
                    single-line
                    hide-details
                ></v-text-field>
            </v-toolbar>
            <v-row>
                <v-col cols="12">
                    <v-card outlined>
                        <v-toolbar dense flat>
                            <v-tooltip top>
                                <template v-slot:activator="{ on }">
                                    <v-btn link v-on="on" icon @click="exportLeads">
                                        <v-icon>mdi-file-download</v-icon>
                                    </v-btn>
                                </template>
                                <span>Esporta</span>
                            </v-tooltip>
                            <template v-if="selected.length > 0">
                                <v-divider class="ml-2 mr-2" vertical></v-divider>
                                <v-btn icon @click.stop="dialogBulk = true" ><v-icon> mdi-delete </v-icon></v-btn>
                            </template>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-divider class="mb-2"></v-divider>
                        <v-dialog
                            v-model="dialog"
                            max-width="500px"
                        >
                            <v-card>
                                <v-card-title>
                                <span class="text-h5">{{ formTitle }}</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                v-model="editedItem.email"
                                                label="Email"
                                                ></v-text-field>
                                                <span v-if="success" style="color:green">Aggiornato con successo</span>
                                                <span v-else-if="wrongEmail" style="color:red">Indirizzo email errato</span>
                                                <span v-else-if="uniqueEmail" style="color:red">L'e-mail è già stata presa</span>
                                                </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="close"
                                >
                                    Annulla
                                </v-btn>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click.stop="updated(editedItem)"
                                >
                                    Aggiornare
                                </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-data-table
                            :search="search"
                            class="mytable"
                            :headers="headers"
                            :items="leads"
                             show-select v-model="selected"
                            :options.sync="options"
                            :server-items-length="options.total"
                            :items-per-page="options.per_page"
                            :footer-props="{'items-per-page-options':rows_per_page_items }"
                            @update:pagination="updatePagination"
                            @update:page="updatePagination"
                            @update:items-per-page="updateItemsPerPage">
                            <template v-slot:item.created_at="{ item }">
                                {{ formatDate(item.created_at) }}
                            </template>
                            <template  v-slot:item.actions="{ item }">
                                <v-icon small class="mr-2" @click="editItem(item)">
                                    mdi-pencil
                                </v-icon>
                                <v-btn  icon  @click.stop="deleteAction(item)" :disabled="deleteDisable"><v-icon> mdi-delete </v-icon></v-btn>
                            </template>
                       </v-data-table>
                    </v-card>
                </v-col>
                 <v-dialog v-model="dialogDelete"  width="400">
                    <v-card>
                        <v-card-title class="headline" style="font-size: 20px !important;">
                            Elimina
                        </v-card-title>
                        <v-card-text>  Sei sicuro di voler eliminare?  </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="dialogDelete = false" >
                            Annulla
                            </v-btn>
                            <v-btn color="red" text @click="doAction" >
                            Elimina </v-btn>
                        </v-card-actions>
                    </v-card>
                 </v-dialog>
                 <v-dialog v-model="dialogBulk"  width="400">
                    <v-card>
                        <v-card-title class="headline" style="font-size: 20px !important;">
                            Elimina
                        </v-card-title>
                        <v-card-text>  Sei sicuro di voler eliminare?  </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="dialogBulk = false" >
                            Annulla
                            </v-btn>
                            <v-btn color="red" text  @click="deleteLeads">
                            Elimina</v-btn>
                        </v-card-actions>
                    </v-card>
                 </v-dialog>
            </v-row>
        </v-container>
    </div>
</v-app>
`
const emailRe = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;



export default {
    template,

    data() {
        return {
            editedItem: {
                email: '',
            },
            wrongEmail: false,
            uniqueEmail: false,
            success: false,
            editedIndex: -1,
            dialog: false,
            dialogDelete: false,
            dialogBulk: false,
            leads: [],
            item: null,
            selected: [],
            search: '',
            deleteDisable: false,
            deleteUrl: '',
            headers: [
                { text: 'E-Mail', align: 'start', value: 'email', },
                { text: 'Creato', align: 'center', value: 'created_at', formatDate: 'yyyy-MM-dd' },
                { text: 'FirstName', align: 'center', value: 'first_name' },
                { text: 'LastName', align: 'center', value: 'last_name' },
                { text: 'Company', align: 'center', value: 'company' },
                { text: 'PhoneNr', align: 'center', value: 'phone_nr' },
                { text: 'Message', align: 'center', value: 'message' },
                { text: 'Role', align: 'center', value: 'role' },
                { text: 'Azioni', value: 'actions', sortable: false, align: 'end' }],
            options: {
                descending: true,
                page: 1,
                itemsPerPage: 20,
                totalItems: 0,
                rowsPerPageItems: 20,
                total: 0
            },

            rows_per_page_items: [10, 20, 50, 100],
        }
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Item' : 'Modifica E-Mail'
        },
    },

    methods: {
        click() {
            this.clickCount++
            this.clickedAt = new Date()
        },

        /**
         *
         * @param  value
         * @returns data fortmat
         */
        formatDate(value) {
            const date = new Date(value)
            return date.toLocaleDateString(['it-IT'], { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' })  //if you want, you can change locale date string
        },

        loadLeads: async function () {

            let response = await axios.get('/leads/all?page=' + this.options.page + '&item_per_page=' + this.options.itemsPerPage + '&q=' + this.search);

            this.leads = response.data.data;
            this.options.total = response.data.total;
            this.options.itemsPerPage = response.data.per_page;
        },
        /**
         *
         * @returns {Promise<void>}
         */
        exportLeads: async function () {

            let ids = [];

            this.selected.forEach(element => {

                ids.push(element.id);

            });

            let options = {
                method: 'GET',
                url: '/leads/export/?ids=' + ids.join(','),
                headers: { 'Content-Type': 'multipart/form-data' },
                responseType: 'blob'
            }

            let response = await axios(options)
                .then(function (response) {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');

                    link.href = url;
                    link.setAttribute('download', 'leads.csv');
                    document.body.appendChild(link);
                    link.click();

                });

        },

        /**
        *
        */
        editItem(item) {
            // alert(item.email);
            this.editedIndex = item.email;
            this.editedItem = Object.assign({}, item)
            this.dialog = true;

        },

        /**
        *
        */
        close() {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        /**
        *
        */
        updated: async function (editedItem) {
            while (this.editedItem.email) {

                this.uniqueEmail = true;
                this.handleMailResponse = this.wrongEmail;
                break;
            }


            if (!emailRe.test(this.editedItem.email)) {
                this.wrongEmail = true;

            } else {

                let form = new FormData();

                form.append("email", this.editedItem.email);

                await axios.post("updated/leads/" + editedItem.id, form, this.handleMailResponse);

                this.success = true;

                this.close();

                this.loadLeads();
            }

        },

        /**
        *
        */
        handleMailResponse: function (response) {

            if (response.status == 200) {
                console.log(response.data);
            } else {
                this.uniqueEmail = true;
                console.log(response.data);
            }

            this.$refs.form.reset();
        },

        /**
         *
         */
        deleteLeads: async function () {

            let ids = [];

            this.selected.forEach(element => {

                ids.push(element.id);

            });

            let options = {
                method: 'GET',
                url: '/leads/delete/bulk?ids=' + ids.join(','),
                headers: { 'Content-Type': 'multipart/form-data' },
                responseType: 'delete'
            }

            let response = await axios(options)

            this.leads = response.data.data;
            this.options.total = response.data.total;
            this.options.itemsPerPage = response.data.per_page;

            this.dialogBulk = false;

        },
        /**
         *
         */
        deleteAction: function (item) {

            this.dialogDelete = true;
            this.item = item
            this.deleteUrl = '/leads/delete/' + item.id;
        },

        /**
         *
         */
        doAction: async function () {

            let options = {
                method: 'GET',
                url: this.deleteUrl,
                headers: { 'Content-Type': 'multipart/form-data' },
                responseType: 'delete'
            }

            let response = await axios(options)

            const index = this.leads.indexOf(this.item);
            if (index > -1) { // only splice array when item is found
                this.leads.splice(index, 1); // 2nd parameter means remove one item only
                this.options.total = this.options.total - 1;

            }

            this.dialogDelete = false;
        },
        /**
         * Detect page change
         */
        updatePagination(pagination) {
            this.loadLeads();
        },

        /**
         * Detect items per page change
         */
        updateItemsPerPage(pagination) {
            this.loadLeads();
        }


    },
    /**
     *
     */
    watch: {

        dialog(val) {
            val || this.close()
        },

        options: {
            handler() {
                //this.fetchCompanies()
            },
            deep: true,
        },
        search: {
            handler() {
                if (this.search.length >= 0) {
                    this.loadLeads();
                }
            },
        },
    },
    mounted() {
        this.loadLeads();
    }
}
