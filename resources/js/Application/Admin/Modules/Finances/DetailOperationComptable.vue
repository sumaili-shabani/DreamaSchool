<template>
    <v-row justify="center">

        <v-dialog v-model="etatModal" persistent max-width="800px">
            <v-card>
                <!-- container -->

                <v-card-title class="warning">
                    {{ titleComponent }} <v-spacer></v-spacer>
                    <v-btn depressed text small fab @click="etatModal = false" dark>
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <!-- layout -->

                    <!-- fin -->




                    <div>
                        <!-- contenu -->
                        <v-layout row wrap>
                            <v-flex xs12 sm12 md12 lg12>
                                <!-- modal -->
                                <v-dialog v-model="dialog" max-width="600px" persistent>
                                    <v-card :loading="loading">
                                        <v-form ref="form" lazy-validation>
                                            <v-card-title>
                                                Paiement des Agents <v-spacer></v-spacer>
                                                <v-tooltip bottom color="black">
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <span v-bind="attrs" v-on="on">
                                                            <v-btn @click="dialog = false" text fab depressed>
                                                                <v-icon>close</v-icon>
                                                            </v-btn>
                                                        </span>
                                                    </template>
                                                    <span>Fermer</span>
                                                </v-tooltip>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-layout row wrap>

                                                    <v-flex xs12 sm12 md12 lg12>
                                                        <div class="mr-1">
                                                            <v-autocomplete label="Selectionnez le Compte"
                                                                prepend-inner-icon="home"
                                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                                :items="this.stataData.CompteList"
                                                                item-text="nom_compte" item-value="id" dense outlined
                                                                v-model="svData.refCompte" chips clearable
                                                                @change="get_souscompte_for_compte(svData.refCompte)">
                                                            </v-autocomplete>
                                                        </div>
                                                    </v-flex>
                                                    <v-flex xs12 sm12 md12 lg12>
                                                        <div class="mr-1">
                                                            <v-autocomplete label="Selectionnez le Sous-Compte"
                                                                prepend-inner-icon="map"
                                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                                :items="stataData.SousCompteList"
                                                                item-text="nom_souscompte" item-value="id" dense
                                                                outlined v-model="svData.refSousCompte" clearable chips
                                                                @change="get_sscompte_for_souscompte(svData.refSousCompte)">
                                                            </v-autocomplete>
                                                        </div>
                                                    </v-flex>

                                                    <v-flex xs12 sm12 md12 lg12>
                                                        <div class="mr-1">
                                                            <v-autocomplete label="Selectionnez le Sous Sous-Compte"
                                                                prepend-inner-icon="map"
                                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                                :items="stataData.SSousCompteList"
                                                                item-text="nom_ssouscompte" item-value="id" dense
                                                                outlined v-model="svData.refSscompte" clearable chips>
                                                            </v-autocomplete>
                                                        </div>
                                                    </v-flex>


                                                    <v-flex xs12 sm12 md6 lg6>
                                                        <div class="mr-1">
                                                            <v-autocomplete label="Type Opération" :items="[
                                                                { designation: 'DEBIT' },
                                                                { designation: 'CREDIT' }
                                                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']"
                                                                outlined dense item-text="designation"
                                                                item-value="designation"
                                                                v-model="svData.typeOperation"></v-autocomplete>
                                                        </div>
                                                    </v-flex>

                                                    <v-flex xs12 sm12 md6 lg6>
                                                        <div class="mr-1">
                                                            <v-text-field type="number" label="Montant"
                                                                prepend-inner-icon="extension" dense
                                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                                v-model="svData.montantOpration"></v-text-field>
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

                                            <v-text-field append-icon="search" label="Recherche..." single-line outlined
                                                dense hide-details v-model="query" @keyup="searchMember"
                                                clearable></v-text-field>

                                        </div>
                                    </div>
                                    <!-- Excel, pdf, print -->
                                    <div class="wordset">
                                        <ul>
                                            <li>
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                                        :src="`${baseURL}/vuetheme/assets/img/icons/pdf.svg`"
                                                        alt="img" /></a>
                                            </li>
                                            <li>
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                                        :src="`${baseURL}/vuetheme/assets/img/icons/excel.svg`"
                                                        alt="img" /></a>
                                            </li>
                                            <li>
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                                        :src="`${baseURL}/vuetheme/assets/img/icons/printer.svg`"
                                                        alt="img" /></a>
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
                                                <th class="text-left">Libellé</th>
                                                <th class="text-left">TypeOpé.</th>
                                                <th class="text-left">SSCompte</th>
                                                <th class="text-left">N°SSCompte</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in fetchData" :key="item.id">
                                                <td>{{ item.libelleOperation }}</td>
                                                <td>{{ item.typeOperation }}</td>
                                                <td>{{ item.nom_ssouscompte }}</td>
                                                <td>{{ item.numero_ssouscompte }}</td>

                                                <td>

                                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                                        <template v-slot:activator="{ on }">
                                                            <v-btn icon v-on="on" small fab depressed text>
                                                                <v-icon>more_vert</v-icon>
                                                            </v-btn>
                                                        </template>

                                                        <v-list dense width="" v-if="userData.id_role=1">

                                                            <v-list-item link @click="editData(item.id)">
                                                                <v-list-item-icon>
                                                                    <v-icon color="  blue">edit</v-icon>
                                                                </v-list-item-icon>
                                                                <v-list-item-title style="margin-left: 5px;">Modifier
                                                                </v-list-item-title>
                                                            </v-list-item>

                                                            <!-- <v-list-item link
                                                                @click="desactiverData(item.id, item.author, item.created_at, item.typeOperation, item.refEnteteOperation)">
                                                                <v-list-item-icon>
                                                                    <v-icon color="  red">delete</v-icon>
                                                                </v-list-item-icon>
                                                                <v-list-item-title style="margin-left: 5px;">Supprimer
                                                                </v-list-item-title>
                                                            </v-list-item> -->

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













                </v-card-text>

                <!-- container -->
            </v-card>
        </v-dialog>
    </v-row>


