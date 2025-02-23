<template>
  <div>

    <v-layout>
       
       <v-flex md12>
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Ajouter Compte<v-spacer></v-spacer>
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
                  v-model="svData.nom_compte"></v-text-field>
                
                <v-text-field label="Numéro Compte" prepend-inner-icon="extension" dense :rules="[(v) => !!v || 'Ce champ est requis']"
                  outlined v-model="svData.numero_compte"></v-text-field>
            
                <v-autocomplete label="Selectionnez la Classe" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="classeList" item-text="nom_classe" item-value="id"
                  outlined v-model="svData.refClasse">
                </v-autocomplete>
                
                <v-autocomplete label="Selectionnez le Type Compte" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="typecompteList" item-text="nom_typecompte" item-value="id"
                  outlined v-model="svData.refTypecompte">
                </v-autocomplete>

                <v-autocomplete label="Selectionnez la Position" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="positionList" item-text="nom_typeposition" item-value="id"
                  outlined v-model="svData.refPosition">
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
                  <span>Ajouter un Catégorie Examen</span>
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
                        <th class="text-left">NuméroCompte</th>
                        <th class="text-left">Classe</th>  
                        <th class="text-left">TypeCompte</th>
                        <th class="text-left">TypePosition</th>                        
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.nom_compte }}</td>
                        <td>{{ item.numero_compte }}</td>
                        <td>{{ item.nom_classe }}</td> 
                        <td>{{ item.nom_typecompte }}</td>
                        <td>{{ item.nom_typeposition }}</td>                         
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
      svData: {
        id: '',
        refClasse: 0,
        refTypecompte:0,
        refPosition:0,          
        nom_compte: "",
        numero_compte:"",          
        author:"Admin"           
      },
      fetchData: [],
      classeList: [],
      typecompteList: [],
      positionList: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
    this.fetchDataList();
    this.fetchListClasse();
    this.fetchListTypeCompte();
    this.fetchListPosition(); 
            
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
            `${this.apiBaseURL}/update_comptefin/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_comptefin`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_compte/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.nom_compte = item.nom_compte;
            this.svData.numero_compte = item.numero_compte;             
            this.svData.refClasse = item.refClasse;
            this.svData.refTypecompte = item.refTypecompte;
            this.svData.refPosition = item.refPosition;  
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
        this.delGlobal(`${this.apiBaseURL}/delete_comptefin/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_comptefin?page=`);
    },  
    fetchListClasse() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_classe_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.classeList = donnees;

        }
      );
    },  
    fetchListTypeCompte() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_typecompte_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typecompteList = donnees;

        }
      );
    },  
    fetchListPosition() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_typeposition_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.positionList = donnees;  
        }
      );
    }  

  },
  filters: {

  }
}
</script>

