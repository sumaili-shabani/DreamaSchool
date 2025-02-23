<template>
    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="600px" persistent transition="dialog-bottom-transition">
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
                                </v-tooltip></v-card-title>

                            <v-card-text>
                                <br>
                                <v-layout row wrap>
                                     <!-- eleves -->
                                     <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionner l'enseignant" prepend-inner-icon="person"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="EnseignantList"
                                                item-text="nomEns" item-value="id" outlined clearable
                                                v-model="svData.idEnseignant" chips dense>
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
                                    <!-- fin eleve -->
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la catégorie de cours" prepend-inner-icon="category"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="CatCoursList"
                                                item-text="nomCatCours" item-value="id" dense outlined
                                                v-model="svData.idCatCours" chips clearable @change="getDataCours(svData.idCatCours)"
                                               >
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le cours" prepend-inner-icon="notes"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stateData.CoursList"
                                                item-text="nomCours" item-value="id" dense outlined
                                                v-model="svData.idCours" chips clearable
                                               >
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la période" prepend-inner-icon="timer"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="PeriodeList"
                                                item-text="nomPeriode" item-value="id" dense outlined
                                                v-model="svData.idPeriode" chips clearable
                                               >
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>


                                    <!-- nomenclature de classe -->
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez l'année" prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="anneeList"
                                                item-text="designation" item-value="id" dense outlined
                                                v-model="svData.idAnne" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la section"
                                                prepend-inner-icon="category"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="sectionList"
                                                item-text="nomSection" item-value="id" dense outlined
                                                v-model="svData.idSection" chips clearable
                                                @change="get_data_tug_option(svData.idSection)">
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez l'option" prepend-inner-icon="category"
                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="stateData.optionList" item-text="nomOption" item-value="id"
                                                dense outlined v-model="svData.idOption" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la classe" prepend-inner-icon="home"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="classeList"
                                                item-text="nomClasse" item-value="id" dense outlined
                                                v-model="svData.idClasse" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>
                                    <!-- fin nomenclature de classe -->

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-text-field label="Point (Maxima)" type="number" min="1"
                                                prepend-inner-icon="pin"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.maximale"></v-text-field>

                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                                <v-btn color="primary" dark :loading="loading" @click="validate">
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
                <h4>Liste des cours et leurs enseignants</h4>
                <h6>Gérez les opérations</h6>
            </div>
            <div class="page-btn">
                <a href="javascript:void(0);" @click="showModal" class="btn btn-added" style="color: white">
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
                                            class="btn btn-warning" style="margin-right: 6px">
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
                                <th class="text-left">Enseignant</th>
                                <th class="text-left">Sexe et age</th>
                                <th class="text-left">Cours</th>
                                <th class="text-left">Maxima</th>
                                <th class="text-left">Catégorie</th>
                                <th class="text-left">Période</th>

                                <th class="text-left">Section et Option</th>
                                <th class="text-left">Classe</th>

                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>
                                    {{ item.nomEns }}
                                </td>
                                <td>{{ item.sexeEns }} / {{ item.ageEns }} ans</td>
                                <td><b>{{ item.nomCours | subStrLong2}}</b></td>
                                <td>
                                    {{ item.maximale }}
                                </td>
                                <td>
                                    <font :color="randColor()">{{ item.nomCatCours |subStrLong2}}</font>
                                </td>

                                <td>
                                    {{ item.nomPeriode | subStrLong2}}
                                </td>

                                <td>
                                    {{ item.nomSection | subStrLong2 }} -
                                    {{ item.nomOption | subStrLong2 }}
                                </td>
                                <td>
                                    {{ item.nomClasse }}
                                </td>

                                <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                </td>
                                <td>
                                    <a class="me-3" href="javascript:void(0);" @click="editData(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/edit.svg`" alt="img" />
                                    </a>
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
                    <v-pagination color="primary" v-model="pagination.current" :length="pagination.total"
                        :total-visible="7" @input="onPageChange"></v-pagination>
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
            svData: {
                id: "",
                idCatCours:"",

                idCours:"",
                idEnseignant:"",

                idPeriode:"",
                idAnne:"",

                idOption:"",
                idClasse:"",

                maximale:"",
                codeAt:"",


            },
            fetchData: null,
            titreModal: "",
            stateData:{
                CoursList:[],
                optionList: [],
            },
        };
    },
    computed: {
        ...mapGetters(["roleList","CatCoursList","EnseignantList",
        "anneeList", "classeList", "sectionList", "divisionList",
        "PeriodeList","isloading"]),
    },
    methods: {
        ...mapActions(["getRole", "getCatCoursList", "getEnseignantList", "getAnneeScollaire",
        "getClasse", "getSection","getPeriodeList"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Attribution de cours";
            this.edit = false;
            this.resetObj(this.svData);
            this.getPeriodeEnCours();
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.nomEns;
            } else {
                this.titleComponent = "Ajout";
            }
        },

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

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_attribution_cours?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_attribution_cours`,
                    JSON.stringify(this.svData)
                )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.onPageChange();

                        // this.dialog = false;
                    })
                    .catch((err) => {
                        this.isLoading(false);
                    });
            }
        },
        editData(id) {
            this.editOrFetch(
                `${this.apiBaseURL}/fetch_single_attribution_cours/${id}`
            ).then(({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "modification de " + item.nomEns;
                    this.get_data_tug_option(item.idSection);
                    this.getDataCours(item.idCatCours);
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            });
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_attribution_cours/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
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


    },
    created() {
        this.getPeriodeList();
        this.getCatCoursList();
        this.getEnseignantList();

        this.getAnneeScollaire();
        this.getClasse();
        this.getSection();

        this.onPageChange();

    },
};
</script>
