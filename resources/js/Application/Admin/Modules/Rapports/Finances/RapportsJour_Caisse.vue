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
                                            <b>Rapports sur les recettes et les dépenses</b>
                                        </div>
                                        <br>
                                        <v-text-field v-model="dateRangeText" label="Date range"
                                            prepend-icon="mdi-calendar" readonly></v-text-field>

                                        <v-layout row wrap>
                                            <!-- tranche  et frais-->

                                            <!-- fin tranche et frais -->


                                            <!-- classe -->
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">


                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="PrintshowDepenseByDate" block
                                                                    color="black" dark>
                                                                    <v-icon>print</v-icon> RAPPORT DES DEPENSES
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
                                                                <v-btn @click="PrintshowRecetteByDate" block
                                                                    color="black" dark>
                                                                    <v-icon>print</v-icon> RAPPORT DES RECETTES
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>


                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1" style="margin-top: 10px;margin-bottom: -10px;">

                                                    <v-autocomplete label="Selectionnez les rubriques des Depenses"
                                                        prepend-inner-icon="category" dense
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="rubSortieList" item-text="designation" item-value="id"
                                                        outlined v-model="svData.refRubSortie">
                                                    </v-autocomplete>

                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="PrintshowDepenseRubriqueByDate" block
                                                                    color="black" dark>
                                                                    <v-icon>print</v-icon> RAPPORT DES DEPENSES/RUBRIQUE
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Imprimer le rapport</span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1" style="margin-top: 10px;margin-bottom: -10px;">

                                                    <v-autocomplete label="Selectionnez les rubriques des Recettes"
                                                        prepend-inner-icon="category" dense
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="rubEntreeList" item-text="designation" item-value="id"
                                                        outlined v-model="svData.refRubEntree">
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn @click="PrintshowRecetteRubriqueByDate" block
                                                                    color="black" dark>
                                                                    <v-icon>print</v-icon> RAPPORT DES RECETTES/RUBRIQUE
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
                idEntreprise: "",
                id_tarif: "",
                id_agent: [],
                remise: 0,
                ceo: "",
                selectionAgent: [],
                refCompte: "",
                refTrajectoire: 0,
                refTypetarification: 0,
                refBanque: 0,
                nom_mode: "",

                refRubEntree: 0,
                refRubSortie: 0,

            },
            stataData: {
                entrepriseList: [],
                agentList: [],


            },
            fetchData: null,
            BanqueList: [],
            ModeList: [],
            titreModal: "",
            typetarifList: [],
            trajectoireList: [],
            compteList: [],
            rubSortieList: [],
            rubEntreeList: [],
            filterValue: '',
            dates: [],
            showDate: true,

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
            this.svData.id_agent = [];
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
            if (this.dates.length >= 1) {
                this.showCardByDate();
            } else {
                this.fetch_data(`${this.apiBaseURL}/fetch_abonnement_carte?page=`);
            }

        },

        fetchListTypeTarif() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_typetarif`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.typetarifList = donnees;
                }
            );
        },

        fetchListTrajectoire() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_trajectoire`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.trajectoireList = donnees;
                }
            );
        },
        fetchListCompte() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.compteList = donnees;
                }
            );
        },
        fetchListRubriqueSortie() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte_sortie`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.rubSortieList = donnees;

                }
            );
        },
        fetchListRubriqueEntree() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte_entree`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.rubEntreeList = donnees;

                }
            );
        },
        PrintshowDepenseByDate() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_sortie_compte_date?date1=` + date1 + "&date2=" + date2);
                //window.open(`${this.apiBaseURL}/fetch_rapport_depense_date?date1=` + date1+"&date2="+date2);
            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        PrintshowDepenseRubriqueByDate() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_sortie_compte_date_rubrique?date1=` + date1 + "&date2=" + date2 + "&refRubSortie=" + this.svData.refRubSortie);
                //window.open(`${this.apiBaseURL}/fetch_rapport_depense_date?date1=` + date1+"&date2="+date2);
            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        PrintshowRecetteByDate() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_entree_compte_date?date1=` + date1 + "&date2=" + date2);
            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        PrintshowRecetteRubriqueByDate() {
            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_entree_compte_date_rubrique?date1=` + date1 + "&date2=" + date2 + "&refRubEntree=" + this.svData.refRubEntree);
            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },


        showDetailModalLot(codeR) {

            if (codeR != null) {

            } else {
                this.showError("Aucune action  n'a été faite!!! prière de selectionner un lot de commande");
            }

        },


        rechargement() {
            this.onPageChange();

        },
        async get_mode_Paiement() {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_tconf_modepaie_2`)
                .then((res) => {
                    var chart = res.data.data;
                    if (chart) {
                        this.ModeList = chart;
                    } else {
                        this.ModeList = [];
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
        async get_Banque(nom_mode) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_list_banque/${nom_mode}`)
                .then((res) => {
                    var chart = res.data.data;
                    if (chart) {
                        this.BanqueList = chart;
                    } else {
                        this.BanqueList = [];
                    }
                    this.isLoading(false);
                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },




    },
    created() {
        this.fetchListTrajectoire();
        this.fetchListTypeTarif();
        this.fetchListCompte();
        this.get_mode_Paiement();
        this.fetchListRubriqueSortie();
        this.fetchListRubriqueEntree();
    },
};
</script>
