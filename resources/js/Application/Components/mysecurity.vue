<template>
    <div>
        <v-layout row wrap>
            <v-flex md12 xs12 sm12>
                <v-card :loading="loading" flat>
                    <v-form ref="form" lazy-validation>
                        <v-card-text>

                            <v-layout row wrap>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">

                                        <v-text-field label="Entrez votre ancien mot de passe"
                                            prepend-inner-icon="vpn_key" :rules="[(v) => !!v || 'Ce champ est requis']"
                                            outlined dense v-model="svData.password"></v-text-field>

                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">

                                        <v-text-field label="Nouveau mot de passe" prepend-inner-icon="lock"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            v-model="svData.password_nouveau"></v-text-field>



                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">


                                        <v-text-field label="Confirmer le nouveau mot de passe"
                                            prepend-inner-icon="lock" :rules="[(v) => !!v || 'Ce champ est requis']"
                                            outlined dense v-model="svData.password_confirm"></v-text-field>



                                    </div>
                                </v-flex>




                                <v-flex xs12 sm12 md5 lg5></v-flex>

                                <v-flex xs12 sm12 md4 lg4>
                                    <div class="mr-1">

                                        <v-btn color="primary" dark :loading="loading" @click="validate">
                                            {{ edit ? "Modifier Ma Sécurité" : "Ajouter Ma Sécurité" }}
                                        </v-btn>

                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md3 lg3></v-flex>
                            </v-layout>



                        </v-card-text>

                    </v-form>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            title: "Basic",
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",
                name: "",
                email: "",
                password: "",

                password_nouveau: "",
                password_confirm: "",
                // photo: "",
            },
            fetchData: null,
            titreModal: "",
        };
    },
    computed: {
        ...mapGetters(["userList", "isloading"]),
    },
    created() {
        this.editData(this.userData.id);
    },
    methods: {
        ...mapActions(["getUser"]),

        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/showUser/${id}`).then(({ data }) => {
                var donnees = data.data;

                //   donnees.map((item) => {
                //     this.svData.name = item.name;
                //     this.svData.email = item.email;
                //     this.svData.sexe = item.sexe;
                //     this.svData.id_role = item.name;
                //     this.svData.id = item.user_id;
                //     this.titleComponent = "modification de " + item.name;
                //   });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            });
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                if (this.svData.password_nouveau == this.svData.password_confirm) {
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/ChangeMyPasswordSecure`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            //   this.resetObj(this.svData);

                            this.editData(this.userData.id);
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });
                } else {
                    if (this.svData.password_nouveau != this.svData.password_confirm) {
                        this.showError("Les deux mots de passe doivent être identiques");

                        this.isLoading(false);

                    }
                }
            }
        },
    },
};
</script>
