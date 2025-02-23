<template>
  <div>
    <!-- user -->

    <!-- contenu -->
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12>
        <!-- modal -->
        <v-dialog v-model="dialog" max-width="600px" persistent>
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
                  <v-flex xs12 sm12 lg12 md12>
                    <div
                      class="alert alert-warning alert-dismissible fade show"
                      role="alert"
                    >
                      <strong>Attention!</strong> L'adresse mail doit être
                      unique
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                      ></button>
                    </div>
                  </v-flex>

                  <v-flex xs12 md6 sm6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Nom"
                        prepend-inner-icon="person"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.name"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 md6 sm6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Email"
                        prepend-inner-icon="email"
                        :rules="[
                          (v) => !!v || 'Ce champ est requis',
                          (v) =>
                            /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                        ]"
                        outlined
                        dense
                        v-model="svData.email"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 md12 sm12 lg12>
                    <div class="mr-1">
                      <v-select
                        :items="[{ designation: 'M' }, { designation: 'F' }]"
                        label="Sexe"
                        prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        item-text="designation"
                        item-value="designation"
                        v-model="svData.sexe"
                      ></v-select>
                    </div>
                  </v-flex>

                  <v-flex xs12 md6 sm6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Téléphone"
                        prepend-inner-icon="phone_iphone"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.telephone"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 md6 sm6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Adresse domicile"
                        prepend-inner-icon="location_on"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.adresse"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 md12 sm12 lg12 v-if="edit == false">
                    <div class="mr-1">
                      <v-text-field
                        label="Mot de passe"
                        prepend-inner-icon="lock"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.password"
                      ></v-text-field>
                    </div>
                  </v-flex>
                </v-layout>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn
                  color="primary"
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
        <ImageUserComponent
          ref="ImageUserComponent"
          v-on:initialisateur="initialisateur"
        />
        <AttributionRoleComponent
          ref="AttributionRoleComponent"
          v-on:initialisateur="initialisateur"
        />
        <!-- fin component -->
      </v-flex>
    </v-layout>
    <!-- Fin contenu -->

    <!-- debit -->
    <div class="page-header">
      <div class="page-title">
        <h4>Liste des utilisateurs</h4>
        <h6>Gérez les opérations</h6>
      </div>
      <div class="page-btn">
        <a
          href="javascript:void(0);"
          @click="showModal"
          class="btn btn-added"
          style="color: white"
        >
          <img
            :src="`${baseURL}/vuetheme/assets/img/icons/plus.svg`"
            class="me-2"
            alt="img"
          />
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
                    <v-btn
                      :loading="loading"
                      fab
                      text
                      small
                      @click="onPageChange"
                      class="btn btn-warning"
                      style="margin-right: 6px"
                    >
                      <v-icon>autorenew</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Initialiser</span>
              </v-tooltip>
            </div>
            <div class="search-input">
              <v-text-field
                append-icon="search"
                label="Recherche..."
                single-line
                outlined
                dense
                hide-details
                v-model="query"
                @keyup="searchMember"
                clearable
              ></v-text-field>
            </div>
          </div>
          <!-- Excel, pdf, print -->
          <div class="wordset">
            <ul>
              <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"
                  ><img
                    :src="`${baseURL}/vuetheme/assets/img/icons/pdf.svg`"
                    alt="img"
                /></a>
              </li>
              <li>
                <a
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="excel"
                  ><img
                    :src="`${baseURL}/vuetheme/assets/img/icons/excel.svg`"
                    alt="img"
                /></a>
              </li>
              <li>
                <a
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="print"
                  ><img
                    :src="`${baseURL}/vuetheme/assets/img/icons/printer.svg`"
                    alt="img"
                /></a>
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
                <th class="text-left">Sexe</th>
                <th class="text-left">Etat</th>
                <th class="text-left">Privilège</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in fetchData" :key="item.user_id">
                <td>
                  <!-- image -->
                  <img
                    style="border-radius: 50px; width: 50px; height: 50px"
                    :src="
                      item.avatar == null
                        ? `${baseURL}/images/avatar.png`
                        : `${baseURL}/images/` + item.avatar
                    "
                  />
                  <!-- images -->
                </td>
                <td>{{ item.name | subStrLong2 }}</td>
                <td>{{ item.email | subStrLong2 }}</td>
                <td>{{ item.sexe | subStrLong }}</td>
                <td>
                  <div
                    class="status-toggle d-flex justify-content-between align-items-center"
                    v-if="item.active == 1"
                  >
                    <input
                      type="checkbox"
                      id="user4"
                      class="check"
                      checked=""
                      @change="operationEtat(item.user_id, item.active)"
                    />
                    <label for="user4" class="checktoggle">
                      {{ item.active == 1 ? "Actif " : "Inactif" }}</label
                    >
                  </div>

                  <div
                    class="status-toggle d-flex justify-content-between align-items-center"
                    v-if="item.active == 0"
                  >
                    <input
                      type="checkbox"
                      id="user5"
                      class="check"
                      @change="operationEtat(item.user_id, item.active)"
                    />
                    <label for="user5" class="checktoggle">{{
                      item.active == 1 ? "Actif " : "Inactif"
                    }}</label>
                  </div>
                </td>
                <td>
                  <span
                    style="height: 25px"
                    :class="
                      item.id_role == 1 ||
                      item.id_role == 3 ||
                      item.id_role == 10
                        ? 'badges bg-lightgreen'
                        : item.id_role == 4 || item.id_role == 5
                        ? 'badges bg-lightprimary'
                        : item.id_role == 6 || item.id_role == 12
                        ? 'badges bg-lightindigo'
                        : item.id_role == 7 || item.id_role == 11
                        ? 'badges bg-lightinfo'
                        : item.id_role == 8
                        ? 'badges bg-lightgreen'
                        : item.id_role == 9 || item.id_role == 13
                        ? 'badges bg-lightorange'
                        : 'badges bg-lightred'
                    "
                  >
                    {{ item.role_name | subStrLong2 }}
                  </span>
                </td>
                <td>
                  <a
                    class="me-3"
                    href="javascript:void(0);"
                    @click="editData(item.user_id)"
                  >
                    <img
                      :src="`${baseURL}/vuetheme/assets/img/icons/edit.svg`"
                      alt="img"
                    />
                  </a>
                  <a
                    class="me-3 confirm-text"
                    href="javascript:void(0);"
                    @click="clearP(item.user_id)"
                  >
                    <img
                      :src="`${baseURL}/vuetheme/assets/img/icons/delete.svg`"
                      alt="img"
                    />
                  </a>

                  <a
                    class="me-3 confirm-text"
                    href="javascript:void(0);"
                    @click="
                      showRoleModal(item.user_id, item.name, item.id_role)
                    "
                  >
                    <img
                      :src="`${baseURL}/vuetheme/assets/img/icons/lock.svg`"
                      alt="img"
                    />
                  </a>

                  <a
                    class="me-3 confirm-text"
                    href="javascript:void(0);"
                    @click="showPhotoModal(item.user_id, item.avatar)"
                  >
                    <img
                      :src="`${baseURL}/vuetheme/assets/img/icons/photo_camera.svg`"
                      alt="img"
                    />
                  </a>

                  <a
                    class="me-3"
                    href="javascript:void(0);"
                    @click="printBill(item.user_id)"
                  >
                    <img
                      :src="`${baseURL}/vuetheme/assets/img/icons/printer.svg`"
                      alt="img"
                    />
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- fin tableau -->
        <!-- pagination -->
        <div class="col-md-12 text-center">
          <v-pagination
            color="primary"
            v-model="pagination.current"
            :length="pagination.total"
            :total-visible="7"
            @input="onPageChange"
          ></v-pagination>
        </div>
        <!-- fin pagination -->
      </div>
    </div>
    <!-- fin card -->
    <!-- fin -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import AttributionRoleComponent from "../Components/AttributionRoleComponent.vue";
