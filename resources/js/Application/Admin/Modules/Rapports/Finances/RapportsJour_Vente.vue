<template>
    <v-app>

        <v-container grid-list-xs>
            <v-layout wrap row>
                <v-flex sm12 xs12 md8 lg8>
                    <div class="mr-1">
                        <!-- bande -->
                        <v-layout>

                            <v-flex md12>
                                <br />

                                <v-row v-show="showDate">
                                    <v-col cols="12" sm="6">
                                        <v-date-picker width="100%" v-model="dates" range color="black"></v-date-picker>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <div class="text-center">
                                            <b>Rapports sur le stock</b>
                                        </div>
                                        <br>
                                        <v-text-field v-model="dateRangeText" label="Date range"
                                            prepend-icon="mdi-calendar" readonly></v-text-field>

                                        <br>


                                        <v-layout row wrap>
                                            <!-- tranche  et frais-->

                                            <!-- fin tranche et frais -->

                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="showDetailSortieByDate" block dark>
                                                                    <v-icon>print</v-icon> RAPPORTS DES VENTES
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>
                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="showDetailSortieDetteByDate" block dark>
                                                                    <v-icon>print</v-icon> RAPPORTS DES DETTES/VENTES
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="showDetailEntreeByDate" block dark>
                                                                    <v-icon>print</v-icon> RAPPORTS DES
                                                                    APPROVISONNEMENTS
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>


                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">

                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="showDetailRequisitionByDate" block dark>
                                                                    <v-icon>print</v-icon> RAPPORTS DES REQUISITIONS
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="showFicheStockByDate" block dark>
                                                                    <v-icon>print</v-icon> IMPRIMER FICHE DE STOCK
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">

                                                    <v-flex xs12 sm12 md12 lg12>
                                                        <div class="mr-1" style="margin-top: 8px;">
                                                            <v-autocomplete label="Selectionnez le Produit"
                                                                prepend-inner-icon="map"
                                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                                :items="produitList" item-text="designation"
                                                                item-value="id" dense outlined
                                                                v-model="svData.refProduit" clearable chips>
                                                            </v-autocomplete>
                                                        </div>
                                                    </v-flex>

                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="showDetailSortieByDate_Produit" block
                                                                    dark>
                                                                    <v-icon>print</v-icon> RAPPORTS DES VENTES/PRODUIT
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">

                                                    <v-flex xs12 sm12 md12 lg12>
                                                        <div class="mr-1" style="margin-top: 8px;">
                                                            <v-autocomplete label="Selectionnez la Catégorie Produit"
                                                                prepend-inner-icon="map"
                                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                                :items="categorieProList" item-text="designation"
                                                                item-value="id" dense outlined
                                                                v-model="svData.idCategorie" clearable chips>
                                                            </v-autocomplete>
                                                        </div>
                                                    </v-flex>

                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="showFicheStockByDate_Categorie" block
                                                                    dark>
                                                                    <v-icon>print</v-icon> FICHE DE STOCK/CATEGORIE
                                                                    PRODUIT
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>


                                            <!-- classe -->
                                        </v-layout>




                                    </v-col>
                                </v-row>
                            </v-flex>


                        </v-layout>
                        <!-- bande -->
                        <v-layout row wrap>
                            <v-flex xs12 sm12 md12 lg12 class="mb-1">
                                <div class="mr-1">
                                    <br />
                                    <!-- component statistique ici -->
                                    <!-- fin component statistique -->
                                </div>
                            </v-flex>

                        </v-layout>
                    </div>
                </v-flex>

                <v-flex sm12 xs12 md4 lg4>
                    <div class="mr-1">
                        <SlideProfile />
                    </div>
                </v-flex>
            </v-layout>
        </v-container>


    </v-app>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import SlideProfile from "../../Ecole/Rapports/SlideProfile.vue";

// import detailLotModal from './detailLotModal.vue'
export default {
    components: {
        // detailLotModal,
        SlideProfile,
    },
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
            svData: {
                id: "",
                refProduit: "",
                refCategorie: 0,
                idCategorie: 0
            },
            stataData: {
            },
            fetchData: null,
            titreModal: "",
            categorieList: [],
            categorieProList: [],
            produitList: [],
            organisationList: [],
            filterValue: '',
            dates: [],
            showDate: false,
        };
    },
    computed: {
        //
        dateRangeText() {
            return this.dates.join(' ~ ')
        },
    },
    methods: {
        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Tarification ";
            this.edit = false;
            this.resetObj(this.svData);

        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de Tarification ";
            } else {
                this.titleComponent = "Ajout Tarification ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),


        onPageChange() {

        },
        fetchListCategorieClient() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_categorie_client_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.categorieList = donnees;

                }
            );
        },
        fetchListCategorieProduit() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_produit_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.categorieProList = donnees;

                }
            );
        },
        async GetProduit() {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_produit_2`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.produitList = chart;
                    } else {
                        this.produitList = [];
                    }

                    this.isLoading(false);
                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
            //fetch_pdf_rapport_detailentree_date
        },
        showDetailEntreeByDate() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_entree_date?date1=` + date1 + "&date2=" + date2);

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieByDate() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_date?date1=` + date1 + "&date2=" + date2);

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieDetteByDate() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_detailvente_dette_date?date1=` + date1 + "&date2=" + date2);

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailRequisitionByDate() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_cmd_date?date1=` + date1 + "&date2=" + date2);

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate() {

            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente?date1=` + date1 + "&date2=" + date2);

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieByDate_Categorie() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                if (this.svData.refCategorie != "") {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_date_categorie?date1=` + date1 + "&date2=" + date2 + "&refCategorie=" + this.svData.refCategorie);
                } else {
                    this.showError("Veillez selectionner le service svp");
                }

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Categorie() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                if (this.svData.idCategorie != "") {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_categorie?date1=` + date1 + "&date2=" + date2 + "&idCategorie=" + this.svData.idCategorie);
                } else {
                    this.showError("Veillez selectionner le service svp");
                }

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieByDate_Produit() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                if (this.svData.refProduit != "") {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_date_produit?date1=` + date1 + "&date2=" + date2 + "&refProduit=" + this.svData.refProduit);
                } else {
                    this.showError("Veillez selectionner le Produit svp");
                }

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },

        rechargement() {
            this.onPageChange();

        },


    },
    created() {
        //this.fetchListCategorieClient();
        this.fetchListCategorieProduit();
        this.GetProduit();
        this.showDate = true;
    },
};
</script>
