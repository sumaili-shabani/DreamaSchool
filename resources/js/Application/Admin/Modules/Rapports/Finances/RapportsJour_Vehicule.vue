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
                            <v-date-picker v-model="dates" range color="  blue"></v-date-picker>
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
                          
                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showMouvementVehiculeByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES MOUVEMENTS DES VEHICULES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> -->
                            <br>
                            <v-autocomplete label="Selectionnez le Vehicule" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="vehiculeList" item-text="nom_vehicule" item-value="id"
                            outlined dense v-model="svData.refVehicule">
                            </v-autocomplete>
                            <br>
                            <v-autocomplete label="Selectionnez la Provenance(Fournisseur)" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="provenanceList" item-text="nom_producteur" item-value="id"
                            outlined dense v-model="svData.refProvenance">
                            </v-autocomplete>
                            <br>


                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showMouvementVehiculeByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES MOUVEMENTS DES VEHICULES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>


                            <br>


                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showMouvementPaiementVehiculeByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES RECTTES SUR LES MOUVEMENTS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>


                            </v-col>
                        </v-row>
                      
                    </v-flex>                 

                
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
                refCategorie:0,
                idCategorie:0,
                refVehicule: 0,
                refProvenance:0,                
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            categorieList: [],
            categorieProList: [],
            produitList: [],
            organisationList: [],
            vehiculeList: [],
            provenanceList: [],
            filterValue:'',
            dates:[],
            showDate:false,
        };
    },
    computed: {
        //
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
     
      async GetProduit() {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_produit_2_salon`)
              .then((res) => {
              var chart = res.data.data;

              if (chart) {
                  this.produitList = chart;
              } else {
                  this.produitList = [];
              }

              this.isLoading(false);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
              //fetch_pdf_rapport_detailentree_date
      },
        showMouvementVehiculeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/pdf_fiche_stock_vehicule?date1=` + date1+"&date2="+date2+"&refVehicule="+this.svData.refVehicule+"&refProvenance="+this.svData.refProvenance);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showMouvementPaiementVehiculeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_paiement_mouvement_date_vehicule?date1=` + date1+"&date2="+date2+"&refVehicule="+this.svData.refVehicule+"&refProvenance="+this.svData.refProvenance);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieByDate_Produit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refProduit!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_salon_date_produit?date1=` + date1+"&date2="+date2+"&refProduit="+this.svData.refProduit);
                }else
                {
                    this.showError("Veillez selectionner le Produit svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },  
        fetchListVehicule() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tcar_vehicule_2`).then(
            ({ data }) => {
                var donnees = data.data;
                this.vehiculeList = donnees;

            }
            );
        },      
        fetchListProvenance() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tcar_producteur_2`).then(
            ({ data }) => {
                var donnees = data.data;
                this.provenanceList = donnees;

            }
            );
        },
        

        rechargement()
        {
            this.onPageChange();
            
        },

       


    },
    created() {
        this.GetProduit();
        this.fetchListVehicule();
        this.fetchListProvenance();
        this.showDate=true;
    },
};
</script>