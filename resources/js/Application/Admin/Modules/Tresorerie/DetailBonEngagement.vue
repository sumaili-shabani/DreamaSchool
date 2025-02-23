<template>
  <v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="1200px">
      <v-card>
        <!-- container -->

        <v-card-title class="primary">
          {{ titleComponent }} <v-spacer></v-spacer>
          <v-btn depressed text small fab @click="etatModal = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <!-- layout -->

          <v-layout>
             
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="600px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Details Bon Engagement <v-spacer></v-spacer>
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

                      <v-autocomplete label="Selectionnez Rubrique" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="RubriqueList" item-text="desiRubriq"
                        item-value="id" dense outlined v-model="svData.refRubrique" chips clearable
                        >
                      </v-autocomplete>

                      <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Qte">
                      </v-text-field>

                      <v-text-field type="number" label="Prix Unitaire ($) " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.PU">
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
                              <th class="text-left">Provenance</th>
                              <th class="text-left">Catégorie</th>
                              <th class="text-left">Rubrique</th>
                              <th class="text-left">Quantité</th>
                              <th class="text-left">PU($)</th>
                              <th class="text-left">PT($)</th>
                              <th class="text-left">Taux(FC)</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.nomProvenance }}</td>
                              <td>{{ item.NomCateRubrique }}</td>
                              <td>{{ item.desiRubriq }}</td>
                              <td>{{ item.Qte }}</td>
                              <td>{{ item.PU }}</td>
                              <td>{{ item.prixTotal }}</td>
                              <td>{{ item.montant_taux }}</td>
                              <td>


                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>

                            <v-list dense width="">

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
                                <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
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
      refEntete:0,
      //'id',refEntete,refRubrique,Qte,PU,author
      svData: {
        id: '',
        refEntete:0,
        refRubrique: "",
        Qte: 0,
        PU: 0,
        author: "Admin",
      },
      fetchData: [],
      RubriqueList: [],
      don: [],
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
          this.svData.refEntete = this.refEntete;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_DbonAngagement`,
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
          this.svData.refEntete = this.refEntete;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_DbonAngagement`,
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

    //'id','refEntete','refRubrique','Qte','PU','author'

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_DbonAngagement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEntete = item.refEntete;
            this.svData.refRubrique = item.refRubrique;
            this.svData.Qte = item.Qte;
            this.svData.PU = item.PU;
            this.svData.author = item.author;            
          });
          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_DbonAngagement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {      
      this.fetch_data(`${this.apiBaseURL}/fetch_detail_enteteengagement/${this.refEntete}?page=`);

    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_rubrique2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.RubriqueList = donnees;
        }
      );
    },
    backPage() {
      this.$router.go(-1);
    },
    desactiverData(valeurs,user_created,date_entree,noms,numEntete) {
//
      var tables='tt_treso_detail_angagement';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une detail : "+noms+" sur le bon d'engagement n° "+numEntete+" par l'utilisateur "+user_name+"" ;

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

