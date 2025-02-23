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

                <DetailBonEngagement ref="DetailBonEngagement" />
                <Depenses ref="Depenses" />

                <v-dialog v-model="dialog" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Bon d'Engagement <v-spacer></v-spacer>
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
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="provenanceList" item-text="nomProvenance" item-value="id"
                          outlined dense v-model="svData.refProvenance">
                        </v-autocomplete>

                        <v-autocomplete label="Selectionnez le Blocs" prepend-inner-icon="mdi-map"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="blocList" item-text="desiBloc" item-value="id"
                          outlined dense v-model="svData.refBloc">
                        </v-autocomplete>

                        <v-text-field type="date" label="Date Engagement" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateEngagement">
                        </v-text-field>

                        <v-text-field label="Motif Dépense" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.motif">          
                        </v-text-field>

                        <v-text-field readonly label="Cfr. N° Etat de Besoin" prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.refEtatbesoin">
                        </v-text-field>

                        <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Mode de Paiement" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ModeList" item-text="designation"
                                  item-value="designation" dense outlined v-model="svData.modepaie" chips
                                  clearable @change="get_Banque(svData.modepaie)">
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez la Caisse/Banque" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList" item-text="nom_banque" item-value="id"
                                  dense outlined v-model="svData.refCaisse" chips clearable>
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
                                <th class="text-left">Date_Eng.</th>
                                <th class="text-left">Provenance</th>
                                <!-- <th class="text-left">Motif</th> -->
                                <th class="text-left">Division</th>
                                <th class="text-left">Tresorerie</th>
                                <th class="text-left">AG</th>
                                <th class="text-left">Directeur</th>
                                <th class="text-left">Gerant</th>
                                <th class="text-left">Montant$</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.codeBE }}</td>
                                <td>{{ item.dateEngagement | formatDate }}</td>
                                <td>{{ item.nomProvenance }}</td>
                                <!-- <td>{{ item.motif }}</td> -->
                                <td>                        
                                  <v-badge bordered color="error" icon="person" overlap>
                                            <v-btn elevation="2" x-small class="white--text" :color="
                                              item.StatutValiderDivision == 'OUI'
                                                ? 'success'
                                                : 'error'
                                            " depressed>
                                              {{ item.StatutValiderDivision }}
                                            </v-btn>
                                          </v-badge>
                                
                                </td>
                                <td>                        
                                  <v-badge bordered color="error" icon="person" overlap>
                                            <v-btn elevation="2" x-small class="white--text" :color="
                                              item.ValiderStatuttresorerie == 'OUI'
                                                ? 'success'
                                                : 'error'
                                            " depressed>
                                              {{ item.ValiderStatuttresorerie }}
                                            </v-btn>
                                          </v-badge>
                                
                                </td>
                                <td>                        
                                  <v-badge bordered color="error" icon="person" overlap>
                                            <v-btn elevation="2" x-small class="white--text" :color="
                                              item.ValiderStatutAdministration == 'OUI'
                                                ? 'success'
                                                : 'error'
                                            " depressed>
                                              {{ item.ValiderStatutAdministration }}
                                            </v-btn>
                                          </v-badge>
                                
                                </td>
                                <td>                        
                                  <v-badge bordered color="error" icon="person" overlap>
                                            <v-btn elevation="2" x-small class="white--text" :color="
                                              item.ValiderStatutDirection == 'OUI'
                                                ? 'success'
                                                : 'error'
                                            " depressed>
                                              {{ item.ValiderStatutDirection }}
                                            </v-btn>
                                          </v-badge>
                                
                                </td>
                                <td>                        
                                  <v-badge bordered color="error" icon="person" overlap>
                                            <v-btn elevation="2" x-small class="white--text" :color="
                                              item.ValiderStatutGerant == 'OUI'
                                                ? 'success'
                                                : 'error'
                                            " depressed>
                                              {{ item.ValiderStatutGerant }}
                                            </v-btn>
                                          </v-badge>
                                
                                </td>
                                <td>{{ item.TotalBE }}$</td>
                                <td>{{ item.author }}</td>
                                <td>
                                  <!-- TotalBE -->
                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <v-list-item  link @click="showDetailBonEngagement(item.id, item.nomProvenance)">
                                      <v-list-item-icon>
                                            <v-icon color="  blue">mdi-briefcase-check</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Ajouter Detail Bon d'Engagement
                                          </v-list-item-title>
                                      </v-list-item>

                                        <v-list-item  v-if="item.StatutValiderDivision == 'OUI' && item.ValiderStatuttresorerie == 'OUI'  
                                      && item.ValiderStatutAdministration == 'OUI' && item.ValiderStatutDirection == 'OUI' 
                                      && item.ValiderStatutGerant == 'OUI'"  link @click="showDepense(item.codeBE, item.nomProvenance,item.TotalBE,item.nom_mode,item.refCaisse)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">mdi-cards</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Executer la Dépense
                                          </v-list-item-title>
                                        </v-list-item>

                                        <v-divider></v-divider>
                                        <v-subheader>Autoriser la Sortie</v-subheader>
                                        <v-divider></v-divider>


                                        <v-list-item link @click="valider_Division(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Autoriser à la Division</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="valider_Tresorerie(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Autoriser à la Trésorerie</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="valider_Administration(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Autoriser à l'Administration</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="valider_Direction(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Autoriser à la Direction</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="valider_Gerant(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Autoriser par le Gerant</v-list-item-title>
                                        </v-list-item>

                                        <!--  -->
                                        <v-divider></v-divider>
                                        <v-subheader>Attester l'Action</v-subheader>
                                        <v-divider></v-divider>


                                        <v-list-item link @click="attester_Division(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Attester Division</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="attester_Tresorerie(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Attester Trésorerie</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="attester_Administration(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Attester Administration</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="attester_Direction(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Attester Direction</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="attester_Gerant(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Attester Gerant</v-list-item-title>
                                        </v-list-item>


                                  
                                      <v-list-item link @click="printBill(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Imprimer Bon D'Engagement</v-list-item-title>
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

          <!-- fin -->
        </v-card-text>

        <!-- container -->
      </v-card>
    </v-dialog>
  </v-row>
  
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import Depenses from '../Finances/Depenses.vue';
import DetailBonEngagement from './DetailBonEngagement.vue';


export default {
  components: {
    DetailBonEngagement,
    Depenses
  },
  data() {
    return {

      title: "Liste des Etats de Besoin",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refEtatbesoin:"", 
      svData: {
        id: '',
        refProvenance: 0,
        refBloc:0,
        motif: "",
        dateEngagement: "", 
        refCaisse:0,
        refEtatbesoin:"",      
        author: "",

        modepaie: ""
      },
      fetchData: [],
      provenanceList: [],
      blocList: [],
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
    this.fetchListBloc();
    this.get_mode_Paiement();
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
            `${this.apiBaseURL}/insert_bonAngagement`,
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
            `${this.apiBaseURL}/insert_bonAngagement`,
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
      async get_Banque(modepaie) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_banque/${modepaie}`)
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
    valider_Division(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/valider_divison/${this.svData.id}`,
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
    },
    attester_Division(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/attester_divison/${this.svData.id}`,
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
    },
    valider_Tresorerie(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/valider_tresorerie/${this.svData.id}`,
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
    },
    attester_Tresorerie(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/attester_tresorerie/${this.svData.id}`,
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

    },
    valider_Administration(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/valider_administration/${this.svData.id}`,
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
    },
    attester_Administration(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/attester_administration/${this.svData.id}`,
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
    },
    valider_Direction(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/valider_direction/${this.svData.id}`,
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
    },
    attester_Direction(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/attester_direction/${this.svData.id}`,
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
    },
    valider_Gerant(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/valider_gerant/${this.svData.id}`,
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
    },
    attester_Gerant(code) {
      this.isLoading(true);
        this.svData.author = this.userData.name;
        this.svData.id=code;
          this.insertOrUpdate(
            `${this.apiBaseURL}/attester_gerant/${this.svData.id}`,
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
    },

// PARTIE DES COMPOSANTS===================================================================   
 

showDetailBonEngagement(refEntete, provenance) {

  if (refEntete != '') {

    this.$refs.DetailBonEngagement.$data.etatModal = true;
    this.$refs.DetailBonEngagement.$data.refEntete = refEntete;
    this.$refs.DetailBonEngagement.$data.svData.refEntete = refEntete;
    this.$refs.DetailBonEngagement.fetchListSelection();
    this.$refs.DetailBonEngagement.fetchDataList();
    this.fetchDataList();
    
    this.$refs.DetailBonEngagement.$data.titleComponent =
      "Détail Bon d'Engagement pour " + provenance;

  } else {
    this.showError("Personne n'a fait cette action");
  }

},

showDepense(numeroBE, provenance,TotalBE,nom_mode,refCaisse) {

if (numeroBE != '') {

  this.$refs.Depenses.$data.etatModal = true;
  this.$refs.Depenses.$data.numeroBE = numeroBE;
  this.$refs.Depenses.$data.svData.numeroBE = numeroBE;
  this.$refs.Depenses.$data.svData.montant = TotalBE;
  this.$refs.Depenses.$data.montant = TotalBE;

  this.$refs.Depenses.$data.svData.modepaie = nom_mode;
  this.$refs.Depenses.$data.modepaie = nom_mode;

  this.$refs.Depenses.$data.svData.refBanque = refCaisse;
  this.$refs.Depenses.$data.refBanque = refCaisse;

  //this.get_Banque(); 

  this.$refs.Depenses.fetchListSelection();
  this.$refs.Depenses.fetchDataList();
  this.$refs.Depenses.get_Banque(refCaisse);
  this.fetchDataList();
  
  this.$refs.Depenses.$data.titleComponent =
    "Dépense pour " + provenance;

} else {
  this.showError("Personne n'a fait cette action");
}

},

   //id,refProvenance,refBloc,motif,dateEngagement,dateValiderDemandeur,StatutValiderDemandeur,
      //ValiderDemandeur,author

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_bonAngagement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refProvenance = item.refProvenance;
            this.svData.refBloc = item.refBloc;
            this.svData.motif = item.motif;
            this.svData.dateEngagement = item.dateEngagement;
            this.svData.dateValiderDemandeur = item.dateValiderDemandeur;
            this.svData.StatutValiderDemandeur = item.StatutValiderDemandeur;
            this.svData.ValiderDemandeur = item.ValiderDemandeur;
            this.svData.refEtatbesoin = item.refEtatbesoin;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog = true;

          // refEtatbesoin
        }
      );
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bon_engagement?id=` + id);
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_bonAngagement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_bonAngagement?page=`);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_provenance2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.provenanceList = donnees;

        }
      );
    },
    fetchListBloc() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_bloc2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.blocList = donnees;

        }
      );
    },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='ttreso_entete_angagement';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'un bon d'engagement sur service : "+noms+" par l'utilisateur "+user_name+"" ;

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
  
  