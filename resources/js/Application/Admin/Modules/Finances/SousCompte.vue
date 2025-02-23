<template>
  <div>

    <v-layout>
       
       <v-flex md12>
        <v-dialog v-model="dialog" max-width="500px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Ajouter Sous Compte<v-spacer></v-spacer>
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

                <v-text-field label="Designation" prepend-inner-icon="extension" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                  v-model="svData.nom_souscompte"></v-text-field>
                
                <v-text-field label="Numéro SousCompte" prepend-inner-icon="extension" dense :rules="[(v) => !!v || 'Ce champ est requis']"
                  outlined v-model="svData.numero_souscompte"></v-text-field>
            
                <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="compteList" item-text="nom_compte" item-value="id"
                  outlined v-model="svData.refCompte">
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
                  <span>Ajouter un SousCompte</span>
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
                        <th class="text-left">NuméroScompte</th>
                        <th class="text-left">Compte</th> 
                        <th class="text-left">Classe</th>
                        <th class="text-left">TypeCompte</th>                         
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.nom_souscompte }}</td>
                        <td>{{ item.numero_souscompte }}</td>
                        <td>{{ item.nom_compte }}</td> 
                        <td>{{ item.nom_classe }}</td> 
                        <td>{{ item.nom_typecompte }}</td>                          
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
                          </v-tooltip>                            -->
                         
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

      title: "Liste des Produits",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //'id','refCompte','nom_souscompte','numero_souscompte','author'
      svData: {
        id: '',
        refCompte: 0,          
        nom_souscompte: "",
        numero_souscompte:"",          
        author:"Admin"           
      },
      fetchData: [],
      compteList: [],
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
            `${this.apiBaseURL}/update_souscomptefin/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_souscomptefin`,
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

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_souscompte/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.nom_souscompte = item.nom_souscompte;  
            this.svData.numero_souscompte = item.numero_souscompte;           
            this.svData.refCompte = item.refCompte;  
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
        this.delGlobal(`${this.apiBaseURL}/delete_souscomptefin/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_souscomptefin?page=`);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.compteList = donnees;
//
        }
      );
    }  

  },
  filters: {

  }
}
</script>

