<?php

namespace App\Http\Controllers\Backend\Paiement\Rapport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Paiement\{Clauture};
use App\Traits\{GlobalMethod,Slug};
use DB;

class PdfRapEffectifController extends Controller
{
    
     use GlobalMethod, Slug;


    /*
    *
    * ====================================
    * Affichage des  rapports effectfs
    * ====================================
    *
    */


    function queryEffectifclauturePromotion($idAnne)
    {
        \DB::statement("SET SQL_MODE=''");

        $data = DB::table("clautures")
        ->join('classes','classes.id','=','clautures.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','clautures.idAnne')
        ->join('options','options.id','=','clautures.idOption')
        ->join('sections','sections.id','=','options.idSection')

        ->leftjoin('mois_scolaires','mois_scolaires.id','=','clautures.refMois')
        
        ->select("clautures.id",
            //clautures
            'clautures.idAnne','clautures.idOption',
            'clautures.idClasse','clautures.idSection',
            'clautures.refMois','clautures.mois',
            'clautures.effectifClasse','clautures.effectifAbandon',
            'clautures.effectifTotal',

            //mois scolaire
            "mois_scolaires.nomMois",

            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "clautures.created_at")
        ->where([
            ['clautures.idAnne', $idAnne],
        ])
        ->groupBy('clautures.idClasse', 'clautures.idOption')
        ->orderBy('sections.nomSection', 'Asc')
        ->get();

        return $data;
    }

