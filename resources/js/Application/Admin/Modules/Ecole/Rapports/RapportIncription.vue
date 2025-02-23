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
                                            <b>Rapports sur les Prévisions</b>
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
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez l'année"
                                                        prepend-inner-icon="event"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="anneeList" item-text="designation" item-value="id" dense
                                                        outlined v-model="svData.idAnne" chips clearable>
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez la section"
                                                        prepend-inner-icon="category"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="sectionList" item-text="nomSection" item-value="id"
                                                        dense outlined v-model="svData.idSection" chips clearable
                                                        @change="get_data_tug_option(svData.idSection)">
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez l'option"
                                                        prepend-inner-icon="category"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="stataData.optionList" item-text="nomOption"
                                                        item-value="id" dense outlined v-model="svData.idOption" chips
                                                        clearable>
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez la classe"
                                                        prepend-inner-icon="home"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="classeList" item-text="nomClasse" item-value="id" dense
                                                        outlined v-model="svData.idClasse" chips clearable>
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>
                                        </v-layout>

                                        <!-- <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="PrintRapportDetailPaiement()"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport journalier des Paiements
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport des Inscriptions par classe</span>
                                        </v-tooltip>
                                        <br> -->

                                        <!-- <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="PrintRapportDetailPaiementClasse(svData.idAnne, svData.idOption, svData.idClasse)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport des Paiements par classe
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport des Inscriptions par classe</span>
                                        </v-tooltip>
                                        <br> -->
                                        <!-- printFicheInscriptionNouveauClasse
                                            printRapportInscriptionNouveauOption -->

                                        <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="printRapportInscriptionClasse(svData.idAnne, svData.idOption, svData.idClasse)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport Inscription par classe
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport des Inscriptions par classe</span>
                                        </v-tooltip>
                                        <br>
                                        <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="printFicheInscriptionNouveauClasse(svData.idAnne, svData.idOption, svData.idClasse)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport Nouveaux Inscrits par classe
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport des Inscriptions par classe</span>
                                        </v-tooltip>
                                        <br>
                                        <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="printRapportInscriptionOption(svData.idAnne, svData.idOption)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport Inscription par Option
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport de Prise en charge par classe</span>
                                        </v-tooltip>
                                        <br>
                                        <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="printRapportInscriptionNouveauOption(svData.idAnne, svData.idOption)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport Nouveaux Incrits par Option
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport de Prise en charge par classe</span>
                                        </v-tooltip>
                                        <br>

                                        <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="printRapportInscriptionClasseReduction(svData.idAnne, svData.idOption, svData.idClasse)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport mesure incitative par classe
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport de Prise en charge par classe</span>
                                        </v-tooltip>
                                        <br>

                                        <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="printRapportInscriptionOptionReduction(svData.idAnne, svData.idOption)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport mesure incitative par Option
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport de Prise en charge par classe</span>
                                        </v-tooltip>
                                        <br>

                                        <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="printFicheInscriptionClasse(svData.idAnne, svData.idOption, svData.idClasse)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Rapport Fiche Inscription par classe
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport de Prise en charge par classe</span>
                                        </v-tooltip>
                                        <br>




                                        <!-- <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn
                                                        @click="printBillPrevisionClasse(svData.idAnne, svData.idOption, svData.idSection, svData.idClasse)"
                                                        block dark>
                                                        <v-icon>area_chart</v-icon> Prevision de paiement par classe
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span> Rapport de Prevision de Paiement scollaire par classe</span>
                                        </v-tooltip>
                                        <br> -->
                                        <!-- <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn @click=" printBillPrevisionGenerale(svData.idAnne)" block dark>
                                                        <v-icon>print</v-icon> Prevision de paiement générale
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span>PDF Rapport de Prevision de paiement</span>
                                        </v-tooltip>
                                        <br /> -->

                                        <!-- <v-tooltip bottom color="black">
                                            <template v-slot:activator="{ on, attrs }">
                                                <span v-bind="attrs" v-on="on">
                                                    <v-btn @click="printBillEffectidRecette(svData.idAnne)" block dark>
                                                        <v-icon>print</v-icon> Imprimer le tableau des recettes
                                                    </v-btn>
                                                </span>
                                            </template>
                                            <span>Imprimer le rapport de tableau de recettes et des effectifs </span>
                                        </v-tooltip> -->




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

import SlideProfile from "./SlideProfile.vue";



