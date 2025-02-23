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
                          
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailDetailSortieByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES RECETTES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Produit" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList"
                                        item-text="designation" item-value="id" dense outlined v-model="svData.refProduit" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                            </v-flex>

                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailSortieByDate_Produit" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES RECETTES/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>
             

    

                            
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
                idCategorie:0                
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            categorieList: [],
            categorieProList: [],
            produitList: [],
            organisationList: [],
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
        showDetailDetailSortieByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_salon_date?date1=` + date1+"&date2="+date2);              
               
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
        

        rechargement()
        {
            this.onPageChange();
            
        },

       


    },
    created() {
        this.GetProduit();
        this.showDate=true;
    },
};
</script>