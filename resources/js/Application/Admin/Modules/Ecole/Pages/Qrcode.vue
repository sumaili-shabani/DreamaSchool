<template>
    <div>

        <v-dialog v-model="dialog" max-width="900px" persistent transition="dialog-bottom-transition">
            <v-card :loading="loading">

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
                        <!-- qrcode -->
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-form ref="form" lazy-validation>
                                    <v-layout row wrap>

                                        <!-- eleves -->
                                        <v-flex xs12 sm12 md12 lg12>
                                            <div class="mr-1">
                                                <v-autocomplete label="Selectionner l'élève" prepend-inner-icon="person"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']"
                                                    :items="eleveInscritList" item-text="nomEleve" item-value="id"
                                                    outlined clearable v-model="svData.idInscription" chips dense>
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
                                                                    {{ data.item.nomSection }}- {{
                                                                        data.item.nomOption }}-
                                                                    {{ data.item.nomClasse }} - {{
                                                                        data.item.nomDivision }}
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
                                        <!-- fin eleve -->
                                        <v-flex xs12 sm12 md6 lg6>
                                            <div class="mr-1">
                                                <v-select
                                                    :items="[{ designation: 'Arrivé' }, { designation: 'Sortie' }]"
                                                    label="Mouvement de la présence" prepend-inner-icon="filter_list"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                    item-text="designation" item-value="designation"
                                                    v-model="svData.mouvement"></v-select>
                                            </div>
                                        </v-flex>
                                        <v-flex xs12 sm12 md6 lg6>
                                            <div class="mr-1">
                                                <v-select
                                                    :items="[{ designation: 'Présent(e)' }, { designation: 'Absent(e)' }, { designation: 'Excusé(e)' }]"
                                                    label="Statut de la présence" prepend-inner-icon="category"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                    item-text="designation" item-value="designation"
                                                    v-model="svData.statut_presence"></v-select>
                                            </div>
                                        </v-flex>


                                        <v-flex xs12 sm12 md6 lg6 v-if="svData.mouvement == 'Arrivé'">
                                            <div class="mr-1">
                                                <v-text-field label="Date d'entrée" type="date"
                                                    prepend-inner-icon="event"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                    v-model="svData.date_entree"></v-text-field>
                                            </div>
                                        </v-flex>

                                        <v-flex xs12 sm12 md6 lg6 v-if="svData.mouvement == 'Sortie'">
                                            <div class="mr-1">
                                                <v-text-field label="Date de sortie" type="date"
                                                    prepend-inner-icon="event"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                    v-model="svData.date_sortie"></v-text-field>
                                            </div>
                                        </v-flex>

                                        <v-flex xs12 sm12 md6 lg6 v-if="svData.statut_presence == 'Excusé(e)'">
                                            <div class="mr-1">
                                                <v-textarea label="Motif d'excuse" type="date" rows="1"
                                                    prepend-inner-icon="edit_note" outlined dense
                                                    v-model="svData.motif"></v-textarea>
                                            </div>
                                        </v-flex>

                                        <v-flex xs12 sm12 md6 lg6>
                                            <div class="mr-1">

                                                <v-btn color="primary" dark :loading="loading" @click="validate"
                                                    class="hover-a" style="text-decoration: none; width: 100%;">
                                                    <v-icon>save</v-icon> {{ edit ? "Modifier" : "Ajouter" }}
                                                </v-btn>
                                            </div>

                                        </v-flex>


                                    </v-layout>
                                </v-form>

                            </div>

                        </v-flex>
                        <!-- fin qrcode -->

                        <!-- panier detail -->
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">

                                <QrcodeScanner :qrbox="150" :fps="10" style="width: 100%;" @result="onScan" />

                                <div class="text-center">
                                    <p class="text-center"><v-icon>qr_code</v-icon> {{ svData.codeInscription }}</p>
                                </div>

                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
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
                                                            <v-btn :loading="loading" fab text small
                                                                @click="onPageChange" class="btn btn-warning"
                                                                style="margin-right: 6px">
                                                                <v-icon>autorenew</v-icon>
                                                            </v-btn>
                                                        </span>
                                                    </template>
                                                    <span>Initialiser</span>
                                                </v-tooltip>
                                            </div>
                                            <div class="search-input">
                                                <v-text-field append-icon="search" label="Recherche..." single-line
                                                    outlined dense hide-details v-model="query" @keyup="searchMember"
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
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="excel"><img
                                                            :src="`${baseURL}/vuetheme/assets/img/icons/excel.svg`"
                                                            alt="img" /></a>
                                                </li>
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="print"><img
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
                                                    <th class="text-left">Photo</th>
                                                    <th class="text-left">Nom Complet</th>
                                                    <th class="text-left">Sexe et Age</th>
                                                    <th class="text-left">Classe</th>

                                                    <th class="text-left">Mouvement</th>
                                                    <th class="text-left">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in fetchData" :key="item.id">
                                                    <td>
                                                        <!-- image -->
                                                        <img style="border-radius: 50px; width: 50px; height: 50px"
                                                            :src="item.photoEleve == null
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
                                                        {{ item.nomOption | subStrLong2 }}-
                                                        <p>
                                                            {{ item.nomClasse }}- {{ item.nomDivision }}
                                                        </p>
                                                    </td>


                                                    <td>
                                                        {{ item.mouvement }} /
                                                        {{ item.statut_presence }}

                                                        <div v-if="item.date1 != null">
                                                            Arrivé: {{ item.date1 | formatDate }}
                                                            {{ item.date1 | formatHour }}
                                                        </div> -
                                                        <div v-if="item.date2 != null">
                                                            Sortie: {{ item.date2 | formatDate }}
                                                            {{ item.date2 | formatHour }}
                                                        </div>
                                                    </td>


                                                    <td>

                                                        <a class="me-3 confirm-text" href="javascript:void(0);"
                                                            @click="clearP(item.id)">
                                                            <img :src="`${baseURL}/vuetheme/assets/img/icons/delete.svg`"
                                                                alt="img" />
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- fin tableau -->
                                    <!-- pagination -->
                                    <div class="col-md-12 text-center">
                                        <v-pagination color="primary" v-model="pagination.current"
                                            :length="pagination.total" :total-visible="7"
                                            @input="onPageChange"></v-pagination>
                                    </div>
                                    <!-- fin pagination -->
                                </div>
                            </div>
                            <!-- fin card -->
                        </v-flex>
                        <!-- fin panier detail -->
                    </v-layout>

                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn depressed text @click="dialog = false"> Fermer </v-btn>

                </v-card-actions>

            </v-card>
        </v-dialog>



    </div>
