<template>
  <v-layout>
    <!-- <v-flex md2></v-flex> -->
    <v-flex md12>
      <v-flex md12>
        <!-- modal -->
        <v-dialog v-model="dialog" max-width="400px" scrollable transition="dialog-bottom-transition">
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
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

                  <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="Designation" prepend-inner-icon="extension" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_banque"></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="N° Compte Bancaire" prepend-inner-icon="extension" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                      v-model="svData.numerocompte"></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Mode de Paiement" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="modeList" item-text="designation"
                      item-value="designation" dense outlined v-model="svData.nom_mode" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>

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



                </v-layout>

                

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

        <!-- bande -->
        <v-layout>
          <v-flex md1>
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn :loading="loading" fab @click="onPageChange">
                    <v-icon>autorenew</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Initialiser</span>
            </v-tooltip>
          </v-flex>
          <v-flex md6>
            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded hide-details
              v-model="query" @keyup="onPageChange" clearable></v-text-field>
          </v-flex>

          <v-flex md4></v-flex>

          <v-flex md1>
            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="showModal" fab color="  blue" dark>
                    <v-icon>add</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Ajouter une opération</span>
            </v-tooltip>
          </v-flex>
        </v-layout>
        <!-- bande -->

        <br />
        <v-card :loading="loading" :disabled="isloading">
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Designation</th>
                    <th class="text-left">N° Compte</th>
                    <th class="text-left">ModePaie</th>
                    <th class="text-left">SSCompte</th>
                    <th class="text-left">N°SSCompte</th>
                    <th class="text-left">Author</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.nom_banque }}</td>
                    <td>{{ item.numerocompte }}</td>
                    <td>{{ item.nom_mode }}</td>
                    <td>{{ item.nom_ssouscompte }}</td>
                    <td>{{ item.numero_ssouscompte }}</td>
                    <td>{{ item.author }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-tooltip top color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <!-- <v-tooltip top   color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="clearP(item.id)" fab small><v-icon color="  red">delete</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Supprimer</span>
                      </v-tooltip> -->
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <hr />

            <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total" @input="onPageChange"
              :total-visible="7"></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
    <!-- <v-flex md2></v-flex> --> 
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  components: {},
  data() {
    return {
      title: "Pays component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      svData: {
        id: "",
        nom_banque: "",
        numerocompte: "",
        nom_mode: "",
        refCompte: "",
        refSousCompte: "",
        refSscompte: "",
        author:""
      },
      modeList: [],
      fetchData: null,
      titreModal: "",
      stataData: {
        CompteList: [],
        SousCompteList: [],
        SSousCompteList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''
    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Caisse/Banque";
      this.edit = false;
      this.resetObj(this.svData);
    },

    fetchListMode() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_tconf_modepaie_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.modeList = donnees;
        }
      );
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.nom_banque;
      } else {
        this.titleComponent = "Ajout Banque";
      }
    }
    ,

    //   searchMember: _.debounce(function () {
    //     this.onPageChange();
    //   }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_banque?page=`);
      this.fetchListMode();
      this.fetchListCompte();
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        this.svData.author = this.userData.name;

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_banque`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_banque/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.nom_banque;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
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

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_banque/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
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
    },


  },
  created() {
    //this.getRole();
    this.testTitle();
    this.onPageChange();
       
  },
};
</script>