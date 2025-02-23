<template>
  <div>

    <v-layout>
       
       <v-flex md12>
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Ajouter Rubriques <v-spacer></v-spacer>
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

                <v-text-field label="Designation" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.desiRubriq"></v-text-field>

                <v-text-field label="Code Rubrique" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.codeRubriq"></v-text-field>

                <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList" item-text="NomCateRubrique"
                  item-value="id" outlined v-model="svData.refcateRubrik">
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
                  <span>Ajouter Rubrique</span>
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
                        <th class="text-left">CodeRubriqe</th>
                        <th class="text-left">Catégorie</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.desiRubriq }}</td>
                        <td>{{ item.codeRubriq }}</td>
                        <td>{{ item.NomCateRubrique }}</td>
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
                          </v-tooltip> -->

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
        refcateRubrik: 0,
        desiRubriq: "",
        codeRubriq: ""
      },
      fetchData: [],
      categorieList: [],
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
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_rubrique/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_rubrique`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_rubrique/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.desiRubriq = item.desiRubriq;
            this.svData.refcateRubrik = item.refcateRubrik;
            this.svData.codeRubriq = item.codeRubriq;

          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_rubrique/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_rubrique?page=`);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_rubrique2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.categorieList = donnees;

        }
      );
    }

  },
  filters: {

  }
}
</script>
  
  