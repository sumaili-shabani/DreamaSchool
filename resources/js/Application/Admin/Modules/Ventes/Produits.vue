<template>

    <div>
        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="600px" persistent>
                    <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                        <v-card-title>
                        Ajouter Produit <v-spacer></v-spacer>
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

                        <v-layout row wrap>
                            <v-flex xs12 sm12 xl12 md12>
                                <div class="mr-1">

                                    <v-text-field
                                        label="Designation"
                                        prepend-inner-icon="edit_note"
                                        :rules="[(v) => !!v || 'Ce champ est requis']"
                                        outlined dense
                                        v-model="svData.designation"
                                    ></v-text-field>

                                </div>
                            </v-flex>


                            <v-flex xs12 sm12 xl12 md12>
                                <div class="mr-1">

                                    <v-text-field type="number" label="Prix Unitaire" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pu">
                                    </v-text-field>

                                </div>
                            </v-flex>

                            <v-flex xs12 sm12 xl12 md12>
                                <div class="mr-1">

                                    <v-autocomplete label="Devise" :items="[
                                    { designation: 'USD' },
                                    { designation: 'FC' },
                                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                    item-text="designation" item-value="designation"
                                    v-model="svData.devise" ></v-autocomplete>

                                </div>
                            </v-flex>

                            <v-flex xs12 sm12 xl12 md6>
                                <div class="mr-1">

                                    <v-text-field type="number" label="Nmbre de pièce par paquet" prepend-inner-icon="extension" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qte_unite">
                                    </v-text-field>

                                </div>
                            </v-flex>

                            <v-flex xs12 sm12 xl12 md6>
                                <div class="mr-1">


                                    <v-autocomplete label="Unité(Paquet ou Produit)" :items="[
                                        { designation: 'Pièce' },
                                        { designation: 'Kg' },
                                        { designation: 'Paquet' },
                                    ]" prepend-inner-icon="extension"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                        item-text="designation" item-value="designation"
                                        v-model="svData.unite">
                                    </v-autocomplete>





                                </div>

                            </v-flex>

                            <v-flex xs12 sm12 xl12 md12>
                                <div class="mr-1">

                                    <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="category" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="CatProduct" item-text="designation" item-value="id"
                                        outlined v-model="svData.refCategorie">
                                    </v-autocomplete>

                                </div>
                            </v-flex>

                        </v-layout>



                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                        <v-btn color="blue" dark :loading="loading" @click="validate">
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
                <h4>Liste des produits</h4>
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
                                <th class="text-left">Designation</th>
                                <th class="text-left">Catégorie</th>
                                <th class="text-left">PU</th>
                                <th class="text-left">Devise</th>
                                <th class="text-left">Qté</th>
                                <th class="text-left">NbrPièce</th>
                                <th class="text-left">Unité</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.designation }}</td>
                                <td>{{ item.Categorie }}</td>
                                <td>{{ item.pu}}</td>
                                <td>{{ item.devise}}</td>
                                <td>{{ item.qte}}</td>
                                <td>{{ item.qte_unite}}</td>
                                <td>{{ item.unite}}</td>

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
          refCategorie: 0,
          designationCategorie: "",
          designation: "",
          pu: 0,
          qte_unite: 0,
          devise:"",
          unite: "",
          author:"Admin"
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

      this.onPageChange();
      this.getCategory();
    },
    computed: {
      ...mapGetters(["CatProduct", "isloading"]),
    },
    methods: {

        ...mapActions(["getCategory"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Catégorie Produit ";
            this.edit = false;
            this.resetObj(this.svData);
            this.svData.unite ="Pièce";
        },

        validate() {
            if (this.$refs.form.validate()) {
            this.isLoading(true);
                if (this.edit) {
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_produit`,
                    JSON.stringify(this.svData)
                    )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.dialog = false;
                        this.resetObj(this.svData);
                        this.onPageChange();
                    })
                    .catch((err) => {
                        this.svErr(), this.isLoading(false);
                    });

                }
                else {
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_produit`,
                    JSON.stringify(this.svData)
                    )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.dialog = false;
                        this.resetObj(this.svData);
                        this.onPageChange();
                    })
                    .catch((err) => {
                        this.svErr(), this.isLoading(false);
                    });
                }

            }
        },



        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_produit/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {
                        this.titleComponent = "modification de " + item.designation;
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_produit/${id}`).then(
                ({ data }) => {
                this.showMsg(data.data);
                this.onPageChange();
                }
            );
            });
        },
        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),

        onPageChange(){
            this.fetch_data(`${this.apiBaseURL}/fetch_produit?page=`);
        },



    },
    filters: {

    }
  }
  </script>

