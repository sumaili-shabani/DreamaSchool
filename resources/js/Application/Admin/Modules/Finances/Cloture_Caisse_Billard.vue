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
                    <v-text-field type="date" label="Date Cloture" prepend-inner-icon="extension" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_cloture"></v-text-field>
                  </div>
                </v-flex>                
                <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="mdi-map" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="compteList" item-text="designation" item-value="id"
                    outlined v-model="svData.refCompte">
                  </v-autocomplete> 



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
                    <th class="text-left">Date</th>
                    <th class="text-left">Montant</th>
                    <th class="text-left">TauxduJour</th>
                    <th class="text-left">SSCompte</th>
                    <th class="text-left">N°SSCompte</th>
                    <th class="text-left">Author</th>
                    <th class="text-left">Mise à jour</th>
                    <!-- <th class="text-left">Action</th> -->
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.date_cloture }}</td>
                    <td>{{ item.montant_cloture }}</td>
                    <td>{{ item.taux_dujour }}</td>
                    <td>{{ item.nom_ssouscompte }}</td>
                    <td>{{ item.numero_ssouscompte }}</td>
                    <td>{{ item.author }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
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
        date_cloture: "",
        refCompte: "",
        author:""
      },
      modeList: [],
      fetchData: null,
      titreModal: "",
      stataData: {
        CompteList: []
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
      this.titleComponent = "Cloture de la Caisse";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.date_cloture;
      } else {
        this.titleComponent = "Ajout Cloture";
      }
    },
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_cloture_caisse?page=`);
      this.fetchListSelection();
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        this.svData.author = this.userData.name;

        this.insertOrUpdate(
          `${this.apiBaseURL}/cloturer_Caisse_billard`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_cloture_caisse/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.date_cloture;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_cloture_caisse/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
  
  fetchListSelection() {
    this.editOrFetch(`${this.apiBaseURL}/fetch_compte_entree`).then(
      ({ data }) => {
        var donnees = data.data;
        this.compteList = donnees;

      }
    );
  },


  },
  created() {
    //this.getRole();
    this.testTitle();
    this.onPageChange();
       
  },
};
</script>