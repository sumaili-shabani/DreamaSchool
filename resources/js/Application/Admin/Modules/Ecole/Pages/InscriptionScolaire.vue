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

                                    <!-- eleves -->
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionner l'élève" prepend-inner-icon="person"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="eleveList"
                                                item-text="nomEleve" item-value="id" outlined clearable
                                                v-model="svData.idEleve" chips dense>
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
                                                                {{ data.item.nomEleve }}
                                                            </v-list-item-title>
                                                            <v-list-item-subtitle>
                                                                <v-icon small>info</v-icon> Sexe: {{
                                                                    data.item.sexeEleve }} /
                                                                Age:{{ data.item.ageEleve }} ans

                                                            </v-list-item-subtitle>
                                                        </v-list-item-content>
                                                    </template>
                                                </template>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>
                                    <!-- fin eleve -->
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
                                            <v-autocomplete label="Selectionnez le Dédoublement de classe"
                                                prepend-inner-icon="category"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="divisionList"
                                                item-text="nomDivision" item-value="id" dense outlined
                                                v-model="svData.idDivision" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Date d'inscription" type="date"
                                                prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.dateInscription"></v-text-field>
                                        </div>
                                    </v-flex>


                                    <!-- <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Moins le frais d'Inscription" type="number"
                                                prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.fraisinscription"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Montant Manquant($)" type="number"
                                                prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.restoreinscription"></v-text-field>
                                        </div>
                                    </v-flex> -->



                                    <!-- //restoreinscription -->
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
                <h4>Liste d'inscriptions</h4>
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
                                <th class="text-left">Section et Option</th>
                                <th class="text-left">Classe</th>
                                <th class="text-left">Division</th>
                                <th class="text-left">Date d'inscription</th>
                                <th class="text-left">Payé</th>
                                <!-- <th class="text-left">Reste</th> -->
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
                                    {{ item.nomSection | subStrLong2 }} -
                                    {{ item.nomOption | subStrLong2 }}
                                    <div v-if="item.reductionPaiement != 0">
                                        <!-- PrevisionReduction -->
                                        <font color="green">
                                            Réduction: <b>{{ item.reductionPaiement }}% ({{ item.PrevisionReduction }}$)</b>
                                        </font>
                                    </div>
                                </td>
                                <td>
                                    {{ item.nomClasse }}
                                </td>
                                <td>
                                    {{ item.nomDivision }}
                                </td>

                                <td>
                                    {{ item.dateInscription | formatDate }}
                                    <p>
                                        <v-icon>qr_code</v-icon> {{ item.codeInscription }}
                                    </p>
                                </td>
                                <td>
                                    {{ item.paie }}$
                                </td>
                                <!-- <td>
                                    {{ item.reste }}$
                                </td> -->

                                <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                </td>
                                <td>

                                    <!-- menu -->

                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                        </template>



                                        <v-list dense width="">

                                            <v-list-item link @click="
                                                editData(item.id)
                                                ">
                                                <v-list-item-icon>
                                                    <v-icon color="primary">edit</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 3px">modifier</v-list-item-title>
                                            </v-list-item>
                                            <v-list-item link @click="
                                                clearP(item.id)
                                                ">
                                                <v-list-item-icon>
                                                    <v-icon color="danger">delete</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 3px">Suprimer</v-list-item-title>
                                            </v-list-item>
                                            <v-list-item link v-if="reductionPaiement != 0" @click="
                                                validerPayement(item.id)
                                                ">
                                                <v-list-item-icon>
                                                    <v-icon color="primary">credit_card</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 3px">Reduction de
                                                    paiement scolaire</v-list-item-title>
                                            </v-list-item>

                                            <v-divider></v-divider>
                                            <v-list-item link router
                                                :to="userData.id_role == 1 ? '/admin/ponctualite/' + item.codeInscription : '/user/ponctualite/' + item.codeInscription">
                                                <v-list-item-icon>
                                                    <v-icon color="primary">event</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 3px">Voir ses
                                                    présences</v-list-item-title>
                                            </v-list-item>
                                            <v-divider></v-divider>
                                            <v-list-item link @click="
                                                printBill(item.codeInscription)
                                                ">
                                                <v-list-item-icon>
                                                    <v-icon>badge</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 3px">Imprimer sa
                                                    carte</v-list-item-title>
                                            </v-list-item>

                                        </v-list>
                                    </v-menu>


                                    <!-- fin menu -->


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
        <!-- components -->
        <ReductionPaiementComponent ref="ReductionPaiementComponent" v-on:initialisateur="onPageChange" />
        <!-- fin components -->
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import ReductionPaiementComponent from './Components/ReductionPaiementComponent.vue';


export default {
    components: {
        ReductionPaiementComponent,
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
                idEleve: "",
                idAnne: "",

                idOption: "",
                idClasse: "",

                idDivision: "",
                dateInscription: "",

                codeInscription: "",
                idSection: "",

                fraisinscription:0,
                restoreinscription:0

            },
            stataData: {
                optionList: [],

            },
            fetchData: null,
            titreModal: "",
        };
    },
    computed: {
        ...mapGetters(["roleList", "paysList", "eleveList", "anneeList", "classeList", "sectionList", "divisionList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole", "getPays", "getEleveList", "getAnneeScollaire", "getClasse", "getSection", "getDivision"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout inscription de l'élève";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.nomEleve;
            } else {
                this.titleComponent = "Ajout inscription de l'élève";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_inscription?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_inscription`,
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
                `${this.apiBaseURL}/fetch_single_inscription/${id}`
            ).then(({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "modification de l'inscription " + item.nomEleve + "-" + item.postNomEleve;
                    this.get_data_tug_option(item.idSection);

                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            });
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_inscription/${id}`).then(
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


        // print
        printBill(codeInscription) {
            window.open(`${this.apiBaseURL}/print_card_identification?codeInscription=` + codeInscription);
        },


        validerPayement(id) {
            this.$refs.ReductionPaiementComponent.$data.dialog = true;
            this.$refs.ReductionPaiementComponent.$data.svData.id = id;
            this.$refs.ReductionPaiementComponent.editData(id);
        },









    },
    created() {
        this.getEleveList();
        this.getAnneeScollaire();
        this.getClasse();
        this.getSection();
        this.getDivision();

        this.onPageChange();
    },
};
</script>
