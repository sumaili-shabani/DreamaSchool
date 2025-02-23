<template>

    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <VenteDetailVente ref="VenteDetailVente" />
                <VentePaiement ref="VentePaiement" />
                <FactureVente ref="FactureVente" />

                <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                        <v-form ref="form" lazy-validation>
                            <v-card-title class="warning">
                                Les ventes <v-spacer></v-spacer>
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
                                        <div class="mr-12">

                                            <v-autocomplete label="Selectionnez l'Eleve" prepend-inner-icon="mdi-map"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="clientList"
                                                item-text="Noms" item-value="id" outlined dense
                                                v-model="svData.refClient">
                                            </v-autocomplete>

                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-12">

                                            <v-text-field type="date" label="Date Vente" prepend-inner-icon="event"
                                                dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.dateVente">
                                            </v-text-field>

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
                <h4>Liste des ventes</h4>
                <h6>Gérez les opérations</h6>
            </div>
            <div class="page-btn">
                <a href="javascript:void(0);" @click="dialog = true" class="btn btn-added" style="color: white;">
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
                                        <v-btn :loading="loading" fab text small @click="fetchDataList"
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
                                hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>

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
                                <th class="text-left">N°FAC</th>
                                <th class="text-left">DateVente</th>
                                <th class="text-left">Client</th>
                                <th class="text-left">Téléphone</th>
                                <th class="text-left">Libellé</th>
                                <th class="text-left">A Payer</th>
                                <th class="text-left">Payé</th>
                                <th class="text-left">Solde</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.id }}</td>
                                <td>{{ item.dateVente | formatDate }}</td>
                                <td>{{ item.noms }}</td>
                                <td>{{ item.contact }}</td>
                                <td>{{ item.libelle }}</td>
                                <td>{{ item.totalFacture }}$</td>
                                <td>{{ item.totalPaie }}$</td>
                                <td>{{ item.RestePaie }}$</td>
                                <td>{{ item.author }}</td>
                                <td>

                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                        </template>

                                        <v-list dense width="">

                                            <v-list-item link @click="showDetailVente(item.id, item.noms)">
                                                <v-list-item-icon>
                                                    <v-icon>mdi-cart-outline</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px">Detail Vente
                                                </v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link
                                                @click="showVentePaiement(item.id, item.noms, item.totalFacture, item.totalPaie, item.RestePaie)">
                                                <v-list-item-icon>
                                                    <v-icon>payments</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px">Paiement Facture
                                                </v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link @click="showFacture(item.id, item.noms, 'Ventes')">
                                                <v-list-item-icon>
                                                    <v-icon color="blue">print</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px">Imprimer la Facture
                                                </v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link @click="editData(item.id)">
                                                <v-list-item-icon>
                                                    <v-icon color="blue">edit</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px">Modifier
                                                </v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link @click="deleteData(item.id)" v-if="item.totalPaie == 0">
                                                <v-list-item-icon>
                                                    <v-icon color="  red">delete</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px">Suppression
                                                </v-list-item-title>
                                            </v-list-item>

                                        </v-list>
                                    </v-menu>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- fin tableau -->
                <!-- pagination -->
                <div class="col-md-12 text-center">
                    <v-pagination color="primary" v-model="pagination.current" :length="pagination.total"
                        @input="fetchDataList" :total-visible="7"></v-pagination>
                </div>
                <!-- fin pagination -->
            </div>
        </div>
        <!-- fin card -->

    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import FactureVente from '../Rapports/Finances/FactureVente.vue';
import VenteDetailVente from './VenteDetailVente.vue';
import VentePaiement from './VentePaiement.vue';


export default {
    components: {
        VenteDetailVente,
        VentePaiement,
        FactureVente
    },
    data() {
        return {

            title: "Liste des Ventes",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,

            //'id','refClient','dateVente','libelle','author'

            svData: {
                id: '',
                refClient: 0,
                dateVente: "",
                libelle: "",
                author: "Admin"
            },
            fetchData: [],
            clientList: [],
            query: ""

        }
    },
    created() {

        this.fetchDataList();
        this.fetchListSelection();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {

        ...mapActions(["getCategory"]),

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);
                if (this.edit) {
                    this.svData.author = this.userData.name;
                    this.svData.libelle = "Vente des Prosuits";
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/update_vente_entete_vente/${this.svData.id}`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });

                }
                else {
                    this.svData.author = this.userData.name;
                    this.svData.libelle = "Vente des Prosuits";
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_vente_entete_vente`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });
                }

            }
        },

        // searchMember: _.debounce(function () {
        //   this.fetchDataList();
        // }, 300),

        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_vente/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {

                        this.svData.id = item.id;
                        this.svData.refClient = item.refClient;
                        this.svData.dateVente = item.dateVente;
                        this.svData.libelle = item.libelle;
                        this.svData.author = item.author;
                    });

                    this.edit = true;
                    this.dialog = true;

                    // console.log(donnees);
                }
            );
        },

        printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_vente/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.fetchDataList();
                    }
                );
            });
        },
        fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_vente?page=`);
        },

        fetchListSelection() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_inscription_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.clientList = donnees;

                }
            );
        },
        showDetailVente(refEnteteVente, name) {

            if (refEnteteVente != '') {

                this.$refs.VenteDetailVente.$data.etatModal = true;
                this.$refs.VenteDetailVente.$data.refEnteteVente = refEnteteVente;
                this.$refs.VenteDetailVente.$data.svData.refEnteteVente = refEnteteVente;
                this.$refs.VenteDetailVente.fetchDataList();
                this.$refs.VenteDetailVente.fetchListSelection();
                this.fetchDataList();

                this.$refs.VenteDetailVente.$data.titleComponent =
                    "Detail Vente pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }
            //

        },
        showFacture(refEnteteVente, name, ServiceData) {

            if (refEnteteVente != '') {

                this.$refs.FactureVente.$data.dialog2 = true;
                this.$refs.FactureVente.$data.refEnteteSortie = refEnteteVente;
                this.$refs.FactureVente.$data.ServiceData = ServiceData;
                this.$refs.FactureVente.showModel(refEnteteVente);
                this.fetchDataList();

                this.$refs.FactureVente.$data.titleComponent =
                    "La Facture pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },
        showVentePaiement(refEnteteVente, name, totalFacture, totalPaie, RestePaie) {

            if (refEnteteVente != '') {

                this.$refs.VentePaiement.$data.etatModal = true;
                this.$refs.VentePaiement.$data.refEnteteVente = refEnteteVente;
                this.$refs.VentePaiement.$data.totalFacture = totalFacture;
                this.$refs.VentePaiement.$data.totalPaie = totalPaie;
                this.$refs.VentePaiement.$data.RestePaie = RestePaie;
                this.$refs.VentePaiement.$data.svData.refEnteteVente = refEnteteVente;
                this.$refs.VentePaiement.fetchDataList();
                this.$refs.VentePaiement.get_mode_Paiement();
                this.$refs.VentePaiement.getInfoFacture();
                this.fetchDataList();

                this.$refs.VentePaiement.$data.titleComponent =
                    "Detail Vente pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },
        desactiverData(valeurs, user_created, date_entree, noms) {
            //
            var tables = 'tvente_entete_vente';
            var user_name = this.userData.name;
            var user_id = this.userData.id;
            var detail_information = "Suppression d'une facture du client " + noms + " par l'utilisateur " + user_name + "";

            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        }

    },
    filters: {

    }
}
</script>
