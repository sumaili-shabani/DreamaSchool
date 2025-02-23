<template>
    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="800px" scrollable transition="dialog-bottom-transition">
                    <v-card :loading="loading">
                        <v-form ref="form" lazy-validation>
                            <v-card-title>
                                {{ titleComponent }} <v-spacer></v-spacer>
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="dialog = false" text fab depressed>
                                                <v-icon>close</v-icon>
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Fermer</span>
                                </v-tooltip></v-card-title>

                            <v-card-text>
                                <v-layout row wrap>

                                    <!-- classe -->
                                    <v-flex xs12 sm12 md12 lg12>
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
                                                :items="stataData.optionList" item-text="nomOption" item-value="id"
                                                dense outlined v-model="svData.idOption" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la classe" prepend-inner-icon="home"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="classeList"
                                                item-text="nomClasse" item-value="id" dense outlined
                                                v-model="svData.idClasse"
                                                @change="getCountEffectifClasse(svData.idClasse, svData.idOption)" chips
                                                clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le mois" prepend-inner-icon="home"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="MoisList"
                                                item-text="nomMois" item-value="id" dense outlined
                                                v-model="svData.refMois" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md4 lg4>
                                        <div class="mr-1">
                                            <v-text-field label="Effectif de la classe" dense
                                                prepend-inner-icon="group"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined disabled
                                                v-model="svData.effectifClasse"></v-text-field>
                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md4 lg4>
                                        <div class="mr-1">
                                            <v-text-field label="Nombre des abandons" dense
                                                prepend-inner-icon="extension"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.effectifAbandon"
                                                @keyup.enter="calculNumber(svData.effectifAbandon)"
                                                @keyup="calculNumber(svData.effectifAbandon)"
                                            ></v-text-field>
                                        </div>
                                    </v-flex>
                                    <!-- Fin classe -->
                                    <v-flex xs12 sm12 md4 lg4>
                                        <div class="mr-1">
                                            <v-text-field label="Effectif Restant" dense
                                                prepend-inner-icon="home" :rules="[(v) => !!v || 'Ce champ est requis']"
                                                outlined  v-model="svData.effectifTotal"></v-text-field>
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
                <h4>Liste des clautures des effectifs des élèves</h4>
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
                    <!-- <div class="wordset">
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
                    </div> -->
                    <!-- Fin Excel, pdf, print -->
                </div>
                <!-- Fin Entete -->

                <!-- tableau -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">Classe</th>
                                <th class="text-left">Option</th>
                                <th class="text-left">Mois</th>

                                <th class="text-left">Effectif classe</th>
                                <th class="text-left">Effectif abandon</th>
                                <th class="text-left">Total Effectif restant</th>
                                <th class="text-left">Année scollaire</th>

                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.nomClasse | subStrLong2 }}</td>
                                <td>{{ item.nomOption | subStrLong2 }}</td>
                                <td>{{ item.nomMois | subStrLong2 }}</td>
                                <td>
                                    {{ item.effectifClasse }} Elèves
                                </td>
                                <td>
                                    <font color="red">{{ item.effectifAbandon }} </font> Elève(s)
                                </td>
                                <td>
                                    {{ item.effectifTotal }} Elèves
                                </td>
                                <td>{{ item.designation | subStrLong2 }}</td>

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
                idTranche: "",
                idFrais: "",
                idSection: "",
                idClasse: "",
                idOption: "",

                idAnne: "",
                refMois: "",
                mois: "",

                effectifClasse: "",
                effectifAbandon: "",
                effectifTotal: "",

            },
            stataData: {
                optionList: [],

            },
            fetchData: null,
            titreModal: "",
            effectifClasse:"",
        };
    },
    computed: {
        ...mapGetters(["roleList", "TrancheList", "FraisList", "eleveList", "anneeList", "classeList", "sectionList", "divisionList", "MoisList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole", "getTrancheList", "getFraisList", "getEleveList", "getAnneeScollaire", "getClasse", "getSection", "getMoisList", "getDivision"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout de l'effectif";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.nomTranche;
            } else {
                this.titleComponent = "Ajout de l'effectif";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_clauture?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_clauture`,
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
                `${this.apiBaseURL}/fetch_single_clauture/${id}`
            ).then(({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "modification de " + item.nomTranche;
                    this.get_data_tug_option(item.idSection);
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            });
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_clauture/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

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

        //voir les nombres d'effectif
        getCountEffectifClasse(idClasse, idOption) {

            if (idClasse != '' && idOption != '') {

                this.editOrFetch(
                    `${this.apiBaseURL}/get_effectif_eleve_classe/${idClasse}/${idOption}`
                ).then(({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {

                        this.svData.effectifClasse = item.effectifClasse;
                        this.effectifClasse = item.effectifClasse;
                    });

                });

            } else {
                this.showError(
                    "Veillez vérifier la classe et l'option"
                );

            }

        },

        calculNumber(effectifAbandon) {
            if (effectifAbandon != 0) {

                var effectifClasse = this.effectifClasse;
                if (this.svData.effectifAbandon <= effectifClasse) {
                    this.svData.effectifTotal = effectifClasse - this.svData.effectifAbandon;
                } else {

                    this.svData.effectifAbandon = "";
                    this.svData.effectifTotal = "";

                    this.showError(
                        "Veillez Saisir un chiffre <= " + effectifClasse
                    );

                }

            } else {


            }

        }







    },
    created() {
        this.getTrancheList();
        this.getFraisList();
        this.getAnneeScollaire();
        this.getClasse();
        this.getSection();
        this.getMoisList();

        this.onPageChange();
    },
};
</script>
