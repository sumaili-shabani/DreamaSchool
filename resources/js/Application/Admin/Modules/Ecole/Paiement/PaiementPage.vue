<template>
    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="800px" transition="dialog-bottom-transition">
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
                                            <v-autocomplete label="Selectionner l'élève" prepend-inner-icon="person"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="eleveInscritList"
                                                item-text="nomEleve" item-value="id" outlined clearable
                                                v-model="svData.idInscription" chips dense
                                                @change="showInfoTranche(svData.idInscription)">
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
                                                                {{ data.item.nomSection }}- {{ data.item.nomOption }}-
                                                                {{ data.item.nomClasse }} - {{ data.item.nomDivision }}
                                                                / <v-icon x-small>event</v-icon> {{
                                                                    data.item.designation }}
                                                                <p>
                                                                    <v-icon small>info</v-icon> Sexe: {{
                                                                        data.item.sexeEleve }} /
                                                                    Age:{{ data.item.ageEleve }} ans
                                                                </p>

                                                            </v-list-item-subtitle>
                                                        </v-list-item-content>
                                                    </template>
                                                </template>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <!-- Fin classe -->

                                    <!-- tranche  et frais-->
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la tranche"
                                                prepend-inner-icon="category"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="TrancheList"
                                                item-text="nomTranche" item-value="id" dense outlined
                                                v-model="svData.idTranche" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le frais" prepend-inner-icon="category"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="FraisList"
                                                item-text="nomTypeTranche" item-value="id" dense outlined
                                                v-model="svData.idFrais" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>
                                    <!-- fin tranche et frais -->
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Date de paiement" type="date" dense
                                                prepend-inner-icon="event"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.datePaiement"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Montant($)" type="number" min="0" dense
                                                prepend-inner-icon="payments"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.montant"></v-text-field>
                                        </div>
                                    </v-flex>



                                    <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Mode de Paiement" prepend-inner-icon="home"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ModeList"
                                        item-text="designation" item-value="designation" dense outlined v-model="svData.modepaie"
                                        chips clearable @change="get_Banque(svData.modepaie)">
                                        </v-autocomplete>
                                    </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Banque" prepend-inner-icon="mdi-map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList"
                                        item-text="nom_banque" item-value="id" dense outlined v-model="svData.refBanque" chips
                                        clearable>
                                        </v-autocomplete>
                                    </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field type="textarea" label="N° Bordereau, N°Compte" prepend-inner-icon="draw" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                        v-model="svData.numeroBordereau"></v-text-field>
                                    </div>
                                    </v-flex>




                                    <v-flex xs12 sm6 md6 lg6>
                                        <div class="mr-1">
                                            <h6>Promotion</h6>
                                            <ul>
                                                <li><b>Nom Elève:</b> {{ stateDataInfo.nomEleve | subStrLong2 }} </li>
                                                <li>
                                                    <b>Promotion:</b>
                                                    {{ stateDataInfo.nomSection | subStrLong2 }} -
                                                    {{ stateDataInfo.nomOption | subStrLong2 }} <br>
                                                    <b>Division:</b> {{ stateDataInfo.nomClasse }} ( {{
                                                        stateDataInfo.nomDivision }} ) <br>
                                                    <b>Réduction:</b> {{ stateDataInfo.montantRemise }} <br>



                                                </li>

                                            </ul>

                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm6 md6 lg6>
                                        <div class="mr-1">
                                            <h6>Frais</h6>
                                            <ul>
                                                <li><b>Total à Payer:</b> {{ stateDataInfo.montantApayer }} </li>
                                                <li><b>Montant total déjà payé:</b> <font color="green">{{ stateDataInfo.montantPayer }}</font>
                                                </li>
                                                <li><b>Reste à payé:</b> <font color="red">{{ stateDataInfo.resteApayer }}</font> </li>
                                            </ul>

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
                <h4>Liste des Paiements</h4>
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
                <!-- Fin Entete  nom_banque -->

                <!-- tableau -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <!-- <th class="text-left">Photo</th> -->
                                <th class="text-left">N°Reçu</th>
                                <th class="text-left">Nom Complet</th>
                                <th class="text-left">Sexe et Age</th>
                                <th class="text-left">Section et Option</th>

                                <th class="text-left">Date de Paiement</th>
                                <!-- <th class="text-left">Tranche et Frais</th> -->
                                <th class="text-left">Montant($)</th>

                                <!-- <th class="text-left">ModePaie</th> -->

                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <!-- <td>

                                    <img style="border-radius: 50px; width: 50px; height: 50px" :src="item.photoEleve == null
                                        ? `${baseURL}/images/avatar.png`
                                        : `${baseURL}/images/` + item.photoEleve
                                        " />

                                </td> -->
                                <td>
                                    {{ item.codePaiement | subStrLong2 }}
                                </td>
                                <td>
                                    {{ item.nomEleve + " " + item.postNomEleve | subStrLong2 }} <br>
                                    {{ item.preNomEleve }}

                                </td>
                                <td>{{ item.sexeEleve }} / {{ item.ageEleve }} ans</td>
                                <td>
                                    {{ item.nomSection | subStrLong2 }} -
                                    {{ item.nomOption | subStrLong2 }} <br>
                                    <b>Classe et Division:</b> {{ item.nomClasse }} ( {{ item.nomDivision }} )
                                </td>



                                <td>
                                    {{ item.datePaiement | formatDate }}
                                </td>
                                <!-- <td>
                                    <font :color="randColor()">
                                        {{ item.nomTranche | subStrLong2 }}</font> <br>
                                    - {{ item.nomTypeTranche | subStrLong2 }}

                                </td> -->
                                <td>
                                    {{ item.montant }} <br>
                                    <font color="green" v-if="item.etatPaiement == 1">Confirmé</font>
                                    <font color="red" v-if="item.etatPaiement == 0"> En attente</font>
                                </td>

                                <!-- <td>
                                    {{ item.nom_banque }}
                                </td> -->


                                <td>
                                    {{ item.created_at | formatDate }} <br>
                                    {{ item.created_at | formatHour }}
                                </td>
                                <td>

                                    <!-- <a class="me-3" href="javascript:void(0);" @click="editData(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/edit.svg`" alt="img" />
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);" @click="clearP(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/delete.svg`" alt="img" />
                                    </a> -->

                                    <!-- menu -->

                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                        </template>



                                        <v-list dense width="">
                                            <div v-if="item.etatPaiement == 0">
                                                <v-list-item link @click="
                                                    validerPayement(item.id, item.etatPaiement)
                                                    ">
                                                    <v-list-item-icon>
                                                        <v-icon color="primary">check</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: 1px">Valider le
                                                        paiement</v-list-item-title>
                                                </v-list-item>
                                                <!-- <v-list-item link @click="
                                                    editData(item.id)
                                                    ">
                                                    <v-list-item-icon>
                                                        <v-icon color="primary">edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title
                                                        style="margin-left: 1px">modifier</v-list-item-title>
                                                </v-list-item> -->
                                                <v-list-item link @click="
                                                    clearP(item.id)
                                                    ">
                                                    <v-list-item-icon>
                                                        <v-icon color="danger">delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title
                                                        style="margin-left: 1px">Suprimer</v-list-item-title>
                                                </v-list-item>
                                            </div>
                                            <div v-if="item.etatPaiement == 1">
                                                <v-list-item link @click="
                                                    printBillRecuPaiement(item.codePaiement)
                                                    ">
                                                    <v-list-item-icon>
                                                        <v-icon>print</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: 1px">Imprimer le
                                                        reçu</v-list-item-title>
                                                </v-list-item>

                                                <!-- <v-list-item link @click="
                                                    printBillRecuPaiementSigle(item.codeInscription)
                                                    ">
                                                    <v-list-item-icon>
                                                        <v-icon>print</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: 1px">Imprimer ses
                                                        paiements</v-list-item-title>
                                                </v-list-item> -->

                                                <v-list-item link @click="
                                                    printHistoriquePaiement(item.idInscription)
                                                    ">
                                                    <v-list-item-icon>
                                                        <v-icon>print</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: 1px">Imprimer ses
                                                        paiements</v-list-item-title>
                                                </v-list-item>

                                            </div>
                                            <v-divider></v-divider>
                                            <v-list-item link @click="
                                                showProfileModal(item.idUser, item.created_at)
                                                ">
                                                <v-list-item-icon>
                                                    <v-icon>person</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 1px">Auteur</v-list-item-title>
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

        <!-- component -->
        <AvatarProfil ref="AvatarProfil" />
        <!-- fin component -->
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import AvatarProfil from '../../../../../views/component/AvatarProfil.vue'

export default {
    components: {
        AvatarProfil,
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
                idTranche: "",
                idFrais: "",

                idInscription: "",
                montant: "",

                datePaiement: "",
                codePaiement: "",

                idUser: "",
                etatPaiement: "" ,

                refBanque: 0,
                numeroBordereau: "000000000",



            },
            stateDataInfo: {


                idClasse: "",
                idOption: "",
                idAnne: "",
                idDivision: "",

                nomEleve: "",

                nomSection: "",
                nomOption: "",
                nomClasse: "",
                nomDivision: "",

                montantApayer: "",
                montantPayer: "",
                resteApayer: "",
                montantRemise:"",



            },
            stataData: {
                optionList: [],

            },
            fetchData: null,
            titreModal: "",
            ModeList: [],
            BanqueList: [],
        };
    },
    computed: {
        ...mapGetters(["roleList", "TrancheList", "FraisList", "eleveList", "eleveInscritList", "anneeList", "classeList", "sectionList", "divisionList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole", "getTrancheList", "getFraisList", "getEleveList", "getEleveInscritList", "getAnneeScollaire", "getClasse", "getSection", "getDivision"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout de la tranche";
            this.edit = false;
            this.resetObj(this.svData);
            this.resetObj(this.stateDataInfo);
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
            this.fetch_data(`${this.apiBaseURL}/fetch_paiement?page=`);

        },

        validate() {
            if (this.$refs.form.validate()) {

                if (this.svData.montant <= this.stateDataInfo.resteApayer) {

                    // this.isLoading(true);
                    this.svData.idUser = this.userData.id;

                    this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_paiement`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.resetObj(this.svData);
                            this.resetObj(this.stateDataInfo);

                            this.onPageChange();

                            // this.dialog = false;
                        })
                        .catch((err) => {
                            this.isLoading(false);
                        });

                } else {

                    this.showError("Erreur, Veillez payer un montant <= à "+this.stateDataInfo.resteApayer);

                }

            }
        },
        editData(id) {
            this.editOrFetch(
                `${this.apiBaseURL}/fetch_single_paiement/${id}`
            ).then(({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "modification de " + item.nomTranche;
                    this.showInfoTranche(item.idInscription);
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;


            });
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_paiement/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        showInfoTranche(idInscription) {

            if (idInscription != '') {



                this.editOrFetch(
                    `${this.apiBaseURL}/getinfo_paiement_eleve/${idInscription}`
                ).then(({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {


                        this.stateDataInfo.idClasse = item.idClasse;
                        this.stateDataInfo.idOption = item.idOption;
                        this.stateDataInfo.idAnne = item.idAnne;
                        this.stateDataInfo.idDivision = item.idDivision;

                        this.stateDataInfo.nomDivision = item.nomDivision;
                        this.stateDataInfo.nomClasse = item.nomClasse;
                        this.stateDataInfo.nomOption = item.nomOption;
                        this.stateDataInfo.nomSection = item.nomSection;
                        this.stateDataInfo.nomEleve = item.nomEleve;

                        this.stateDataInfo.montantApayer = item.montantApayer;
                        this.stateDataInfo.montantPayer = item.montantPayer;
                        this.stateDataInfo.resteApayer = item.resteApayer;
                        this.stateDataInfo.montantRemise = item.montantRemise;


                    });



                });

            } else {

            }

        },

        // voir l'auteur de l'action
        showProfileModal(id, created) {
            if (id != null) {
                this.$refs.AvatarProfil.$data.dialog = true;
                this.$refs.AvatarProfil.$data.svData.id = id;
                this.$refs.AvatarProfil.$data.svData.created = created;
                this.$refs.AvatarProfil.display_profile(id);

                this.$refs.AvatarProfil.$data.titleComponent = "Détail du Profile";
            } else {
                this.showError("Personne n'a fait cette action");
            }
        },

        validerPayement(id, etat) {
            if (id != "" && etat != "") {
                // alert("id:"+id+" etat:"+etat);

                this.confirmEtat().then(({ res }) => {
                    this.delGlobal(
                        `${this.apiBaseURL}/chect_validation_paiement/${id}/${etat}`
                    ).then(({ data }) => {
                        this.showMsg(data.data);
                        this.onPageChange();
                    });
                });
            } else {
                this.confirmEtat().then(({ res }) => {
                    this.delGlobal(
                        `${this.apiBaseURL}/chect_validation_paiement/${id}/${etat}`
                    ).then(({ data }) => {
                        this.showMsg(data.data);
                        this.onPageChange();
                    });
                });
            }
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
        // print
        printBillRecuPaiement(codePaiement) {
            window.open(`${this.apiBaseURL}/print_recu_paiement?codePaiement=` + codePaiement);
        },

        printBillRecuPaiementSigle(codeInscription) {
            window.open(`${this.apiBaseURL}/print_recu_paiement_sigle?codeInscription=` + codeInscription);
        },

        printHistoriquePaiement(idInscription) {
            window.open(`${this.apiBaseURL}/fetch_historique_paiement?idInscription=` + idInscription);
        },







    },
    created() {
        this.getTrancheList();
        this.getFraisList();
        this.getEleveInscritList();
        this.get_mode_Paiement();

        this.onPageChange();
    },
};
</script>
