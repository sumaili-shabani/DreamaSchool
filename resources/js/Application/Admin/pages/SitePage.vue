<template>

    <div>

        <!-- contenu -->
        <v-layout row wrap>
            <v-flex xs12 sm12 md12 lg12>
                <!-- modal -->
                <v-dialog v-model="dialog" hide-overlay transition="dialog-bottom-transition" persistent
                    max-width="700px">
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
                            <v-card-text max-height="1000px">
                                <v-layout row wrap>
                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Nom" prepend-inner-icon="person"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.nom"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Email" prepend-inner-icon="email" :rules="[
                                                (v) => !!v || 'Ce champ est requis',
                                                (v) =>
                                                    /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                                            ]" outlined dense v-model="svData.email"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md12 sm12 lg12>
                                        <div class="mr-1">
                                            <v-textarea label="Description" rows="1"
                                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                                prepend-inner-icon="mdi-comment" outlined dense
                                                v-model="svData.description"></v-textarea>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Adresse" prepend-inner-icon="person"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.adresse"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="N° de Téléphone principal"
                                                prepend-inner-icon="phone_iphone"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.tel1"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="N° de Téléphone" prepend-inner-icon="phone_iphone"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.tel2"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="N° de Téléphone des sms API"
                                                prepend-inner-icon="phone_iphone"
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                                v-model="svData.tel3"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Token" prepend-inner-icon="token" outlined dense
                                                v-model="svData.token"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Facebook" prepend-inner-icon="travel_explore" outlined dense
                                                v-model="svData.facebook"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Twitter" prepend-inner-icon="travel_explore" outlined dense
                                                v-model="svData.twitter"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md6 sm6 lg6>
                                        <div class="mr-1">
                                            <v-text-field label="Linkedin" prepend-inner-icon="travel_explore" outlined dense
                                                v-model="svData.linkedin"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md12 sm12 lg12>
                                        <div class="mr-1">
                                            <v-text-field label="Youtube" prepend-inner-icon="travel_explore" outlined dense
                                                v-model="svData.youtube"></v-text-field>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md12 sm12 lg12>
                                        <div class="mr-1">
                                            <v-textarea label="Mission" rows="1" prepend-inner-icon="open_in_new"
                                                outlined dense v-model="svData.mission"></v-textarea>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md12 sm12 lg12>
                                        <div class="mr-1">
                                            <v-textarea label="Objectif" rows="1" prepend-inner-icon="open_in_new"
                                                outlined dense v-model="svData.objectif"></v-textarea>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md12 sm12 lg12>
                                        <div class="mr-1">
                                            <v-textarea label="Politique de confidentialité" rows="1"
                                                prepend-inner-icon="open_in_new" outlined dense
                                                v-model="svData.politique"></v-textarea>
                                        </div>
                                    </v-flex>

                                    <v-flex xs12 md12 sm12 lg12>
                                        <div class="mr-1">
                                            <v-textarea label="Condition d'utilisation" rows="1"
                                                prepend-inner-icon="open_in_new" outlined dense
                                                v-model="svData.condition"></v-textarea>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                                <v-btn color="primary" dark :loading="loading" @click="validate">
                                    {{ edit ? "Modifier" : "Ajouter" }}
                                </v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-dialog>
                <br /><br />
                <!-- fin modal -->
                <uploadImage ref="uploadImage" v-on:initialisateur="initialisateur" />
                <!-- component -->
                <!-- fin component -->

            </v-flex>
        </v-layout>
        <!-- Fin contenu -->

        <!-- debit -->
        <div class="page-header">
            <div class="page-title">
                <h4>Paramètrage de site</h4>
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
                                <th class="text-left">Avatar</th>
                                <th class="text-left">Nom</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Description</th>
                                <th class="text-left">Adresse</th>
                                <th class="text-left">Téléphone</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>

                                    <!-- image -->
                                    <img style="border-radius: 50px; width: 50px; height: 50px" :src="item.logo == null
                                        ? `${baseURL}/images/avatar.png`
                                        : `${baseURL}/images/` + item.logo
                                        " />
                                    <!-- images -->
                                </td>
                                <td>{{ item.nom | subStrLong2 }}</td>
                                <td>{{ item.email | subStrLong2 }}</td>
                                <td>{{ item.description | subStrLong2 }}</td>
                                <td>{{ item.adresse | subStrLong2 }}</td>
                                <td>{{ item.tel1 | subStrLong2 }}</td>
                                <td>
                                    <a class="me-3" href="javascript:void(0);" @click="editData(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/edit.svg`" alt="img" />
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);" @click="clearP(item.id)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/delete.svg`" alt="img" />
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);" @click="showPhotoModal(item.id, item.logo)">
                                        <img :src="`${baseURL}/vuetheme/assets/img/icons/photo_camera.svg`" alt="img" />
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- fin tableau -->
                <!-- pagination -->
                <div class="col-md-12 text-center">
                    <v-pagination color="primary" v-model="pagination.current" :length="pagination.total" :total-visible="7"
                        @input="onPageChange"></v-pagination>
                </div>
                <!-- fin pagination -->
            </div>
        </div>
        <!-- fin card -->
    </div>




</template>

<script>
import { mapGetters, mapActions } from "vuex";
import uploadImage from "../Components/logo_site.vue";


export default {
    components: {
        uploadImage,
    },
    data() {
        return {
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",
                nom: "",
                email: "",
                description: "",
                adresse: "",

                token: "",
                tel1: "",
                tel2: "",
                tel3: "",
                about: "",
                mission: "",
                objectif: "",
                politique: "",
                condition: "",
                facebook: "",
                linkedin: "",
                twitter: "",
                youtube: "",
            },
            fetchData: null,
            titreModal: "",
        };
    },

    computed: {
        ...mapGetters(["userList", "isloading"]),
    },
    methods: {
        ...mapActions(["getUser"]),

        showPhotoModal(id, avatar) {
            this.$refs.uploadImage.$data.dialog = true;
            this.$refs.uploadImage.$data.svData.agentId = id;
            this.$refs.uploadImage.$data.image = avatar;
        },

        showModal() {
            this.dialog = true;
            this.titleComponent = "Configuration site ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification du site ";
            } else {
                this.titleComponent = "Configuration site ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_site?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_site`,
                    JSON.stringify(this.svData)
                )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.getSite();
                        this.onPageChange();

                        this.dialog = false;
                    })
                    .catch((err) => {
                        this.isLoading(false);
                    });
            }
        },
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_site/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.titleComponent = "modification du site ";
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_site/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        initialisateur() {
            this.onPageChange();
        }
    },
    created() {
        this.onPageChange();
    },
};
</script>
