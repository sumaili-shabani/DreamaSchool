<template>

    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <AnnexeDepense ref="AnnexeDepense" />

                <v-dialog v-model="dialog" max-width="600px" persistent>
                    <v-card :loading="loading">
                        <v-form ref="form" lazy-validation>
                            <v-card-title class="warning">
                                Depenses <v-spacer></v-spacer>
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="dialog = false" text fab depressed dark>
                                                <v-icon>close</v-icon>
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Fermer</span>
                                </v-tooltip>
                            </v-card-title>
                            <v-card-text>
                                <br>

                                <v-layout row wrap>

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le Mode de Paiement"
                                                prepend-inner-icon="credit_card" :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="this.ModeList" item-text="designation" item-value="designation"
                                                dense outlined v-model="svData.modepaie" chips clearable
                                                @change="get_Banque(svData.modepaie)">
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la Caisse/Banque"
                                                prepend-inner-icon="home"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList"
                                                item-text="nom_banque" item-value="id" dense outlined
                                                v-model="svData.refBanque" chips clearable>
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="N° Bordereau, N°Compte" prepend-inner-icon="draw" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.numeroBordereau"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field type="date" label="Date Dépense" prepend-inner-icon="event"
                                                dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.dateOperation">
                                            </v-text-field>

                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field type="number" min="0.01" label="Montant($)" prepend-inner-icon="payments"
                                                dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.montant" @keypress.enter="showNumber(svData.montant)">
                                            </v-text-field>

                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-text-field type="text" label="Montant en Lettre"
                                                prepend-inner-icon="note" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.montantLettre">
                                            </v-text-field>

                                        </div>
                                    </v-flex>


                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-text-field type="text" label="Motif" prepend-inner-icon="edit_note" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.motif">
                                            </v-text-field>


                                        </div>
                                    </v-flex>


                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le Libellé" prepend-inner-icon="category"
                                                dense :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="compteDepenseList" item-text="designation" item-value="id"
                                                outlined v-model="svData.refCompte"
                                                @change="getDetailCompte(svData.refCompte)">
                                            </v-autocomplete>

                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field readonly label="Comptes" prepend-inner-icon="credit_card" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.comptesJournal">
                                            </v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Numéro Compte" prepend-inner-icon="extension" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.numCompteJournal">
                                            </v-text-field>
                                        </div>
                                    </v-flex>


                                </v-layout>

                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                                <v-btn color="  blue" dark :loading="loading" @click="validate">
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
                <h4>Liste des dépenses</h4>
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
                                        <v-btn :loading="loading" fab text small @click="fetchDataList"
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
                                <!-- <th class="text-left">N°</th> -->
                                <th class="text-left">Date</th>
                                <th class="text-left">Montant($)</th>

                                <th class="text-left">Caisse/Banque</th>
                                <th class="text-left">N°Compte</th>
                                <th class="text-left">Compte</th>
                                <th class="text-left">Motif</th>

                                <th class="text-left">Aquitté</th>
                                <th class="text-left">Aprouvé(AG)</th>

                                <th class="text-left">Author</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <!-- <td>{{ item.codeOperation | subStrLong2 }}</td> -->
                                <td>{{ item.dateOperation | formatDate }}</td>
                                <td>
                                    {{ item.montant | subStrLong2 }} <br>
                                    {{ item.montantLettre | subStrLong2 }}
                                </td>

                                <td>{{ item.nom_banque | subStrLong2 }}</td>
                                <td>{{ item.numero_ssouscompte | subStrLong2 }}</td>
                                <td>{{ item.Compte | subStrLong2 }}</td>
                                <td>{{ item.motif | subStrLong2 }}</td>

                                <td>
                                    <font :color="randColor()">
                                        {{ item.StatutAcquitterPar }}</font>

                                </td>
                                <td>
                                    <font :color="randColor()">
                                        {{ item.StatutApproCoordi }}</font>
                                </td>
                                <!-- <td>{{ item.numeroBE}}</td> -->
                                <td>{{ item.author }}</td>
                                <td>
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                        </template>

                                        <v-list dense width="">

                                            <v-list-item link @click="aquitter_Depense(item.id)">
                                                <v-list-item-icon>
                                                    <v-icon color="  blue">check</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px;">Aquitter la
                                                    Dépense</v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link @click="approuver_Depense(item.id)">
                                                <v-list-item-icon>
                                                    <v-icon color="  blue">check</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px;">Approuver la
                                                    Dépense</v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link @click="showAnnexeDepense(item.id, item.codeOperation)">
                                                <v-list-item-icon>
                                                    <v-icon>description</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px;">Enregistrer
                                                    les documents en
                                                    annexe</v-list-item-title>
                                            </v-list-item>

                                            <v-list-item v-if="item.StatutAcquitterPar == 'OUI'" link
                                                @click="printBill(item.id)">
                                                <v-list-item-icon>
                                                    <v-icon color="  blue">print</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px;">Bon de
                                                    Sortie</v-list-item-title>
                                            </v-list-item>

                                            <div v-if="item.StatutAcquitterPar != 'OUI' && item.StatutApproCoordi != 'OUI'">
                                                <v-list-item link @click="editData(item.id)" >
                                                <v-list-item-icon>
                                                    <v-icon color="  blue">edit</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title
                                                    style="margin-left: 5px;">Modifier</v-list-item-title>
                                            </v-list-item>

                                            <v-list-item link
                                                @click="desactiverData(item.id, item.author, item.created_at, item.montant)">
                                                <v-list-item-icon>
                                                    <v-icon color="  red">delete</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title
                                                    style="margin-left: 5px;">Supprimer</v-list-item-title>
                                            </v-list-item>
                                            </div>





                                        </v-list>
                                    </v-menu>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- fin tableau -->
                <!-- pagination -->
                <div class="col-md-12 text-center">
                    <v-pagination color="primary" v-model="pagination.current" :total-visible="7"
                        :length="pagination.total" @input="fetchDataList"></v-pagination>
                </div>
                <!-- fin pagination -->
            </div>
        </div>
        <!-- fin card -->

    </div>



