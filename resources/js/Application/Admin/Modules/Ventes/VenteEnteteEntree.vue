<template>
  <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <VenteDetailEntrees ref="VenteDetailEntrees" />
                <BonEntree ref="BonEntree" />

                <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                        <v-card-title>
                        Approvisionnements <v-spacer></v-spacer>
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

                        <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms" item-value="id"
                            outlined dense v-model="svData.refFournisseur">
                        </v-autocomplete>

                        <v-text-field type="date" label="Date Entrée" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateEntree">
                        </v-text-field>

                        <v-text-field label="Libellé" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
                        </v-text-field>

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
                <h4>Liste des Fournisseurs</h4>
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
                                hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>

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
                                <th class="text-left">N°BE</th>
                                <th class="text-left">DateEntrée</th>
                                <th class="text-left">Fournisseur</th>
                                <th class="text-left">Téléphone</th>
                                <th class="text-left">Libellé</th>
                                <th class="text-left">Montant($)</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.id }}</td>
                                <td>{{ item.dateEntree | formatDate }}</td>
                                <td>{{ item.noms }}</td>
                                <td>{{ item.contact }}</td>
                                <td>{{ item.libelle }}</td>
                                <td>{{ item.montant }}$</td>
                                <td>{{ item.author }}</td>
                                <td>

                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                        </v-btn>
                                    </template>

                                    <v-list dense width="">

                                        <v-list-item link @click="showDetailEntree(item.id, item.noms)">
                                        <v-list-item-icon>
                                            <!-- <v-icon>mdi-cart-outline</v-icon> -->
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Detail Entrée
                                        </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="showFacture(item.id,item.noms,'Ventes')">
                                        <v-list-item-icon>
                                            <!-- <v-icon color="blue">print</v-icon> -->
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Bon d'Entree
                                        </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item    link @click="editData(item.id)">
                                        <v-list-item-icon>
                                            <!-- <v-icon color="  blue">edit</v-icon> -->
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item   link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                            <!-- <v-icon color="  red">delete</v-icon> -->
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Suppression
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
                    <v-pagination color="primary" v-model="pagination.current" :length="pagination.total"
                        @input="fetchDataList" :total-visible="7"></v-pagination>
                </div>
                <!-- fin pagination -->
            </div>
        </div>
        <!-- fin card -->

  </div>

</template>
<script>
import { mapGetters, mapActions } from "vuex";
import VenteDetailEntrees from './VenteDetailEntrees.vue';
import BonEntree from "../Rapports/Finances/BonEntree.vue";

export default {
  components:{
    VenteDetailEntrees,
    BonEntree
  },
  data() {
    return {

      title: "Liste des Approvisionnements",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      svData: {
        id: '',
        refFournisseur: 0,
        dateEntree: "",
        libelle: "",
        author: "Admin"
      },
      fetchData: [],

      query: "",

      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {

    this.fetchDataList();
    this.getFournisseur();

  },
  computed: {
    ...mapGetters(["categoryList","fournisseurList", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory", "getFournisseur",]),

    showModal() {
        this.dialog = true;
        this.titleComponent = "Approvisionnement ";
        this.edit = false;
        this.resetObj(this.svData);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_vente_entete_entree/${this.svData.id}`,
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
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_vente_entete_entree`,
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

    // searchMember: _.debounce(function () {
    //   this.fetchDataList();
    // }, 300),


    editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_entree/${id}`).then(
            ({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "modification de " + item.libelle;
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            }
        );
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_entree/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_entree?page=`);
    },


    showDetailEntree(refEnteteEntree, name) {

      if (refEnteteEntree != '') {

        this.$refs.VenteDetailEntrees.$data.etatModal = true;
        this.$refs.VenteDetailEntrees.$data.refEnteteEntree = refEnteteEntree;
        this.$refs.VenteDetailEntrees.$data.svData.refEnteteEntree = refEnteteEntree;
        this.$refs.VenteDetailEntrees.fetchDataList();
        this.$refs.VenteDetailEntrees.fetchListSelection();
        this.fetchDataList();

        this.$refs.VenteDetailEntrees.$data.titleComponent =
          "Detail Entree pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tvente_entete_entree';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une approvisionnment du fournisseur "+noms+" par l'utilisateur "+user_name+"" ;

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
    showFacture(refEnteteEntree, name,ServiceData) {

      if (refEnteteEntree != '') {

        this.$refs.BonEntree.$data.dialog2 = true;
        this.$refs.BonEntree.$data.refEnteteEntree = refEnteteEntree;
        this.$refs.BonEntree.$data.ServiceData = ServiceData;
        this.$refs.BonEntree.showModel(refEnteteEntree);
        this.fetchDataList();

        this.$refs.BonEntree.$data.titleComponent =
          "Bon Entree pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }

  },
  filters: {

  }
}
</script>

