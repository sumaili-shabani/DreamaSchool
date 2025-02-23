<template>
    <v-layout wrap row>
        
        <v-flex md12>
            <v-flex md12>
                <!-- modal  -->
                <!-- <detailLotModal v-on:chargement="rechargement" ref="detailLotModal" /> -->
                <!-- fin modal -->
                <!-- modal -->
               <br><br>
                <!-- fin modal -->

                <!-- bande -->
                <v-layout>
                    <v-flex md1>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn :loading="loading" fab @click="onPageChange">
                                        <v-icon>autorenew</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Initialiser</span>
                        </v-tooltip>
                    </v-flex>
                    <v-flex md7>

                        <v-row v-show="showDate">
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-date-picker
                                v-model="dates"
                                range  color="  blue"
                            ></v-date-picker>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-text-field
                                v-model="dateRangeText"
                                label="Date range"
                                prepend-icon="mdi-calendar"
                                readonly
                            ></v-text-field>
                          
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPaiementPersonnelByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DE PAIEMENT DES AGENTS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                      
                            <br>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez DIV/COORD/SERVICE" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList"
                                        item-text="name_serv_perso" item-value="id" dense outlined v-model="svData.refServicePerso" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPaiementPersonnel_ServiceByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DE PAIEMENT DES AGENTS/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>  

                            <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Mois" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="moisList" item-text="name_mois"
                                item-value="id" dense outlined v-model="svData.refmois" chips clearable>
                            </v-autocomplete>
                            </div>
                            </v-flex>
                            <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                <v-autocomplete label="Selectionnez l'année" prepend-inner-icon="mdi-map" dense
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="anneeList" item-text="name_annee"
                                    item-value="id" outlined v-model="svData.refAnne">
                                </v-autocomplete>
                                </div>
                            </v-flex>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPaiementPersonnel_MoisByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DE PAIEMENT DES AGENTS/MOIS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                <v-autocomplete label="Selectionnez Rubrique de Paiement" prepend-inner-icon="mdi-map" dense
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="rubriqueList" item-text="name_rubrique"
                                    item-value="id" outlined v-model="svData.refRubrique">
                                </v-autocomplete>
                                </div>
                            </v-flex>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPaiementPersonnel_MoisRubriqueByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DE PAIEMENT DES AGENTS/MOIS/RUBIQUES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>


                            </v-col>
                        </v-row>
                      
                    </v-flex>
                   

                    <!-- <v-flex md3>
                       
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Organisation'" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="organisationList"
                                item-text="nom_org" item-value="nom_org" dense outlined v-model="svData.organisationAbonne"
                                chips clearable >
                            </v-autocomplete>
                        </div>
                    </v-flex> -->

                    <!-- <v-flex md1>
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="showDate = !showDate" fab color="  blue" dark>
                                        <v-icon>mdi-calendar</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Voir les Rapports</span>
                        </v-tooltip>
                    </v-flex> -->
                </v-layout>
                <!-- bande -->

                
            </v-flex>
        </v-flex>
        
    </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
// import detailLotModal from './detailLotModal.vue'
export default {
    components: {
        // detailLotModal,
    },
    data() {
        return {
            title: "Pays component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",                
                refProduit: "", 
                refServicePerso:0,
                organisationAbonne:"",
                refmois: 0,
                refAnne: 0,
                refRubrique: 0                
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            serviceList: [],
            produitList: [],
            rubriqueList: [],
            organisationList: [],
            anneeList: [],
            moisList: [],
            filterValue:'',
            dates:[],
            showDate:false,
        };
    },
    computed: {
        
        dateRangeText () {
            return this.dates.join(' ~ ')
        },
    },
    methods: {
        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Tarification ";
            this.edit = false;
            this.resetObj(this.svData);
            
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de Tarification ";
            } else {
                this.titleComponent = "Ajout Tarification ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),

        
        onPageChange() {           
           
        },      
      fetchListService() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_service_personnel2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.serviceList = donnees;

          }
        );
      },

        fetchListAnnee() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_annee2`).then(
            ({ data }) => {
            var donnees = data.data;
            this.anneeList = donnees;

            }
        );
        },
        fetchListMois() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_mois`).then(
            ({ data }) => {
            var donnees = data.data;
            this.moisList = donnees;
            }
        );
        },
        fetchListRubrique() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_Rubrique`).then(
            ({ data }) => {
            var donnees = data.data;
            this.rubriqueList = donnees;

            }
        );
        },
        showPaiementPersonnelByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_paiement_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showPaiementPersonnel_ServiceByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refServicePerso!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiement_date_service?date1=` + date1+"&date2="+date2+"&refServicePerso="+this.svData.refServicePerso);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showPaiementPersonnel_MoisByDate() {
            if(this.svData.refmois!="" && this.svData.refAnne!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiement_date_mois?refmois=` + this.svData.refmois+"&refAnne="+this.svData.refAnne);
                }else
                {
                    this.showError("Veillez selectionner le mois et l'année svp");
                }  
        },
        showPaiementPersonnel_MoisRubriqueByDate() {
            //refRubrique
            if(this.svData.refmois!="" && this.svData.refAnne!=""&& this.svData.refRubrique!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiement_date_mois_rubrique?refmois=` + this.svData.refmois+"&refAnne="+this.svData.refAnne+"&refRubrique="+this.svData.refRubrique);
                }else
                {
                    this.showError("Veillez selectionner le mois et l'année svp");
                }  
        },
        

        rechargement()
        {
            this.onPageChange();
            
        },

       


    },
    created() {        
        this.fetchListService();
        this.fetchListAnnee();
        this.fetchListMois();
        this.fetchListRubrique();
        this.showDate=true;
    },
};
</script>