</template>
<script>
import { mapGetters, mapActions } from "vuex";
import AnnexeDepense from './AnnexeDepense.vue';

export default {
    components: {
        AnnexeDepense
    },
    data() {
        return {
            title: "Liste des Dépenses",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,

            etatModal: false,
            titleComponent: '',
            numeroBE: '',
            montant: '',
            modepaie: "",
            refBanque: 0,

            svData: {
                id: '',
                montant: 0,
                montantLettre: "",
                motif: "",
                dateOperation: "",
                refMvt: 2,
                refCompte: 0,
                author: "Admin",

                modepaie: "",
                refBanque: 0,
                numeroBordereau: "",
                numeroBE: '',

                comptesJournal: '',
                numCompteJournal: ''
            },
            fetchData: [],


            BanqueList: [],
            query: "",

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''

        }
    },
    created() {

        this.fetchDataList();
        this.fetchListSelection();


        this.getCompteDepenseList();
        this.getModeList();

    },
    computed: {
        ...mapGetters(["categoryList", "compteDepenseList", "ModeList", "isloading"]),
    },
    methods: {

        ...mapActions(["getCategory", "getCompteDepenseList", "getModeList"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Recette ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        showNumber(montant) {
            if (montant) {
                this.svData.montantLettre = this.inWords(montant);
            } else {
                this.showError("Veillez entrer le montant!!!");
            }

        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);
                if (this.edit) {
                    // this.svData.refBanque=this.refBanque;
                    // this.svData.modepaie=this.modepaie;
                    // this.svData.montant=this.montant;
                    // this.svData.numeroBE= '0000';
                    // this.svData.author = this.userData.name;
                    this.svData.refMvt = 2;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/update_depense/${this.svData.id}`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });

                }
                else {
                    // this.svData.refBanque=this.refBanque;
                    // this.svData.modepaie=this.modepaie;
                    // this.svData.montant=this.montant;
                    this.svData.numeroBE = '0000';
                    this.svData.author = this.userData.name;
                    this.svData.refMvt = 2;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_depense`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });
                }

            }
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



        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_depense/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {

                        this.svData.id = item.id;
                        this.svData.montant = item.montant;
                        this.svData.montantLettre = item.montantLettre;
                        this.svData.motif = item.motif;
                        this.svData.dateOperation = item.dateOperation;
                        this.svData.refMvt = item.refMvt;
                        this.svData.refCompte = item.refCompte;
                        this.svData.author = item.author;
                        this.svData.modepaie = item.modepaie;
                        this.svData.refBanque = item.refBanque;
                        this.svData.numeroBordereau = item.numeroBordereau;
                        this.svData.numeroBE = item.numeroBE;

                        this.getDetailCompte(item.refCompte);
                    });

                    this.edit = true;
                    this.dialog = true;

                    // console.log(donnees);
                }
            );
        },

        printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_bonsortie_data?id=` + id);
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_depense/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.fetchDataList();
                    }
                );
            });
        },

        searchMember: _.debounce(function () {
            this.fetchDataList();
        }, 300),
        fetchDataList() {
            // this.svData.numeroBE = this.numeroBE;
            this.fetch_data(`${this.apiBaseURL}/fetch_mouvement_depense?page=`);
        },

        fetchListSelection() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte_sortie`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.compteList = donnees;

                }
            );
        },
        //
        aquitter_Depense(code) {
            // if (this.$refs.form.validate()) {

            this.isLoading(true);
            this.svData.id = code;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
                `${this.apiBaseURL}/aquitter_depense/${this.svData.id}`,
                JSON.stringify(this.svData)
            )
                .then(({ data }) => {
                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.edit = false;
                    this.dialog = false;
                    this.resetObj(this.svData);
                    this.fetchDataList();
                })
                .catch((err) => {
                    this.svErr(), this.isLoading(false);
                });

            // }
        },

        approuver_Depense(code) {
            // if (this.$refs.form.validate()) {
            this.isLoading(true);
            this.svData.id = code;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
                `${this.apiBaseURL}/approuver_depense/${this.svData.id}`,
                JSON.stringify(this.svData)
            )
                .then(({ data }) => {
                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.edit = false;
                    this.dialog = false;
                    this.resetObj(this.svData);
                    this.fetchDataList();
                })
                .catch((err) => {
                    this.svErr(), this.isLoading(false);
                });

            // }
        },

        getDetailCompte(idLibelle) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_libelle/${idLibelle}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {
                        this.svData.comptesJournal = item.nom_ssouscompte;
                        this.svData.numCompteJournal = item.numero_ssouscompte;
                    });

                }
            );
        },
        showAnnexeDepense(refDepense, name) {
            //CheckList

            if (refDepense != '') {

                this.$refs.AnnexeDepense.$data.etatModal = true;
                this.$refs.AnnexeDepense.$data.refDepense = refDepense;
                this.$refs.AnnexeDepense.$data.svData.refDepense = refDepense;
                this.$refs.AnnexeDepense.fetchDataList();
                this.onPageChange();

                this.$refs.AnnexeDepense.$data.titleComponent =
                    "Les docuements en annexe pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }
        },
        desactiverData(valeurs, user_created, date_entree, noms) {
            //
            var tables = 'tdepense';
            var user_name = this.userData.name;
            var user_id = this.userData.id;
            var detail_information = "Suppression d'une depense de montant : " + noms + " par l'utilisateur " + user_name + "";

            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        }

    },
    filters: {

    }
}
</script>
