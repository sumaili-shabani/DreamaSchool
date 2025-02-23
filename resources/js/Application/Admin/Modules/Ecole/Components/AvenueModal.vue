<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="400">
      <v-card>
        <!-- form -->
        <v-form ref="form" lazy-validation>
          <v-card-title>
            Ajout d'une avenue <v-spacer></v-spacer>
            <v-btn depressed text small fab @click="dialog = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-layout row wrap>
              <v-flex xs12 sm12 md12 lg12>
                <div class="mr-1">
                  <v-text-field
                    label="Nom de l'avenue"
                    prepend-inner-icon="extension"
                    :rules="[(v) => !!v || 'Ce champ est requis']"
                    outlined
                    dense
                    v-model="svData.nomAvenue"
                  ></v-text-field>
                </div>
              </v-flex>
            </v-layout>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn depressed text @click="dialog = false">Fermer</v-btn>
            <v-btn color="rgb(75 119 163)" dark @click="validate">{{
              edit ? "Modifier" : "Ajouter"
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
      idQuartier: "",
      svData: {
        id: "",
        idQuartier: "",
        nomAvenue: "",
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

        if (this.svData.idQuartier == "") {
          this.svData.idQuartier = this.idQuartier;
        } else {
          this.svData.idQuartier = this.idQuartier;
        }

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_avenue`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);

            this.dialog = false;

            this.$emit("initialisateur");
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
  },

  created() {},
};
</script>