const gradients = [
    ["#222"],
    ["#42b3f4"],
    ["red", "orange", "yellow"],
    ["purple", "violet"],
    ["#00c6ff", "#F0F", "#FF0"],
    ["#f72047", "#ffd200", "#1feaea"],
];

export default {
    components: {
        SlideProfile,
    },
    data() {
        return {
            dialog: false,
            dialog2: false,
            loading: false,
            disabled: false,
            idEntreStock: "",
            status: "",
            svData: {
                id: "",
                idTranche: "",
                idFrais: "",

                idClasse: "",
                idOption: "",

                idAnne: "",
                montant: "",
                date_debit_prev: "",
                date_fin_prev: "",

                etatPrevision: "",

                date1: "",
                date2: "",

            },
            stataData: {
                optionList: [],

            },

            stat: {
                options: null,
                series: null,
                typechart1: "line",
                typechart2: "area",
                typechart3: "bar",
                typechart4: "donut",
            },
            titleComponent: "",

            dates: [],
            showDate: true,

            loading: false,
            edit: false,
            query: "",
            fetchData: null,
        };
    },
    computed: {
        ...mapGetters(["roleList", "TrancheList", "FraisList", "eleveList", "anneeList", "classeList", "sectionList", "divisionList", "isloading"]),
        dateRangeText() {
            return this.dates.join(" ~ ");
        },
    },
    methods: {
        ...mapActions(["getRole", "getTrancheList", "getFraisList", "getEleveList", "getAnneeScollaire", "getClasse", "getSection", "getDivision"]),

        //fultrage de donnees
        async get_data_tug_option(idSection) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_option_by_section/${idSection}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.optionList = chart;
                    } else {
                        this.stataData.optionList = [];
                    }

                    this.isLoading(false);

                    //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {

                });
        },

        showStatFiltrageDateTaxation(date1, date2) {
            if (date1 != "" && date2 != "") {
                // this.$refs.RapportContribuableFiltrageDateTaxePaye.$data.svData.date1 = date1;
                // this.$refs.RapportContribuableFiltrageDateTaxePaye.$data.svData.date2 = date2;
                // this.$refs.RapportContribuableFiltrageDateTaxePaye.my_statistique(date1, date2);

            } else {

                // this.$refs.RapportContribuableFiltrageDateTaxePaye.$data.svData.date1 = "";
                // this.$refs.RapportContribuableFiltrageDateTaxePaye.$data.svData.date2 = "";
                // this.$refs.RapportContribuableFiltrageDateTaxePaye.my_statistique("", "");


            }


        },


        getDataFilter() {

            this.svData.date1 = this.dates[0];
            this.svData.date2 = this.dates[1];

            var date1 = this.svData.date1;
            var date2 = this.svData.date2;

            var idUser = this.userData.id;

            if (date1 != "" && date2 != "") {
                if (date1 <= date2) {
                    // this.showStatFiltrageDateTaxation(this.svData.date1, this.svData.date2);
                } else {
                    if (this.dates.length == 0) {
                        // this.showStatFiltrageDateTaxation("", "");
                    }
                    else {
                        this.showError(
                            "Veillez vérifier les dates car la date debit doit être inférieure à la date de fin"
                        );
                    }

                }
            } else {




            }
        },



        PrintRapportGeneral() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];

            if (date1 <= date2) {
                window.open(
                    `${this.apiBaseURL}/pdf_rapport_note_par_banque?date1=${date1}&date2=${date2}`
                );
            } else {
                this.showError(
                    "Veillez vérifier les dates car la date debit doit être inférieure à la date de fin"
                );
            }
        },

        PrintRapportDetaille() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];

            if (date1 <= date2) {
                window.open(
                    `${this.apiBaseURL}/pdf_rapport_note_detaille?date1=${date1}&date2=${date2}`
                );
            } else {
                this.showError(
                    "Veillez vérifier les dates car la date debit doit être inférieure à la date de fin"
                );
            }
        },

        printBillPrevisionClasse(idAnne, idOption, idSection, idClasse) {
            if (idAnne !='' && idOption !='' && idSection !='' && idClasse !='') {
                window.open(`${this.apiBaseURL}/print_echeancier_promotion?idAnne=${idAnne}&idOption=${idOption}&idSection=${idSection}&idClasse=${idClasse}`);
            } else {

                this.showError(
                    "Veillez selectionner toutes les informations"
                );

            }

        },

        printRapportInscriptionClasse(idAnne, idOption, idClasse) {
            if (idAnne !='' && idOption !='' && idClasse !='') {
                window.open(`${this.apiBaseURL}/fetch_rapport_inscription_classe?idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}`);
            } else {

                this.showError(
                    "Veillez selectionner toutes les informations"
                );

            }

        },
        printFicheInscriptionClasse(idAnne, idOption, idClasse) {
            if (idAnne !='' && idOption !='' && idClasse !='') {
                window.open(`${this.apiBaseURL}/fetch_fiche_inscription_classe?idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}`);
            } else {

                this.showError(
                    "Veillez selectionner toutes les informations"
                );

            }

        },
        printFicheInscriptionNouveauClasse(idAnne, idOption, idClasse) {
            if (idAnne !='' && idOption !='' && idClasse !='') {
                window.open(`${this.apiBaseURL}/fetch_rapport_inscription_nouveau_classe?idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}`);
            } else {

                this.showError(
                    "Veillez selectionner toutes les informations"
                );

            }

        },
        printRapportInscriptionNouveauOption(idAnne, idOption) {
            if (idAnne !='' && idOption !='') {
                window.open(`${this.apiBaseURL}/fetch_rapport_nouveau_option?idAnne=${idAnne}&idOption=${idOption}`);
            } else {

                this.showError(
                    "Veillez selectionner toutes les informations"
                );

            }

        },

        printRapportInscriptionClasseReduction(idAnne, idOption, idClasse) {
            if (idAnne !='' && idOption !='' && idClasse !='') {
                window.open(`${this.apiBaseURL}/fetch_rapport_inscription_classe_reduction?idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}`);
            } else {

                this.showError(
                    "Veillez selectionner toutes les informations"
                );

            }

        },

        printRapportInscriptionOptionReduction(idAnne, idOption) {
            if (idAnne !='' && idOption !='') {
                window.open(`${this.apiBaseURL}/fetch_rapport_inscription_classe_reduction_annuel?idAnne=${idAnne}&idOption=${idOption}`);
            } else {

                this.showError(
                    "Veillez selectionner toutes les informations"
                );

            }

        },

        printRapportInscriptionOption(idAnne, idOption) {
            if (idAnne !='' && idOption !='') {
                window.open(`${this.apiBaseURL}/fetch_rapport_inscription_annuel?idAnne=${idAnne}&idOption=${idOption}`);
            } else {

                this.showError(
                    "Veillez selectionner toutes les informations"
                );

            }

        },

        PrintRapportDetailPaiement() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];

            if (date1 <= date2) {
                window.open(
                    `${this.apiBaseURL}/fetch_rapport_paiement_frais_date?date1=${date1}&date2=${date2}`
                );
            } else {
                this.showError(
                    "Veillez vérifier les dates car la date debit doit être inférieure à la date de fin"
                );
            }
        },

        PrintRapportDetailPaiementClasse(idAnne, idOption, idClasse) {
            var date1 = this.dates[0];
            var date2 = this.dates[1];

            if (date1 <= date2) {

                if (idAnne !='' && idOption !='' && idClasse !='') {
                    window.open(
                    `${this.apiBaseURL}/fetch_rapport_paiement_frais_date_classe?date1=${date1}&date2=${date2}&idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}`
                );
                }
                else {
                    this.showError(
                    "Veillez selectionner toutes les informations"
                    );
                }

            } else {
                this.showError(
                    "Veillez vérifier les dates car la date debit doit être inférieure à la date de fin"
                );
            }
        },

        printBillPrevisionGenerale(idAnne) {
            if (idAnne !='') {
                window.open(`${this.apiBaseURL}/print_echeancier_anneescolaire?idAnne=${idAnne}`);
            } else {

                this.showError(
                    "Veillez selectionner l'année scolaire"
                );

            }

        },

        //effectif scolaire
        printBillEffectidRecette(idAnne) {
            if (idAnne !='') {
                window.open(`${this.apiBaseURL}/print_effectif_promotion?idAnne=${idAnne}`);
            } else {

                this.showError(
                    "Veillez selectionner l'année scolaire"
                );

            }

        },


    },
    created() {
        this.getTrancheList();
        this.getFraisList();
        this.getAnneeScollaire();
        this.getClasse();
        this.getSection();
        this.getDivision();
    },
};
</script>
