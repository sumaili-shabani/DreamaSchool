<template>

<v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="1500px">
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
        <!--   -->
          <v-flex md12>
            <v-dialog v-model="dialog" max-width="600px" persistent>
              <v-card :loading="loading">
                <v-form ref="form" lazy-validation>
                  <v-card-title>
                    Depenses <v-spacer></v-spacer>
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

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field readonly label="Ref. N° Bon d'Engagement "
                        prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="this.numeroBE"></v-text-field>
                    </div>
                  </v-flex>

                  <!-- <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Mode de Paiement" prepend-inner-icon="home"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ModeList" item-text="designation"
                        item-value="designation" dense outlined v-model="svData.modepaie" chips
                        clearable @change="get_Banque(svData.modepaie)">
                      </v-autocomplete>
                    </div>
                  </v-flex> -->

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez la Caisse/Banque" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList" item-text="nom_banque" item-value="id"
                        dense outlined v-model="svData.refBanque" chips clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="N° Bordereau, N°Compte"
                        prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.numeroBordereau"></v-text-field>
                    </div>
                  </v-flex>
                    
                    <v-text-field type="number" label="Montant($)" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montant">
                    </v-text-field>

                    <v-text-field type="text" label="Montant en Lettre" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montantLettre">
                    </v-text-field>

                    <v-text-field type="text" label="Motif" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.motif">
                    </v-text-field>

                    <v-text-field type="date" label="Date Dépense" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateOperation">
                        </v-text-field>
                
                    <v-autocomplete label="Selectionnez le Libellé" prepend-inner-icon="mdi-map" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="compteList" item-text="designation" item-value="id"
                      outlined v-model="svData.refCompte" @change="getDetailCompte(svData.refCompte)">
                    </v-autocomplete > 

                    <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field readonly label="Comptes" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.comptesJournal">
                      </v-text-field>
                    </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                      <v-text-field label="Numéro Compte" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numCompteJournal">
                      </v-text-field>
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
              <!--   -->
              <v-flex md12>
                <v-layout>
                  <v-flex md6>
                    <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                      outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                      <span>Ajouter une Depense</span>
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
                            <th class="text-left">N°</th>                          
                            <th class="text-left">Montant($)</th>
                            <th class="text-left">MontantLettre</th>
                            <th class="text-left">Caisse/Banque</th>
                            <th class="text-left">N°Compte</th>
                            <th class="text-left">Compte</th>
                            <th class="text-left">Motif</th>
                            <th class="text-left">Date</th>
                            <th class="text-left">Aquitté</th>
                            <th class="text-left">Aprouvé(AG)</th>
                            <th class="text-left">N°B.ENGAG.</th>
                            <th class="text-left">Author</th>
                            <th class="text-left">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="item in fetchData" :key="item.id">
                            <td>{{ item.codeOperation }}</td>                          
                            <td>{{ item.montant }}</td>
                            <td>{{ item.montantLettre}}</td>
                            <td>{{ item.nom_banque}}</td>
                            <td>{{ item.numero_ssouscompte}}</td>
                            <td>{{ item.Compte}}</td>
                            <td>{{ item.motif}}</td>
                            <td>{{ item.dateOperation | formatDate}}</td>
                            <td>
                                  <font :color="randColor()">
                                    {{ item.StatutAcquitterPar }}</font>                 
                            
                                </td>
                                <td>  
                                  <font :color="randColor()">
                                    {{ item.StatutApproCoordi }}</font> 
                                </td>
                            <td>{{ item.numeroBE}}</td>
                            <td>{{ item.author}}</td>
                            <td>                            
                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>

                            <v-list dense width="">

                              <v-list-item link @click="aquitter_Depense(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="  blue">edit</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Aquitter la Dépense</v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="approuver_Depense(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="  blue">edit</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Approuver la Dépense</v-list-item-title>
                                </v-list-item>

                                <v-list-item v-if="item.StatutAcquitterPar == 'OUI'" link  @click="printBill(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="  blue">print</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Bon de Sortie</v-list-item-title>
                                </v-list-item> 

                              <v-list-item    link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                              </v-list-item>
                              
                              <v-list-item   link @click="desactiverData(item.id, item.author, item.created_at, item.montant)">
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
              <!--   -->
            </v-layout>
          </v-flex>
        <!--   -->
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
        //
  
        title: "Liste des Dépenses",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,

        etatModal: false,
        titleComponent: '',
        numeroBE:'',
        montant:'',
        modepaie: "",
        refBanque:0,

        svData: {
          id: '',
          montant: 0,
          montantLettre: "",
          motif: "",
          dateOperation: "",
          refMvt: 2,
          refCompte: 0,
          author:"Admin",          
          
          modepaie: "",
          refBanque:0,
          numeroBordereau:"",
          numeroBE:'',
          
          comptesJournal:'',
          numCompteJournal:''
        },
        fetchData: [],
        compteList: [],
        ModeList: [],
        BanqueList: [],
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
      
      this.get_Banque(this.refBanque);
      
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
            this.svData.refBanque=this.refBanque;
            this.svData.modepaie=this.modepaie;
            this.svData.montant=this.montant;
            this.svData.numeroBE=this.numeroBE;
            this.svData.author = this.userData.name;
            this.svData.refMvt = 2;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_depense/${this.svData.id}`,
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
            this.svData.refBanque=this.refBanque;
            this.svData.modepaie=this.modepaie;
            this.svData.montant=this.montant;
            this.svData.numeroBE=this.numeroBE;
            this.svData.author = this.userData.name;
            this.svData.refMvt = 2;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_depense`,
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
      async get_Banque(id) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_single_banque/${id}`)
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
  
    
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_depense/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
  
              this.svData.id = item.id;
              this.svData.montant = item.montant;  
              this.svData.montantLettre= item.montantLettre;  
              this.svData.motif = item.motif;  
              this.svData.dateOperation = item.dateOperation;  
              this.svData.refMvt = item.refMvt;
              this.svData.refCompte= item.refCompte;              
              this.svData.author = item.author; 
              this.svData.modepaie = item.modepaie;
              this.svData.refBanque = item.refBanque;
              this.svData.numeroBordereau = item.numeroBordereau;     
              this.svData.numeroBE = item.numeroBE;                    
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },  
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonsortie_data?id=` + id);
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_depense/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.svData.numeroBE=this.numeroBE;
        this.fetch_data(`${this.apiBaseURL}/fetch_mouvement_depense?page=`);
      },
  
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_compte_sortie`).then(
          ({ data }) => {
            var donnees = data.data;
            this.compteList = donnees;
  
          }
        );
      },
//
        aquitter_Depense(code) {
          // if (this.$refs.form.validate()) {
            
            this.isLoading(true);
            this.svData.id=code;
            this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/aquitter_depense/${this.svData.id}`,
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

        approuver_Depense(code) {
          // if (this.$refs.form.validate()) {
            this.isLoading(true);
            this.svData.id=code;
            this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/approuver_depense/${this.svData.id}`,
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

      getDetailCompte(idLibelle) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_libelle/${idLibelle}`).then(
          ({ data }) => {
            var donnees = data.data;

            donnees.map((item) => {
              this.svData.comptesJournal = item.nom_ssouscompte;
              this.svData.numCompteJournal = item.numero_ssouscompte;
            });

          }
        );
      },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tdepense';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une depense de montant : "+noms+" par l'utilisateur "+user_name+"" ;

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
  
  