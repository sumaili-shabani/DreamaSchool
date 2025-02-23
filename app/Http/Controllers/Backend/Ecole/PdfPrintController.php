<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Backend\Paiement\{Prevision};
use App\Traits\{GlobalMethod,Slug};
use DB;



class PdfPrintController extends Controller
{
    
    use GlobalMethod, Slug;


    /*
    *
    * ====================================
    * Carte d'electeur
    * ====================================
    *
    */
    function queryInscription($codeInscription){

        \DB::statement("SET SQL_MODE=''");

        $data = DB::table('inscriptions')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        //localisation
        ->join('avenues','avenues.id','=','eleves.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')

        ->select('inscriptions.id',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
            'inscriptions.reductionPaiement',
            'inscriptions.codeInscription',
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays','fraisinscription','restoreinscription',

            'inscriptions.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->where('inscriptions.codeInscription', $codeInscription)
        ->take(1)
        ->get();

        return $data;

    }


    function print_card_identification(Request $request)
    {
        if ($request->get('codeInscription')) 
        {
            $codeInscription = $request->get('codeInscription');
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlFicheCardidentificationEleve($codeInscription);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('fiche_card_identification_codeInscription:-'.$codeInscription.'.pdf');

        }
    }

    function viewHtmlFicheCardidentificationEleve($codeInscription)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $text3="CARTE D'ELEVE";

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        $data = $this->queryInscription($codeInscription);
        $photoEleve ='';
        $nomEleve;
        $postNomEleve;
        $preNomEleve;
        $sexeEleve;
        $etatCivilEleve;
        $ageEleve;
        $designation;

        $nomSection;
        $nomOption;
        $nomClasse;

        foreach ($data as $row) {
            $photoEleve     = $this->displayImg('images', $row->photoEleve);
            $nomEleve       = $row->nomEleve;
            $postNomEleve   = $row->postNomEleve;
            $preNomEleve    = $row->preNomEleve;
            $sexeEleve      = $row->sexeEleve;
            $etatCivilEleve = $row->etatCivilEleve;
            $ageEleve       = $row->ageEleve;
            $designation    = $row->designation;

            $nomSection     = $row->nomSection;
            $nomOption      = $row->nomOption;
            $nomClasse      = $row->nomClasse;
            

        }
        $output = '
        <!doctype html>
        <html lang="fr">
          <head>
            <!-- Required meta tags -->
            <title>Carte d\'élève codeInscription:'.$codeInscription.' </title>

            <style>

              
                *{
                    font-size: 0.9rem !important;
                    font-family: Roboto, sans-serif !important;
                    letter-spacing: .0333333333em!important;
                    padding:0px;
                }
                .table_detail{
                    font-size: 0.9rem !important;
                    font-family: Roboto, sans-serif !important;

                    letter-spacing: .0333333333em!important;
                }

                .page-break {
                    page-break-after: always;
                }

                @page {
                  size: A6 portrait;
                  margin:20px;
                }

            </style>
          </head>
          <body>
            
            <div style="border:1px solid black;padding:1px; height:auto;">
                <div align="center" style="text-align:center;">
                    <h3 style="font-size: 20px;""><u>'.$text1.'</u></h3>
                </div>
                
                <table class="table table-responsive" cellpadding="7" cellspacing="0" border="0" width="100%" style="border:0px solid black;padding:0px;"
                >
                    <tr>

                        <td width="50%" class="table_detail" align="right">

                            <div align="text-align:right;">
                                <h4>'.$text2.' </h4>
                                <h2>'.$text3.' </h2>
                               
                            </div>
                        </td>

                        <td width="50%" class="table_detail">

                            <div style="margin:10px;">
                                <img src="'.$logordc.'"  style=";
                                    margin-bottom: 1px;
                                    border-radius: 2px 2px 0 0;
                                    overflow: hidden;
                                    width : 100vw;
                                    height : 100vh;
                                    max-width : 50px;
                                    max-height : 50px;
                                    float:left;
                                    margin-right:10px;

                                   
                                "/>
                               <p>
                                
                                <b>Code Elève</b>: '.$codeInscription.' <br>
                                <b>Promotion</b>: '.$nomSection.' - '.$nomOption.' <br>
                                <b>Classe</b>: '.$nomClasse.' <br>
                               </p>
                            </div>
                        </td>

                       
                    </tr>

                </table>

                <table class="table table-responsive table_detail" cellpadding="7" cellspacing="0" border="0" width="100%" style="border:0px solid black;padding:0px;" 
                >';

                foreach ($data as $row) {
                    $nomParents = 'Noms Parents:'.$row->nomPere.' - '.$row->nomMere;
                    $photoEleve = $this->displayImg('images', $row->photoEleve);
                    $output .='
                        <tr>
                            <td width="75%" align="right">
                                <div>

                                    <img src="'.$photoEleve.'"  style=";
                                        margin-bottom: 1px;
                                        border-radius: 2px 2px 0 0;
                                        overflow: hidden;
                                        width : 100vw;
                                        height : 100vh;
                                        max-width : 100px;
                                        max-height : 100px;
                                        float:left;
                                        margin-right:10px;
                                        margin-left:10px;

                                       
                                    "/>
                                   <p>
                                   
                                    Nom: <b>'.$row->nomEleve.'</b> <br>
                                    PostNom / Prenom: <b>'.$row->postNomEleve.' / '.$row->preNomEleve.'</b> <br>
                                    Adresse: <b>'.$row->nomAvenue.'</b> <br>
                                    <b>'.$row->nomQuartier.' - '.$row->nomCommune.' - '.$row->nomVille.'</b> <br>
                                    Année scolaire: <b> '.$row->designation.'</b> <br>
                                    
                                        
                                   </p>
                                </div>
                            </td>
                            <td width="25%">
                                <div style="margin:15px;">
                                    <p>
                                        <b>Sexe:</b> '.$row->sexeEleve.'
                                    </p>
                                    
                                    '.$this->generateQrcodeTiquetCard($codeInscription).'
                                </div>

                                
                            </td>
                        </tr>

                        <tr>
                            <td width="50%" align="right">
                                Nom du père: <b>'.$row->nomPere.'</b> <br>
                                Nom de la mère: <b>'.$row->nomMere.'</b> <br>
                            </td>
                            <td width="50%">
                                <div style="margin-left: 15px;">

                                    
                                    Lieu et Date de livraison:  <br>
                                    <b> Goma ville le '.$this->CreatedFormat(date("Y-m-d")).' </b>
                                   
                                    
                                </div>
                                                               
                            </td>
                        </tr> 

                        
                       
                    ';
                }

                $output .='
                </table>';


                $output .='
                <br><br><br>

                '.$this->retroVerso($data).'

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }

