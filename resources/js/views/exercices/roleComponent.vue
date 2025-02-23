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
            <v-select
              label="Privilège"
              :rules="[(v) => !!v || 'Ce champ est requis']"
              :items="roleList"
              item-text="role_name"
              item-value="id"
              outlined
              v-model="svData.id_role"
            >
            </v-select>

            <v-text-field
              label="Mot de passe"
              outlined
              dense
              v-model="svData.password"
              prepend-inner-icon="lock"
              required
              :rules="[
                (v) => !!v || 'Ce champ est requis',
                (v) => (v && v.length >= 6) || '6 charactères au maximum',
              ]"
            ></v-text-field>
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
        password: "",
        id_role: null,
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
          `${this.apiBaseURL}/change_pwd_user`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);

            this.dialog = false;

            // this.$router.push({name: 'dashboard'});

          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },





  },

  created() {
      this.getRole();

  },



};
</script>
