<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\tresorerie\tt_treso_blocController;
use App\Http\Controllers\tresorerie\tt_treso_categorie_rubriqueController;
use App\Http\Controllers\tresorerie\tt_treso_detail_angagementController;
use App\Http\Controllers\tresorerie\tt_treso_detail_etatbesoinController;
use App\Http\Controllers\tresorerie\tt_treso_entete_etatbesoinController;
use App\Http\Controllers\tresorerie\tt_treso_provenanceController;
use App\Http\Controllers\tresorerie\tt_treso_rubriqueController;
use App\Http\Controllers\tresorerie\ttreso_entete_angagementController;

use App\Http\Controllers\Finances\BonSortieCaissePdfController;
use App\Http\Controllers\Finances\BonEntreeCaissePdfController;
use App\Http\Controllers\Finances\tBanqueController;
use App\Http\Controllers\Finances\tCompteController;
use App\Http\Controllers\Finances\tClasseController;
use App\Http\Controllers\Finances\tfin_cloture_comptabiliteController;
use App\Http\Controllers\Finances\tCompteFinController;
use App\Http\Controllers\Finances\tSousCompteFinController;
use App\Http\Controllers\Finances\tSSousCompteFinController;
use App\Http\Controllers\Finances\tTypeCompteController;
use App\Http\Controllers\Finances\tTypeOperationController;
use App\Http\Controllers\Finances\tTypePositionController;
use App\Http\Controllers\Finances\Pdf_ComptabiliteController;
use App\Http\Controllers\Finances\tClotureCaisseController;
use App\Http\Controllers\Finances\tfin_entete_operationcompteController;
use App\Http\Controllers\Finances\tfin_detail_operationcompteController;
use App\Http\Controllers\Finances\tDepenseController;
use App\Http\Controllers\Finances\Pdf_BonEngagementController;
use App\Http\Controllers\Finances\ModePaieController;
use App\Http\Controllers\Finances\tannexe_depenseController;


use App\Http\Controllers\Ventes\PdfVenteController;
use App\Http\Controllers\Ventes\tvente_categorie_clientController;
use App\Http\Controllers\Ventes\tvente_categorie_produitController;
use App\Http\Controllers\Ventes\tvente_detail_entreeController;
use App\Http\Controllers\Ventes\tvente_detail_requisitionController;
use App\Http\Controllers\Ventes\tvente_detail_venteController;
use App\Http\Controllers\Ventes\tvente_entete_entreeController;
use App\Http\Controllers\Ventes\tvente_entete_requisitionController;
use App\Http\Controllers\Ventes\tvente_entete_venteController;
use App\Http\Controllers\Ventes\tvente_fournisseurController;
use App\Http\Controllers\Ventes\tvente_paiementController;
use App\Http\Controllers\Ventes\tvente_produitController;
use App\Http\Controllers\Ventes\tvente_tauxController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace'	=>	"Role"], function(){
	Route::get("fetch_role", 'RoleController@index');
	Route::get("fetch_single_role/{id}", 'RoleController@edit');
	Route::get("delete_role/{id}", 'RoleController@destroy');
	Route::post("insert_role", 'RoleController@store');
});

Route::group(['namespace'   =>  "User"], function(){
    Route::get("fetch_user", 'UserController@index');
    Route::get("fetch_user_all", 'UserController@fetch_user_all');
    Route::get("fetch_user_all_agent", 'UserController@fetch_user_all_agent');
    

    Route::get("fetch_single_user/{id}", 'UserController@edit');
    Route::get("delete_user/{id}", 'UserController@destroy');
    Route::post("insert_user", 'UserController@store');
    Route::post("change_pwd_user", 'UserController@ChangePassword');
    Route::post("change_role_user", 'UserController@ChangeRole');

    Route::post("insertion_user", 'UserController@insert_user');

    // envoie de mail
    Route::post("send_mail", 'SendMailController@send_mail');
    // imprimmer sa carte
    Route::get('print_bill','UserController@printBill');

    Route::post('edit_photo','UserController@editPhoto');

    Route::get("showUser/{id}", 'UserController@showUser');

    //modifier son mot de passe
    Route::post("ChangeMyPasswordSecure", 'UserController@ChangeMyPasswordSecure');

    Route::get("fetch_user_ceo", 'UserController@fetch_user_ceo');
    Route::get("fetch_user_medecin", 'UserController@fetch_user_medecin');
    Route::get("fetch_user_infirmier", 'UserController@fetch_user_infirmier');
    

    Route::get("checkEtat_compte/{id}/{etat}", 'UserController@checkEtat_Compte');


});


Route::group(['namespace'   =>  "Site"], function(){
    Route::get("fetch_site", 'SiteController@index');
    Route::get("fetch_site_2", 'SiteController@fetch_site_2');
    Route::get("fetch_single_site/{id}", 'SiteController@edit');
    Route::get("delete_site/{id}", 'SiteController@destroy');
    Route::post("insert_site", 'SiteController@store');

    Route::post('edit_photo_site','SiteController@editPhoto');

});

// localisation
Route::group(['namespace'   =>  "Backend"], function(){

    /*
    * ===============
    * localisation
    * ===============
    */

    //pays
    Route::get("fetch_pays", 'PaysController@index');
    Route::get("fetch_single_pays/{id}", 'PaysController@edit');
    Route::get("delete_pays/{id}", 'PaysController@destroy');
    Route::post("insert_pays", 'PaysController@store');
    Route::get("fetch_pays_2", 'PaysController@fetch_pays_2');
    Route::get("destroyMessage/{id}", 'PaysController@destroyMessage');


    //provinces
    Route::get("fetch_province", 'ProvinceController@index');
    Route::get("fetch_single_province/{id}", 'ProvinceController@edit');
    Route::get("delete_province/{id}", 'ProvinceController@destroy');
    Route::post("insert_province", 'ProvinceController@store');
    Route::get("fetch_province_2", 'ProvinceController@fetch_province_2');
    Route::get("fetch_province_tug_pays/{idPays}", 'ProvinceController@fetch_province_tug_pays');

    //Ville
    Route::get("fetch_ville", 'VilleController@index');
    Route::get("fetch_single_ville/{id}", 'VilleController@edit');
    Route::get("delete_ville/{id}", 'VilleController@destroy');
    Route::post("insert_ville", 'VilleController@store');
    Route::get("fetch_ville_tug_pays/{idProvince}", 'VilleController@fetch_ville_tug_pays');

    //Commune
    Route::get("fetch_commune", 'CommuneController@index');
    Route::get("fetch_single_commune/{id}", 'CommuneController@edit');
    Route::get("delete_commune/{id}", 'CommuneController@destroy');
    Route::post("insert_commune", 'CommuneController@store');
    Route::get("fetch_commune_tug_ville/{idVille}", 'CommuneController@fetch_commune_tug_ville');

    //Quartier
    Route::get("fetch_quartier", 'QuartierController@index');
    Route::get("fetch_single_quartier/{id}", 'QuartierController@edit');
    Route::get("delete_quartier/{id}", 'QuartierController@destroy');
    Route::post("insert_quartier", 'QuartierController@store');
    Route::get("fetch_quartier_tug_commune/{idVille}", 'QuartierController@fetch_quartier_tug_commune');

    //Avenue
    Route::get("fetch_avenue", 'AvenueController@index');
    Route::get("fetch_single_avenue/{id}", 'AvenueController@edit');
    Route::get("delete_avenue/{id}", 'AvenueController@destroy');
    Route::post("insert_avenue", 'AvenueController@store');
    Route::get("getAvenueTug/{idQuartier}", 'AvenueController@getAvenueTug');
    Route::get("fetch_avenue_2", 'AvenueController@fetch_avenue_2');

    

    /*
    * ===============
    * localisation
    * ===============
    */

});