    function retroVerso($data){
        $output ='';
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $carte = $this->displayImg('images', 'carte2.png');

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        foreach ($data as $row) {
            // code...
            $output .=' 
                <div>
                    <table class="table table-responsive table_detail" cellpadding="7" cellspacing="0" border="0" width="100%" style="border:0px solid black;padding:0px;" 
                    >
                        <tr>
                            <td width="25%">

                                <img src="'.$logordc.'"  style=";
                                        margin-bottom: 1px;
                                        border-radius: 2px 2px 0 0;
                                        overflow: hidden;
                                        width : 100vw;
                                        height : 100vh;
                                        max-width : 50px;
                                        max-height : 50px;
                                        margin-left:10px;
                                       
                                "/>

                            </td>
                            <td width="50%">

                                <div style="margin:10px; text-align:center;">

                                    '.$text1.'
                                    '.$text2.'
                                    
                                </div>

                            </td>
                            <td width="25%">
                                <img src="'.$logodgrpi.'"  style=";
                                        margin-bottom: 1px;
                                        border-radius: 2px 2px 0 0;
                                        overflow: hidden;
                                        width : 100vw;
                                        height : 100vh;
                                        max-width : 50px;
                                        max-height : 50px;
                                        margin-right:5px;
                                                                              
                                "/>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" width="100%">

                                <div>

                                    <img src="'.$carte.'"  style=";
                                            margin-bottom: 1px;
                                            border-radius: 2px 2px 0 0;
                                            overflow: hidden;
                                            width : 100vw;
                                            height : 100vh;
                                            max-width : 320px;
                                            max-height : 320px;
                                            
                                            margin-right:5px;
                                            margin-left:5px;
                                           
                                    "/>
                                    
                                </div>


                            </td>
                            
                        </tr>

                        <tr>
                            <td colspan="3" width="100%">
                                <div style="margin:10px;" align="center">
                                    
                                    <b>Promotion:</b> '.$row->nomSection.' - '.$row->nomOption.' -'.$row->nomClasse.'/ '.$row->designation.'
                                </div>
                                <div style="margin:5px;" align="center">
                                    Nom Elève: <b>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.' </b> <br>
                                    <b>Province:</b> '.$row->nomProvince.'
                                </div>
                            </td>
                            
                            
                        </tr>

                    </table>

                    
                </div>

               
            ';
        }

        $output .='';

        return $output;

    }

