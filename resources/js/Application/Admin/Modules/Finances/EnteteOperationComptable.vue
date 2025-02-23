<template>



    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <DetailOperationComptable ref="DetailOperationComptable" />

                <v-dialog v-model="dialog" max-width="500px" persistent>
                    <v-card :loading="loading">
                        <v-form ref="form" lazy-validation>
                            <v-card-title class="warning">
                                Les Opérations du journal <v-spacer></v-spacer>
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
                                            <v-text-field label="Libellé de l'Opération" prepend-inner-icon="extension"
                                                dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.libelleOperation"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-text-field label="N° Opération" prepend-inner-icon="extension" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.numOpereation"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-text-field type="date" label="Date'Opération"
                                                prepend-inner-icon="extension" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                v-model="svData.dateOpration"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez le Type de Compte de Tresorerie"
                                                prepend-inner-icon="home" :rules="[(v) => !!v || 'Ce champ est requis']"
                                                :items="this.ModeList" item-text="designation" item-value="designation"
                                                dense outlined v-model="svData.modepaie" chips clearable
                                                @change="get_Banque(svData.modepaie)">
                                            </v-autocomplete>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">
                                            <v-autocomplete label="Selectionnez la Compte de Tresorerie"
                                                prepend-inner-icon="mdi-map"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList"
                                                item-text="nom_banque" item-value="id" dense outlined
                                                v-model="svData.refTresorerie" chips clearable>
                                            </v-autocomplete>
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
                <h4>Liste des détails de clotures des opérations</h4>
                <h6>A la comptabilité</h6>
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
                                <th class="text-left">
                                   #Id
                                </th>
                                <th class="text-left">DateOpe.</th>
                                <th class="text-left">LibelléOpe.</th>
                                <th class="text-left">N°Opé.</th>
                                <th class="text-left">Tresorerie</th>
                                <th class="text-left">Taux</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>#{{ item.id }}</td>

                                <td>{{ item.dateOpration }}</td>
                                <td>{{ item.libelleOperation }}</td>
                                <td>{{ item.numOpereation }}</td>
                                <td>{{ item.nom_banque }}</td>
                                <td>{{ item.tauxdujour }}</td>
                                <td>{{ item.author }}</td>
                                <td>

                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" small fab depressed text>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                        </template>

                                        <v-list dense width="">

                                            <v-list-item link
                                                @click="showDetailOperationComptable(item.id, item.libelleOperation)">
                                                <v-list-item-icon>
                                                    <v-icon color="  blue">description</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px">Détail de
                                                    l'Opération
                                                </v-list-item-title>
                                            </v-list-item>

                                            <!-- <v-list-item link @click="editData(item.id)">
                                                <v-list-item-icon>
                                                    <v-icon color="  blue">edit</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px">Modifier
                                                </v-list-item-title>
                                            </v-list-item> -->

                                            <v-list-item link
                                                @click="deleteData(item.id)" v-if="userData.id_role=1">
                                                <v-list-item-icon>
                                                    <v-icon color="red">delete</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: 5px">Supprimer
                                                </v-list-item-title>
                                            </v-list-item>

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
                        :length="pagination.total" @input="onPageChange"></v-pagination>
                </div>
                <!-- fin pagination -->
            </div>
        </div>
        <!-- fin card -->

    </div>


</template>
<script>
import { mapGetters, mapActions } from "vuex";
import DetailOperationComptable from './DetailOperationComptable.vue';

export default {
    components: {
        DetailOperationComptable
    },
    data() {
        return {

            title: "Liste des Produits",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,
            //id","libelleOperation","dateOpration","numOpereation",'tauxdujour','author'
            svData: {
                id: '',
                libelleOperation: '',
                dateOpration: '',
                numOpereation: '',
                refTresorerie: 0,
                author: "",

                modepaie: ""
            },
            fetchData: [],
            ModeList: [],
            BanqueList: [],
            query: "",

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: '',

        }
    },
    created() {
        this.onPageChange();
        this.get_mode_Paiement();

    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {

        ...mapActions(["getCategory"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Classe ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_all_enteteoperationcomptable?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);
                if (this.edit) {
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/update_enteteoperationcomptable/${this.svData.id}`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.onPageChange();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });

                }
                else {
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_enteteoperationcomptable`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.onPageChange();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });
                }

            }
        },
        fetchAccess() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_crud_access_roles_one/${this.userData.id_role}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.inserer = item.insert;
                        this.modifier = item.update;
                        this.supprimer = item.delete;
                        this.chargement = item.load;
                    });

                    console.log(donnees);
                }
            );
        },

        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteoperationcomptable/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {

                        this.svData.id = item.id;
                        this.svData.libelleOperation = item.libelleOperation;
                        this.svData.dateOpration = item.dateOpration;
                        this.svData.numOpereation = item.numOpereation;
                        this.svData.refTresorerie = item.refTresorerie;
                        this.svData.author = item.author;

                    });

                    // this.getSvData(this.svData, data.data[0]);

                    this.edit = true;
                    this.dialog = true;

                    // console.log(donnees);
                }
            );
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_enteteoperationcomptable/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },



        showDetailOperationComptable(refEnteteOperation, name) {

            if (refEnteteOperation != '') {

                this.$refs.DetailOperationComptable.$data.etatModal = true;
                this.$refs.DetailOperationComptable.$data.refEnteteOperation = refEnteteOperation;
                this.$refs.DetailOperationComptable.$data.svData.refEnteteOperation = refEnteteOperation;
                this.$refs.DetailOperationComptable.onPageChange();
                this.$refs.DetailOperationComptable.fetchListCompte();
                this.onPageChange();

                this.$refs.DetailOperationComptable.$data.titleComponent =
                    "Détail Opération pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
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
        desactiverData(valeurs, user_created, date_entree, noms) {
            //
            var tables = 'tfin_entete_operationcompte';
            var user_name = this.userData.name;
            var user_id = this.userData.id;
            var detail_information = "Suppression d'une operation " + noms + " par l'utilisateur " + user_name + "";

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
