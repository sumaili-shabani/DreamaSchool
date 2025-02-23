<template>
  <v-layout>
    <!-- <v-flex md1>EnteteBonEngagement_Model</v-flex> -->
    <v-flex md12>

      <DetailEtatdeBesoin ref="DetailEtatdeBesoin" />
      <EnteteBonEngagement_Model ref="EnteteBonEngagement_Model" />

      <v-dialog v-model="dialog" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              ETat de Besoin <v-spacer></v-spacer>
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

              <v-autocomplete label="Selectionnez la Provenance" prepend-inner-icon="mdi-map"
                :rules="[(v) => !!v || 'Ce champ est requis']" :items="provenanceList" item-text="nomProvenance"
                item-value="id" outlined dense v-model="svData.refProvenance">
              </v-autocomplete>

              <v-text-field type="date" label="Date Elaboration" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.DateElaboration">
              </v-text-field>

              <v-text-field label="Motif Dépense" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.motifDepense">
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
      <v-layout>
        <!--   -->
        <v-flex md12>
          <v-layout>
            <v-flex md6>
              <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
            </v-flex>
            <v-flex md5>


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
                <span>Ajouter un Produit</span>
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
                      <th class="text-left">N° BE</th>
                      <th class="text-left">Date_EB</th>
                      <th class="text-left">Provenance</th>
                      <th class="text-left">Motif</th>
                      <th class="text-left">Aquitté</th>
                      <th class="text-left">Aprouvé</th>
                      <th class="text-left">Author</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.codeEB }}</td>
                      <td>{{ item.DateElaboration | formatDate }}</td>
                      <td>{{ item.nomProvenance }}</td>
                      <td>{{ item.motifDepense }}</td>
                      <td>
                        <v-badge bordered color="error" icon="person" overlap>
                          <v-btn elevation="2" x-small class="white--text" :color="
                            item.StatutAcquitterPar == 'OUI'
                              ? 'success'
                              : 'error'
                          " depressed>
                            {{ item.StatutAcquitterPar }}
                          </v-btn>
                        </v-badge>

                      </td>
                      <td>
                        <v-badge bordered color="error" icon="person" overlap>
                          <v-btn elevation="2" x-small class="white--text" :color="
                            item.StatutApproCoordi == 'OUI'
                              ? 'success'
                              : 'error'
                          " depressed>
                            {{ item.StatutApproCoordi }}
                          </v-btn>
                        </v-badge>

                      </td>
                      <td>{{ item.author }}</td>
                      <td>

                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <!-- showEnteteBonEngagement -->

                          <v-list dense width="">

                            <v-list-item link @click="showDetailEtatdeBesoin(item.id, item.nomProvenance)">
                              <v-list-item-icon>
                                <v-icon color="  blue">mdi-briefcase-check</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Ajouter les details
                                EB
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="item.StatutAcquitterPar == 'OUI' && item.StatutApproCoordi == 'OUI'" link @click="showEnteteBonEngagement(item.codeEB, item.nomProvenance)">
                              <v-list-item-icon>
                                <v-icon color="  blue">mdi-briefcase-check</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Passer au Bon d'Engagement
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="aquitter_EB(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  blue">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Aquitter Etat de Besoin</v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="approuver_EB(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  blue">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Approuver Etat de Besoin</v-list-item-title>
                            </v-list-item>

                            <!-- v-if="item.StatutAcquitterPar == 'OUI' && item.StatutApproCoordi == 'OUI'" -->

                            <v-list-item link @click="printBill(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  blue">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Imprimer Etat de Besoin</v-list-item-title>
                            </v-list-item>

                            <v-list-item    link @click="editData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  blue">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                            </v-list-item>

                            <v-list-item   link @click="deleteData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  red">delete</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Suppression</v-list-item-title>
                            </v-list-item>

                          </v-list>
                        </v-menu>

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
        <!--   -->
      </v-layout>
    </v-flex>
    <!--   -->
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import DetailEtatdeBesoin from './DetailEtatdeBesoin.vue';
import EnteteBonEngagement_Model from './EnteteBonEngagement_Model.vue';

export default {
  components: {
    DetailEtatdeBesoin,
    EnteteBonEngagement_Model
  },
  data() {
    return {

      title: "Liste des Etats de Besoin",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //id,refProvenance , motifDepense, DateElaboration,author
      svData: {
        id: '',
        refProvenance: 0,
        DateElaboration: "",
        motifDepense: "",
        author: "Admin"
      },
      fetchData: [],
      provenanceList: [],
      query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {
     
    this.fetchDataList();
    this.fetchListSelection();
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
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_etatBesoin`,
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
            `${this.apiBaseURL}/insert_etatBesoin`,
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

    aquitter_EB(code) {
      // if (this.$refs.form.validate()) {

      this.isLoading(true);
      this.svData.id = code;
      this.svData.author = this.userData.name;
      this.insertOrUpdate(
        `${this.apiBaseURL}/aquitter_etatbesoin/${this.svData.id}`,
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

    approuver_EB(code) {
      // if (this.$refs.form.validate()) {
      this.isLoading(true);
      this.svData.id = code;
      this.svData.author = this.userData.name;
      this.insertOrUpdate(
        `${this.apiBaseURL}/approuver_etatbesoin/${this.svData.id}`,
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

    // PARTIE DES COMPOSANTS===================================================================   


    showDetailEtatdeBesoin(refEntete, provenance) {

      if (refEntete != '') {

        this.$refs.DetailEtatdeBesoin.$data.etatModal = true;
        this.$refs.DetailEtatdeBesoin.$data.refEntete = refEntete;
        this.$refs.DetailEtatdeBesoin.$data.svData.refEntete = refEntete;
        this.$refs.DetailEtatdeBesoin.fetchListSelection();
        this.$refs.DetailEtatdeBesoin.fetchDataList();
        this.fetchDataList();

        this.$refs.DetailEtatdeBesoin.$data.titleComponent =
          "Détail de Etat de Besoin pour " + provenance;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    // searchMember: _.debounce(function () {
    //   this.fetchDataList();
    // }, 300),

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_etatBesoin/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refProvenance = item.refProvenance;
            this.svData.DateElaboration = item.DateElaboration;
            this.svData.motifDepense = item.motifDepense;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bon_etatdebesoin?id=` + id);
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_etatBesoin/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_etatBesoin?page=`);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_provenance2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.provenanceList = donnees;

        }
      );
    },

    showEnteteBonEngagement(refEtatbesoin, provenance) {

      if (refEtatbesoin != '') {

        this.$refs.EnteteBonEngagement_Model.$data.etatModal = true;
        this.$refs.EnteteBonEngagement_Model.$data.refEtatbesoin = refEtatbesoin;
        this.$refs.EnteteBonEngagement_Model.$data.svData.refEtatbesoin = refEtatbesoin;
        this.$refs.EnteteBonEngagement_Model.fetchListSelection();
        this.$refs.EnteteBonEngagement_Model.fetchDataList();
        this.fetchDataList();

        this.$refs.EnteteBonEngagement_Model.$data.titleComponent =
          "Bon d'Engagement pour " + provenance;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tt_treso_entete_etatbesoin';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'un etat de service : "+noms+" par l'utilisateur "+user_name+"" ;

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
  
  