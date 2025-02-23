<template>

    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="400px" transition="dialog-bottom-transition">
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
                        <v-text-field
                            label="Nom complèt"
                            prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            outlined dense
                            v-model="svData.noms"
                        ></v-text-field>

                        <v-text-field
                            label="Adresse complète"
                            prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            outlined dense
                            v-model="svData.adresse"
                        ></v-text-field>

                        <v-text-field
                            label="Téléphone"
                            prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            outlined dense
                            v-model="svData.contact"
                        ></v-text-field>

                        <v-text-field
                            label="E-mail"
                            prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            outlined dense
                            v-model="svData.mail"
                        ></v-text-field>


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
                <!-- component -->
                <!-- fin component -->
            </v-flex>
        </v-layout>
        <!-- Fin contenu -->

        <!-- debit -->
        <div class="page-header">
            <div class="page-title">
                <h4>Liste des Fournisseurs</h4>
                <h6>Gérez les opérations</h6>
            </div>
            <div class="page-btn">
                <a href="javascript:void(0);" @click="showModal" class="btn btn-added" style="color: white;">
                    <img :src="`${baseURL}/vuetheme/assets/img/icons/plus.svg`" class="me-2" alt="img" />
                    Ajouter
                </a>
            </div>
        </div>

        <!-- card -->
        <div class="card">
            <div class="card-body">
                <!-- Entete -->
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">


                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn :loading="loading" fab text small @click="onPageChange"
                                            class="btn btn-warning" style="margin-right: 6px;">
                                            <v-icon>autorenew</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Initialiser</span>
                            </v-tooltip>


                        </div>
                        <div class="search-input">

                            <v-text-field append-icon="search" label="Recherche..." single-line outlined dense
                                hide-details v-model="query" @keyup="searchMember" clearable></v-text-field>

                        </div>
                    </div>
                    <!-- Excel, pdf, print -->
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/pdf.svg`" alt="img" /></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/excel.svg`" alt="img" /></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/printer.svg`" alt="img" /></a>
                            </li>
                        </ul>
                    </div>
                    <!-- Fin Excel, pdf, print -->
                </div>
                <!-- Fin Entete -->

                <!-- tableau -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">Nom Complet</th>
                                <th class="text-left">Téléphone</th>
                                <th class="text-left">E-mail</th>
                                <th class="text-left">Adresse</th>
                                <!-- <th class="text-left">Author</th> -->
                                <th class="text-left">Mise à jour</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms }}</td>
                                <td>{{ item.contact }}</td>
                                <td>{{ item.mail }}</td>
                                <td>{{ item.adresse }}</td>
                                <!-- <td>{{ item.author }}</td>                       -->
                                <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                </td>


                                <td>
                                    <a class="me-3" href="javascript:void(0);" @click="editData(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/edit.svg`" alt="img" />
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);" @click="clearP(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/delete.svg`" alt="img" />
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- fin tableau -->
                <!-- pagination -->
                <div class="col-md-12 text-center">
                    <v-pagination color="primary" v-model="pagination.current" :length="pagination.total"
                        @input="onPageChange" :total-visible="7"></v-pagination>
                </div>
                <!-- fin pagination -->
            </div>
        </div>
        <!-- fin card -->

    </div>








  </template>
  <script>
    //id','noms','contact','mail','adresse','author'
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
          noms: "",
          contact: "",
          mail: "",
          adresse: "",
          author: "admin",
        },
        fetchData: null,
        titreModal: "",

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
        this.titleComponent = "Ajouter Fournisseur ";
        this.edit = false;
        this.resetObj(this.svData);
      },

      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "Modification de " + item.noms;
        } else {
          this.titleComponent = "Ajout Fournisseur ";
        }
      }
      ,

      searchMember: _.debounce(function () {
        this.onPageChange();
      }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_fournisseur?page=`);
      },

      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);

          this.svData.author=this.userData.name;

          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_fournisseur`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_fournisseur/${id}`).then(
          ({ data }) => {
            var donnees = data.data;

            donnees.map((item) => {
              this.titleComponent = "modification de " + item.noms;
            });

            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },

      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_fournisseur/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },


    },
    created() {

      this.testTitle();
      this.onPageChange();
    },
  };
  </script>
