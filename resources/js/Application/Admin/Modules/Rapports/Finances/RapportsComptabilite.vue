<template>

    <!-- debit  -->
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
                                            <b>Rapports sur la Comptabilité</b>
                                        </div>
                                        <br>
                                        <v-text-field v-model="dateRangeText" label="Date range"
                                            prepend-icon="mdi-calendar" readonly></v-text-field>

                                        <br>


                                        <v-layout row wrap>
                                            <!-- tranche  et frais-->

                                            <!-- fin tranche et frais -->


                                            <!-- classe -->
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1" style="margin-top: -10px; margin-bottom: -10px;">

                                                    <v-autocomplete label="Selectionnez le Compte"
                                                        prepend-inner-icon="home"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="banqueList" item-text="nom_banque" item-value="id" dense
                                                        outlined v-model="svData.refTresorerie" chips clearable>
                                                    </v-autocomplete>



                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="show_fetch_livre_caisse" block
                                                                    color="black" dark>
                                                                    <v-icon>print</v-icon> LIVRE DE CAISSE/JOUR
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
                                                                <v-btn @click="show_fetch_livre_banque" block
                                                                    color="black" dark>
                                                                    <v-icon>print</v-icon> LIVRE DES BANQUES/JOUR
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
                                                                <v-btn @click="show_fetch_rapport_bilan" block
                                                                    color="black" dark>
                                                                    <v-icon>print</v-icon> RAPPORT BILAN
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
                                                                <v-btn @click="show_fetch_rapport_journal_caisse" block
                                                                    color="black" dark>
                                                                    <v-icon>print</v-icon> JOURNAL DES OPERATIONS
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>


                                                </div>
                                            </v-flex>





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
    <!-- fin -->

</template>
<script>
import { mapGetters, mapActions } from "vuex";
import SlideProfile from "../../Ecole/Rapports/SlideProfile.vue";


export default {
    components: {
        SlideProfile
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
                refUniteProduction: "",
                refDepartement: 0,
                refMedecin: 0,
                author: "",

                refCompte: "",
                refSousCompte: "",
                refSscompte: "",
                refBanque: 0,
                dateOperation: ''
            },
            stataData: {
                CompteList: [],
                SousCompteList: [],
                SSousCompteList: []
            },
            fetchData: null,
            titreModal: "",
            banqueList: [],
            caissierList: [],
            departementList: [],
            uniteproductionList: [],
            medecinList: [],
            filterValue: '',
            dates: [],
            showDate: false,
        };
    },
    computed: {
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
        show_fetch_rapport_detailfacture_date_compte_cash() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                if (this.svData.refSousCompte != "") {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailfacture_date_compte_cash?date1=` + date1 + "&date2=" + date2 + "&refSousCompte=" + this.svData.refSousCompte);
                }
                else {
                    this.showError("Veillez selectionner le compte de tresorerie svp");
                }

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        show_fetch_rapport_detailfacture_date_compte_credit() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                if (this.svData.refSousCompte != "") {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailfacture_date_compte_credit?date1=` + date1 + "&date2=" + date2 + "&refSousCompte=" + this.svData.refSousCompte);
                }
                else {
                    this.showError("Veillez selectionner le compte de tresorerie svp");
                }

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        show_fetch_rapport_journal_caisse() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                if (this.svData.refTresorerie != "") {
                    window.open(`${this.apiBaseURL}/fetch_rapport_journal_caisse?date1=` + date1 + "&date2=" + date2 + "&refTresorerie=" + this.svData.refTresorerie);
                }
                else {
                    this.showError("Veillez selectionner le compte de tresorerie svp");
                }

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        show_fetch_rapport_bilan() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_bilan?date1=` + date1 + "&date2=" + date2);

            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        show_fetch_livre_caisse() {
            var date1 = this.dates[0];
            if (date1 != '') {

                window.open(`${this.apiBaseURL}/pdf_livre_caisse?dateOperation=` + date1);

            } else {
                this.showError("Veillez sélectionner la date");
            }
        },
        show_fetch_livre_banque() {
            var date1 = this.dates[0];
            if (date1 != '') {

                window.open(`${this.apiBaseURL}/pdf_livre_banque?dateOperation=` + date1);

            } else {
                this.showError("Veillez sélectionner la date");
            }
        },


        rechargement() {
            this.onPageChange();

        },
        fetchListCompte() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.stataData.CompteList = donnees;

                }
            );
        },
        //fultrage de donnees
        async get_souscompte_for_compte(refCompte) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_souscompte_compte2/${refCompte}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.SousCompteList = chart;
                    } else {
                        this.stataData.SousCompteList = [];
                    }

                    this.isLoading(false);

                    //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },

        //fultrage de donnees
        async get_sscompte_for_souscompte(refSousCompte) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_ssouscompte_sous2/${refSousCompte}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.SSousCompteList = chart;
                    } else {
                        this.stataData.SSousCompteList = [];
                    }

                    this.isLoading(false);

                    //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },
        fetchListBanque() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tconf_banque_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.banqueList = donnees;

                }
            );
        },




    },
    created() {
        this.fetchListCompte();
        this.fetchListBanque();
        this.showDate = true;
    },
};
</script>
