<template>
  <v-layout>
     
     <v-flex md12>
      <v-flex md12>
        <!-- modal -->
        <v-dialog
          v-model="dialog"
          max-width="700px"
          scrollable
          transition="dialog-bottom-transition"
        >
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
                </v-tooltip></v-card-title
              >
              <v-card-text>

                  <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.CompteList" item-text="nom_compte"
                              item-value="id" dense outlined v-model="svData.refCompte" chips clearable
                              @change="get_souscompte_for_compte(svData.refCompte)">
                              </v-autocomplete>
                          </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Sous Compte" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SousCompteList"
                              item-text="nom_souscompte" item-value="id" dense outlined v-model="svData.refSousCompte" clearable
                              chips>
                              </v-autocomplete>
                          </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                      
                          <v-text-field label="Designation SSous Compte" prepend-inner-icon="extension" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_ssouscompte"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                      
                          <v-text-field  label="Numéro SSousCompte" prepend-inner-icon="extension" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numero_ssouscompte"></v-text-field>
                        </div>
                      </v-flex>                   


                  </v-layout>  
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn
                  color="  blue"
                  dark
                  :loading="loading"
                  @click="validate"
                >
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
          <v-flex md5>
            <v-text-field
              append-icon="search"
              label="Recherche..."
              single-line
              solo
              outlined
              rounded
              hide-details
              v-model="query"
              @keyup="onPageChange"
              clearable
            ></v-text-field>
          </v-flex>

          <v-flex md5></v-flex>

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
                    <th class="text-left">N°SSCompte</th>
                    <th class="text-left">Souscompte</th>
                    <th class="text-left">Compte</th>
                    <th class="text-left">Classe</th>
                    <th class="text-left">TypeCompte</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.nom_ssouscompte }}</td>
                    <td>{{ item.numero_ssouscompte }}</td>
                    <td>{{ item.nom_souscompte }}</td>
                    <td>{{ item.nom_compte }} </td>                   
                    <td>{{ item.nom_classe }}</td>
                    <td>{{ item.nom_typecompte }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-tooltip top    color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small
                              ><v-icon color="  blue">edit</v-icon></v-btn
                            >
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <!-- <v-tooltip top   color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="clearP(item.id)" fab small
                              ><v-icon color="  red">delete</v-icon></v-btn
                            >
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

            <v-pagination
              color="  blue"
              v-model="pagination.current"
              :length="pagination.total"
              :total-visible="7"
              @input="onPageChange"
            ></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
     
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
        //'id','refSousCompte','nom_ssouscompte','numero_ssouscompte','author',refCompte
        svData: {
          id: "",
          refCompte: "",
          refSousCompte: "",
          nom_ssouscompte: "",
          numero_ssouscompte:"",
          author:""
        },
        
        fetchData: null,
        titreModal: "",
        stataData: {
          CompteList: [],
          SousCompteList: []
        },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''
  
      };
    },
    methods: {
     showModal() {
        this.dialog = true;
        this.titleComponent = "Ajout SSous Compte";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification ";
        } else {
          this.titleComponent = "Ajout SSous Compte ";
        }
      },

      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_ssouscomptefin?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_ssouscomptefin`,
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
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_ssouscompte/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.nom_ssouscompte;
              this.get_souscompte_for_compte(item.refCompte);
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_ssouscomptefin/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.CompteList = donnees;
  
          }
        );
      }
      ,
//TubeList
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
  
  
  
    },
    created() {
      this.fetchListSelection();
      this.testTitle();
      this.onPageChange();  
            

    },
  };
  </script>