    /*
    *
    * ====================================
    * Fin Carte d'electeur
    * ====================================
    *
    */


    /*
    *
    * ====================================
    * Fin Recu de paiement
    * ====================================
    *
    */

    function queryRecuPaiement($codePaiement)
    {
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
            'inscriptions.reductionPaiement',
            'inscriptions.codeInscription',
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
            'users.name','users.email','users.avatar','fraisinscription','restoreinscription',
            "paiements.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->where('paiements.codePaiement', $codePaiement)
        ->take(1)
        ->get();

        return $data;
    }

    function print_recu_paiement(Request $request)
    {
        if ($request->get('codePaiement')) 
        {
            $codePaiement = $request->get('codePaiement');
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlRecuPaiementEleve($codePaiement);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a7', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('recu_paiement_eleve_codePaiement:-'.$codePaiement.'.pdf');

        }
    }

    function viewHtmlRecuPaiementEleve($codePaiement)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $text3="RECU DE PAIEMENT";

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        $data = $this->queryRecuPaiement($codePaiement);
        
        $output = '
        <!doctype html>
        <html lang="fr">
          <head>
            <!-- Required meta tags -->
            <title>Reçu de paiement d\'élève codePaiement:'.$codePaiement.' </title>

            <style>

              
                *{
                    font-size: 0.9rem !important;
                    font-family: Roboto, sans-serif !important;
                    letter-spacing: .0333333333em!important;
                    padding:0px;
                }
                .table_detail{
                    font-size: 0.9rem !important;
                    font-family: Roboto, sans-serif !important;

                    letter-spacing: .0333333333em!important;
                }

                .page-break {
                    page-break-after: always;
                }

                @page {
                  size: A6 portrait;
                  margin:20px;
                }

            </style>
          </head>
          <body>
            
            <div style="border:1px solid black;padding:1px; height:auto;">';
                
                $output .='
                <div style="margin:15px;">

