<template>
    <div>

        <div class="main-wrapper">
            <div class="account-content">
                <div class="login-wrapper">
                    <div class="login-content">
                        <div class="login-userset">
                            <div class="login-logo">
                                <img :src="`${baseURL}/vuetheme/assets/img/logo.png`" alt="img" />
                            </div>
                            <div class="login-userheading">
                                <h3>Créer un compte</h3>
                                <h4>Continuez là où vous vous étiez arrêté</h4>
                            </div>

                            <v-form
                                ref="form"
                                v-model="valid"
                                lazy-validation
                                autocomplete="off"
                            >
                                <v-layout row wrap>
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">

                                            <v-text-field
                                            label="Nom"
                                            append-icon="person"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            outlined dense
                                            v-model="svData.name"
                                            ></v-text-field>

                                        </div>
                                    </v-flex>

                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">

                                            <v-text-field
                                            v-model="svData.email"
                                            outlined dense
                                            append-icon="email"
                                            :rules="[
                                                (v) => !!v || 'Ce champ est requis',
                                                (v) =>
                                                /.+@.+\..+/.test(v) ||
                                                'Doit être un email valide',
                                            ]"
                                            placeholder="E-mail"
                                            ></v-text-field>

                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">

                                            <v-autocomplete
                                            :items="SexeList"
                                            label="Sexe"
                                            append-icon="wc"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            outlined
                                            dense
                                            item-text="designation"
                                            item-value="designation"
                                            v-model="svData.sexe"
                                            ></v-autocomplete>

                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <div class="mr-1">

                                            <v-text-field
                                            label="N° de Téléphone"
                                            append-icon="phone"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            outlined dense
                                            v-model="svData.telephone"
                                            ></v-text-field>

                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">

                                            <v-text-field
                                            placeholder="Password"
                                            v-model="svData.password"
                                            :type="show1 ? 'text' : 'password'"
                                            outlined dense
                                            :append-icon="show1 ? 'visibility' : 'visibility_off'"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            @click:append="show1 = !show1"
                                            ></v-text-field>

                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">

                                            <v-checkbox
                                            :rules="[
                                                (v) => !!v || 'Vous devez accepter de continuer!',
                                            ]"
                                            label="J'accepte Politique de confidentialité"
                                            required
                                            ></v-checkbox>

                                        </div>
                                    </v-flex>
                                    <v-flex xs12 sm12 md12 lg12>
                                        <div class="mr-1">

                                            <v-btn
                                                dark
                                                color="primary"
                                                block
                                                :disabledb="!valid"
                                                @click="validate"
                                                class="hover-a"
                                                ><v-icon>logout</v-icon> S'inscrire
                                            </v-btn>

                                        </div>
                                    </v-flex>


                                </v-layout>
                            </v-form>

                            <dialogLoader v-if="diaL" />

                            <div class="signinform text-center">
                                <br>
                                <h4>Vous êtes déjà un utilisateur ?
                                    <a @click="gotoPage('login')" class="hover-a" style="text-decoration: none">Connexion</a>
                                </h4>
                            </div>
                            <div class="form-setlogin">
                                <h4>Ou Connectez-vous avec</h4>
                            </div>
                            <div class="form-sociallink">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" style="text-decoration: none">
                                            <img :src="`${baseURL}/vuetheme/assets/img/icons/google.png`" class="me-2"
                                                alt="google" />
                                            Se connecter avec Google
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" style="text-decoration: none">
                                            <img :src="`${baseURL}/vuetheme/assets/img/icons/facebook.png`" class="me-2"
                                                alt="google" />
                                            Se connecter avec Facebook
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="login-img">
                        <img :src="`${baseURL}/vuetheme/assets/img/login.jpg`" alt="img" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import dialogLoader from '../emerfine/dialogLoader.vue'

export default {
    components: {
        dialogLoader,
    },
    data() {

        return {
            svData: {
                id: "",
                name: "",
                email: "",
                password: "",
                sexe: "",
                telephone:"",
            },
            SexeList:[{ designation: 'M' }, { designation: 'F' }],
            valid: false,
            diaL: false,
            show1: false,
            titre:
                "Devenir à présent membre au système en créant un compte utilisateur",

        };

    },
    methods: {

        validate() {
            if (this.$refs.form.validate()) {
                this.diaL = true;
                this.insertOrUpdate(
                `${this.baseURL}/register_count`,
                JSON.stringify(this.svData)
                )
                .then(({ data }) => {
                    console.log(data.data);

                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.resetObj(this.svData);

                    if (data.success == false) {
                    this.showError("Information incorrecte");
                    this.diaL = false;
                    }
                    if (data.success == true) {
                    window.location = `${this.baseURL}/login`;
                    }
                })
                .catch((error) => {
                    error.response.status === 419
                    ? window.location.reload()
                    : this.svErr(),
                    (this.diaL = false),
                    (this.diaL = false);
                });
            }
        },

    },
    computed: {
    },
    created() {

    }

}
</script>
