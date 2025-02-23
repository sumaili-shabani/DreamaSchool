<template>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="700px">
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

                <v-container grid-list-xs>
                    
                
                    <v-layout row wrap>
                        <v-flex xs12 md12 lg12 sm12 v-for="item in dataList" :key="item.id">

                            <v-system-bar class="text-center">
                               {{item.nomEntreprise}}
                               
                            </v-system-bar>
                            <v-list>
                                <v-list-item>
                                    <v-list-item-avatar>
                                        <img 
                                            :src="
                                                item.photo == null
                                                ? `${baseURL}/fichier/avatar.png`
                                                : `${baseURL}/fichier/` + item.photo
                                            "
                                            :alt="'pas d\'image pour '+item.name"
                                            
                                        />
                                    </v-list-item-avatar>
                                </v-list-item>
                                <v-layout row wrap>
                                    <v-flex xs12 sm12 md6 lg6>

                                        <v-list-item>
                                            <v-list-item-content>
                                                <v-list-item-title class="text-h6">
                                                    Nom: {{item.noms}}
                                                </v-list-item-title>
                                                <v-list-item-title class="text-h6">
                                                    Categorie: {{item.Categorie}}
                                                </v-list-item-title>                                                
                                                <v-list-tile-content>                                                   
                                                    <p>
                                                        <strong>N° de Téléphone</strong>: {{item.contact}}
                                                        <v-divider></v-divider>
                                                    </p>                                                   
                                                    <p>
                                                        <strong>Adresse Email</strong>: {{item.mail }}
                                                        <v-divider></v-divider>
                                                    </p>
                                                </v-list-tile-content>
                                            </v-list-item-content>

                                            
                                        </v-list-item>
                                        
                                    </v-flex>

                                    <v-flex xs12 sm12 md6 lg6>

                                        <v-list-item >
                                            <v-list-item-content>
                                                <v-list-item-title class="text-h6">
                                                    Localisation
                                                </v-list-item-title>
                                                
                                                <v-list-tile-content>
                                                    <p>
                                                        <strong>Pays</strong>: {{item.nomPays}}
                                                        <v-divider></v-divider>
                                                    </p>
                                                    <p>
                                                        <strong>Province</strong>: {{item.nomProvince}}
                                                        <v-divider></v-divider>
                                                    </p>
                                                    <p>
                                                       <strong> Chef lieu</strong>: {{item.nomVille}}
                                                       <v-divider></v-divider>
                                                    </p>
                                                    
                                                    <p>
                                                        <strong>Commune</strong>: {{item.nomCommune}}
                                                        <v-divider></v-divider>
                                                    </p>
                                                    <p>
                                                        <strong>Quartier</strong>: {{item.nomQuartier}}
                                                        <v-divider></v-divider>
                                                    </p>
                                                    <p>
                                                        <strong>Avenue</strong>: {{item.nomAvenue}}
                                                        <v-divider></v-divider>
                                                    </p>

                                                </v-list-tile-content>
                                            </v-list-item-content>

                                            
                                        </v-list-item>
                                        
                                    </v-flex>


                                </v-layout>

                                
                            </v-list>
                            
                        </v-flex>
                    </v-layout>
                </v-container>
              
              
            </v-card-text>
  
           
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
          name:"",
          created:"",
        },
        titleComponent: "",
        loading: false,
        edit: true,
        dataList:[],
      };
    },
  
    
    computed: {
      ...mapGetters(["roleList"]),
      
    },
    methods: {
      ...mapActions(["getRole"]),

      display_profile(id) {

        this.editOrFetch(`${this.apiBaseURL}/ad1/ProfiletClient/${id}`).then(
            ({ data }) => {
            var donnees = data.data;
            this.dataList = donnees;

            donnees.map((item) => {
            
                this.svData.id = item.id;
                
            });

            this.edit = true;
            this.dialog = true;

            }
        );

      },
      
  
      
  
  
  
    },
  
    created() {
       
    },
  
  
  
  };
  </script>