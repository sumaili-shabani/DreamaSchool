<template>

    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="500px" scrollable transition="dialog-bottom-transition">
                    <v-card :loading="loading">
                        <v-form ref="form" lazy-validation>
                            <v-card-title class="warning">
                                {{ titleComponent }} <v-spacer></v-spacer>
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="dialog = false" text fab depressed dark>
                                                <v-icon>close</v-icon>
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Fermer</span>
                                </v-tooltip>
                            </v-card-title>
                            <v-card-text>
                                <br>
                                <v-layout row wrap>
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">

                                            <v-text-field type="date" label="Date de Cloture" dense
                                                prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.dateCloture"></v-text-field>

                                        </div>
                                    </v-flex>


                                </v-layout>


                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                                <v-btn color="  blue" dark :loading="loading" @click="validate">
                                    {{ edit ? "Modifier" : "Ajouter" }}
                                </v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-dialog>
                <br /><br />
                <!-- fin modal -->
                <!-- component -->
                <!-- fin component -->
            </v-flex>
        </v-layout>
        <!-- Fin contenu -->

        <!-- debit -->
        <div class="page-header">
            <div class="page-title">
                <h4>Liste des clotures des opérations</h4>
                <h6>A la comptabilité</h6>
            </div>
            <div class="page-btn">
                <a href="javascript:void(0);" @click="showModal" class="btn btn-added" style="color: white;">
                    <img :src="`${baseURL}/vuetheme/assets/img/icons/plus.svg`" class="me-2" alt="img" />
                    Ajouter
                </a>
            </div>
        </div>

        <!-- card -->
        <div class="card">
            <div class="card-body">
                <!-- Entete -->
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">


                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn :loading="loading" fab text small @click="onPageChange"
                                            class="btn btn-warning" style="margin-right: 6px;">
                                            <v-icon>autorenew</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Initialiser</span>
                            </v-tooltip>


                        </div>
                        <div class="search-input">

                            <v-text-field append-icon="search" label="Recherche..." single-line outlined dense
                                hide-details v-model="query" @keyup="searchMember" clearable></v-text-field>

                        </div>
                    </div>
                    <!-- Excel, pdf, print -->
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/pdf.svg`" alt="img" /></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/excel.svg`" alt="img" /></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/printer.svg`" alt="img" /></a>
                            </li>
                        </ul>
                    </div>
                    <!-- Fin Excel, pdf, print -->
                </div>
                <!-- Fin Entete -->

                <!-- tableau -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">DateCloture</th>
                                <th class="text-left">Taux</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.dateCloture  | formatDate }}</td>
                                <td>{{ item.tauxdujour }}</td>
                                <td>{{ item.author }}</td>
                                <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                </td>


                                <td>
                                    <!-- <a class="me-3" href="javascript:void(0);" @click="editData(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/edit.svg`" alt="img" />
                                    </a> -->
                                    <a class="me-3 confirm-text" href="javascript:void(0);" @click="clearP(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/delete.svg`" alt="img" />
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- fin tableau -->
                <!-- pagination -->
                <div class="col-md-12 text-center">
                    <v-pagination color="primary" v-model="pagination.current" :total-visible="7"
                        :length="pagination.total" @input="onPageChange"></v-pagination>
                </div>
                <!-- fin pagination -->
            </div>
        </div>
        <!-- fin card -->

    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    components: {},
    data() {
        return {
            title: "Pays component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,

            //id,numerOperation,dateCloture,tauxdujour,author
            svData: {
                id: "",
                dateCloture: "",
                author: ""
            },
            fetchData: null,
            titreModal: "",

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''
        };
    },
    computed: {
        ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Classe ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.dateCloture;
            } else {
                this.titleComponent = "Ajout Cloture ";
            }
        }
        ,

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_cloture_comptabilite?page=`);
        },

        validate() {

            if (this.$refs.form.validate()) {
                this.isLoading(true);
                if (this.edit) {
                    this.svData.author = this.userData.name;
                    if (this.$refs.form.validate()) {
                        this.isLoading(true);
                        this.insertOrUpdate(
                            `${this.apiBaseURL}/cloturer_Comptabilite`,
                            JSON.stringify(this.svData)
                        )
                            .then(({ data }) => {
                                this.showMsg(data.data);
                                this.isLoading(false);
                                this.edit = false;
                                this.resetObj(this.svData);
                                this.onPageChange();

                                this.dialog = false;
                            })
                            .catch((err) => {
                                this.svErr(), this.isLoading(false);
                            });
                    }

                }
                else {
                    this.svData.author = this.userData.name;
                    if (this.$refs.form.validate()) {
                        this.isLoading(true);
                        this.insertOrUpdate(
                            `${this.apiBaseURL}/cloturer_Comptabilite`,
                            JSON.stringify(this.svData)
                        )
                            .then(({ data }) => {
                                this.showMsg(data.data);
                                this.isLoading(false);
                                this.edit = false;
                                this.resetObj(this.svData);
                                this.onPageChange();

                                this.dialog = false;
                            })
                            .catch((err) => {
                                this.svErr(), this.isLoading(false);
                            });
                    }
                }

            }














        },
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_cloture_comptabilite/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {
                        this.titleComponent = "modification de " + item.dateCloture;
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_cloture_comptabilite/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },


    },
    created() {
        //this.getRole();
        this.testTitle();
        this.onPageChange();

    },
};
</script>