</template>
<script>

// To use Html5QrcodeScanner (more info below)
import { Html5QrcodeScanner } from "html5-qrcode";
// To use Html5Qrcode (more info below)
import { Html5Qrcode } from "html5-qrcode";

import { mapGetters, mapActions } from "vuex";
import QrcodeScanner from "./qrcode-scanner.vue";


export default {
    components: {
        QrcodeScanner,
    },

    data() {
        return {
            title: "Role component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",
                idInscription: "",
                date_entree: "",

                date_sortie: "",
                statut_presence: "",
                mouvement: "",

                motif: "",
                codeInscription: "",

            },
            fetchData: null,
            fetchDataCommande: [],
            titreModal: "",
            lastIdLivraison: "",
            text: "Qrcode",
            message: [],
            decodedResult: "",

        };
    },
    computed: {
        ...mapGetters(["roleList", "paysList", "eleveList", "anneeList", "classeList", "sectionList", "divisionList", "eleveInscritList", "isloading"]),
    },

    methods: {
        ...mapActions(["getRole", "getPays", "getEleveList", "getAnneeScollaire", "getClasse", "getSection", "getDivision", "getEleveInscritList"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout présence de l'élève par qrcode";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.nomEleve;
            } else {
                this.titleComponent = "Ajout présence de l'élève par qrcode";
            }
        },

        /*
        *
        *========================================
        *qrcode scanner
        *========================================
        *
        */
        //qrcode scanner
        onScan(decodedText, decodedResult) {
            // handle the message here :)
            console.log('decodedText:' + decodedText);

            this.decodedResult = decodedText;
            this.svData.codeInscription = decodedText;
            this.insert_presence_qrcode();

        },



        /*
        *
        *========================================
        *qrcode scanner
        *========================================
        *
        */

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_presence_codeqr?page=`);
        },

        //ajout des presences
        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_presence`,
                    JSON.stringify(this.svData)
                )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.onPageChange();

                        // this.resetObj(this.svData);
                        this.viderSvData();

                        // this.dialog = false;
                    })
                    .catch((err) => {
                        this.isLoading(false);
                    });
            }
        },

        insert_presence_qrcode() {
            if (this.svData.codeInscription != '') {
                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_presence_qrcode`,
                    JSON.stringify(this.svData)
                )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.onPageChange();

                        // this.resetObj(this.svData);
                        this.viderSvData();

                        // this.dialog = false;
                    })
                    .catch((err) => {
                        this.isLoading(false);
                    });
            } else {
                this.showError(
                    "Veillez vérifier la dat d'expiration de codeQr"
                );
            }

        },


        viderSvData() {
            this.svData.idInscription = '';
        },
        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_presence/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },
        // fin ajout presence


        //voir la dernière commande
        getLastCommande() {
            var idPharmacie = this.myofficine.id;
            var idUser = this.userData.id;
            this.isLoading(true);
            this.editOrFetch(`${this.apiBaseURL}/getLastCommande/${idPharmacie}/${idUser}`).then(
                ({ data }) => {
                    this.lastIdLivraison = data.idLivraison;
                    this.isLoading(false);

                }
            );
        },

        getDetailProduit(codeQrProduit) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_officine_qrcode/${codeQrProduit}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    var idProduct = 0;
                    var qte = 1;
                    var date_expiration = "";
                    var pricevente = 0;


                    donnees.map((item) => {
                        idProduct = item.id;
                        pricevente = item.pricevente;
                        date_expiration = item.date_expiration;

                        this.insertCommande(idProduct, date_expiration, 1, pricevente);

                    });


                }
            );
        },

        insertCommande(idProduct, date_expiration, qte, pu) {
            if (qte >= 1) {

                this.getLastCommande();

                if (this.svData.idLivraison == "") {
                    this.svData.idLivraison = this.idLivraison;
                } else {
                    this.svData.idLivraison = this.idLivraison;
                }

                var idPharmacie = this.myofficine.id;
                var idUser = this.userData.id;
                var idLivraison = this.lastIdLivraison;
                var pt = (qte * pu);
                var svDataPanier = {
                    id: "",
                    idLivraison: idLivraison,
                    idProduct: idProduct,
                    qte: 1,
                    pu: pu,
                    pt: pt,
                    etat: 0,
                    date_expiration: date_expiration,
                    num_lot: "Lot n° " + idLivraison + "-du-" + date_expiration,

                };

                if (idLivraison > 0) {

                    this.isLoading(true);
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_detail_liv_officine`,
                        JSON.stringify(svDataPanier)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.resetObj(svDataPanier);
                            //   this.onPageChange();

                            this.showDetailVente(idLivraison, 0);
                            // this.lastIdLivraison = 0;

                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });


                    // this.showMsg("idLivraison: "+idLivraison);

                } else {
                    this.showError(
                        "Veillez créer une commande pour effectuer une vente!!!"
                    );

                }




            }
            else {
                this.showError(
                    "Veillez approvisionner le stock pour effectuer la commande "
                );
            }
        },

        /*
        *
        *======================================
        *pour les impressions
        *======================================
        *
        * */


        printBill(code) {
            window.open(
                `${this.apiBaseURL}/pdf_bon_sortie_stock_produit_officine?code=` + code
            );
        },



        /*
        *
        *======================================
        *Fin pour les impressions
        *======================================
        *
        * */



    },

    created() {
        this.testTitle();
        this.getEleveInscritList();
        this.onPageChange();

    }


}
</script>
