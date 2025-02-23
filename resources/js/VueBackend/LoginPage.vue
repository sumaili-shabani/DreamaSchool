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
                                <h3>Se connecter</h3>
                                <h4>Veuillez vous connecter à votre compte</h4>
                            </div>


                            <v-form
                                ref="form"
                                v-model="valid"
                                lazy-validation
                                autocomplete="off"
                            >
                                <v-text-field
                                    v-model="svData.email"
                                    outlined
                                    append-icon="email"
                                    :rules="[
                                        (v) => !!v || 'Ce champ est requis',
                                        (v) =>
                                        /.+@.+\..+/.test(v) ||
                                        'Doit être un email valide',
                                    ]"
                                    dense
                                    placeholder="E-mail"
                                    >
                                </v-text-field>
                                <v-text-field
                                    placeholder="Password"
                                    v-model="svData.password"
                                    :type="show1 ? 'text' : 'password'"
                                    outlined
                                    :append-icon="show1 ? 'visibility' : 'visibility_off'"
                                    :rules="[(v) => !!v || 'Ce champ est requis']"
                                    @click:append="show1 = !show1"
                                    dense>
                                </v-text-field>

                                <v-checkbox
                                label="Mot de passe oublié?"

                                @blur="$v.checkbox.$touch()"
                                ></v-checkbox>


                                <div class="signinform text-center">
                                    <v-btn
                                        dark
                                        color="primary"
                                        block
                                        :disabledb="!valid"
                                        @click="validate"
                                        class="hover-a"
                                        ><v-icon>login</v-icon> Connexion
                                    </v-btn>
                                    <br>
                                    <h4>Vous n'avez pas de compte ?
                                        <a @click="gotoPage('register')" class="hover-a" style="text-decoration: none">S'inscrire</a>
                                    </h4>
                                </div>



                                <!-- Avez-vous un compte?
                                <a
                                @click="gotoPage('registerEntreprise')"
                                style="text-decoration: none"
                                >Créer un compte</a
                                >

                                <br /> -->
                                <br />
                            </v-form>

                            <dialogLoader v-if="diaL" />




                            <div class="form-setlogin">
                                <h4>Ou inscrivez-vous avec</h4>
                            </div>
                            <div class="form-sociallink">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" style="text-decoration: none">
                                            <img :src="`${baseURL}/vuetheme/assets/img/icons/google.png`" class="me-2"
                                                alt="google" />
                                            S'inscrire avec Google
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" style="text-decoration: none">
                                            <img :src="`${baseURL}/vuetheme/assets/img/icons/facebook.png`" class="me-2"
                                                alt="google" />
                                            S'inscrire avec Facebook
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
                email: "",
                password: "",
            },
            valid: false,
            diaL: false,
            show1: false,
            titre: "Connexion et authentification au système",

        };

    },
    methods: {

        validate() {
            if (this.$refs.form.validate()) {
                this.diaL = true;
                this.insertOrUpdate(
                    `${this.baseURL}/checkLogin`,
                    JSON.stringify(this.svData)
                )
                    .then(({ data }) => {
                        if (data.wrong) {
                            this.showError("Information incorrecte");
                            this.diaL = false;
                        }
                        if (data.wrong == false) {
                            this.diaL = false;

                            window.location = `${this.baseURL}/dashbord`;
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
