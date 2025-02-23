<template>
    <v-row justify="center">
        <v-dialog v-model="etatModal" persistent max-width="900px">
            <v-card>
                <!-- container -->

                <v-card-title class="warning">
                    {{ titleComponent }} <v-spacer></v-spacer>
                    <v-btn depressed text small fab @click="etatModal = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <!-- layout -->

                    <div>

                        <v-layout>

                            <v-flex md12>
                                <FactureVente ref="FactureVente" />
                                <VentePaiement ref="VentePaiement" />

                                <v-dialog v-model="dialog" max-width="400px" persistent>
                                    <v-card :loading="loading">
                                        <v-form ref="form" lazy-validation>
                                            <v-card-title>
                                                Details Sortie <v-spacer></v-spacer>
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

                                                <v-autocomplete label="Selectionnez l'Article"
                                                    prepend-inner-icon="mdi-map"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList"
                                                    item-text="designation" item-value="id" dense outlined
                                                    v-model="svData.refProduit" chips clearable
                                                    @change="getPrice(svData.refProduit)">
                                                </v-autocomplete>

                                                <v-text-field type="number" disabled readonly
                                                    label="Quantité Disponible" prepend-inner-icon="event" dense
                                                    outlined v-model="svData.qteDisponible">
                                                </v-text-field>

                                                <v-text-field type="number" step="0.01" label="Quantité "
                                                    prepend-inner-icon="event" dense
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                    v-model="svData.qteVente">
                                                </v-text-field>

                                                <v-text-field type="number" step="0.01" label="Prix Unitaire ($) "
                                                    prepend-inner-icon="event" dense
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                    v-model="svData.puVente">
                                                </v-text-field>

                                                <v-autocomplete label="Device" :items="[
                                                    { designation: 'USD' },
                                                    { designation: 'FC' },
                                                ]" prepend-inner-icon="extension"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                    item-text="designation" item-value="designation"
                                                    v-model="svData.devise"></v-autocomplete>

                                                <v-autocomplete label="Unité(Paquet ou Produit)" :items="[
                                                    { designation: 'Par Pièce' },
                                                    { designation: 'Par Kg' },
                                                    { designation: 'Par Paquet' },
                                                ]" prepend-inner-icon="extension"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                    item-text="designation" item-value="designation"
                                                    v-model="svData.paquets">
                                                </v-autocomplete>

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
                                <v-layout>
                                    <!--   -->
                                    <v-flex md12>
                                        <v-layout>
                                            <v-flex md6>
                                                <v-text-field placeholder="recherche..." append-icon="search"
                                                    label="Recherche..." single-line solo outlined rounded hide-details
                                                    v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                                            </v-flex>
                                            <v-flex md5>
                                                <div>
                                                    <!-- {{ this.don }} -->
                                                </div>
                                            </v-flex>
                                            <v-flex md1>
                                                <v-tooltip bottom color="black">
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <span v-bind="attrs" v-on="on">
                                                            <v-btn @click="dialog = true" fab color="  blue" dark>
                                                                <v-icon>add</v-icon>
                                                            </v-btn>
                                                        </span>
                                                    </template>
                                                    <span>Ajouter le Detail</span>
                                                </v-tooltip>
                                            </v-flex>
                                        </v-layout>
                                        <br />
                                        <v-card>
                                            <v-card-text>
                                                <v-simple-table>
                                                    <template v-slot:default>
                                                        <thead>
                                                            <tr>
                                                                <!-- unite_paquet -->
                                                                <th class="text-left">Article</th>
                                                                <th class="text-left">Quantité</th>
                                                                <th class="text-left">PU($)</th>
                                                                <th class="text-left">PT($)</th>
                                                                <th class="text-left">Reduction($)</th>
                                                                <th class="text-left">N° B.E</th>
                                                                <th class="text-left">Client</th>
                                                                <th class="text-left">DateVente</th>
                                                                <th class="text-left">Montant($)</th>
                                                                <th class="text-left">Taux</th>
                                                                <th class="text-left">Unité</th>
                                                                <th class="text-left">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="item in fetchData" :key="item.id">
                                                                <td>{{ item.designation }}</td>
                                                                <td>{{ item.qteVente }}</td>
                                                                <td>{{ item.puVente }}$</td>
                                                                <td>{{ item.PTVente }}$</td>
                                                                <td>{{ item.Reduction }}$</td>
                                                                <td>{{ item.refEnteteVente }}</td>
                                                                <td>{{ item.noms }}</td>
                                                                <td>{{ item.dateVente }}</td>
                                                                <td>{{ item.RestePaie }}$</td>
                                                                <td>{{ item.taux }}</td>
                                                                <td>{{ item.unite_paquet }}</td>
                                                                <td>

                                                                    <v-menu bottom rounded offset-y
                                                                        transition="scale-transition">
                                                                        <template v-slot:activator="{ on }">
                                                                            <v-btn icon v-on="on" small fab depressed
                                                                                text>
                                                                                <v-icon>more_vert</v-icon>
                                                                            </v-btn>
                                                                        </template>

                                                                        <v-list dense width="">

                                                                            <v-list-item link
                                                                                @click="showVentePaiement(item.refEnteteVente, item.noms, item.totalFacture, item.totalPaie, item.RestePaie)">
                                                                                <v-list-item-icon>
                                                                                    <v-icon>mdi-cart-outline</v-icon>
                                                                                </v-list-item-icon>
                                                                                <v-list-item-title
                                                                                    style="margin-left: 2px">Paiement
                                                                                    Facture
                                                                                </v-list-item-title>
                                                                            </v-list-item>

                                                                            <v-list-item link
                                                                                @click="showFacture(item.refEnteteVente, item.noms, 'Ventes')">
                                                                                <v-list-item-icon>
                                                                                    <v-icon color="blue">print</v-icon>
                                                                                </v-list-item-icon>
                                                                                <v-list-item-title
                                                                                    style="margin-left: 2px">Imprimer la
                                                                                    Facture
                                                                                </v-list-item-title>
                                                                            </v-list-item>

                                                                            <!-- <v-list-item v-if="(roless[0].update == 'OUI')" link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                      </v-list-item> -->

                                                                            <v-list-item link
                                                                                @click="deleteData(item.id)">
                                                                                <v-list-item-icon>
                                                                                    <v-icon
                                                                                        color="  red">delete</v-icon>
                                                                                </v-list-item-icon>
                                                                                <v-list-item-title
                                                                                    style="margin-left: 2px">Suppression
                                                                                </v-list-item-title>
                                                                            </v-list-item>

                                                                        </v-list>
                                                                    </v-menu>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </template>
                                                </v-simple-table>
                                                <hr />

                                                <v-pagination color="  blue" v-model="pagination.current"
                                                    :length="pagination.total" @input="fetchDataList"></v-pagination>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>

                                </v-layout>
                            </v-flex>

                        </v-layout>

                    </div>


                    <!-- fin -->
                </v-card-text>

                <!-- container -->
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import FactureVente from '../Rapports/Finances/FactureVente.vue';
import VentePaiement from './VentePaiement.vue';
export default {
    components: {
        FactureVente,
        VentePaiement
    },
    data() {
        return {

            title: "Liste des Details",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,
            etatModal: false,
            titleComponent: '',
            refEnteteVente: 0,

            //'id','refEnteteVente','refProduit','puVente','devise','taux','qteVente','author'
            svData: {
                id: '',
                refEnteteVente: 0,
                refProduit: 0,
                puVente: 0.00,
                devise: "",
                qteVente: 0.00,
                author: "",
                qteDisponible: 0.00,
                paquets: ''
            },
            fetchData: [],
            produitList: [],
            don: [],
            query: "",

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''

        }
    },
    created() {

        // this.fetchDataList();
        // this.fetchListSelection();
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

                    if (this.svData.qteVente <= this.svData.qteDisponible) {

                        this.svData.refEnteteVente = this.refEnteteVente;
                        this.svData.author = this.userData.name;
                        this.insertOrUpdate(
                            `${this.apiBaseURL}/update_vente_detail_vente/${this.svData.id}`,
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


                    } else {
                        this.showError("La quantité demandé est supérieure à la quantité disponible stock !!! Veillez entrez une quantité <= à " + this.svData.qteDisponible);
                        this.isLoading(false);
                    }
                }
                else {
                    if (this.svData.qteVente <= this.svData.qteDisponible) {

                        this.svData.refEnteteVente = this.refEnteteVente;
                        this.svData.author = this.userData.name;
                        this.insertOrUpdate(
                            `${this.apiBaseURL}/insert_vente_detail_vente`,
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

                    } else {

                        this.showError("La quantité demandé est supérieure à la quantité disponible stock !!! Veillez entrez une quantité <= à " + this.svData.qteDisponible);

                        this.isLoading(false);

                    }

                }



            }
        },

        // s'id','refEnteteVente','refProduit','puVente','qteVente','author'
        //   this.fetchDataList();
        // }, 300),

        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_detail_vente/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.svData.refEnteteVente = item.refEnteteVente;
                        this.svData.refProduit = item.refProduit;
                        this.svData.puVente = item.puVente;
                        this.svData.qteVente = item.qteVente;
                        this.svData.designationProduit = item.designationProduit;
                    });

                    this.edit = true;
                    this.dialog = true;

                    // console.log(donnees);
                }
            );
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_vente_detail_vente/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.fetchDataList();
                    }
                );
            });
        },

        printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
        },
        fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/fetch_vente_detail_vente/${this.refEnteteVente}?page=`);
        },

        fetchListSelection() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_produit_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.produitList = donnees;
                }
            );
        },
        getPrice(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_produit/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.svData.puVente = item.pu;
                        this.svData.qteDisponible = item.qte;
                        this.svData.paquets = "Par "+item.unite;

                    });
                    // this.getSvData(this.svData, data.data[0]);
                }
            );
        },
        desactiverData(valeurs, user_created, date_entree, noms, numEntete) {
            //
            var tables = 'tvente_detail_vente';
            var user_name = this.userData.name;
            var user_id = this.userData.id;
            var detail_information = "Suppression du produit : " + noms + " sur la facture n° " + numEntete + " par l'utilisateur " + user_name + "";

            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },
        showFacture(refEnteteVente, name, ServiceData) {

            if (refEnteteVente != '') {

                this.$refs.FactureVente.$data.dialog2 = true;
                this.$refs.FactureVente.$data.refEnteteSortie = refEnteteVente;
                this.$refs.FactureVente.$data.ServiceData = ServiceData;
                this.$refs.FactureVente.showModel(refEnteteVente);
                this.fetchDataList();

                this.$refs.FactureVente.$data.titleComponent =
                    "La Facture pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },
        showVentePaiement(refEnteteVente, name, totalFacture, totalPaie, RestePaie) {

            if (refEnteteVente != '') {

                this.$refs.VentePaiement.$data.etatModal = true;
                this.$refs.VentePaiement.$data.refEnteteVente = refEnteteVente;
                this.$refs.VentePaiement.$data.totalFacture = totalFacture;
                this.$refs.VentePaiement.$data.totalPaie = totalPaie;
                this.$refs.VentePaiement.$data.RestePaie = RestePaie;
                this.$refs.VentePaiement.$data.svData.refEnteteVente = refEnteteVente;
                this.$refs.VentePaiement.fetchDataList();
                this.$refs.VentePaiement.get_mode_Paiement();
                this.$refs.VentePaiement.getInfoFacture();
                this.fetchDataList();

                this.$refs.VentePaiement.$data.titleComponent =
                    "Detail Vente pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        }


    },
    filters: {

    }
}
</script>