import ImageUserComponent from "../Components/ImageUserComponent.vue";

export default {
  components: {
    ImageUserComponent,
    AttributionRoleComponent,
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
        name: "",
        email: "",
        password: "",
        telephone: "",
        adresse: "",
        // photo: "",
        sexe: "",
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
      this.$refs.ImageUserComponent.$data.dialog = true;
      this.$refs.ImageUserComponent.$data.svData.agentId = id;
      this.$refs.ImageUserComponent.$data.image = avatar;
    },
    showRoleModal(id, name, id_role) {
      this.$refs.AttributionRoleComponent.$data.dialog = true;
      this.$refs.AttributionRoleComponent.$data.svData.id = id;
      this.$refs.AttributionRoleComponent.$data.svData.id_role = id_role;

      this.$refs.AttributionRoleComponent.$data.titleComponent =
        "modification de privilègle de: " + name;
    },
    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout utilisateur ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.name;
      } else {
        this.titleComponent = "Ajout utilisateur ";
      }
    },

    searchMember: _.debounce(function () {
      this.onPageChange();
    }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_user?page=`);
    },

    initialisateur() {
      this.onPageChange();
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        if (this.edit) {
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_user`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.getUser();
              this.onPageChange();

              this.dialog = false;
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        } else {
          this.insertOrUpdate(
            `${this.baseURL}/register_count`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.getUser();
              this.onPageChange();

              this.dialog = false;
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        }
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_user/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.id = item.user_id;
            this.titleComponent = "modification de " + item.name;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_user/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },

    operationEtat(id, etat) {
      if (id != "" && etat != "") {
        // alert("id:"+id+" etat:"+etat);

        this.confirmEtat().then(({ res }) => {
          this.delGlobal(
            `${this.apiBaseURL}/checkEtat_compte/${id}/${etat}`
          ).then(({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          });
        });
      } else {
        this.confirmEtat().then(({ res }) => {
          this.delGlobal(
            `${this.apiBaseURL}/checkEtat_compte/${id}/${etat}`
          ).then(({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          });
        });
      }
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/print_bill?id_user=` + id);
    },

    editTitleModal(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_user/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.titleComponent = "modification de " + item.name;
          });
        }
      );
    },
  },
  created() {
    this.getUser();
    this.testTitle();
    this.onPageChange();
  },
};
</script>