                '.$this->recu_paiement($codePaiement).'
                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }

    function recu_paiement($codePaiement){
        $output ='';
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $carte = $this->displayImg('images', 'carte2.png');

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        $data = $this->queryRecuPaiement($codePaiement);

        foreach ($data as $row) {
            $montantApayer = $this->getSumMontantApayer($row->idClasse, $row->idOption, $row->idAnne);
            $montantPayer = $this->getSumMontantPayerEleve($row->idInscription);

            $montantRemise = round((($montantApayer * $row->reductionPaiement) / 100), 01);
            $resteApayer = (($montantApayer - $montantPayer) - $montantRemise - ($row->fraisinscription) + ($row->restoreinscription));
//restoreinscription
            // code...
            $output .=' 
                <div>
                    <table class="table table-responsive table_detail" cellpadding="7" cellspacing="0" border="0" width="100%" style="border:0px solid black;padding:0px;" 
                    >
                        <tr>
                            <td width="25%">

                                <img src="'.$logordc.'"  style=";
                                        margin-bottom: 1px;
                                        border-radius: 2px 2px 0 0;
                                        overflow: hidden;
                                        width : 100vw;
                                        height : 100vh;
                                        max-width : 50px;
                                        max-height : 50px;
                                        margin-left:10px;
                                       
                                "/>

                            </td>
                            <td width="50%">

                                <div style="margin:10px; text-align:center;">

                                    '.$text1.'
                                    '.$text2.'
                                    
                                </div>

                            </td>
                            <td width="25%">
                                <img src="'.$logodgrpi.'"  style=";
                                        margin-bottom: 1px;
                                        border-radius: 2px 2px 0 0;
                                        overflow: hidden;
                                        width : 100vw;
                                        height : 100vh;
                                        max-width : 50px;
                                        max-height : 50px;
                                        margin-right:5px;
                                                                              
                                "/>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="1" width="40%">

                                '.$this->generateQrcodeTiquetCard($codePaiement).'

                            </td>
                            
                            <td colspan="2" width="60%">

                                <div style="margin-left:10px;">
                                   
                                    <div style="border:1 solid black;">
                                        <div style="margin:10px;">

                                            <h3>Reçu N°: <b>'.$row->codePaiement.'</b> </h3>

                                            Date de paiement: <b>'.$this->CreatedFormat($row->created_at).'</b> <br>
                                            
                                        </div>
                                        
                                    </div>
                                     
                                </div>

                            </td>
                            
                        </tr>

                        <tr>
                            <td colspan="3" width="100%">

                                

                                <div style="margin-top:10px;">

                                De: <u><b>'.$row->nomEleve.' '.$row->postNomEleve.'  '.$row->preNomEleve.'</b></u> <br>

                                Inscrit(e) dans la classe: <u><b>'.$row->nomSection.' - '.$row->nomOption.' - '.$row->nomClasse.'</b></u> <br>


                                Pour : <u><b> Paiement de  '.$row->nomTranche.' ('.$row->nomTypeTranche.') </b></u> <br>
                                La somme de : <u><b>'.$this->chiffreEnLettre($row->montant).'</b></u> dollars  <u><b>('.$row->montant.' $)</b></u> <br>
                                Reste à Payé : </u><b>'.$resteApayer.' $</b></u> 
                                    <div align="right">
                                        Auteur: <u><b>'.$row->name.'</b></u>
                                        
                                    </div>
                                 <br>

                                    
                                    
                                </div>


                            </td>
                            
                        </tr>


                    </table>

                    
                </div>

               
            ';
        }

        $output .='';

        return $output;

    }

    /*
    *
    * ====================================
    * Fin recu de paiement
    * ====================================
    *
    */


     /*
    *
    * ====================================
    * Ensemble de Recu de paiement
    * ====================================
    *
    */

    function queryRecuPaiementSigle($codeInscription)
    {
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
            'inscriptions.reductionPaiement',
            'inscriptions.codeInscription',
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
            'users.name','users.email','users.avatar','fraisinscription','restoreinscription',
            "paiements.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')
        ->where('inscriptions.codeInscription', $codeInscription)
        ->get();

        return $data;
    }

    function print_recu_paiement_sigle(Request $request)
    {
        if ($request->get('codeInscription')) 
        {
            $codeInscription = $request->get('codeInscription');
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlRecuPaiementEleveSigle($codeInscription);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('information_sur_les_paiements_eleve_codeInscription:-'.$codeInscription.'.pdf');

        }
    }

    function viewHtmlRecuPaiementEleveSigle($codeInscription)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $text3="INFORMATION GENERALE SUR LES PAIEMENTS";

        $logordc = $this->displayImg('images', 'logo.png');
        $logodgrpi = $this->displayImg('images', 'logo.png');
        
        // $noms_eleve = $this->getNomEleve($codeInscription);
        // $classe_eleve = $this->getClasseEleve($codeInscription);
        // $option_eleve = $this->getOptionEleve($codeInscription);
        // 
        
        $output = '
        <!doctype html>
        <html lang="fr">
          <head>
            <!-- Required meta tags -->
            <title>Information sur les paiements d\'élève codeInscription:'.$codeInscription.' </title>

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
                  size: A4 portrait;
                  margin:20px;
                }

            </style>
          </head>
          <body>
            
            <div style="border:1px solid black;padding:1px; height:auto;">';
                
                $output .='
                <div style="margin:15px;">
                '.$this->entetePrintPDF($text1, $text2, $text3).'

                <br><br>
                  Nom : '.$this->getNomEleve($codeInscription).'
                  <br>
                  Adresse : '.$this->getClasseEleve($codeInscription).'
                  <br>
                  Option : '.$this->getOptionEleve($codeInscription).'
                <br><br>

                '.$this->information_recu_paiement($codeInscription).'
                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }

    function information_recu_paiement($codeInscription){
        $output ='';
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $carte = $this->displayImg('images', 'carte2.png');

        $logordc = $this->displayImg('images', 'logo.png');
        $logodgrpi = $this->displayImg('images', 'logo.png');
        $count = 0;
        $montantApayer;
        $montantPayer;
        $resteApayer;


        $data = $this->queryRecuPaiementSigle($codeInscription);
            // code...
            $output .=' 
                <div>
                    <table class="table table-responsive table_detail" cellpadding="7" cellspacing="0" border="1" width="100%" style="border:0px solid black;padding:0px;" 
                    >
                    <thead>                      
                   
                        <tr>
                            <td colspan="1">N°</td>
                            <td colspan="1">Date</td>
                            <td colspan="1">Tranche</td>
                            <td colspan="1">Frais</td>
                            <td colspan="1">Montant($)</td>
                            
                        </tr> 
                    </thead>
                    <tbody>
                ';

            foreach ($data as $row) {
                //PrevisionReduction
                $count++;
                $montantApayer = $this->getSumMontantApayer($row->idClasse, $row->idOption, $row->idAnne);
                $montantPayer = $this->getSumMontantPayerEleve($row->idInscription);
                $resteApayer = ($montantApayer - $montantPayer - ($row->fraisinscription) + ($row->restoreinscription) - ($row->PrevisionReduction));

                $output .='
                <tr>
                    <td colspan="1">'.$count.'</td>
                    <td colspan="1">'.$this->CreatedFormat($row->datePaiement).'</td>
                    <td colspan="1">'.$row->nomTranche.'</td>
                    <td colspan="1">'.$row->nomTypeTranche.'</td>
                    <td colspan="1">'.$row->montant.'</td>
                    
                </tr>
                ';


            }


            $output .='</tbody>
                        <tr>
                            <td colspan="4" align="right">Total Montant à Payer</td>
                            <td colspan="1">'.$montantApayer.'</td>
                            
                        </tr>
                        <tr>
                            <td colspan="4" align="right">Montant total déjà Payé</td>
                            <td colspan="1">'.$montantPayer.'</td>
                            
                        </tr>
                        <tr>
                            <td colspan="4" align="right">Total Reste à Payer</td>
                            <td colspan="1">'.$resteApayer.'</td>
                            
                        </tr>

                       

                    </table>

                    
                </div>

               
            ';
        

        $output .='';

        return $output;

    }

    /*
    *
    * ====================================
    * Fin recu de paiement
    * ====================================
    *
    */

     /*
    *
    * ====================================
    * Echeancier Global
    * ====================================
    *
    */

    function queryEcheancierPromotion($idAnne, $idOption, $idSection, $idClasse)
    {
        $data = DB::table("previsions")
        ->join('tranches','tranches.id','=','previsions.idTranche')
        ->join('type_tranches','type_tranches.id','=','previsions.idFrais')
        
        ->join('classes','classes.id','=','previsions.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','previsions.idAnne')
        ->join('options','options.id','=','previsions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        
        ->select("previsions.id",
            //previsions
            'previsions.idTranche','previsions.idFrais',
            'previsions.idClasse','previsions.idOption',
            'previsions.idAnne','previsions.montant',
            'previsions.etatPrevision',
            'previsions.date_debit_prev','previsions.date_fin_prev',

            //tranches 
            "tranches.nomTranche",

            //type tranche
            'type_tranches.nomTypeTranche', 

           
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "previsions.created_at")
        ->where([
            ['previsions.idAnne', $idAnne],
            ['previsions.idOption', $idOption],
            ['options.idSection', $idSection],
            ['previsions.idClasse', $idClasse],
        ])
        ->orderBy('previsions.date_debit_prev', 'Asc')
        ->get();

        return $data;
    }

    function print_echeancier_promotion(Request $request)
    {
        if ($request->get('idAnne') && $request->get('idOption') && $request->get('idSection') && $request->get('idClasse')) 
        {
            $idAnne         = $request->get('idAnne');
            $idOption       = $request->get('idOption');
            $idSection      = $request->get('idSection');
            $idClasse       = $request->get('idClasse');

            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlEcheancierPromotion($idAnne, $idOption, $idSection, $idClasse);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('information_sur_echeancier_classe_idClasse:-'.$idClasse.'.pdf');

        }
    }

    function viewHtmlEcheancierPromotion($idAnne, $idOption, $idSection, $idClasse)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $text3="INFORMATION GENERALE SUR L'ECHEANCIER DE PAIEMENT";

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        
        $output = '
        <!doctype html>
        <html lang="fr">
          <head>
            <!-- Required meta tags -->
            <title>Echeancier de paiement d\'élève Classe:'.$idClasse.' </title>

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
                  size: A4 portrait;
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

                    <h2 style="padding:5px;">'.$this->getPromotionClasse($idClasse).' - '.$this->getPromotionOption($idOption).' - '.$this->getPromotionAnnee($idAnne).'</h2>
                    
                </div>

                '.$this->information_echeancier_paiement($idAnne, $idOption, $idSection, $idClasse).'
                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }

    function information_echeancier_paiement($idAnne, $idOption, $idSection, $idClasse){
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
        $montantApayer = $this->showSumMontantPayerParClasse($idAnne, $idOption, $idSection, $idClasse);

        $data = $this->queryEcheancierPromotion($idAnne, $idOption, $idSection, $idClasse);
            // code...
            $output .=' 
                <div>
                    <table class="table table-responsive table_detail" cellpadding="7" cellspacing="0" border="1" width="100%" style="border:0px solid black;padding:0px;" 
                    >
                    <thead>
                        
                   
                        <tr>
                            <td colspan="1">N°</td>
                            <td colspan="1">Date Debit de paiement</td>
                            <td colspan="1">Date Fin de paiement</td>
                            <td colspan="1">Tranche</td>
                            <td colspan="1">Frais</td>
                            <td colspan="1">Montant($)</td>
                            
                        </tr> 
                    </thead>
                    <tbody>
                ';

            foreach ($data as $row) {
                $count++;
               
                $output .='
                <tr>
                    <td colspan="1" >'.$count.'</td>
                    <td colspan="1" >'.$this->CreatedFormat($row->date_debit_prev).'</td>
                    <td colspan="1" >'.$this->CreatedFormat($row->date_fin_prev).'</td>
                    <td colspan="1" > 
                        '.$row->nomTranche.'
                    </td>
                    <td colspan="1" > 
                        '.$row->nomTypeTranche.'
                    </td>
                    <td colspan="1" >'.$row->montant.'</td>
                    
                </tr>
                ';


            }


            $output .='</tbody>
                        <tr>
                            <td colspan="5" align="right">Total Montant à Payer</td>
                            <td colspan="1">'.$montantApayer.'</td>
                            
                        </tr>
                       

                    </table>

                    
                </div>

               
            ';
        

        $output .='';

        return $output;

    }

    /*
    *
    * ====================================
    * Fin recu de paiement
    * ====================================
    *
    */



    /*
    *
    * ====================================
    * paiement par Annee scolaire
    * ====================================
    *
    */

    function queryEcheancierAnneeScolaire($idAnne)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("previsions")
        ->join('tranches','tranches.id','=','previsions.idTranche')
        ->join('type_tranches','type_tranches.id','=','previsions.idFrais')
        
        ->join('classes','classes.id','=','previsions.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','previsions.idAnne')
        ->join('options','options.id','=','previsions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        
        ->select("previsions.id",
            //previsions
            'previsions.idTranche','previsions.idFrais',
            'previsions.idClasse','previsions.idOption',
            'previsions.idAnne','previsions.montant',
            'previsions.etatPrevision',
            'previsions.date_debit_prev','previsions.date_fin_prev',

            //tranches 
            "tranches.nomTranche",

            //type tranche
            'type_tranches.nomTypeTranche', 

           
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "previsions.created_at")
        ->where([
            ['previsions.idAnne', $idAnne],

        ])
        ->groupBy('previsions.idOption')
        ->get();

        return $data;
    }

    function querySumMontantEcheancierAnneeScolaire($idAnne, $idOption)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("previsions")
        ->join('tranches','tranches.id','=','previsions.idTranche')
        ->join('type_tranches','type_tranches.id','=','previsions.idFrais')
        
        ->join('classes','classes.id','=','previsions.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','previsions.idAnne')
        ->join('options','options.id','=','previsions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        
        ->select("previsions.id",
            //previsions
            'previsions.idTranche','previsions.idFrais',
            'previsions.idClasse','previsions.idOption',
            'previsions.idAnne','previsions.montant',
            'previsions.etatPrevision',
            'previsions.date_debit_prev','previsions.date_fin_prev',

            //tranches 
            "tranches.nomTranche",

            //type tranche
            'type_tranches.nomTypeTranche', 

           
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "previsions.created_at")
        ->selectRaw('sum(previsions.montant) as sum_montant')
        ->where([
            ['previsions.idAnne', $idAnne],
            ['previsions.idOption', $idOption],

        ])
        ->groupBy('previsions.idClasse')
        ->get();

        return $data;
    }

    function print_echeancier_anneescolaire(Request $request)
    {
        if ($request->get('idAnne')) 
        {
            $idAnne         = $request->get('idAnne');
           
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlEcheancierAnneScolaire($idAnne);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('information_sur_echeancier_generale:-'.$idAnne.'.pdf');

        }
    }

    function viewHtmlEcheancierAnneScolaire($idAnne)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite();
        $text3="INFORMATION GENERALE SUR L'ECHEANCIER DE PAIEMENT";

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        
        $output = '
        <!doctype html>
        <html lang="fr">
          <head>
            <!-- Required meta tags -->
            <title>Echeancier de paiement par année scolaire:'.$idAnne.' </title>

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
                  size: A4 portrait;
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

                    <h2 style="padding:5px;">Année scolaire: '.$this->getPromotionAnnee($idAnne).'</h2>
                    
                </div>

                '.$this->information_echeancier_paiement_annescolaire($idAnne).'

                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }

    function information_echeancier_paiement_annescolaire($idAnne){
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
        
        $data = $this->queryEcheancierAnneeScolaire($idAnne);
            // code...
            $output .=' 
                <div>
                    <table class="table table-responsive table_detail" cellpadding="7" cellspacing="0" border="1" width="100%" style="border:0px solid black;padding:0px;" 
                    >
                       
                        <tr>
                            <td colspan="1">N°</td>
                            <td colspan="1">Option</td>
                            <td colspan="2">Détails</td>
                        </tr> 
                    
                ';

            foreach ($data as $row) {
                $count++;
                $montantApayer = $this->showSumMontantPayerParClasse($row->idAnne, $row->idOption, $row->idSection, $row->idClasse);
               
                $output .='
                <tr>
                    <td colspan="1">'.$count.'</td>
                    <td colspan="1">'.$row->nomOption.'</td>

                    <td colspan="2">
                        '.$this->getMontantAnneeScolairePArPayement($row->idAnne, $row->idOption).'

                    </td>
                   

                    
                </tr>
                ';


            }


            $output .='
                        
                    </table>

                    
                </div>

               
            ';
        

        $output .='';

        return $output;

    }

    function getMontantAnneeScolairePArPayement($idAnne, $idOption)
    {
        $output = '';
        $count = 0;
        $data = $this->querySumMontantEcheancierAnneeScolaire($idAnne, $idOption);
            // code...
            $output .=' 
                <div>
                    <table class="table table-responsive table_detail" cellpadding="7" cellspacing="0" border="1" width="100%" style="border:0px solid black;padding:0px;" 
                    >
                    <thead>

                        <tr>
                            
                            <td colspan="1">Classe</td>
                            <td colspan="1">Montant</td>
                        </tr> 

                    </thead>
                    <tbody>
                ';

            foreach ($data as $row) {
                $count++;
               
                $output .='
                <tr>
                    
                    <td colspan="1">'.$row->nomClasse.'</td>
                    <td colspan="1">'.$row->sum_montant.'</td>
                   
                    
                </tr>
                ';


            }


            $output .='</tbody>
                       
                    </table>

                </div>
               
            ';
        

        $output .='';

        return $output;

    }

    /*
    *
    * ====================================
    * Annee scolaire et paiement
    * ====================================
    *
    */
















}
