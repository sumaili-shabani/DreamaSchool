<template>
  <v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="750px">
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

          <v-layout>
            <!--   -->
            <v-flex md12>

              <FactureVente ref="FactureVente" />

              <v-dialog v-model="dialog" max-width="500px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Paiement Facture <v-spacer></v-spacer>
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
                            <v-text-field readonly type="number" label="Total Facture" prepend-inner-icon="extension"
                              dense outlined v-model="svData.totalFacture"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field readonly type="number" label="Total déjà Payé" prepend-inner-icon="extension"
                              dense outlined v-model="svData.totalPaie"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field readonly type="number" label="Reste Facture" prepend-inner-icon="extension"
                              dense outlined v-model="svData.RestePaie"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Montant Payé" prepend-inner-icon="extension" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              v-model="svData.montant_paie"></v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Device" :items="[
                              { designation: 'USD' },
                              { designation: 'FC' },
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              dense item-text="designation" item-value="designation"
                              v-model="svData.devise"></v-autocomplete>
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


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Paiement" prepend-inner-icon="extension" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              v-model="svData.date_paie"></v-text-field>
                          </div>
                        </v-flex>

                        <!-- <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field type="textarea" label="Autres Details"
                      prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                      v-model="svData.libellepaie"></v-text-field>
                  </div>
                </v-flex> -->

                      </v-layout>


                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                      <v-btn color="blue" dark :loading="loading" @click="validate">
                        {{ edit ? "Modifier" : "Ajouter" }}
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-card>
              </v-dialog>

              <br /><br />
              <v-layout>

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
                            <v-btn @click="dialog = true" fab color="blue" dark>
                              <v-icon>add</v-icon>
                            </v-btn>
                          </span>
                        </template>
                        <span>Ajouter le Paiement</span>
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

                              <th class="text-left">N°Reçcu</th>
                              <th class="text-left">Client</th>
                              <th class="text-left">Montant($)</th>
                              <th class="text-left">ModePaie</th>
                              <th class="text-left">DatePaie</th>
                              <th class="text-left">Taux(FC)</th>
                              <th class="text-left">Compte</th>
                              <th class="text-left">Agent</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.codeRecu }}</td>
                              <td>{{ item.noms }}</td>
                              <td>{{ item.montant_paie }}$</td>
                              <td>{{ item.modepaie }}</td>
                              <td>{{ item.date_paie }}</td>
                              <td>{{ item.taux }}</td>
                              <td>{{ item.nom_banque }}</td>
                              <td>{{ item.author }}</td>
                              <td>

                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

                                    <!-- <v-list-item v-if="item.RestePaie == 0 || (roless[0].update == 'OUI')" link
                                      @click="editData(item.id)">
                                      <v-list-item-icon>
                                        <v-icon color="blue">edit</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                    </v-list-item> -->

                                    <v-list-item link @click="showFacture(item.refEnteteVente, item.noms, 'Ventes')">
                                      <v-list-item-icon>
                                        <v-icon color="blue">print</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: 3px">Imprimer Reçu</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="desactiverData(item.id, item.author, item.created_at, item.montant_paie, item.refEnteteVente,item.date_paie)">
                                        <v-list-item-icon>
                                          <v-icon color="red">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: 3px">Supprimer</v-list-item-title>
                                      </v-list-item>
                                  </v-list>
                                </v-menu>

                              </td>
                            </tr>
                          </tbody>
                        </template>
                      </v-simple-table>
                      <hr />

                      <v-pagination color="blue" v-model="pagination.current" :length="pagination.total"
                        @input="fetchDataList"></v-pagination>
                    </v-card-text>
                  </v-card>
                </v-flex>

              </v-layout>
            </v-flex>

          </v-layout>


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

export default {
  components: {
    FactureVente
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

      totalFacture: 0,
      totalPaie: 0,
      RestePaie: 0,
      // 'id','refEnteteVente','montant_paie','date_paie','modepaie','libellepaie','author'
      svData: {
        id: '',
        refEnteteVente: 0,
        montant_paie: 0,
        date_paie: "",
        modepaie: "",
        libellepaie: "",
        refBanque: 0,
        numeroBordereau: "000000000",
        author: "Admin",
        devise: "",

        totalFacture: 0,
        totalPaie: 0,
        RestePaie: 0
      },
      fetchData: [],
      ModeList: [],
      BanqueList: [],
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
    // this.get_mode_Paiement();

  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"])
    ,
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

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.author = this.userData.name;
          this.svData.libellepaie = 'Paiement Facture';
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_vente_paiement/${this.svData.id}`,
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
          this.svData.libellepaie = 'Paiement Facture';
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_vente_paiement`,
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

    // s'id','refEnteteVente','refFrais','puEntree','qteEntree','author'
    //   this.fetchDataList();
    // }, 300),

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_paiement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteVente = item.refEnteteVente;
            this.svData.montant_paie = item.montant_paie;
            this.svData.modepaie = item.modepaie;
            this.svData.libellepaie = item.libellepaie;
            this.svData.refBanque = item.refBanque;
            this.svData.numeroBordereau = item.numeroBordereau;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_vente_paiement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    getInfoFacture() {
      this.svData.totalFacture = this.totalFacture;
      this.svData.totalPaie = this.totalPaie;
      this.svData.RestePaie = this.RestePaie;
    },
    printRecuPrivee(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_recu_privee_data?id=` + id);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_vente_paiement/${this.refEnteteVente}?page=`);
    },
    backPage() {
      this.$router.go(-1);
    },
    desactiverData(valeurs,user_created,date_entree,noms,numEntete,datepaie) {
//
      var tables='tvente_paiement';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'un paiement du montant de : "+noms+" en date du "+datepaie+" pour la vente des Produits n° "+numEntete+" par l'utilisateur "+user_name+"" ;

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

    }


  },
  filters: {

  }
}
</script>