    //voir effectif par classe
    function queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption)
    {
        \DB::statement("SET SQL_MODE=''");

        $data = DB::table("clautures")
        ->join('classes','classes.id','=','clautures.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','clautures.idAnne')
        ->join('options','options.id','=','clautures.idOption')
        ->join('sections','sections.id','=','options.idSection')

        ->leftjoin('mois_scolaires','mois_scolaires.id','=','clautures.refMois')
        
        ->select("clautures.id",
            //clautures
            'clautures.idAnne','clautures.idOption',
            'clautures.idClasse','clautures.idSection',
            'clautures.refMois','clautures.mois',
            'clautures.effectifClasse','clautures.effectifAbandon',
            'clautures.effectifTotal',

            //mois scolaire
            "mois_scolaires.nomMois",

            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "clautures.created_at")
        ->where([
            ['clautures.idAnne', $idAnne],
            ['clautures.refMois', $refMois],
            ['clautures.idClasse', $idClasse],
            ['clautures.idOption', $idOption],

        ])
        ->orderBy('sections.nomSection', 'Asc')
        ->take(1)
        ->get();
        $effectif = 0;
        foreach ($data as $row) {
            // code...
            $effectif =$row->effectifTotal;
        }

        return $effectif;
    }

    //voir effectif montant payer par classe
    function queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption)
    {
        \DB::statement("SET SQL_MODE=''");

        $data = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        ->join('users','users.id','=','paiements.idUser')

        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        
        ->select("paiements.id",
            //paiements
            'paiements.idTranche','paiements.idFrais',
            'paiements.idInscription','paiements.montant',
            'paiements.datePaiement','paiements.codePaiement',
            'paiements.idUser','paiements.etatPaiement',

            //tranches 
            "tranches.nomTranche",

            //type tranche
            'type_tranches.nomTypeTranche', 

            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
            'inscriptions.codeInscription',
            'inscriptions.reductionPaiement',
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
            //division
            'divisions.nomDivision',

            //eleves
            'eleves.idAvenue', 'eleves.nomEleve',
            'eleves.postNomEleve', 'eleves.preNomEleve',
            'eleves.etatCivilEleve', 'eleves.sexeEleve',
            'eleves.nomPere', 'eleves.nomMere',
            'eleves.numPere', 'eleves.numMere',
            'eleves.codeEleve','eleves.photoEleve',
            'eleves.numAdresseEleve', 'eleves.dateNaisEleve',

            //users
            'users.name','users.email','users.avatar',  DB::raw('YEAR(paiements.datePaiement) year, MONTH(paiements.datePaiement) month'),
            "paiements.created_at")
        ->selectRaw('sum(montant) as sum_montant')
                
        ->where([
            ['inscriptions.idAnne', $idAnne],
            ['inscriptions.idClasse', $idClasse],
            ['inscriptions.idOption', $idOption],
            ['paiements.etatPaiement', 1],

        ])
        ->whereMonth('paiements.datePaiement', '=', $refMois)
        ->groupBy('year', 'month')
        ->get();
        $sum_montant = 0;
        foreach ($data as $row) {
            // code...
            $sum_montant = $row->sum_montant;
        }

        return $sum_montant;
    }

    function print_effectif_promotion(Request $request)
    {
        if ($request->get('idAnne')) 
        {
            $idAnne         = $request->get('idAnne');
            
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlEffectifPromotion($idAnne);

            // $html .='<script type="text/javascript">
            //     window.print();
            //     window.onafterprint = (event) => {
            //       window.close();
            //     };

            // </script>';

            // echo($html);

            // $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            $pdf->loadHTML($html)->setPaper('a3', 'landscape');
            return $pdf->stream('information_sur_le_tableau_de_recettes_et_effectif:-'.$idAnne.'.pdf');

        }
    }

    function viewHtmlEffectifPromotion($idAnne)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $text3="TABLEAU RECAPITILATIF DES EFFECTIFS ET RECETTES ANNEE SCOLLAIRE ".$this->getPromotionAnnee($idAnne);

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        
        $output = '
        <!doctype html>
        <html lang="fr">
          <head>
            <!-- Required meta tags -->
            <title>'.$text3.'</title>

            <style>

              
               
                .table_detail{
                    font-size: 0.9rem !important;
                    font-family: Roboto, sans-serif !important;

                    letter-spacing: .0333333333em!important;
                }

                .page-break {
                    page-break-after: always;
                }

                @page {
                  size: A4 landscape;
                  margin:20px;
                }

            </style>
          </head>
          <body>
            
            <div style="border:1px solid black;padding:1px; height:auto;">';
                
                $output .='
                <div style="margin:15px;">
                '.$this->entetePrintPDF($text1, $text2, $text3).'

                
                <div style="background-color:#0080FF; color:white; text-align:center;">

                    <h2 style="padding:5px;">'.$text3.'</h2>
                    
                </div>

                '.$this->information_effectif_paiement($idAnne).'
                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }

    function information_effectif_paiement($idAnne){
        $output ='';
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $carte = $this->displayImg('images', 'carte2.png');

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');
        $count = 0;
        $montantApayer;
        $montantPayer;
        $resteApayer;
        $montantApayer = 0;

        $data = $this->queryEffectifclauturePromotion($idAnne);
            // code...
            $output .=' 
                <div>
                    <table class="table table-responsive table_detail" cellpadding="7" cellspacing="0" border="1" width="100%" style="border:0px solid black;padding:0px;" 
                    >
                    <thead style="font-style:bold;">
                        
                        <tr>
                        <td colspan="1" rowspan="2">Classe</td>
                            <td colspan="2" rowspan="1">Septembre</td>
                            <td colspan="2" rowspan="1">Octobre</td>
                            <td colspan="2" rowspan="1">Novembret</td>
                            <td colspan="2" rowspan="1">Décebre</td>
                            <td colspan="2" rowspan="1">Janvier</td>
                            <td colspan="2" rowspan="1">Février</td>
                            <td colspan="2" rowspan="1">Mars</td>
                            <td colspan="2" rowspan="1">Avril</td>
                            <td colspan="2" rowspan="1">Mai</td>
                            <td colspan="2" rowspan="1">Juin</td>
                            
                        </tr>


                            <td colspan="1">Eff</td>
                            <td colspan="1">Montant($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Montant($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Montant($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Montant($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Montant($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Montant($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Mon($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Mon($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Mon($)</td>

                            <td colspan="1">Eff</td>
                            <td colspan="1">Mon($)</td>
                            
                            
                        </tr>  
                    </thead>
                    <tbody>
                ';

            $eff9 =0;
            $eff10=0;
            $eff11=0;
            $eff12=0;
            $eff01=0;
            $eff02=0;
            $eff03=0;
            $eff04=0;
            $eff05=0;
            $eff06=0;

            $montant9=0;
            $montant10=0;
            $montant11=0;
            $montant12=0;
            $montant01=0;
            $montant02=0;
            $montant03=0;
            $montant04=0;
            $montant05=0;
            $montant06=0;


            foreach ($data as $row) {
                $count++;
               
                $output .='
                <tr>
                    <td colspan="1">'.$row->nomClasse.' - <b>'.$row->nomOption.'</b></td>

                    <td>'.$this->getEff9($row->idAnne, 9, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant9($row->idAnne, "09", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff10($row->idAnne, 10, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant10($row->idAnne, "10", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff11($row->idAnne, 11, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant11($row->idAnne, "11", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff12($row->idAnne, 12, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant12($row->idAnne, "12", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff01($row->idAnne, 01, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant01($row->idAnne, "01", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff02($row->idAnne, 02, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant02($row->idAnne, "02", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff03($row->idAnne, 03, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant03($row->idAnne, "03", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff04($row->idAnne, 04, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant04($row->idAnne, "04", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff05($row->idAnne, 05, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant05($row->idAnne, "05", $row->idClasse, $row->idOption).'</td>

                    <td>'.$this->getEff06($row->idAnne, 06, $row->idClasse, $row->idOption).'</td>
                    <td>'.$this->getEffMontant06($row->idAnne, "06", $row->idClasse, $row->idOption).'</td>

                    
                    
                    
                </tr>
                ';

                $eff9 += $this->getEff9($row->idAnne, 9, $row->idClasse, $row->idOption);
                $eff10 += $this->getEff10($row->idAnne, 10, $row->idClasse, $row->idOption);
                $eff11 += $this->getEff11($row->idAnne, 11, $row->idClasse, $row->idOption);
                $eff12 += $this->getEff12($row->idAnne, 12, $row->idClasse, $row->idOption);
                $eff01 += $this->getEff01($row->idAnne, 01, $row->idClasse, $row->idOption);
                $eff02 += $this->getEff02($row->idAnne, 02, $row->idClasse, $row->idOption);
                $eff03 += $this->getEff03($row->idAnne, 03, $row->idClasse, $row->idOption);
                $eff04 += $this->getEff04($row->idAnne, 04, $row->idClasse, $row->idOption);
                $eff05 += $this->getEff05($row->idAnne, 05, $row->idClasse, $row->idOption);
                $eff06 += $this->getEff06($row->idAnne, 06, $row->idClasse, $row->idOption);
                
                $montant9 += $this->getEffMontant9($row->idAnne, "09", $row->idClasse, $row->idOption);
                $montant10 += $this->getEffMontant10($row->idAnne, "10", $row->idClasse, $row->idOption);
                $montant11 += $this->getEffMontant11($row->idAnne, "11", $row->idClasse, $row->idOption);
                $montant12 += $this->getEffMontant12($row->idAnne, "12", $row->idClasse, $row->idOption);
                $montant01 += $this->getEffMontant01($row->idAnne, "01", $row->idClasse, $row->idOption);
                $montant02 += $this->getEffMontant02($row->idAnne, "02", $row->idClasse, $row->idOption);
                $montant03 += $this->getEffMontant03($row->idAnne, "03", $row->idClasse, $row->idOption);
                $montant04 += $this->getEffMontant04($row->idAnne, "04", $row->idClasse, $row->idOption);
                $montant05 += $this->getEffMontant05($row->idAnne, "05", $row->idClasse, $row->idOption);
                $montant06 += $this->getEffMontant06($row->idAnne, "06", $row->idClasse, $row->idOption);


            }

            $output .='
                <tr>
                    <td colspan="1" align="right"><b>TOTAL</b></td>

                    <td><b>'.$eff9.'</b></td>
                    <td><b>'.$montant9.'</b></td>

                    <td><b>'.$eff10.'</b></td>
                    <td><b>'.$montant10.'</b></td>

                    <td><b>'.$eff11.'</b></td>
                    <td><b>'.$montant11.'</b></td>

                    <td><b>'.$eff12.'</b></td>
                    <td><b>'.$montant12.'</b></td>

                    <td><b>'.$eff01.'</b></td>
                    <td><b>'.$montant01.'</b></td>

                    <td><b>'.$eff02.'</b></td>
                    <td><b>'.$montant02.'</b></td>

                    <td><b>'.$eff03.'</b></td>
                    <td><b>'.$montant03.'</b></td>

                    <td><b>'.$eff04.'</b></td>
                    <td><b>'.$montant04.'</b></td>

                    <td><b>'.$eff05.'</b></td>
                    <td><b>'.$montant05.'</b></td>

                    <td><b>'.$eff06.'</b></td>
                    <td><b>'.$montant06.'</b></td>

                    
                </tr>
                ';


            $output .='</tbody>
                        
                    </table>

                    
                </div>

               
            ';
        

        $output .='';

        return $output;

    }

    /*
    *
    *===================
    *pour les mois
    *===================
    *
    */

    //septembre
    function getEff9($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant9($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }
    //octobre
    function getEff10($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant10($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }

    //Novembre
    function getEff11($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant11($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }
    //Decembre
    function getEff12($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant12($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }

    //Janvier
    function getEff01($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant01($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }

    //Fevrier
    function getEff02($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant02($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }

    //Mars
    function getEff03($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant03($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }
    //Avril
    function getEff04($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant04($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }
    //Mai
    function getEff05($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant05($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }
    //juin
    function getEff06($idAnne, $refMois, $idClasse, $idOption)
    {
        $effectif = $this->queryEffectifClasse($idAnne, $refMois, $idClasse, $idOption);
        return $effectif;
        

    }
    function getEffMontant06($idAnne, $refMois, $idClasse, $idOption)
    {

        $montant = $this->queryEffectifMonantClasse($idAnne, $refMois, $idClasse, $idOption);
        return $montant;


    }


    /*
    *
    * ====================================
    * Affichage des  rapports effectfs
    * ====================================
    *
    */



}
