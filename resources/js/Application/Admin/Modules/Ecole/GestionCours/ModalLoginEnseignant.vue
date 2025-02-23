<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="600">
            <v-card>
                <!-- form -->
                <v-form ref="form" lazy-validation>
                    <v-card-title>
                        {{ titleComponent }} <v-spacer></v-spacer>
                        <v-btn depressed text small fab @click="dialog = false">
                            <v-icon>close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-layout row wrap>
                            <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">

                                    <v-text-field label="Nom d'utilisateur" outlined dense
                                        v-model="svData.nomUtilisateurEns" prepend-inner-icon="person" required :rules="[
                                            (v) => !!v || 'Ce champ est requis',

                                        ]">
                                    </v-text-field>

                                </div>
                            </v-flex>
                            <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-text-field label="Mot de passe" outlined dense v-model="svData.passwordEns"
                                        prepend-inner-icon="lock" required :rules="[
                                            (v) => !!v || 'Ce champ est requis',
                                            (v) => (v && v.length >= 6) || '6 charactères au maximum',
                                        ]"></v-text-field>

                                </div>
                            </v-flex>
                        </v-layout>



                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog = false">Fermer</v-btn>
                        <v-btn color="rgb(75 119 163)" dark @click="validate">{{
                            edit ? "Modifier" : "Enregistrer"
                        }}</v-btn>
                    </v-card-actions>
                </v-form>
                <!-- in form -->
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
import _ from "lodash";
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            dialog: false,
            loading: false,
            disabled: false,
            svData: {
                id: "",
                nomUtilisateurEns: "",
                passwordEns: "",
            },
            titleComponent: "",
            loading: false,
            edit: true,
        };
    },


    computed: {
        ...mapGetters(["roleList"]),

    },
    methods: {
        ...mapActions(["getRole"]),

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);
                this.insertOrUpdate(
                    `${this.apiBaseURL}/update_login_enseignant`,
                    JSON.stringify(this.svData)
                )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);

                        this.dialog = false;

                        // this.$router.push({name: 'dashboard'});

                        this.$emit('initialisateur');

                    })
                    .catch((err) => {
                        this.svErr(), this.isLoading(false);
                    });
            }
        },

        editData(id) {
            this.editOrFetch(
                `${this.apiBaseURL}/fetch_single_enseignant/${id}`
            ).then(({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "modification des identifiants de " + item.nomEns;
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
            });
        },






    },

    created() {
        this.getRole();

    },



};
</script>
