<template>
    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="700px" transition="dialog-bottom-transition">
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
                                            <v-text-field label="Nom de l'élève" prepend-inner-icon="person"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.nomEleve"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Post-nom de l'élève" prepend-inner-icon="person"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.postNomEleve"></v-text-field>
                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Prenom de l'élève" prepend-inner-icon="person"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.preNomEleve"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-select :items="[{ designation: 'M' }, { designation: 'F' }]"
                                                label="Sexe de l'élève" prepend-inner-icon="man"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                item-text="designation" item-value="designation"
                                                v-model="svData.sexeEleve"></v-select>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-select
                                                :items="[{ designation: 'Celibataire' }, { designation: 'Marié(e)' }, { designation: 'Divorsé(e)' }, { designation: 'Veuf (veuve)' }]"
                                                label="Etat civil de l'élève" prepend-inner-icon="category"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                item-text="designation" item-value="designation"
                                                v-model="svData.etatCivilEleve"></v-select>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Nom du père de l'élève" prepend-inner-icon="man"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.nomPere"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Nom de la mère de l'élève" prepend-inner-icon="woman"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.nomMere"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="N° de téléphone du père de l'élève"
                                                prepend-inner-icon="call" outlined dense
                                                v-model="svData.numPere"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="N° de téléphone de la mère de l'élève"
                                                prepend-inner-icon="call" outlined dense
                                                v-model="svData.numMere"></v-text-field>
                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Date de naissance" type="date" prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.dateNaisEleve"></v-text-field>
                                        </div>
                                    </v-flex>
                                    <!-- localisation -->
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
                                                dense outlined v-model="svData.idQuartier" clearable
                                                @change="get_data_tug_avenue(svData.idQuartier)" chips>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs11 sm11 md4 lg4>
                                        <div class="mr-1">
                                            <v-autocomplete label="Avenue" prepend-inner-icon="home"
                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="stataData.avenueList" item-text="nomAvenue" item-value="id"
                                                dense outlined v-model="svData.idAvenue" chips clearable>
                                            </v-autocomplete>

                                        </div>
                                    </v-flex>
                                    <v-flex xs1 sm1 md1 lg1>
                                        <div class="mr-1">
                                            <v-tooltip bottom color="black">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <span v-bind="attrs" v-on="on">
                                                        <v-btn @click="getAllAvenue" color="primary" :loading="loading"
                                                            dark x-small fab depressed>
                                                            <v-icon dark>refresh</v-icon>
                                                        </v-btn>
                                                    </span>
                                                </template>
                                                <span>Recharger la liste</span>
                                            </v-tooltip>

                                        </div>
                                    </v-flex>

                                    <v-flex xs1 sm1 md1 lg1>
                                        <div class="mr-1">
                                            <v-tooltip bottom color="black">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <span v-bind="attrs" v-on="on">
                                                        <v-btn @click="
                                                            showaddAvenueModal(svData.idQuartier)
                                                            " fab x-small color="primary" dark>
                                                            <v-icon>add</v-icon>
                                                        </v-btn>
                                                    </span>
                                                </template>
                                                <span>Ajouter une avenue</span>
                                            </v-tooltip>
                                        </div>
                                    </v-flex>
                                    <!-- fin localisation -->
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-text-field label="N° de la parcelle de l'élève"
                                                prepend-inner-icon="location_on" outlined dense
                                                v-model="svData.numAdresseEleve"></v-text-field>
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
                <ImageEleveComponent ref="ImageEleveComponent" v-on:initialisateur="initialisateur" />

                <AvenueModal ref="AvenueModal" v-on:initialisateur="initialisateurAvenue" />
                <!-- fin component -->
            </v-flex>
        </v-layout>
        <!-- Fin contenu -->

        <!-- debit -->
        <div class="page-header">
            <div class="page-title">
                <h4>Liste d'élève</h4>
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
                                <th class="text-left">Photo</th>
                                <th class="text-left">Nom Complet</th>
                                <th class="text-left">Sexe et Age</th>
                                <th class="text-left">Noms des parents</th>
                                <th class="text-left">Contacts des Parents</th>
                                <th class="text-left">Adresse</th>
                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>
                                    <!-- image -->
                                    <img style="border-radius: 50px; width: 50px; height: 50px" :src="item.photoEleve == null
                                        ? `${baseURL}/images/avatar.png`
                                        : `${baseURL}/images/` + item.photoEleve
                                        " />
                                    <!-- images -->
                                </td>
                                <td>
                                    {{ item.nomEleve + " " + item.postNomEleve | subStrLong2 }} <br>
                                    {{ item.preNomEleve }}

                                </td>
                                <td>{{ item.sexeEleve }} / {{ item.ageEleve }} ans</td>
                                <td>
                                    <b>Père:</b> {{ item.nomPere | subStrLong2 }} <br>
                                    <b>Mère:</b> {{ item.nomMere | subStrLong2 }}
                                </td>
                                <td>
                                    <v-icon small>call</v-icon> <b>du Père:</b> <a :href="'tel:' + item.numPere">{{ item.numPere
                                        }}</a> <br>
                                    <v-icon small>call</v-icon> <b>de la Mère:</b> <a :href="'tel:' + item.numMere">{{ item.numMere
                                        }}</a>
                                </td>
                                <td>
                                    <b>{{ item.nomPays }}-</b> {{ item.nomProvince }} V/ {{ item.nomVille }} C/{{
                                        item.nomCommune }} <br>Q/{{ item.nomQuartier }} A/{{ item.nomAvenue }} N°{{
                                        item.numAdresseEleve }} <br>
                                </td>

                                <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                </td>
                                <td>
                                    <a class="me-3 confirm-text" href="javascript:void(0);"
                                        @click="showPhotoModal(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/photo_camera.svg`" alt="img" />
                                    </a>
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
import AvenueModal from '../Components/AvenueModal.vue';
import ImageEleveComponent from '../Components/ImageEleveComponent.vue';

