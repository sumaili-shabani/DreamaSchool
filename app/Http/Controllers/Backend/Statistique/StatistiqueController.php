<?php

namespace App\Http\Controllers\Backend\Statistique;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\{GlobalMethod, Slug};
use DB;

class StatistiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

       //les notification de bord
    public function showCountDashbord()
    {
        //
        
        $NombreTotalUtilisateur = $this->showCountTable("users");
        $NombreTotalRole = $this->showCountTable("roles");
        $NombreTotalUtilisateurM = $this->showCountTableWhere("users", "sexe", "M");
        $NombreTotalUtilisateurF = $this->showCountTableWhere("users", "sexe", "F");


        $NombreTotalEleveM = $this->showCountInscritHomme();
        $NombreTotalEleveF = $this->showCountInscritFemme();
        $NombreTotalInscrit = $this->showCountInscrit();
        $NombreTotalInscritReduction = $this->showCountInscritReduction();


        $SommeTotalCaisseE = $this->showSommeCaisseTotalRecette();
        $SommeTotalCaisseS = $this->showSommeCaisseTotalDepense();
        $SommeTotalCaisse = (floatval($SommeTotalCaisseE) - floatval($SommeTotalCaisseS));

        $SommeTotalBanqueE = $this->showSommeBanqueTotalRecette();
        $SommeTotalBanqueS = $this->showSommeBanqueTotalDepense();
        $SommeTotalBanque = (floatval($SommeTotalBanqueE) - floatval($SommeTotalBanqueS));



        $data =[];
        array_push($data, array(
            'NombreTotalUtilisateur'            =>  $NombreTotalUtilisateur,
            'NombreTotalUtilisateurM'           =>  $NombreTotalUtilisateurM,
            'NombreTotalUtilisateurF'           =>  $NombreTotalUtilisateurF,
            'NombreTotalRole'                   =>  $NombreTotalRole,
            
            'NombreTotalEleveM'                 =>  $NombreTotalEleveM,
            'NombreTotalEleveF'                 =>  $NombreTotalEleveF,
            'NombreTotalInscrit'                =>  $NombreTotalInscrit,
            'NombreTotalInscritReduction'       =>  $NombreTotalInscritReduction,

            'SommeTotalCaisseE'   =>  $SommeTotalCaisseE,
            'SommeTotalCaisseS'   =>  $SommeTotalCaisseS,
            'SommeTotalCaisse'    =>  $SommeTotalCaisse,
            'SommeTotalBanque'    =>  $SommeTotalBanque,
        ));

        return response()->json([
            'data'  =>  $data
        ]);
       
    }





















    //statistique selon les roles
    function stat_users()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Personnes",
            "data"  =>   $this->putstatCategories_table_role(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur le paiement",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->putstatOption_table_role()
               
            ),
        );

        array_push($data, array(

            'options'    =>  $options,
            'series'     =>  $series,

        ));

        return $data;

     
    }

    //stat users by role
    function putstatOption_table_role()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('inscriptions')
         ->join('eleves','eleves.id','=','inscriptions.idEleve')
         ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
         ->join('options','options.id','=','inscriptions.idOption')
         ->join('sections','sections.id','=','options.idSection')
         ->join('classes','classes.id','=','inscriptions.idClasse')
         ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('options.nomOption as nom,inscriptions.idOption, count(*) as nombre')
        ->where('anne_scollaires.statut', '=', 1)
        ->groupBy("inscriptions.idOption")
        // ->groupBy("users.id_role")
        ->get();


        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nom);
            
        }

        return $data;
    }


    function putstatCategories_table_role()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('users')
        ->join('roles', 'roles.id', '=','users.id_role')
        ->selectRaw('roles.nom, users.id_role, count(*) as nombre')
        ->groupBy("users.id_role")
        ->get();


        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);
            
        }

        return $data;
    }

    //statistique selon les roles




    /*
    *
    *=====================================
    * statistique sur les inscriptions
    *=====================================
    *
    */

    function stat_eleves()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Eleves",
            "data"  =>   $this->putstatOption_table_eleve(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur annee",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->putstatAnnee_table_eleve()
               
            ),
        );

        array_push($data, array(

            'options'    =>  $options,
            'series'     =>  $series,

        ));

        return $data;

    }

    function putstatOption_table_eleve()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('inscriptions')
         ->join('eleves','eleves.id','=','inscriptions.idEleve')
         ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
         ->join('options','options.id','=','inscriptions.idOption')
         ->join('sections','sections.id','=','options.idSection')
         ->join('classes','classes.id','=','inscriptions.idClasse')
         ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('options.nomOption as nom,inscriptions.idOption, count(*) as nombre')
        ->where('anne_scollaires.statut', '=', 1)
        ->groupBy("inscriptions.idOption")
        ->get();

        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);           
        }

        return $data;
    }


    function putstatAnnee_table_eleve()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('inscriptions')
         ->join('eleves','eleves.id','=','inscriptions.idEleve')
         ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
         ->join('options','options.id','=','inscriptions.idOption')
         ->join('sections','sections.id','=','options.idSection')
         ->join('classes','classes.id','=','inscriptions.idClasse')
         ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('anne_scollaires.designation as nom,inscriptions.idAnne,sections.nomSection, count(*) as nombre')
        ->where('anne_scollaires.statut', '=', 1)
        ->groupBy("inscriptions.idOption")
        ->get();

        $data = [];

        $obs = '';

        foreach ($presence as $row) {
            $nom = $row->nom.'-'.$row->nomSection;
            array_push($data, $nom);           
        }

        return $data;
    }

     /*
    *
    *=====================================
    * Fin statistique sur les inscriptions
    *=====================================
    *
    */

      /*
    *
    *=====================================
    * statistique sur le paiement
    *=====================================
    *
    */

    function stat_paiement()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Montant($)",
            "data"  =>   $this->putstatOption_table_paiement(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur paiement",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->putstatAnnee_table_paiement()
               
            ),
        );

        array_push($data, array(

            'options'    =>  $options,
            'series'     =>  $series,

        ));

        return $data;

    }

    function putstatOption_table_paiement()
    {
        \DB::statement("SET SQL_MODE=''");
        $presence = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('paiements.datePaiement as nom, sum(paiements.montant) as nombre')
        ->where('paiements.etatPaiement', '=', 1)
        ->whereYear('paiements.datePaiement', '=', date('Y'))
        ->whereMonth('paiements.datePaiement', '=', date('m'))
        ->groupBy("paiements.datePaiement")
        ->get();

        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);           
        }

        return $data;
    }


    function putstatAnnee_table_paiement()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('paiements.datePaiement as nom, sum(paiements.montant) as nombre')
        ->where('paiements.etatPaiement', '=', 1)
        ->whereYear('paiements.datePaiement', '=', date('Y'))
        ->whereMonth('paiements.datePaiement', '=', date('m'))
        ->groupBy("paiements.datePaiement")
        ->get();

        $data = [];

        foreach ($presence as $row) {
            array_push($data, $row->nom);           
        }

        return $data;
    }

     /*
    *
    *=====================================
    * Fin statistique sur le paiement
    *=====================================
    *
    */

    /*
    *
    *============================================
    * statistique sur le paiement par option 
    *============================================
    *
    */

    function stat_paiement_option()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Montant($)",
            "data"  =>   $this->putstatOption_table_paiement_option(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur paiement",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->putstatAnnee_table_paiement_option()
               
            ),
        );

        array_push($data, array(
            'options'    =>  $options,
            'series'     =>  $series,
        ));

        return $data;

    }

    function putstatOption_table_paiement_option()
    {
        \DB::statement("SET SQL_MODE=''");
        $presence = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('paiements.datePaiement as nom,options.nomOption, sum(paiements.montant) as nombre')
        ->where('paiements.etatPaiement', '=', 1)
        ->whereYear('paiements.datePaiement', '=', date('Y'))
        ->whereMonth('paiements.datePaiement', '=', date('m'))
        ->groupBy("paiements.datePaiement", "inscriptions.idOption")
        ->get();

        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);           
        }

        return $data;
    }


    function putstatAnnee_table_paiement_option()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('paiements.datePaiement as nom,options.nomOption, sum(paiements.montant) as nombre')
        ->where('paiements.etatPaiement', '=', 1)
        ->whereYear('paiements.datePaiement', '=', date('Y'))
        ->whereMonth('paiements.datePaiement', '=', date('m'))
        ->groupBy("paiements.datePaiement", "inscriptions.idOption")
        ->get();

        $data = [];
        $nom ="";
        foreach ($presence as $row) {
            $nom = $row->nom.'-'.$row->nomOption;
            array_push($data, $nom);           
        }

        return $data;
    }

     /*
    *
    *=============================================
    * Fin statistique sur le paiement par option 
    *=============================================
    *
    */


     /*
    *
    *============================================
    * statistique sur le paiement par classe 
    *============================================
    *
    */

    function stat_paiement_classe()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Montant($)",
            "data"  =>   $this->putstatOption_table_paiement_classe(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur paiement",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->putstatAnnee_table_paiement_classe()
               
            ),
        );

        array_push($data, array(
            'options'    =>  $options,
            'series'     =>  $series,
        ));

        return $data;

    }

    function putstatOption_table_paiement_classe()
    {
        \DB::statement("SET SQL_MODE=''");
        $presence = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('paiements.datePaiement as nom,options.nomOption,classes.nomClasse, sum(paiements.montant) as nombre')
        ->where('paiements.etatPaiement', '=', 1)
        ->whereYear('paiements.datePaiement', '=', date('Y'))
        ->whereMonth('paiements.datePaiement', '=', date('m'))
        ->groupBy("paiements.datePaiement","inscriptions.idOption", "inscriptions.idClasse")
        ->get();

        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);           
        }

        return $data;
    }


    function putstatAnnee_table_paiement_classe()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->selectRaw('paiements.datePaiement as nom,options.nomOption,classes.nomClasse, sum(paiements.montant) as nombre')
        ->where('paiements.etatPaiement', '=', 1)
        ->whereYear('paiements.datePaiement', '=', date('Y'))
        ->whereMonth('paiements.datePaiement', '=', date('m'))
        ->groupBy("paiements.datePaiement","inscriptions.idOption", "inscriptions.idClasse")
        ->get();

        $data = [];
        $nom ="";
        foreach ($presence as $row) {
            $nom = $row->nom.'-'.$row->nomOption.'-'.$row->nomClasse;
            array_push($data, $nom);           
        }

        return $data;
    }

     /*
    *
    *=============================================
    * Fin statistique sur le paiement par option 
    *=============================================
    *
    */











   
}