</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {

            title: "Liste des Details",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,
            etatModal: false,
            titleComponent: '',
            refEnteteOperation: 0,

            //id,refEnteteOperation,refSscompte,typeOperation,montantOpration

            svData: {
                id: '',
                refEnteteOperation: 0,
                refSscompte: 0,
                typeOperation: '',
                montantOpration: 0,

                refCompte: "",
                refSousCompte: "",
            },
            fetchData: [],
            medecinList: [],
            don: [],
            query: "",
            stataData: {
                CompteList: [],
                SousCompteList: [],
                SSousCompteList: []
            },

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''

        }
    },
    created() {
        // this.fetchDataList();
        // this.fetchListCompte();

    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {

        ...mapActions(["getCategory"]),

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);
                if (this.edit) {
                    this.svData.refEnteteOperation = this.refEnteteOperation;
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/update_detailoperationcomptable/${this.svData.id}`,
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
                    this.svData.refEnteteOperation = this.refEnteteOperation;
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_detailoperationcomptable`,
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_detail_operationcomptable/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    this.getSvData(this.svData, data.data[0]);
                    donnees.map((item) => {
                        // this.svData.id = item.id;
                        // this.svData.refEnteteOperation = item.refEnteteOperation;
                        // this.svData.refSscompte = item.refSscompte;
                        // this.svData.montantOpration = item.montantOpration;

                        this.get_souscompte_for_compte(item.refCompte);
                        this.get_sscompte_for_souscompte(item.refSousCompte);
                    });


                    this.edit = true;
                    this.dialog = true;

                    // console.log(donnees);
                }
            );
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_detailoperationcomptable/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.fetchDataList();
                    }
                );
            });
        },

        printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_bulletin_paie?id=` + id);
        },
        fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/fetch_detail_enteteoperationcomptable/${this.refEnteteOperation}?page=`);
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange(){
            this.fetch_data(`${this.apiBaseURL}/fetch_detail_enteteoperationcomptable/${this.refEnteteOperation}?page=`);
        },
        fetchListCompte() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.stataData.CompteList = donnees;

                }
            );
        },
        //fultrage de donnees
        async get_souscompte_for_compte(refCompte) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_souscompte_compte2/${refCompte}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.SousCompteList = chart;
                    } else {
                        this.stataData.SousCompteList = [];
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
        //fultrage de donnees
        async get_sscompte_for_souscompte(refSousCompte) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_ssouscompte_sous2/${refSousCompte}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.SSousCompteList = chart;
                    } else {
                        this.stataData.SSousCompteList = [];
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
        desactiverData(valeurs, user_created, date_entree, noms, numEntete) {
            //
            var tables = 'tfin_detail_operationcompte';
            var user_name = this.userData.name;
            var user_id = this.userData.id;
            var detail_information = "Suppression type operation : " + noms + " sur l'Operation n° " + numEntete + " par l'utilisateur " + user_name + "";

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
