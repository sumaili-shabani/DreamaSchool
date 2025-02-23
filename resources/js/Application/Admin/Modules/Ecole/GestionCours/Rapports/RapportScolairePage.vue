<template>
    <v-app>

        <v-container grid-list-xs>
            <v-layout wrap row>
                <v-flex sm12 xs12 md12 lg12>
                    <div class="mr-1">
                        <!-- bande -->
                        <v-layout wrap row>

                            <v-flex xs12 sm12 md12 lg12>
                                <br />

                                <v-layout wrap row>
                                    <v-flex xs12 sm12 md4 lg4 class="mb-1">
                                        <v-date-picker width="100%" v-model="dates" range color="black"></v-date-picker>
                                        <br>
                                        <SlideProfile />
                                    </v-flex>
                                    <v-flex xs12 sm12 md8 lg8 class="mb-1">
                                        <div class="text-center">
                                            <b>Rapports sur les résultats scolaire</b>
                                        </div>
                                        <br>

                                        <v-layout row wrap>
                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">

                                                    <v-text-field v-model="dateRangeText" label="Date range"
                                                        prepend-inner-icon="mdi-calendar" outlined dense
                                                        readonly></v-text-field>

                                                </div>
                                            </v-flex>
                                            <!-- Enseignant -->
                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionner l'enseignant"
                                                        prepend-inner-icon="person"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="EnseignantList" item-text="nomEns" item-value="id"
                                                        outlined clearable v-model="svData.idEnseignant" chips dense>
                                                        <template v-slot:item="data">
                                                            <template>
                                                                <v-list-item-avatar>
                                                                    <img :src="data.item.imageEns == null
                                                                        ? `${baseURL}/images/avatar.png`
                                                                        : `${baseURL}/images/` + data.item.imageEns
                                                                        " alt="alt" />
                                                                </v-list-item-avatar>

                                                                <v-list-item-content>
                                                                    <v-list-item-title>
                                                                        {{ data.item.nomEns }}
                                                                    </v-list-item-title>
                                                                    <v-list-item-subtitle>
                                                                        <v-icon small>info</v-icon> Sexe: {{
                                                                            data.item.sexeEns }} /
                                                                        Age:{{ data.item.ageEns }} ans

                                                                    </v-list-item-subtitle>
                                                                </v-list-item-content>
                                                            </template>
                                                        </template>
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>
                                            <!-- fin Enseignant -->

                                            <!-- Cotation -->
                                            <!-- nomenclature de classe -->
                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez l'année"
                                                        prepend-inner-icon="event"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="anneeList" item-text="designation" item-value="id" dense
                                                        outlined v-model="svData.idAnne" chips clearable>
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md6 lg6>
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

                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez l'option"
                                                        prepend-inner-icon="category"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="stateData.optionList" item-text="nomOption"
                                                        item-value="id" dense outlined v-model="svData.idOption" chips
                                                        clearable>
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez la classe"
                                                        prepend-inner-icon="home"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="classeList" item-text="nomClasse" item-value="id" dense
                                                        outlined v-model="svData.idClasse" chips clearable
                                                        @change="getDataEleveList(svData.idOption, svData.idClasse)">
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>
                                            <!-- fin nomenclature de classe -->

                                            <!-- info sur l'eleve -->
                                            <!-- eleves -->
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-flex xs12 sm12 md12 lg12>
                                                        <div class="mr-1">
                                                            <v-autocomplete label="Selectionner l'élève"
                                                                prepend-inner-icon="person"
                                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                                :items="stateData.eleveList" item-text="Noms"
                                                                item-value="id" outlined clearable
                                                                v-model="svData.idInscription" chips dense>
                                                                <template v-slot:item="data">
                                                                    <template>
                                                                        <v-list-item-avatar>
                                                                            <img :src="data.item.photoEleve == null
                                                                                ? `${baseURL}/images/avatar.png`
                                                                                : `${baseURL}/images/` + data.item.photoEleve
                                                                                " alt="alt" />
                                                                        </v-list-item-avatar>

                                                                        <v-list-item-content>
                                                                            <v-list-item-title>
                                                                                {{ data.item.Noms }}
                                                                            </v-list-item-title>
                                                                            <v-list-item-subtitle>
                                                                                <v-icon small>info</v-icon> Sexe: {{
                                                                                    data.item.sexeEleve }} /
                                                                                Age:{{ data.item.ageEleve }} ans <br>
                                                                                <v-icon small>domaine</v-icon>
                                                                                <font style="margin-left: -15px;">
                                                                                    Classe: {{
                                                                                        data.item.nomClasse }} -{{
                                                                                        data.item.nomOption }} : {{
                                                                                        data.item.nomDivision }}
                                                                                </font>

                                                                            </v-list-item-subtitle>
                                                                        </v-list-item-content>
                                                                    </template>
                                                                </template>
                                                            </v-autocomplete>
                                                        </div>
                                                    </v-flex>
                                                </div>
                                            </v-flex>
                                            <!-- fin eleve -->
                                            <v-flex xs12 sm12 md12 lg12>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez la catégorie de cours"
                                                        prepend-inner-icon="category"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="CatCoursList" item-text="nomCatCours" item-value="id"
                                                        dense outlined v-model="svData.idCatCours" chips clearable
                                                        @change="getDataCoursListbyCategoryCours(svData.idOption, svData.idClasse, svData.idCatCours)">
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez le cours"
                                                        prepend-inner-icon="notes"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="stateData.CoursList" item-text="nomCours"
                                                        item-value="idCours" dense outlined v-model="svData.idCours"
                                                        chips clearable
                                                        @change="getMaximaCours(svData.idOption, svData.idClasse, svData.idCours)">
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">
                                                    <v-autocomplete label="Selectionnez la période"
                                                        prepend-inner-icon="timer"
                                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                                        :items="PeriodeList" item-text="nomPeriode" item-value="id"
                                                        dense outlined v-model="svData.idPeriode" chips clearable>
                                                    </v-autocomplete>
                                                </div>
                                            </v-flex>



                                            <!-- fin info sur l'eleve -->
                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn
                                                                    @click="print_cours_par_classe(svData.idAnne, svData.idOption, svData.idClasse, svData.idPeriode)"
                                                                    block dark>
                                                                    <v-icon>note</v-icon>Rap Att des cours par
                                                                    classe
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span> Rapport Attribution des cours par
                                                            classe</span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn
                                                                    @click="print_cours_par_enseignant(svData.idAnne, svData.idPeriode, svData.idEnseignant)"
                                                                    block dark>
                                                                    <v-icon>description</v-icon>Rap des cours par
                                                                    Enseignant
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span> Rapport Attribution des cours par
                                                            classe</span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn
                                                                    @click="print_cours_aux_enseignants_par_classe(svData.idAnne, svData.idOption, svData.idClasse, svData.idPeriode)"
                                                                    block dark>
                                                                    <v-icon>description</v-icon>Rap de repartition des
                                                                    cours
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span> Rapport de repartition des cours des cours par enseignant
                                                            de classe
                                                        </span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>

                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn
                                                                    @click="print_resultat_cotation_par_classe(svData.idAnne, svData.idOption, svData.idClasse, svData.idPeriode)"
                                                                    block dark>
                                                                    <v-icon>mdi-school</v-icon>Proclammation des rés par
                                                                    classe
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span> Rapport sur la proclammation des résultats par classe
                                                        </span>
                                                    </v-tooltip>

                                                </div>
                                            </v-flex>
                                            <v-flex xs12 sm12 md6 lg6>
                                                <div class="mr-1">

                                                    <v-tooltip bottom color="black">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn
                                                                    @click="print_resultat_cotation_par_eleve(svData.idAnne, svData.idOption, svData.idClasse, svData.idPeriode, svData.idInscription)"
                                                                    block dark>
                                                                    <v-icon>person</v-icon>Proclammation des rés par
                                                                    élève

                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span> Rapport sur la proclammation des résultats par élève
                                                        </span>
                                                    </v-tooltip>



                                                </div>
                                            </v-flex>



                                        </v-layout>






                                    </v-flex>
                                </v-layout>
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


            </v-layout>
        </v-container>
    </v-app>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import SlideProfile from '../../Rapports/SlideProfile.vue';


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
                idEnseignant: "",
                idCatCours: "",

                idAnne: "",
                idOption: "",
                idClasse: "",

                maximale: "",
                codeAt: "",

                //cotation
                idInscription: "",
                idCours: "",
                idPeriode: "",
                cote: "",
                codeCote: "",
                maxima: "",



            },
            stateData: {
                eleveList: [],
                CoursList: [],
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
        ...mapGetters(["roleList", "CatCoursList", "EnseignantList",
            "anneeList", "classeList", "sectionList", "divisionList",
            "PeriodeList", "isloading"]),
        dateRangeText() {
            return this.dates.join(" ~ ");
        },
    },
    methods: {
        ...mapActions(["getRole", "getCatCoursList", "getEnseignantList", "getAnneeScollaire",
            "getClasse", "getSection", "getPeriodeList"]),

        /*
        *
        *========================================
        * Filtrage des données
        *========================================
        * *
        * */
        getPeriodeEnCours() {
            this.isLoading(true);

            this.editOrFetch(
                `${this.apiBaseURL}/getPeriodeEnCours`
            ).then(({ data }) => {
                var donnees = data.data;
                donnees.map((item) => {
                    this.svData.idAnne = item.idAnne;
                    this.svData.idPeriode = item.idPeriode;
                });

                this.isLoading(false);
            });


        },

        //filtrage
        getDataCours(idCatCours) {
            this.isLoading(true);
            this.editOrFetch(
                `${this.apiBaseURL}/fetch_cours_by_catcours/${idCatCours}`
            ).then(({ data }) => {
                var donnees = data.data;
                this.stateData.CoursList = donnees;
                this.isLoading(false);

            });
        },

        async get_data_tug_option(idSection) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_option_by_section/${idSection}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stateData.optionList = chart;
                    } else {
                        this.stateData.optionList = [];
                    }

                    this.isLoading(false);

                    //   console.log(this.stataData.car_optionList);
                })
                .catch((err) => {

                });
        },

        getDataEleveList(idOption, idClasse) {
            if (this.svData.idAnne != '') {
                var idAnne = this.svData.idAnne;
                this.isLoading(true);
                this.editOrFetch(
                    `${this.apiBaseURL}/get_eleve_inscript_par_classe/${idAnne}/${idOption}/${idClasse}`
                ).then(({ data }) => {
                    var donnees = data.data;
                    this.stateData.eleveList = donnees;
                    this.isLoading(false);

                    this.getDataCoursList(idOption, idClasse);

                });

            } else {
                this.showError("Veillez selectionner l'année scolaire");

            }

        },

        getDataCoursList(idOption, idClasse) {
            if (this.svData.idAnne != '' && this.svData.idPeriode) {
                var idAnne = this.svData.idAnne;
                var idPeriode = this.svData.idPeriode;
                this.isLoading(true);
                this.editOrFetch(
                    `${this.apiBaseURL}/getListCoursClasse/${idAnne}/${idOption}/${idClasse}/${idPeriode}`
                ).then(({ data }) => {
                    var donnees = data.data;
                    this.stateData.CoursList = donnees;
                    this.isLoading(false);

                });

            } else {
                this.showError("Veillez selectionner l'année scolaire et la période");

            }

        },

        getDataCoursListbyCategoryCours(idOption, idClasse, idCatCours) {
            if (this.svData.idAnne != '' && this.svData.idPeriode && idCatCours != '') {
                var idAnne = this.svData.idAnne;
                var idPeriode = this.svData.idPeriode;
                this.isLoading(true);
                this.editOrFetch(
                    `${this.apiBaseURL}/getListCoursClasseByCatCours/${idAnne}/${idOption}/${idClasse}/${idPeriode}/${idCatCours}`
                ).then(({ data }) => {
                    var donnees = data.data;
                    this.stateData.CoursList = donnees;
                    this.isLoading(false);

                });

            } else {
                this.showError("Veillez selectionner l'année scolaire et la période");

            }

        },

        getMaximaCours(idOption, idClasse, idCours) {
            if (idCours != '') {
                this.isLoading(true);
                var idAnne = this.svData.idAnne;
                var idPeriode = this.svData.idPeriode;
                this.editOrFetch(
                    `${this.apiBaseURL}/getMaximaCours/${idAnne}/${idOption}/${idClasse}/${idPeriode}/${idCours}`
                ).then(({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.svData.maximale = item.maximale;
                        this.svData.idCatCours = item.idCatCours;

                    });

                    this.isLoading(false);

                });

            } else {
                this.showError("Veillez selectionner le cours!!!");

            }

        },

        /*
       *
       *========================================
       * Filtrage des données
       *========================================
       * *
       * */

        print_cours_par_classe(idAnne, idOption, idClasse, idPeriode) {

            if (idAnne != "" && idOption != "" && idClasse != "" && idPeriode != "") {

                window.open(
                    `${this.apiBaseURL}/print_cours_par_classe?idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}&idPeriode=${idPeriode}`
                );

            } else {
                this.showError(
                    "Veillez reseigner tous les champs!!!"
                );
            }

        },

        print_cours_aux_enseignants_par_classe(idAnne, idOption, idClasse, idPeriode) {

            if (idAnne != "" && idOption != "" && idClasse != "" && idPeriode != "") {

                window.open(
                    `${this.apiBaseURL}/print_cours_aux_enseignants_par_classe?idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}&idPeriode=${idPeriode}`
                );

            } else {
                this.showError(
                    "Veillez reseigner tous les champs!!!"
                );
            }

        },

        print_cours_par_enseignant(idAnne, idPeriode, idEnseignant) {

            if (idAnne != "" && idPeriode != "" && idEnseignant != "") {

                window.open(
                    `${this.apiBaseURL}/print_cours_par_enseignant?idAnne=${idAnne}&idPeriode=${idPeriode}&idEnseignant=${idEnseignant}`
                );

            } else {
                this.showError(
                    "Veillez reseigner tous les champs!!!"
                );
            }

        },

        //resultat par classe


        print_resultat_cotation_par_classe(idAnne, idOption, idClasse, idPeriode) {

            if (idAnne != "" && idOption != "" && idClasse != "" && idPeriode != "") {

                window.open(
                    `${this.apiBaseURL}/print_resultat_cotation_par_classe?idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}&idPeriode=${idPeriode}`
                );

            } else {
                this.showError(
                    "Veillez reseigner tous les champs!!!"
                );
            }

        },

        print_resultat_cotation_par_eleve(idAnne, idOption, idClasse, idPeriode, idInscription) {

            if (idAnne != "" && idOption != "" && idClasse != "" && idPeriode != "" && idInscription != '') {

                window.open(
                    `${this.apiBaseURL}/print_resultat_cotation_par_eleve?idAnne=${idAnne}&idOption=${idOption}&idClasse=${idClasse}&idPeriode=${idPeriode}&idInscription=${idInscription}`
                );

            } else {
                this.showError(
                    "Veillez reseigner tous les champs!!!"
                );
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


    },
    created() {
        this.getPeriodeEnCours();
        this.getPeriodeList();
        this.getCatCoursList();
        this.getEnseignantList();

        this.getAnneeScollaire();
        this.getClasse();
        this.getSection();
    },
};
</script>
