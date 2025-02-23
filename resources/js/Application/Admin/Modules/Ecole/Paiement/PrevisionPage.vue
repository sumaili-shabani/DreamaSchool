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

                                    <!-- tranche  et frais-->
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la tranche" prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="TrancheList"
                                                item-text="nomTranche" item-value="id" dense outlined
                                                v-model="svData.idTranche" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le frais" prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="FraisList"
                                                item-text="nomTypeTranche" item-value="id" dense outlined
                                                v-model="svData.idFrais" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>
                                     <!-- fin tranche et frais -->

                                    <!-- classe -->
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
                                                v-model="svData.idClasse" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Date de debit écheance" type="date" dense prepend-inner-icon="extension"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.date_debit_prev"></v-text-field>
                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Date de fin écheance" type="date" dense prepend-inner-icon="extension"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.date_fin_prev"></v-text-field>
                                        </div>
                                    </v-flex>
                                    <!-- Fin classe -->
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-text-field label="Montant" type="number" min="0" dense prepend-inner-icon="extension"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.montant"></v-text-field>
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
                <h4>Liste des Prévisions</h4>
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
                                <th class="text-left">Frais</th>
                                <th class="text-left">Tranche</th>

                                <th class="text-left">section</th>
                                <th class="text-left">Echéance</th>
                                <th class="text-left">Classe</th>
                                <th class="text-left">Montant($)</th>

                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.nomTypeTranche | subStrLong2 }}</td>
                                <td>{{ item.nomTranche | subStrLong2 }}</td>

                                <td>
                                    {{ item.nomSection | subStrLong2 }} -
                                    {{ item.nomOption | subStrLong2 }}
                                </td>
                                <td>
                                    {{ item.date_debit_prev | formatDate }} au <br>
                                    {{ item.date_fin_prev | formatDate }}

                                </td>
                                <td>
                                    {{ item.nomClasse }}
                                </td>
                                <td>
                                    {{ item.montant }}
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
                idTranche: "",
                idFrais: "",

                idClasse: "",
                idOption: "",

                idAnne: "",
                montant: "",
                date_debit_prev:"",
                date_fin_prev:"",

                etatPrevision: "",

            },
            stataData: {
                optionList: [],

            },
            fetchData: null,
            titreModal: "",
        };
    },
    computed: {
        ...mapGetters(["roleList","TrancheList","FraisList", "eleveList", "anneeList", "classeList", "sectionList", "divisionList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole","getTrancheList","getFraisList", "getEleveList", "getAnneeScollaire", "getClasse", "getSection", "getDivision"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout de la tranche";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.nomTranche;
            } else {
                this.titleComponent = "Ajout de la tranche";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_prevision?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_prevision`,
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
                `${this.apiBaseURL}/fetch_single_prevision/${id}`
            ).then(({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "modification de " + item.nomTranche;
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            });
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_prevision/${id}`).then(
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







    },
    created() {
        this.getTrancheList();
        this.getFraisList();
        this.getAnneeScollaire();
        this.getClasse();
        this.getSection();
        this.getDivision();

        this.onPageChange();
    },
};
</script>
