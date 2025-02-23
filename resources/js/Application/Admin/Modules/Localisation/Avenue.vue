<template>
    <div>

        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="500px" scrollable transition="dialog-bottom-transition">
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
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le Pays" prepend-inner-icon="home"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="paysList"
                                                item-text="nomPays" item-value="id" dense outlined
                                                v-model="svData.idPays" chips clearable
                                                @change="get_data_tug_pays(svData.idPays)">
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la province" prepend-inner-icon="map"
                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="stataData.provinceList" item-text="nomProvince" item-value="id"
                                                dense outlined v-model="svData.idProvince" clearable chips
                                                @change="get_data_tug_province(svData.idProvince)">
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la ville" prepend-inner-icon="explore"
                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="stataData.villeList" item-text="nomVille" item-value="id" dense
                                                outlined v-model="svData.idVille" clearable chips
                                                @change="get_data_tug_commune(svData.idVille)">
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la commune"
                                                prepend-inner-icon="push_pin"
                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="stataData.communeList" item-text="nomCommune" item-value="id"
                                                dense outlined v-model="svData.idCommune" clearable
                                                @change="get_data_tug_quartier(svData.idCommune)" chips>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le quartier"
                                                prepend-inner-icon="navigation"
                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="stataData.quartierList" item-text="nomQuartier" item-value="id"
                                                dense outlined v-model="svData.idQuartier" clearable chips>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Nom de l'avenue" prepend-inner-icon="extension"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.nomAvenue"></v-text-field>
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
                <!-- fin modal -->
                <!-- component -->
                <!-- fin component -->
            </v-flex>
        </v-layout>
        <!-- Fin contenu -->

        <!-- debit -->
        <div class="page-header">
            <div class="page-title">
                <h4>Liste des rôles</h4>
                <h6>Gérez les opérations</h6>
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
                                <th class="text-left">Nom de l'avenue</th>
                                <th class="text-left">Nom de quartier</th>
                                <th class="text-left">Nom de la province</th>
                                <th class="text-left">Nom de la ville</th>
                                <th class="text-left">Nom de la Commune</th>

                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.nomAvenue }}</td>
                                <td>{{ item.nomQuartier }}</td>
                                <td>{{ item.nomProvince }}</td>
                                <td>{{ item.nomVille }}</td>
                                <td>{{ item.nomCommune }}</td>
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
                    <v-pagination color="primary" v-model="pagination.current" :length="pagination.total" :total-visible="7"
                        @input="onPageChange"></v-pagination>
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
                idPays: "",
                idProvince: "",
                idVille: "",
                idCommune: "",
                idQuartier: "",
                nomAvenue: "",
            },

            fetchData: null,
            titreModal: "",
            stataData: {
                paysList: [],
                provinceList: [],
                villeList: [],
                communeList: [],
                quartierList: [],
            },
        };
    },
    computed: {
        ...mapGetters(["paysList", "isloading"]),
    },
    methods: {
        ...mapActions(["getPays"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Avenue ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification ";
            } else {
                this.titleComponent = "Ajout Avenue ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_avenue?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_avenue`,
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
        },
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_avenue/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {
                        this.titleComponent = "modification de " + item.nomAvenue;
                        this.get_data_tug_pays(item.idPays);
                        this.get_data_tug_province(item.idProvince);
                        this.get_data_tug_commune(item.idVille);
                        this.get_data_tug_quartier(item.idCommune);
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_avenue/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        //fultrage de donnees
        async get_data_tug_pays(id_pays) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_province_tug_pays/${id_pays}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.provinceList = chart;
                    } else {
                        this.stataData.provinceList = [];
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

        async get_data_tug_province(idProvince) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_ville_tug_pays/${idProvince}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.villeList = chart;
                    } else {
                        this.stataData.villeList = [];
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

        async get_data_tug_commune(idVille) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_commune_tug_ville/${idVille}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.communeList = chart;
                    } else {
                        this.stataData.communeList = [];
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

        async get_data_tug_quartier(idCommune) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_quartier_tug_commune/${idCommune}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.quartierList = chart;
                    } else {
                        this.stataData.quartierList = [];
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
        this.getPays();
        this.testTitle();
        this.onPageChange();
    },
};
</script>
