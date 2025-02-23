<template>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="350">
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

                            <v-system-bar>
                                {{ svData.created | formatDate }} à 
                                {{ svData.created | formatHour }}
                               
                            </v-system-bar>
                            <v-list>
                                <v-list-item>
                                    <v-list-item-avatar>
                                        <img 
                                            :src="
                                                item.avatar == null
                                                ? `${baseURL}/images/avatar.png`
                                                : `${baseURL}/images/` + item.avatar
                                            "
                                            :alt="'pas d\'image pour '+item.name"
                                        />
                                    </v-list-item-avatar>
                                </v-list-item>

                                <v-list-item link>
                                    <v-list-item-content>
                                        <v-list-item-title class="text-h6">
                                            Nom: {{item.name}}
                                        </v-list-item-title>
                                        <v-list-item-subtitle>Email: {{item.email}}</v-list-item-subtitle>
                                        <v-list-tile-content>
                                            <p>
                                                Sexe: {{item.sexe}}
                                            </p>
                                            <p>
                                                Foncion et privilège: {{item.role_name}}
                                            </p>
                                        </v-list-tile-content>
                                    </v-list-item-content>

                                    <v-list-item-action>
                                        <v-icon>mdi-menu-down</v-icon>
                                    </v-list-item-action>
                                </v-list-item>
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

        this.editOrFetch(`${this.apiBaseURL}/fetch_single_user/${id}`).then(
            ({ data }) => {
            var donnees = data.data;
            this.dataList = donnees;

            donnees.map((item) => {
            
                this.svData.id = item.user_id;
                
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