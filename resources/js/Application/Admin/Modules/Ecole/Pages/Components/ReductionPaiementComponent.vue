<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="500">
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

                                    <v-text-field label="Pourcentage(%)" type="number" min="0" prepend-inner-icon="payments"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                        v-model="svData.reductionPaiement"></v-text-field>

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
                reductionPaiement: "",
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
                    `${this.apiBaseURL}/updateReductionPaiement`,
                    JSON.stringify(this.svData)
                )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.$emit('initialisateur');

                        this.dialog = false;
                    })
                    .catch((err) => {
                        this.isLoading(false);
                    });
            }
        },
        editData(id) {
            this.editOrFetch(
                `${this.apiBaseURL}/fetch_single_inscription/${id}`
            ).then(({ data }) => {
                var donnees = data.data;

                donnees.map((item) => {
                    this.titleComponent = "Reduction de paiement de " + item.nomEleve + "-" + item.postNomEleve;

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