export default {
    components: { ImageEleveComponent, AvenueModal, },
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
                idAvenue: "",
                nomEleve: "",

                postNomEleve: "",
                preNomEleve: "",

                etatCivilEleve: "",
                sexeEleve: "",

                nomPere: "",
                nomMere: "",

                numPere: "",
                numMere: "",

                photoEleve: "",
                codeEleve: "",
                numAdresseEleve: "",
                dateNaisEleve:"",
                //localisation
                idPays: "",
                idProvince: "",
                idVille: "",
                idCommune: "",
                idQuartier: "",

            },
            stataData: {
                paysList: [],
                provinceList: [],
                villeList: [],
                communeList: [],
                quartierList: [],
                avenueList: [],
            },
            fetchData: null,
            titreModal: "",
        };
    },
    computed: {
        ...mapGetters(["roleList", "sectionList", "paysList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole", "getSection", "getPays"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout de l'élève";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.nomEleve;
            } else {
                this.titleComponent = "Ajout de l'élève";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_eleve?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_eleve`,
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
                        this.isLoading(false);
                    });
            }
        },
        editData(id) {
            this.editOrFetch(
                `${this.apiBaseURL}/fetch_single_eleve/${id}`
            ).then(({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "modification de " + item.nomEleve + "-" + item.postNomEleve;
                    this.get_data_tug_pays(item.idPays);
                    this.get_data_tug_province(item.idProvince);
                    this.get_data_tug_commune(item.idVille);
                    this.get_data_tug_quartier(item.idCommune);
                    this.get_data_tug_avenue(item.idQuartier);
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            });
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_eleve/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },
        initialisateur() {
            this.onPageChange();
        },
        showPhotoModal(id) {
            this.$refs.ImageEleveComponent.$data.dialog = true;
            this.$refs.ImageEleveComponent.$data.svData.agentId = id;
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
        async get_data_tug_avenue(idQuartier) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/getAvenueTug/${idQuartier}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.avenueList = chart;
                    } else {
                        this.stataData.avenueList = [];
                    }

                    this.isLoading(false);
                })
                .catch((err) => {
                    this.errMsg();

                });
        },


        showaddAvenueModal(idQuartier) {
            if (idQuartier != "") {
                this.$refs.AvenueModal.$data.dialog = true;
                this.$refs.AvenueModal.$data.idQuartier = idQuartier;
                this.$refs.AvenueModal.$data.edit = false;
                this.$refs.AvenueModal.$data.svData.idQuartier = idQuartier;
            } else {
                this.showError("Veillez selectionner le quartier!!!");
            }
        },

        initialisateurAvenue() {
            this.get_data_tug_avenue(this.svData.idQuartier);
        },


        async getAllAvenue() {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_avenue_2`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.avenueList = chart;
                    } else {
                        this.stataData.avenueList = [];
                    }

                    this.isLoading(false);
                })
                .catch((err) => {
                    this.errMsg();

                });
        },





    },
    created() {
        this.getPays();
        this.onPageChange();
    },
};
</script>
