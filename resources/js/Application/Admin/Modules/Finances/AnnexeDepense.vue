<template>
    <v-row justify="center">
        <v-dialog v-model="etatModal" persistent max-width="900px">
            <v-card>
                <!-- container -->

                <v-card-title class="warning">
                    Les docuements en annexe <v-spacer></v-spacer>
                    <v-btn depressed text small fab @click="etatModal = false" dark>
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <!-- layout -->

                    <div>

                        <v-layout>
                            <!--   -->
                            <v-flex md12>

                                <!-- modal  -->
                                <avatarAvatar ref="avatarAvatar" />
                                <!-- fin modal -->

                                <AvatarProfil ref="avatarPhoto" />

                                <v-dialog v-model="dialog" max-width="400px" persistent>
                                    <v-card :loading="loading">
                                        <v-form ref="form" lazy-validation>
                                            <v-card-title class="warning">
                                                Annexe <v-spacer></v-spacer>
                                                <v-tooltip bottom color="black">
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <span v-bind="attrs" v-on="on">
                                                            <v-btn @click="dialog = false" dark text fab depressed>
                                                                <v-icon>close</v-icon>
                                                            </v-btn>
                                                        </span>
                                                    </template>
                                                    <span>Fermer</span>
                                                </v-tooltip>
                                            </v-card-title>
                                            <v-card-text>
                                                <br />
                                                <v-layout row wrap>

                                                    <v-flex xs12 sm12 md12 lg12>
                                                        <div class="mr-1">
                                                            <v-text-field label="Designation"
                                                                prepend-inner-icon="description" dense
                                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                                v-model="svData.noms_annexe">
                                                            </v-text-field>
                                                        </div>
                                                    </v-flex>

                                                    <v-flex xs12 sm12 md12 lg12>
                                                        <div class="mr-1">
                                                            <input class="form-control" type="file" id="photo_input"
                                                                @change="onImageChange" required />
                                                            <br />
                                                            <img :style="{ height: style.height }" id="output" />
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
                                <v-layout>

                                    <v-flex md12>



                                        <!-- Entete -->
                                        <div class="table-top">
                                            <div class="search-set">
                                                <div class="search-path">


                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-btn :loading="loading" fab text small
                                                                    @click="fetchDataList" class="btn btn-warning"
                                                                    style="margin-right: 6px;">
                                                                    <v-icon>autorenew</v-icon>
                                                                </v-btn>
                                                            </span>
                                                        </template>
                                                        <span>Initialiser</span>
                                                    </v-tooltip>


                                                </div>
                                                <div class="search-input">

                                                    <v-text-field append-icon="search" label="Recherche..." single-line
                                                        outlined dense hide-details v-model="query"
                                                        @keyup="fetchDataList" clearable></v-text-field>

                                                </div>
                                            </div>
                                            <!-- Excel, pdf, print -->
                                            <div class="wordset">
                                                <ul>
                                                    <li>
                                                        <a @click="dialog = true" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="pdf"><img
                                                                :src="`${baseURL}/vuetheme/assets/img/icons/add.svg`"
                                                                alt="img" /></a>
                                                    </li>
                                                    <li>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="excel"><img
                                                                :src="`${baseURL}/vuetheme/assets/img/icons/excel.svg`"
                                                                alt="img" /></a>
                                                    </li>
                                                    <li>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="print"><img
                                                                :src="`${baseURL}/vuetheme/assets/img/icons/printer.svg`"
                                                                alt="img" /></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- Fin Excel, pdf, print -->
                                        </div>
                                        <!-- Fin Entete -->
                                        <br>

                                        <v-card>
                                            <!-- ,'ValeurNormale2','observation2' -->
                                            <v-card-text>
                                                <v-simple-table>
                                                    <template v-slot:default>
                                                        <thead>
                                                            <tr>
                                                                <th class="text-left">N°Opération</th>
                                                                <th class="text-left">Montant</th>
                                                                <th class="text-left">Designation</th>
                                                                <th class="text-left">N°PDF</th>
                                                                <th class="text-left">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="item in fetchData" :key="item.id">
                                                                <td>{{ item.codeOperation }}</td>
                                                                <td>{{ item.montant }}$</td>
                                                                <td>{{ item.noms_annexe }}</td>
                                                                <td>{{ item.annexe }}</td>
                                                                <td>

                                                                    <v-menu bottom rounded offset-y
                                                                        transition="scale-transition">
                                                                        <template v-slot:activator="{ on }">
                                                                            <v-btn icon v-on="on" small fab depressed
                                                                                text>
                                                                                <v-icon>more_vert</v-icon>
                                                                            </v-btn>
                                                                        </template>

                                                                        <v-list dense width="">

                                                                            <v-list-item link
                                                                                @click="printBill(item.annexe)">
                                                                                <v-list-item-icon>
                                                                                    <v-icon
                                                                                        color="blue">mdi-eye</v-icon>
                                                                                </v-list-item-icon>
                                                                                <v-list-item-title
                                                                                    style="margin-left: 5px">Voir
                                                                                    Annexe</v-list-item-title>
                                                                            </v-list-item>

                                                                            <v-list-item link
                                                                                @click="editData(item.id)">
                                                                                <v-list-item-icon>
                                                                                    <v-icon color="  blue">edit</v-icon>
                                                                                </v-list-item-icon>
                                                                                <v-list-item-title
                                                                                    style="margin-left: 5px">Modifier</v-list-item-title>
                                                                            </v-list-item>

                                                                            <v-list-item link
                                                                                @click="deleteData(item.id)">
                                                                                <v-list-item-icon>
                                                                                    <v-icon
                                                                                        color="  red">delete</v-icon>
                                                                                </v-list-item-icon>
                                                                                <v-list-item-title
                                                                                    style="margin-left: 5px">Annuler</v-list-item-title>
                                                                            </v-list-item>

                                                                        </v-list>
                                                                    </v-menu>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </template>
                                                </v-simple-table>
                                                <hr />

                                                <v-pagination color="  blue" v-model="pagination.current"
                                                    :length="pagination.total" @input="fetchDataList"></v-pagination>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>

                                </v-layout>
                            </v-flex>

                        </v-layout>

                    </div>

                    <!-- fin -->
                </v-card-text>

                <!-- container -->
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import AvatarProfil from '../Patients/AvatarProfil.vue';
import avatarAvatar from '../Patients/AvatarAction.vue';
export default {
    components: {
        AvatarProfil,
        avatarAvatar,
    },
    data() {
        return {

            title: "Liste des Details",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,
            etatModal: false,
            titleComponent: '',
            refDepense: 0,
            style: {
                height: "0px",
            },
            //id,noms_annexe,refDepense,sexe,date_naissance,etat_civile,degre_parente,annexe,author
            svData: {
                id: '',
                noms_annexe: '',
                refDepense: 0,
                author: ""
            },
            fetchData: [],
            image: "",
            don: [],
            query: "",

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''

        }
    },
    created() {
        //this.fetchDataList();
    },
    computed: {
        ...mapGetters(["categoryList", "ListeEdition", "isloading"]),
    },
    methods: {

        ...mapActions(["getCategory"]),

        updatePhoto() {
            const config = {
                headers: { "content-type": "multipart/form-data" },
            };

            let formData = new FormData();
            formData.append("data", JSON.stringify(this.svData));
            formData.append("image", this.image);

            if (this.edit == true) {
                this.svData.refDepense = this.refDepense;
                this.svData.author = this.userData.name;
                axios
                    .post(`${this.apiBaseURL}/update_depense_annexe/${this.svData.id}`, formData, config)
                    .then(({ data }) => {
                        this.image = "";
                        this.showMsg(data.data);

                        this.fetchDataList();
                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);

                        this.dialog = false;

                        document.getElementById("photo_input").value = "";
                        document.getElementById("output").src = "";
                    })
                    .catch((err) => this.svErr());
            }
            else {
                this.svData.refDepense = this.refDepense;
                this.svData.author = this.userData.name;
                axios
                    .post(`${this.apiBaseURL}/insert_depense_annexe`, formData, config)
                    .then(({ data }) => {
                        this.image = "";
                        this.showMsg(data.data);

                        this.fetchDataList();
                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.dialog = false;

                        // setTimeout(() => window.location.reload(), 2000);
                        document.getElementById("photo_input").value = "";
                        document.getElementById("output").src = "";
                    })
                    .catch((err) => this.svErr());
            }
        },

        validate() {
            if (this.$refs.form.validate()) {
                // this.isLoading(true);

                if (this.edit) {
                    this.updatePhoto();
                    this.dialog = false;
                } else {
                    this.updatePhoto();
                    this.dialog = false;
                }
            }
        },

        onImageChange(e) {
            this.image = e.target.files[0];
            let output = document.getElementById("output");
            output.src = URL.createObjectURL(e.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src);
                this.style.height = "240px"; // free memory
            };
        },

        printBill(filenamess) {
            window.open(`${this.apiBaseURL}/downloadfile/${filenamess}`);
        },

        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_depense_annexe/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.svData.refDepense = item.refDepense;
                        this.svData.author = item.author;
                        this.svData.noms_annexe = item.noms_annexe;
                    });

                    this.edit = true;
                    this.dialog = true;
                }
            );
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_depense_annexe/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.fetchDataList();
                    }
                );
            });
        },
        fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/fetch_annexe_bydepense/${this.refDepense}?page=`);
            //
        },
        desactiverData(valeurs, user_created, date_entree, noms) {
            //
            var tables = 'tperso_annexe';
            var user_name = this.userData.name;
            var user_id = this.userData.id;
            var detail_information = "Suppression de la fiche des annexes de l'agent : " + noms + " par l'utilisateur " + user_name + "";

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
<style scoped>
.mb-2 {
    margin-top: 10px;
}

.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
}
</style>
