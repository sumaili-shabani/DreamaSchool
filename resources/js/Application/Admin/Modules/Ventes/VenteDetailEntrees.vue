<template>

    <v-row justify="center">
        <v-dialog v-model="etatModal" persistent max-width="950px">
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

              <div>

              <v-layout>

                <v-flex md12>

                  <BonEntree ref="BonEntree" />

                  <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Details Entrée <v-spacer></v-spacer>
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

                          <v-autocomplete label="Selectionnez l'Article" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList" item-text="designation"
                            item-value="id" dense outlined v-model="svData.refProduit" chips clearable @change="getPrice(svData.refProduit)">
                          </v-autocomplete>

                          <v-text-field type="number" readonly label="Quantité Disponible" prepend-inner-icon="event" dense
                            outlined v-model="svData.qteDisponible">
                          </v-text-field>

                          <v-text-field type="number" label="Entrez la Quantité " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qteEntree">
                          </v-text-field>

                          <v-text-field type="number" label="Prix Unitaire ($) " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.puEntree">
                          </v-text-field>

                          <v-autocomplete label="Device" :items="[
                            { designation: 'USD' },
                            { designation: 'FC' },
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                               item-text="designation" item-value="designation"
                               v-model="svData.devise">
                          </v-autocomplete>

                        <v-autocomplete label="Unité(Paquet ou Produit)" :items="[
                          { designation: 'Par Pièce' },
                          { designation: 'Par Kilo' },
                          { designation: 'Par Paquet' },
                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                          item-text="designation" item-value="designation" v-model="svData.paquets">
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
                          <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                            outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                                  <th class="text-left">Produit</th>
                                  <th class="text-left">Quantité</th>
                                  <th class="text-left">PU($)</th>
                                  <th class="text-left">PT($)</th>
                                  <th class="text-left">N° B.E</th>
                                  <th class="text-left">Fournisseur</th>
                                  <th class="text-left">DateEntrée</th>
                                  <th class="text-left">Taux</th>
                                  <th class="text-left">Unité</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.designation }}</td>
                                  <td>{{ item.qteEntree }}</td>
                                  <td>{{ item.puEntree }}</td>
                                  <td>{{ item.PTEntree }}</td>
                                  <td>{{ item.refEnteteEntree }}</td>
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.dateEntree }}</td>
                                  <td>{{ item.taux }}</td>
                                  <td>{{ item.unite_paquet }}</td>
                                  <td>
                                    <!--  <v-tooltip top    color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="editData(item.id)" fab small>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Modifier</span>
                                    </v-tooltip> -->

                                    <v-tooltip  top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="deleteData(item.id)" fab x-small>
                                            <v-icon color="  red">delete</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Suppression</span>
                                    </v-tooltip>

                                    <v-tooltip top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="showFacture(item.refEnteteEntree,item.noms,'Ventes')" fab x-small><v-icon
                                              color="blue">print</v-icon></v-btn>
                                        </span>
                                      </template>
                                      <span>Imprimer Bon</span>
                                    </v-tooltip>

                                  </td>
                                </tr>
                              </tbody>
                            </template>
                          </v-simple-table>
                          <hr />

                          <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                            @input="fetchDataList"></v-pagination>
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
    import BonEntree from "../Rapports/Finances/BonEntree.vue";
    BonEntree

    export default {
      components:{
        BonEntree
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
          refEnteteEntree: 0,

          //'id','refEnteteEntree','refProduit','puEntree','devise','taux','qteEntree','author'
          svData: {
            id: '',
            refEnteteEntree: 0,
            refProduit: 0,
            puEntree: 0,
            devise:"",
            qteEntree: 0,
            author: "Admin",

            qteDisponible:0,
            puProduit:0,
            paquets:''
          },
          fetchData: [],
          produitList: [],
          don: [],
          query: "",

          inserer:'',
          modifier:'',
          supprimer:'',
          chargement:''

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
              this.svData.refEnteteEntree = this.refEnteteEntree;
              this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_vente_detail_entree/${this.svData.id}`,
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
              this.svData.refEnteteEntree = this.refEnteteEntree;
              this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_detail_entree`,
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

        // s'id','refEnteteEntree','refProduit','puEntree','qteEntree','author'
        //   this.fetchDataList();
        // }, 300),

        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_detail_entree/${id}`).then(
            ({ data }) => {
              var donnees = data.data;
              donnees.map((item) => {
                this.svData.id = item.id;
                this.svData.refEnteteEntree = item.refEnteteEntree;
                this.svData.refProduit = item.refProduit;
                this.svData.puEntree = item.puEntree;
                this.svData.qteEntree = item.qteEntree;
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
            this.delGlobal(`${this.apiBaseURL}/delete_vente_detail_entree/${id}`).then(
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
          this.fetch_data(`${this.apiBaseURL}/fetch_vente_detail_entree/${this.refEnteteEntree}?page=`);
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
              this.svData.puEntree = item.pu;
              this.svData.qteDisponible = item.qte;
              this.svData.paquets = "Par "+item.unite;
            });
            // this.getSvData(this.svData, data.data[0]);
          }
        );
      },
    desactiverData(valeurs,user_created,date_entree,noms,numEntete) {
//
      var tables='tvente_detail_entree';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression du produit : "+noms+" sur le bon d'entrée n° "+numEntete+" par l'utilisateur "+user_name+"" ;

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

