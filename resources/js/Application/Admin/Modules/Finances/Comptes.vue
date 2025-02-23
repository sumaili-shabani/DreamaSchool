<template>
    
    <div>
  
      <v-layout>
        <!--   -->
         <v-flex md12>
          <v-dialog v-model="dialog" max-width="600px" persistent>
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  Comptes <v-spacer></v-spacer>
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

                  <v-text-field type="text" label="Designation Rubrique " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designation">
                  </v-text-field>
                  
                  <v-autocomplete label="Selectionnez le Type" prepend-inner-icon="mdi-map" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="mouvementList" item-text="designation" item-value="id"
                    outlined v-model="svData.refMvt">
                  </v-autocomplete> 
                  
                  <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.CompteList"
                      item-text="nom_compte" item-value="id" dense outlined v-model="svData.refCompte" chips clearable
                      @change="get_souscompte_for_compte(svData.refCompte)">
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Sous-Compte" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SousCompteList"
                      item-text="nom_souscompte" item-value="id" dense outlined v-model="svData.refSousCompte" clearable
                      chips @change="get_sscompte_for_souscompte(svData.refSousCompte)">
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Sous Sous-Compte" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                      item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.refSscompte" clearable
                      chips>
                    </v-autocomplete>
                  </div>
                </v-flex>

                
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
                    <span>Ajouter Compte</span>
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
                          <th class="text-left">Designation</th>
                          <th class="text-left">Mouvement</th>
                          <th class="text-left">Compte</th>
                          <th class="text-left">N°Compte</th>
                          <th class="text-left">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in fetchData" :key="item.id">
                          <td>{{ item.Compte }}</td>
                          <td>{{ item.TypeMouvement }}</td>
                          <td>{{ item.nom_ssouscompte }}</td>
                          <td>{{ item.numero_ssouscompte }}</td>
                          <td>
                            <v-tooltip top    color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="editData(item.id)" fab small>
                                    <v-icon color="  blue">edit</v-icon>
                                  </v-btn>
                                </span>
                              </template>
                              <span>Modifier</span>
                            </v-tooltip>
  
                            <!-- <v-tooltip top   color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="deleteData(item.id)" fab small>
                                    <v-icon color="  red">delete</v-icon>
                                  </v-btn>
                                </span>
                              </template>
                              <span>Suppression</span>
                            </v-tooltip>  -->
                           
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
    
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    data() {
      return {
  
        title: "Liste des Comptes",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
  
        svData: {
          id: '',          
          refMvt:0,
          designation: "",
          refCompte: "",
          refSousCompte: "",
          refSscompte: "",  
        },
        fetchData: [],        
        mouvementList: [],
        don:[],
        query: "",
        stataData: {
          CompteList: [],
          SousCompteList: [],
          SSousCompteList: []
        }
  
      }
    },
    created() {           
      this.fetchDataList();
      this.fetchListMouvement();
      this.fetchListCompte();
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
  
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_libelle/${this.svData.id}`,
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
  
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_libelle`,
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
 
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_libelle/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refMvt = item.refMvt;
              this.svData.designation = item.designation;
              this.svData.refSscompte = item.refSscompte;                        
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_libelle/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_libelle?page=`);        
      },
  
      fetchListMouvement() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_typemouvement`).then(
          ({ data }) => {
            var donnees = data.data;
            this.mouvementList = donnees;
          }
        );
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
    }
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  