Route::group(['namespace'   =>  "Backend"], function(){

//stat_eleves



	Route::group(['namespace'   =>  "Statistique"], function(){
		
	    Route::get("showCountDashbord", 'StatistiqueController@showCountDashbord');
	    Route::get("stat_users", 'StatistiqueController@stat_users');
        Route::get("stat_eleves", 'StatistiqueController@stat_eleves');
        //pour la stat de paiement
        Route::get("stat_paiement", 'StatistiqueController@stat_paiement');
        Route::get("stat_paiement_option", 'StatistiqueController@stat_paiement_option');
        Route::get("stat_paiement_classe", 'StatistiqueController@stat_paiement_classe');
        

	});


    Route::group(['namespace'   =>  "Cours"], function(){
        
        //periode
        Route::get("fetch_periode", 'PeriodeController@index');
        Route::get("fetch_single_periode/{id}", 'PeriodeController@edit');
        Route::get("delete_periode/{id}", 'PeriodeController@destroy');
        Route::post("insert_periode", 'PeriodeController@store');
        Route::get("fetch_periode_2", 'PeriodeController@fetch_periode_2');
        Route::get("chect_etat_periode/{id}/{etat}", 'PeriodeController@chect_etat_periode');

        //cat_cours
        Route::get("fetch_cat_cours", 'CatCoursController@index');
        Route::get("fetch_single_cat_cours/{id}", 'CatCoursController@edit');
        Route::get("delete_cat_cours/{id}", 'CatCoursController@destroy');
        Route::post("insert_cat_cours", 'CatCoursController@store');
        Route::get("fetch_cat_cours_2", 'CatCoursController@fetch_cat_cours_2');

        //cours
        Route::get("fetch_cours", 'CoursController@index');
        Route::get("fetch_single_cours/{id}", 'CoursController@edit');
        Route::get("delete_cours/{id}", 'CoursController@destroy');
        Route::post("insert_cours", 'CoursController@store');
        Route::get("fetch_cours_by_catcours/{idCatCours}", 'CoursController@fetch_cours_by_catcours');
        Route::get("fetch_cours_2", 'CoursController@fetch_cours_2');
        

        //Enseignant
        Route::get("fetch_enseignant", 'EnseignantController@index');
        Route::get("fetch_single_enseignant/{id}", 'EnseignantController@edit');
        Route::get("delete_enseignant/{id}", 'EnseignantController@destroy');
        Route::post("insert_enseignant", 'EnseignantController@store');
        Route::get("fetch_enseignant_2", 'EnseignantController@fetch_enseignant_2');
        //modification ensignant
        Route::post("update_login_enseignant", 'EnseignantController@updateEnseignantLoginData');
        Route::post("editPhotoEnseignant", 'EnseignantController@editPhotoEnseignant');

        //attribution
        Route::get("fetch_attribution_cours", 'AttributionCoursController@index');
        Route::get("fetch_single_attribution_cours/{id}", 'AttributionCoursController@edit');
        Route::get("delete_attribution_cours/{id}", 'AttributionCoursController@destroy');
        Route::post("insert_attribution_cours", 'AttributionCoursController@store');

        //attributions
        Route::get("getListCoursClasse/{idAnne}/{idOption}/{idClasse}/{idPeriode}", 'AttributionCoursController@getListCoursClasse');

        Route::get("getListCoursClasseByCatCours/{idAnne}/{idOption}/{idClasse}/{idPeriode}/{idCatCours}", 'AttributionCoursController@getListCoursClasseByCatCours');

        Route::get("getMaximaCours/{idAnne}/{idOption}/{idClasse}/{idPeriode}/{idCours}", 'AttributionCoursController@getMaximaCours');


        //attribution
        Route::get("fetch_cotation", 'CotationController@index');
        Route::get("fetch_single_cotation/{id}", 'CotationController@edit');
        Route::get("delete_cotation/{id}", 'CotationController@destroy');
        Route::post("insert_cotation", 'CotationController@store');

        //raaport cotation
        Route::get("print_cours_par_classe", 'PdfCoursController@print_cours_par_classe');
        Route::get("print_cours_par_enseignant", 'PdfCoursController@print_cours_par_enseignant');
        Route::get("print_cours_aux_enseignants_par_classe", 'PdfCoursController@print_cours_aux_enseignants_par_classe');
        //pour l'impression de la cote
        Route::get("print_resultat_cotation_par_classe", 'PdfCotationController@print_resultat_cotation_par_classe');

        Route::get("print_resultat_cotation_par_eleve", 'PdfCotationController@print_resultat_cotation_par_eleve');
        
        
       
        
        
        
        

    });

    /*
    *
    *================================
    * les scripts pour les eleves
    *================================
    */
    Route::group(['namespace'   =>  "Ecole"], function(){

       //Eleves
        Route::get("fetch_eleve", 'EleveController@index');
        Route::get("fetch_single_eleve/{id}", 'EleveController@edit');
        Route::get("delete_eleve/{id}", 'EleveController@destroy');
        Route::post("insert_eleve", 'EleveController@store');
        Route::get("getListEleve", 'EleveController@getListEleve');
        Route::post("editPhotoEleve", 'EleveController@editPhotoEleve');

        //Annee
        Route::get("fetch_anne_scolaire", 'AnneScollaireController@index');
        Route::get("fetch_single_anne_scolaire/{id}", 'AnneScollaireController@edit');
        Route::get("delete_anne_scolaire/{id}", 'AnneScollaireController@destroy');
        Route::post("insert_anne_scolaire", 'AnneScollaireController@store');

        Route::get("chect_etat_anne_scolaire/{id}/{etat}", 'AnneScollaireController@chect_etat_anne_scolaire');
        Route::get("fetch_anne_scollaire_2", 'AnneScollaireController@fetch_anne_scollaire_2');

        //Classe
        Route::get("fetch_classe", 'ClasseController@index');
        Route::get("fetch_single_classe/{id}", 'ClasseController@edit');
        Route::get("delete_classe/{id}", 'ClasseController@destroy');
        Route::post("insert_classe", 'ClasseController@store');
        Route::get("fetch_classe_2", 'ClasseController@fetch_classe_2');


        //Division
        Route::get("fetch_division", 'DivisionController@index');
        Route::get("fetch_single_division/{id}", 'DivisionController@edit');
        Route::get("delete_division/{id}", 'DivisionController@destroy');
        Route::post("insert_division", 'DivisionController@store');
        Route::get("fetch_division_2", 'DivisionController@fetch_division_2');

        //Section
        Route::get("fetch_section", 'SectionController@index');
        Route::get("fetch_single_section/{id}", 'SectionController@edit');
        Route::get("delete_section/{id}", 'SectionController@destroy');
        Route::post("insert_section", 'SectionController@store');
        Route::get("fetch_section_2", 'SectionController@fetch_section_2');

        //option
        Route::get("fetch_option", 'OptionController@index');
        Route::get("fetch_single_option/{id}", 'OptionController@edit');
        Route::get("delete_option/{id}", 'OptionController@destroy');
        Route::post("insert_option", 'OptionController@store');
        Route::get("fetch_option_by_section/{idSection}", 'OptionController@fetch_option_by_section');

        //inscription
        Route::get("fetch_inscription", 'InscriptionController@index');
        Route::get("fetch_inscription_2", 'InscriptionController@fetch_inscription_2');
        Route::get("fetch_single_inscription/{id}", 'InscriptionController@edit');
        Route::get("delete_inscription/{id}", 'InscriptionController@destroy');
        Route::post("insert_inscription", 'InscriptionController@store');
        Route::get("getListEleveInscrits", 'InscriptionController@getListEleveInscrits');

        //fetch_inscription_2

        Route::post("updateReductionPaiement", 'InscriptionController@updateReductionPaiement');

        //voir l'effectif
        Route::get("get_effectif_eleve_classe/{idClasse}/{idOption}", 'InscriptionController@getCountInscriptionEffectif');

        //voir les inscrit par classe
        Route::get("get_eleve_inscript_par_classe/{idAnne}/{idOption}/{idClasse}", 'InscriptionController@getListEleveInscritsClasse');

        Route::get("getPeriodeEnCours", 'InscriptionController@getPeriodeEnCours');


        
        

        

        //presence
        Route::get("fetch_presence", 'PresenceController@index');
        Route::get("fetch_presence_codeqr", 'PresenceController@indexQrcode');
        
        Route::get("fetch_single_presence/{id}", 'PresenceController@edit');
        Route::get("delete_presence/{id}", 'PresenceController@destroy');
        Route::post("insert_presence", 'PresenceController@store');

        Route::post("insert_presence_qrcode", 'PresenceController@storeQrcode');
        Route::get("fetch_calendrier_presence_eleve/{codeInscription}", 'PresenceController@getAttendanceDay');

        // carte  d'eleve
        Route::get("print_card_identification", 'PdfPrintController@print_card_identification');
        //recu de paiement
        Route::get("print_recu_paiement", 'PdfPrintController@print_recu_paiement');
        Route::get("print_recu_paiement_sigle", 'PdfPrintController@print_recu_paiement_sigle');

        // rapport echeancier
        Route::get("print_echeancier_promotion", 'PdfPrintController@print_echeancier_promotion');
        Route::get("print_echeancier_anneescolaire", 'PdfPrintController@print_echeancier_anneescolaire');

        
        Route::get("fetch_rapport_inscription_classe", 'PdfPrintEleveController@fetch_rapport_inscription_classe');
        Route::get("fetch_rapport_recouvrement_classe", 'PdfPrintEleveController@fetch_rapport_recouvrement_classe');
        Route::get("fetch_rapport_retardpaie_classe", 'PdfPrintEleveController@fetch_rapport_retardpaie_classe');
        Route::get("fetch_rapport_inscription_classe_reduction", 'PdfPrintEleveController@fetch_rapport_inscription_classe_reduction');
        Route::get("fetch_rapport_paiement_frais_date", 'PdfPrintEleveController@fetch_rapport_paiement_frais_date');
        Route::get("fetch_rapport_paiement_frais_date_classe", 'PdfPrintEleveController@fetch_rapport_paiement_frais_date_classe');

        Route::get("fetch_historique_paiement", 'PdfPrintEleveController@fetch_historique_paiement');
        Route::get("fetch_fiche_inscription_classe", 'PdfPrintEleveController@fetch_fiche_inscription_classe');

        Route::get("fetch_rapport_inscription_classe_reduction_annuel", 'PdfPrintEleveController@fetch_rapport_inscription_classe_reduction_annuel');
        Route::get("fetch_rapport_inscription_annuel", 'PdfPrintEleveController@fetch_rapport_inscription_annuel');
        Route::get("fetch_rapport_recouvrement_option", 'PdfPrintEleveController@fetch_rapport_recouvrement_option');
        Route::get("fetch_rapport_retardpaie_option", 'PdfPrintEleveController@fetch_rapport_retardpaie_option');

        Route::get("fetch_rapport_nouveau_option", 'PdfPrintEleveController@fetch_rapport_nouveau_option');
        Route::get("fetch_rapport_inscription_nouveau_classe", 'PdfPrintEleveController@fetch_rapport_inscription_nouveau_classe');

        


        //fetch_rapport_retardpaie_classe


        
        
        
        


    });

    Route::group(['namespace'   =>  "Paiement"], function(){
        
        //Type Tranche
        Route::get("fetch_type_tranche", 'TypeTrancheController@index');
        Route::get("fetch_single_type_tranche/{id}", 'TypeTrancheController@edit');
        Route::get("delete_type_tranche/{id}", 'TypeTrancheController@destroy');
        Route::post("insert_type_tranche", 'TypeTrancheController@store');
        Route::get("fetch_type_tranche_2", 'TypeTrancheController@fetch_type_tranche_2');

        //Tranche
        Route::get("fetch_tranche", 'TrancheController@index');
        Route::get("fetch_single_tranche/{id}", 'TrancheController@edit');
        Route::get("delete_tranche/{id}", 'TrancheController@destroy');
        Route::post("insert_tranche", 'TrancheController@store');
        Route::get("fetch_tranche_2", 'TrancheController@fetch_tranche_2');

        //paiement
        Route::get("fetch_paiement", 'PaiementController@index');
        Route::get("fetch_single_paiement/{id}", 'PaiementController@edit');
        Route::get("delete_paiement/{id}", 'PaiementController@destroy');
        Route::post("insert_paiement", 'PaiementController@store');
        Route::get("chect_validation_paiement/{id}/{etat}", 'PaiementController@chect_validation_paiement');

        Route::get("getinfo_paiement_eleve/{idInscription}", 'PaiementController@getInfoPaiementEleve');

        

        //Prevision
        Route::get("fetch_prevision", 'PrevisionController@index');
        Route::get("fetch_single_prevision/{id}", 'PrevisionController@edit');
        Route::get("delete_prevision/{id}", 'PrevisionController@destroy');
        Route::post("insert_prevision", 'PrevisionController@store');
        Route::get("chect_validation_prevision/{id}/{etat}", 'PrevisionController@chect_validation_prevision');

        //clauture effectif
        Route::get("fetch_clauture", 'ClautureController@index');
        Route::get("fetch_single_clauture/{id}", 'ClautureController@edit');
        Route::get("delete_clauture/{id}", 'ClautureController@destroy');
        Route::post("insert_clauture", 'ClautureController@store');

        //Division
        Route::get("fetch_mois_scolaire", 'MoisScolaireController@index');
        Route::get("fetch_single_mois_scolaire/{id}", 'MoisScolaireController@edit');
        Route::get("delete_mois_scolaire/{id}", 'MoisScolaireController@destroy');
        Route::post("insert_mois_scolaire", 'MoisScolaireController@store');
        Route::get("fetch_mois_scolaire_2", 'MoisScolaireController@fetch_mois_scolaire_2');
        
        

        Route::group(['namespace'   =>  "Rapport"], function(){
            Route::get("print_effectif_promotion", 'PdfRapEffectifController@print_effectif_promotion');
        

        });

    });

    /*
    *
    *================================
    * Fin des scripts pour les eleves
    *================================
    */  

});





    //=========EnteteBON D'ANGAGEMENT===============
    Route::get("fetch_all_bonAngagement", [ttreso_entete_angagementController::class, 'index']);
    Route::get("fetch_single_bonAngagement/{id}",[ttreso_entete_angagementController::class,'edit']);
    Route::post('insert_bonAngagement', [ttreso_entete_angagementController::class, 'store']);
    Route::post('update_bonAngagement/{id}', [ttreso_entete_angagementController::class, 'store']);
    
    Route::post('valider_divison/{id}', [ttreso_entete_angagementController::class, 'valider_divison']);
    Route::post('attester_divison/{id}', [ttreso_entete_angagementController::class, 'attester_divison']);
    
    Route::post('valider_tresorerie/{id}', [ttreso_entete_angagementController::class, 'valider_tresorerie']);
    Route::post('attester_tresorerie/{id}', [ttreso_entete_angagementController::class, 'attester_tresorerie']);
    
    Route::post('valider_administration/{id}', [ttreso_entete_angagementController::class, 'valider_administration']);
    Route::post('attester_administration/{id}', [ttreso_entete_angagementController::class, 'attester_administration']);
    
    Route::post('valider_direction/{id}', [ttreso_entete_angagementController::class, 'valider_direction']);
    Route::post('attester_direction/{id}', [ttreso_entete_angagementController::class, 'attester_direction']);
    
    Route::post('valider_gerant/{id}', [ttreso_entete_angagementController::class, 'valider_gerant']);
    Route::post('attester_gerant/{id}', [ttreso_entete_angagementController::class, 'attester_gerant']);
    
    Route::get("delete_bonAngagement/{id}", [ttreso_entete_angagementController::class, 'destroy']);
    
    //=========DetailBON D'ANGAGEMENT=======================
    Route::get("fetch_all_DbonAngagement", [tt_treso_detail_angagementController::class, 'index']);
    Route::get('/fetch_detail_enteteengagement/{refEntete}', [tt_treso_detail_angagementController::class, 'fetch_detail_for_entete']);
    Route::get("fetch_single_DbonAngagement/{id}",[tt_treso_detail_angagementController::class,'edit']);
    Route::post('insert_DbonAngagement', [tt_treso_detail_angagementController::class, 'store']);
    Route::post('update_DbonAngagement/{id}', [tt_treso_detail_angagementController::class, 'store']);
    Route::get("delete_DbonAngagement/{id}", [tt_treso_detail_angagementController::class, 'destroy']);
    //==========PROVENANCE==============***********
    Route::get("fetch_all_provenance", [tt_treso_provenanceController::class, 'index']);
    Route::get("fetch_provenance2", [tt_treso_provenanceController::class, 'fetch_provenance2']);
    Route::get("fetch_single_provenance/{id}",[tt_treso_provenanceController::class,'edit']);
    Route::post('insert_provenance', [tt_treso_provenanceController::class, 'store']);
    Route::post('update_provenance/{id}', [tt_treso_provenanceController::class, 'store']);
    Route::get("delete_provenance/{id}", [tt_treso_provenanceController::class, 'destroy']);
    //fetch_provenance2
    //=========RUBRIQUEDEPENSE===============
    Route::get("fetch_all_rubrique", [tt_treso_rubriqueController::class, 'index']);
    Route::get("fetch_rubrique2", [tt_treso_rubriqueController::class, 'fetch_rubrique2']);
    Route::get("fetch_single_rubrique/{id}",[tt_treso_rubriqueController::class,'edit']);
    Route::post('insert_rubrique', [tt_treso_rubriqueController::class, 'store']);
    Route::post('update_rubrique/{id}', [tt_treso_rubriqueController::class, 'update_rubrique']);
    Route::get("delete_rubrique/{id}", [tt_treso_rubriqueController::class, 'destroy']);
    //=========CATEGORIERUBRIQUE=====================================================
    //fetch_categorie_rubrique2
    Route::get("fetch_all_catRubrique", [tt_treso_categorie_rubriqueController::class, 'index']);
    Route::get("fetch_categorie_rubrique2", [tt_treso_categorie_rubriqueController::class, 'fetch_categorie_rubrique2']);
    Route::get("fetch_single_catRubrique/{id}",[tt_treso_categorie_rubriqueController::class,'edit']);
    Route::post('insert_catRubrique', [tt_treso_categorie_rubriqueController::class, 'store']);
    Route::post('update_catRubrique/{id}', [tt_treso_categorie_rubriqueController::class, 'store']);
    Route::get("delete_catRubrique/{id}", [tt_treso_categorie_rubriqueController::class, 'destroy']);
    //=========ENTETE_ETATDEBESOIN===============
    Route::get("fetch_all_etatBesoin", [tt_treso_entete_etatbesoinController::class, 'index']);
    Route::get("fetch_single_etatBesoin/{id}",[tt_treso_entete_etatbesoinController::class,'edit']);
    Route::post('insert_etatBesoin', [tt_treso_entete_etatbesoinController::class, 'store']);
    Route::post('update_etatBesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'store']);
    Route::post('aquitter_etatbesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'aquitter_etatbesoin']);
    Route::post('approuver_etatbesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'approuver_etatbesoin']);
    Route::get("delete_etatBesoin/{id}", [tt_treso_entete_etatbesoinController::class, 'destroy']);
    //=========DETAIL_ETATDEBESOIN===============
    Route::get("fetch_all_DetatBesoin", [tt_treso_detail_etatbesoinController::class, 'index']);
    Route::get('/fetch_detail_enteteetatbesoin/{refEntete}', [tt_treso_detail_etatbesoinController::class, 'fetch_detail_for_entete']);
    Route::get("fetch_single_DetatBesoin/{id}",[tt_treso_detail_etatbesoinController::class,'edit']);
    Route::post('insert_DetatBesoin', [tt_treso_detail_etatbesoinController::class, 'store']);
    Route::post('update_DetatBesoin/{id}', [tt_treso_detail_etatbesoinController::class, 'store']);
    Route::get("delete_DetatBesoin/{id}", [tt_treso_detail_etatbesoinController::class, 'destroy']);
    //=========BLOCS===============
    Route::get("fetch_all_bloc", [tt_treso_blocController::class, 'index']);
    Route::get("fetch_bloc2", [tt_treso_blocController::class, 'fetch_bloc2']);
    Route::get("fetch_single_bloc/{id}",[tt_treso_blocController::class,'edit']);
    Route::post('insert_bloc', [tt_treso_blocController::class, 'store']);
    Route::post('update_bloc/{id}', [tt_treso_blocController::class, 'store']);
    Route::get("delete_bloc/{id}", [tt_treso_blocController::class, 'destroy']);
    
    
    
    // PARTIE FINANCE=============================================================
    
    
    Route::get("fetch_modepaie", [ModePaieController::class, 'index']);
    Route::get("fetch_single_modepaie/{id}",[ModePaieController::class,'edit']);
    Route::get("delete_modepaie/{id}", [ModePaieController::class,'destroy']);
    Route::post("insert_modepaie", [ModePaieController::class,'store']);
    Route::get("fetch_tconf_modepaie_2", [ModePaieController::class, 'fetch_tconf_modepaiement_2']);
    Route::get("destroyMessage/{id}", [ModePaieController::class, 'destroyMessage']);
    
    Route::get("fetch_classecompte", [tClasseController::class, 'index']);
    Route::get("fetch_single_classecompte/{id}",[tClasseController::class,'edit']);
    Route::get("delete_classecompte/{id}", [tClasseController::class,'destroy']);
    Route::post("insert_classecompte", [tClasseController::class,'store']);
    Route::get("fetch_fin_classe_2", [tClasseController::class, 'fetch_tfin_classe_2']);
    
    Route::get("fetch_typecompte", [tTypeCompteController::class, 'index']);
    Route::get("fetch_single_typecompte/{id}",[tTypeCompteController::class,'edit']);
    Route::get("delete_typecompte/{id}", [tTypeCompteController::class,'destroy']);
    Route::post("insert_typecompte", [tTypeCompteController::class,'store']);
    Route::get("fetch_fin_typecompte_2", [tTypeCompteController::class, 'fetch_tfin_typecompte_2']);
    
    Route::get("fetch_typeposition", [tTypePositionController::class, 'index']);
    Route::get("fetch_single_typeposition/{id}",[tTypePositionController::class,'edit']);
    Route::get("delete_typeposition/{id}", [tTypePositionController::class,'destroy']);
    Route::post("insert_typeposition", [tTypePositionController::class,'store']);
    Route::get("fetch_fin_typeposition_2", [tTypePositionController::class, 'fetch_tfin_typeposition_2']);
    
    Route::get("fetch_typeoperation", [tTypeOperationController::class, 'index']);
    Route::get("fetch_single_typeoperation/{id}",[tTypeOperationController::class,'edit']);
    Route::get("delete_typeoperation/{id}", [tTypeOperationController::class,'destroy']);
    Route::post("insert_typeoperation", [tTypeOperationController::class,'store']);
    Route::get("fetch_fin_typeoperation_2", [tTypeOperationController::class, 'fetch_tfin_typeoperation_2']);
    
    //fetch_unite2
    Route::get('/fetch_comptefin', [tCompteFinController::class, 'all']);
    Route::get('/fetch_single_compte/{id}', [tCompteFinController::class, 'fetch_single_compte']);
    Route::get('/fetch_compte_classe/{refClasse}', [tCompteFinController::class, 'fetch_compte_classe']);   
    Route::get('/fetch_compte_classe2/{refClasse}', [tCompteFinController::class, 'fetch_compte_classe2']); 
    Route::get('/fetch_compte2', [tCompteFinController::class, 'fetch_compte2']);         
    Route::post('/insert_comptefin', [tCompteFinController::class, 'insert_compte']);
    Route::post('/update_comptefin/{id}', [tCompteFinController::class, 'update_compte']);
    Route::get('/delete_comptefin/{id}', [tCompteFinController::class, 'delete_compte']);
    
    Route::get('/fetch_souscomptefin', [tSousCompteFinController::class, 'all']);
    Route::get('/fetch_single_souscompte/{id}', [tSousCompteFinController::class, 'fetch_single_souscompte']);
    Route::get('/fetch_souscompte_compte/{refCompte}', [tSousCompteFinController::class, 'fetch_souscompte_compte']);   
    Route::get('/fetch_souscompte_compte2/{refCompte}', [tSousCompteFinController::class, 'fetch_souscompte_compte2']);         
    Route::post('/insert_souscomptefin', [tSousCompteFinController::class, 'insert_souscompte']);
    Route::post('/update_souscomptefin/{id}', [tSousCompteFinController::class, 'update_souscompte']);
    Route::get('/delete_souscomptefin/{id}', [tSousCompteFinController::class, 'delete_souscompte']);
    
    Route::get('/fetch_ssouscomptefin', [tSSousCompteFinController::class, 'all']);
    Route::get('/fetch_single_ssouscompte/{id}', [tSSousCompteFinController::class, 'fetch_single_ssouscompte']);
    Route::get('/fetch_ssouscompte_sous/{refSousCompte}', [tSSousCompteFinController::class, 'fetch_ssouscompte_sous']);   
    Route::get('/fetch_ssouscompte_sous2/{refSousCompte}', [tSSousCompteFinController::class, 'fetch_ssouscompte_sous2']);         
    Route::post('/insert_ssouscomptefin', [tSSousCompteFinController::class, 'insert_ssouscompte']);
    Route::post('/update_ssouscomptefin/{id}', [tSSousCompteFinController::class, 'update_ssouscompte']);
    Route::get('/delete_ssouscomptefin/{id}', [tSSousCompteFinController::class, 'delete_ssouscompte']);
    
    Route::get("fetch_all_enteteoperationcomptable",[tfin_entete_operationcompteController::class, 'all']);
    Route::get("fetch_single_enteteoperationcomptable/{id}",[tfin_entete_operationcompteController::class,'fetch_single']);
    Route::post('insert_enteteoperationcomptable',[tfin_entete_operationcompteController::class, 'insert_data']);
    Route::post('update_enteteoperationcomptable/{id}', [tfin_entete_operationcompteController::class, 'updateData']);
    Route::get("delete_enteteoperationcomptable/{id}", [tfin_entete_operationcompteController::class, 'destroy']);
    
    Route::get('/fetch_detail_operationcomptable', [tfin_detail_operationcompteController::class, 'all']);
    Route::get('/fetch_single_detail_operationcomptable/{id}', [tfin_detail_operationcompteController::class, 'fetch_single_detail']);
    Route::get('/fetch_detail_enteteoperationcomptable/{refEnteteOperation}', [tfin_detail_operationcompteController::class, 'fetch_detail_entete']);
    Route::post('/insert_detailoperationcomptable', [tfin_detail_operationcompteController::class, 'insert_detail']);
    Route::post('/update_detailoperationcomptable/{id}', [tfin_detail_operationcompteController::class, 'update_detail']);
    Route::get('/delete_detailoperationcomptable/{id}', [tfin_detail_operationcompteController::class, 'delete_detail']);
    
    Route::get("fetch_cloture_comptabilite", [tfin_cloture_comptabiliteController::class, 'index']);
    Route::get("fetch_single_cloture_comptabilite/{id}",[tfin_cloture_comptabiliteController::class,'edit']);
    Route::get("delete_cloture_comptabilite/{id}", [tfin_cloture_comptabiliteController::class,'destroy']);
    Route::post("insert_cloture_comptabilite", [tfin_cloture_comptabiliteController::class,'store']);
    Route::get("fetch_tfin_cloture_comptabilite_2", [tfin_cloture_comptabiliteController::class, 'fetch_tfin_cloture_comptabilite_2']);
    
    Route::get('fetch_depense', [tDepenseController::class, 'all']);
    Route::get('fetch_single_depense/{id}', [tDepenseController::class, 'fetch_single_depense']);
    Route::get('fetch_mouvement_depense', [tDepenseController::class, 'fetch_mouvement_depense']);
    Route::get('fetch_mouvement_entree', [tDepenseController::class, 'fetch_mouvement_entree']);        
    Route::post('insert_depense', [tDepenseController::class, 'insert_depense']);
    Route::post('update_depense/{id}', [tDepenseController::class, 'update_depense']);
    Route::get('delete_depense/{id}', [tDepenseController::class, 'delete_depense']);
    Route::get('fetch_compte_entree', [tDepenseController::class, 'fetch_compte_entree']);
    Route::get('fetch_compte_sortie', [tDepenseController::class, 'fetch_compte_sortie']);
    Route::post('aquitter_depense/{id}', [tDepenseController::class, 'aquitter_depense']);
    Route::post('approuver_depense/{id}', [tDepenseController::class, 'approuver_depense']);
    Route::post('cloturer_Comptabilite', [tDepenseController::class, 'cloturer_Comptabilite']);
    Route::post('cloturer_Caisse_vente', [tDepenseController::class, 'cloturer_Caisse_vente']);
    Route::post('cloturer_Caisse_hotel', [tDepenseController::class, 'cloturer_Caisse_hotel']);
    Route::post('cloturer_Caisse_salle', [tDepenseController::class, 'cloturer_Caisse_salle']);
    Route::post('cloturer_Caisse_billard', [tDepenseController::class, 'cloturer_Caisse_billard']);
    Route::post('cloturer_Caisse', [tDepenseController::class, 'cloturer_Caisse']);
    Route::post('cloturer_Caisse_ok', [tDepenseController::class, 'cloturer_Caisse_ok']);   
    
    Route::get("fetch_rapport_detailfacture_date_compte_cash", [Pdf_ComptabiliteController::class, 'fetch_rapport_detailfacture_date_compte_cash']);
    Route::get("fetch_rapport_detailfacture_date_compte_credit", [Pdf_ComptabiliteController::class, 'fetch_rapport_detailfacture_date_compte_credit']);
    Route::get("fetch_rapport_journal_caisse", [Pdf_ComptabiliteController::class, 'fetch_rapport_journal_caisse']);
    Route::get("fetch_rapport_bilan", [Pdf_ComptabiliteController::class, 'fetch_rapport_bilan']);
    Route::get("pdf_livre_caisse", [Pdf_ComptabiliteController::class, 'pdf_livre_caisse']);
    Route::get("pdf_livre_banque", [Pdf_ComptabiliteController::class, 'pdf_livre_banque']);
    
    Route::get("fetch_cloture_caisse", [tClotureCaisseController::class, 'index']);
    Route::get("fetch_single_cloture_caisse/{id}",[tClotureCaisseController::class,'edit']);
    Route::get("delete_cloture_caisse/{id}", [tClotureCaisseController::class,'destroy']);
    Route::post("insert_cloture_caisse", [tClotureCaisseController::class,'store']);
    
    
    Route::get("pdf_bon_engagement", [Pdf_BonEngagementController::class, 'pdf_bon_engagement']);
    Route::get("pdf_bon_etatdebesoin", [Pdf_BonEngagementController::class, 'pdf_bon_etatdebesoin']); 
    
    
    Route::get("fetch_banque", [tBanqueController::class, 'index']);
    Route::get("fetch_list_mode", [tBanqueController::class, 'fetch_list_mode']);
    Route::get("fetch_tconf_banque_2", [tBanqueController::class, 'fetch_tconf_banque_2']);
    Route::get('/fetch_list_banque/{nom_mode}', [tBanqueController::class, 'fetch_list_banque']);
    Route::get("fetch_single_banque/{id}",[tBanqueController::class,'edit']);
    Route::get("delete_banque/{id}", [tBanqueController::class,'destroy']);
    Route::post("insert_banque", [tBanqueController::class,'store']);
    
    
    Route::get("fetch_modepaie", [ModePaieController::class, 'index']);
    Route::get("fetch_single_modepaie/{id}",[ModePaieController::class,'edit']);
    Route::get("delete_modepaie/{id}", [ModePaieController::class,'destroy']);
    Route::post("insert_modepaie", [ModePaieController::class,'store']);
    Route::get("fetch_tconf_modepaie_2", [ModePaieController::class, 'fetch_tconf_modepaiement_2']);
    Route::get("destroyMessage/{id}", [ModePaieController::class, 'destroyMessage']);
    
    Route::get('fetch_libelle', [tCompteController::class, 'all']);
    Route::get('fetch_single_libelle/{id}', [tCompteController::class, 'fetch_single_compte']);
    Route::post('insert_libelle', [tCompteController::class, 'insert_compte']);
    Route::post('update_libelle/{id}', [tCompteController::class, 'update_compte']);
    Route::get('delete_libelle/{id}', [tCompteController::class, 'delete_compte']);
    Route::get('fetch_typemouvement', [tCompteController::class, 'fetch_typemouvement']);


    // VENTE

    Route::get("fetch_vente_categorie_client", [tvente_categorie_clientController::class,'index']);
    Route::get("fetch_single_vente_categorie_client/{id}", [tvente_categorie_clientController::class,'edit']);
    Route::get("delete_vente_categorie_client/{id}", [tvente_categorie_clientController::class,'destroy']);
    Route::post("insert_vente_categorie_client", [tvente_categorie_clientController::class,'store']);
    Route::get("fetch_tvente_categorie_client_2", [tvente_categorie_clientController::class,'fetch_tvente_categorie_client_2']);



    Route::get("fetch_categorie_produit", [tvente_categorie_produitController::class,'index']);
    Route::get("fetch_single_categorie_produit/{id}", [tvente_categorie_produitController::class,'edit']);
    Route::get("delete_categorie_produit/{id}", [tvente_categorie_produitController::class,'destroy']);
    Route::post("insert_categorie_produit", [tvente_categorie_produitController::class,'store']);
    Route::get("fetch_categorie_produit_2", [tvente_categorie_produitController::class,'fetch_tvente_categorie_produit_2']);

    Route::get("fetch_fournisseur", [tvente_fournisseurController::class,'index']);
    Route::get("fetch_single_fournisseur/{id}", [tvente_fournisseurController::class,'edit']);
    Route::get("delete_fournisseur/{id}", [tvente_fournisseurController::class,'destroy']);
    Route::post("insert_fournisseur", [tvente_fournisseurController::class,'store']);
    Route::get("fetch_list_fournisseur", [tvente_fournisseurController::class,'fetch_list_fournisseur']);

    Route::get("fetch_produit", [tvente_produitController::class,'index']);
    Route::get("fetch_single_produit/{id}", [tvente_produitController::class,'edit']);
    Route::get("delete_produit/{id}", [tvente_produitController::class,'destroy']);
    Route::post("insert_produit", [tvente_produitController::class,'store']);
    Route::get("fetch_produit_2", [tvente_produitController::class,'fetch_tvente_produit_2']);

    Route::get("fetch_vente_taux", [tvente_tauxController::class,'index']);
    Route::get("fetch_single_vente_taux/{id}", [tvente_tauxController::class,'edit']);
    Route::get("delete_vente_taux/{id}", [tvente_tauxController::class,'destroy']);
    Route::post("insert_vente_taux", [tvente_tauxController::class,'store']);
    Route::get("fetch_tvente_taux_2", [tvente_tauxController::class,'fetch_tvente_taux_2']);

    Route::get("fetch_vente_entete_entree", [tvente_entete_entreeController::class,'all']);
    Route::get("fetch_vente_entete_entree/{refEntete}", [tvente_entete_entreeController::class,'fetch_data_entete']);
    Route::get("fetch_single_vente_entete_entree/{id}", [tvente_entete_entreeController::class,'fetch_single_data']);    
    Route::post("insert_vente_entete_entree", [tvente_entete_entreeController::class,'insert_data']);
    Route::post("update_vente_entete_entree/{id}", [tvente_entete_entreeController::class,'update_data']);
    Route::get("delete_vente_entete_entree/{id}", [tvente_entete_entreeController::class,'delete_data']);

    Route::get("fetch_vente_entete_requisition", [tvente_entete_requisitionController::class,'all']);
    Route::get("fetch_vente_entete_requisition/{refEntete}", [tvente_entete_requisitionController::class,'fetch_data_entete']);
    Route::get("fetch_single_vente_entete_requisition/{id}", [tvente_entete_requisitionController::class,'fetch_single_data']);    
    Route::post("insert_vente_entete_requisition", [tvente_entete_requisitionController::class,'insert_data']);
    Route::post("update_vente_entete_requisition/{id}", [tvente_entete_requisitionController::class,'update_data']);
    Route::get("delete_vente_entete_requisition/{id}", [tvente_entete_requisitionController::class,'delete_data']);

    Route::get("fetch_vente_entete_vente", [tvente_entete_venteController::class,'all']);
    Route::get("fetch_vente_entete_vente/{refEntete}", [tvente_entete_venteController::class,'fetch_data_entete']);
    Route::get("fetch_single_vente_entete_vente/{id}", [tvente_entete_venteController::class,'fetch_single_data']);    
    Route::post("insert_vente_entete_vente", [tvente_entete_venteController::class,'insert_data']);
    Route::post("update_vente_entete_vente/{id}", [tvente_entete_venteController::class,'update_data']);
    Route::get("delete_vente_entete_vente/{id}", [tvente_entete_venteController::class,'delete_data']);


    Route::get("fetch_vente_detail_entree", [tvente_detail_entreeController::class,'all']);
    Route::get("fetch_vente_detail_entree/{refEntete}", [tvente_detail_entreeController::class,'fetch_data_entete']);
    Route::get("fetch_single_vente_detail_entree/{id}", [tvente_detail_entreeController::class,'fetch_single_data']);    
    Route::post("insert_vente_detail_entree", [tvente_detail_entreeController::class,'insert_data']);
    Route::post("update_vente_detail_entree/{id}", [tvente_detail_entreeController::class,'update_data']);
    Route::get("delete_vente_detail_entree/{id}", [tvente_detail_entreeController::class,'delete_data']);
    Route::get("fetch_detail_appro_vente/{id}", [tvente_detail_entreeController::class,'fetch_detail_appro_vente']);
    Route::get("fetch_total_appro_vente/{id}", [tvente_detail_entreeController::class,'fetch_total_appro_vente']);



    Route::get("fetch_vente_detail_requisition", [tvente_detail_requisitionController::class,'all']);
    Route::get("fetch_vente_detail_requisition/{refEntete}", [tvente_detail_requisitionController::class,'fetch_data_entete']);
    Route::get("fetch_single_vente_detail_requisition/{id}", [tvente_detail_requisitionController::class,'fetch_single_data']);    
    Route::post("insert_vente_detail_requisition", [tvente_detail_requisitionController::class,'insert_data']);
    Route::post("update_vente_detail_requisition/{id}", [tvente_detail_requisitionController::class,'update_data']);
    Route::get("delete_vente_detail_requisition/{id}", [tvente_detail_requisitionController::class,'delete_data']);
    Route::get("fetch_detail_requisition_vente/{id}", [tvente_detail_requisitionController::class,'fetch_detail_requisition_vente']);

    //fetch_detail_requisition_log
    //fetch_detail_requisition_vente

    Route::get("fetch_vente_detail_vente", [tvente_detail_venteController::class,'all']);
    Route::get("fetch_vente_detail_vente/{refEntete}", [tvente_detail_venteController::class,'fetch_data_entete']);
    Route::get("fetch_single_vente_detail_vente/{id}", [tvente_detail_venteController::class,'fetch_single_data']);    
    Route::post("insert_vente_detail_vente", [tvente_detail_venteController::class,'insert_data']);
    Route::get('/fetch_detail_facture/{id}', [tvente_detail_venteController::class,'fetch_detail_facture']);
    Route::post("update_vente_detail_vente/{id}", [tvente_detail_venteController::class,'update_data']);
    Route::get("delete_vente_detail_vente/{id}", [tvente_detail_venteController::class,'delete_data']);

    Route::get("fetch_vente_paiement", [tvente_paiementController::class,'all']);
    Route::get("fetch_vente_paiement/{refEntete}", [tvente_paiementController::class,'fetch_data_entete']);
    Route::get("fetch_single_vente_paiement/{id}", [tvente_paiementController::class,'fetch_single_data']);    
    Route::post("insert_vente_paiement", [tvente_paiementController::class,'insert_data']);
    Route::post("update_vente_paiement/{id}", [tvente_paiementController::class,'update_data']);
    Route::get("delete_vente_paiement/{id}", [tvente_paiementController::class,'delete_data']);

    Route::get("fetch_pdf_rapport_detail_vente_date", [PdfVenteController::class,'fetch_rapport_detailvente_date']); 
    Route::get("fetch_pdf_rapport_detail_vente_date_categorie", [PdfVenteController::class,'fetch_rapport_detailvente_date_categorie']); 
    Route::get("fetch_pdf_rapport_detail_vente_date_produit", [PdfVenteController::class,'fetch_rapport_detailvente_date_produit']); 
    Route::get("fetch_pdf_rapport_detail_vente_entree_date", [PdfVenteController::class,'fetch_rapport_detailentree_date']); 
    Route::get("fetch_pdf_rapport_detail_vente_cmd_date", [PdfVenteController::class,'fetch_rapport_detailcmd_date']); 
    Route::get("pdf_fiche_stock_vente", [PdfVenteController::class,'pdf_fiche_stock_vente']);    
    Route::get("pdf_fiche_stock_vente_categorie", [PdfVenteController::class,'pdf_fiche_stock_vente_categorie']);
    Route::get("fetch_rapport_detailvente_dette_date", [PdfVenteController::class,'fetch_rapport_detailvente_dette_date']); 

    Route::get("fetch_all_annexe_depense",[tannexe_depenseController::class, 'index']);
    Route::get("fetch_annexe_depense",[tannexe_depenseController::class, 'fetch_annexe_depense']);
    Route::get("annexe_recette",[tannexe_depenseController::class, 'annexe_recette']);
    Route::get("fetch_annexe_bydepense/{refDepense}",[tannexe_depenseController::class, 'fetch_annexe_depense']);
    Route::get("fetch_single_depense_annexe/{id}",[tannexe_depenseController::class,'fetch_single']);
    Route::post('insert_depense_annexe',[tannexe_depenseController::class, 'insert_data']);
    Route::post('update_depense_annexe/{id}', [tannexe_depenseController::class, 'update_data']);
    Route::get("delete_depense_annexe/{id}", [tannexe_depenseController::class, 'delete_data']);
    Route::get("downloadfile/{filenamess}",[tannexe_depenseController::class,'downloadfile']);


    Route::get("pdf_bonsortie_data", [BonSortieCaissePdfController::class, 'pdf_bon_data']);
    Route::get("pdf_bonentree_data", [BonEntreeCaissePdfController::class, 'pdf_bon_data']); 
    Route::get("fetch_rapport_sortie_compte_date", [BonSortieCaissePdfController::class, 'fetch_rapport_sortie_compte_date']);
    Route::get("fetch_rapport_sortie_compte_date_rubrique", [BonSortieCaissePdfController::class, 'fetch_rapport_sortie_compte_date_rubrique']);
    Route::get("fetch_rapport_entree_compte_date", [BonEntreeCaissePdfController::class, 'fetch_rapport_entree_compte_date']);
    Route::get("fetch_rapport_entree_compte_date_rubrique", [BonEntreeCaissePdfController::class, 'fetch_rapport_entree_compte_date_rubrique']);


//fetch_rapport_sortie_compte_date_rubrique












