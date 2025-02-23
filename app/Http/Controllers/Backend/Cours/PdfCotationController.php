<?php

namespace App\Http\Controllers\Backend\Cours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Cours\{AttributionCours};
use App\Traits\{GlobalMethod,Slug};
use DB;

class PdfCotationController extends Controller
{
    use GlobalMethod;

     /*
    *
    *=========================================
    * Impressions de cours par classe
    *=========================================
    */
    function querySumMaximaleCoursparClasse($idAnne, $idOption, $idClasse, $idPeriode)
    {
        $data = DB::table("attribution_cours")
        ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
        ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
        ->join('cours','cours.id','=','attribution_cours.idCours')
        ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

        ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
        ->join('options','options.id','=','attribution_cours.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','attribution_cours.idClasse')
        ->selectRaw('SUM(maximale) as sum_maximale')
        ->where([
            ['attribution_cours.idAnne', '=', $idAnne],
            ['attribution_cours.idOption', '=', $idOption],
            ['attribution_cours.idClasse', '=', $idClasse],
            ['attribution_cours.idPeriode', '=', $idPeriode],
        ])
        ->sum('attribution_cours.maximale');

       

        return $data;

    }

    function querySumMaximaleCoursparEleve($idAnne, $idOption, $idClasse, $idPeriode, $idInscription)
    {
        $data = DB::table("cotations")
        ->join('inscriptions','inscriptions.id','=','cotations.idInscription')
        ->join('periodes','periodes.id','=','cotations.idPeriode')
        ->join('cours','cours.id','=','cotations.idCours')

        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')

        ->select("cotations.id",
            //cotations
            'cotations.idInscription','cotations.idCours',
            'cotations.idPeriode','cotations.cote',
            'cotations.codeCote', 'cotations.maxima',
            //cours
            'cours.nomCours',
            //periodes
            'periodes.nomPeriode',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
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
           
            "cotations.created_at")
        ->selectRaw('SUM(cotations.cote) as sum_cote')
        ->where([
            ['inscriptions.idAnne', '=', $idAnne],
            ['inscriptions.idOption', '=', $idOption],
            ['inscriptions.idClasse', '=', $idClasse],
            ['cotations.idPeriode', '=', $idPeriode],
            ['cotations.idInscription', '=', $idInscription]
        ])
        ->sum('cotations.cote');


        return $data;

    

    }

    //voir la liste des eleves par classe 
    function getListEleveInscriptParClasse($idAnne, $idOption, $idClasse)
    {
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',
            //Paiement     anne_scollaires.statut
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")
        ->where([
            ['inscriptions.idAnne', '=', $idAnne],
            ['inscriptions.idOption', '=', $idOption],
            ['inscriptions.idClasse', '=', $idClasse],
        ])
        ->orderBy('eleves.nomEleve')
        ->get();

        return $data;


    }





    function print_resultat_cotation_par_classe(Request $request)
    {
        if ($request->get('idAnne') && $request->get('idOption') && $request->get('idClasse') && $request->get('idPeriode')) 
        {
            $idAnne         = $request->get('idAnne');
            $idOption       = $request->get('idOption');
            $idClasse       = $request->get('idClasse');
            $idPeriode      = $request->get('idPeriode');
            
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlCoursParClasse($idAnne,$idOption, $idClasse, $idPeriode);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('liste_des_cours_par_classe:-'.$idClasse.'.pdf');

        }
    }

    function viewHtmlCoursParClasse($idAnne,$idOption, $idClasse, $idPeriode)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite()."<br> LISTE DE COURS PAR REPARTITION DE LA CLASSE";
        $text3=strtoupper("Proclamation des résultats ".$this->getPromotionPeriode($idPeriode)." Pour  Année scolaire:".$this->getPromotionAnnee($idAnne)." - ".$this->getPromotionOption($idOption)."-".$this->getPromotionClasse($idClasse));

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        $data = $this->getListEleveInscriptParClasse($idAnne, $idOption, $idClasse);
        

       
        $output = '
        <!doctype html>
        <html lang="fr">
          <head>
            <!-- Required meta tags -->
            <title>'.$text3.' </title>

            <style>
              
                *{
                    font-size: 0.9rem !important;
                    font-family: Roboto, sans-serif !important;
                    letter-spacing: .0333333333em!important;
                    padding:1px;
                }
                

                

            </style>
          </head>
          <body>
            
            <div style="border:1px solid black;padding:1px; height:auto;">';
                
                $output .='
                <div style="margin:15px;">
                '.$this->entetePrintPDF($text1, $text2, $text3).'


                '.$this->tableau_cours_par_classe($idAnne, $idOption, $idClasse, $idPeriode).'
                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }



    function tableau_cours_par_classe($idAnne, $idOption, $idClasse, $idPeriode)
    {
        $data = $this->getListEleveInscriptParClasse($idAnne, $idOption, $idClasse);
        $maxCours = $this->querySumMaximaleCoursparClasse($idAnne, $idOption, $idClasse, $idPeriode);
        
        $output ='';
        $count = 0;
        $coteEleve = 0;
        $PourcentageEleve = 0;
        $MentionEleve = "";
        $NbrReussite = 0;
        $NbrD = 0;
        $NbrE = 0;
        $NbrMoyenne = 0;

        $output .=' 
        <table width="100%" style="border-collapse: collapse; margin: auto; border: 1px solid black;">
            <thead>
                <tr style="background-color:#ccc;">
                    <th style="border: 1px solid black;">N°</th>
                    <th style="border: 1px solid black;">Elève</th>
                    <th style="border: 1px solid black;">Sexe</th>
                    <th style="border: 1px solid black;">Points Obtenus</th>
                    <th style="border: 1px solid black;">Pourcentage</th>
                    <th style="border: 1px solid black;">Mention</th>
                    <th style="border: 1px solid black;">Conduite</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($data as $row) {
            // code...
            $count ++;
            $coteEleve = round($this->querySumMaximaleCoursparEleve($idAnne, $idOption, $idClasse, $idPeriode, $row->id), 01);
            $PourcentageEleve = round( (($coteEleve * 100)/$maxCours), 02);

            $NbrReussite += $PourcentageEleve >=50;
            $NbrE += $PourcentageEleve <50;
            $NbrD += $PourcentageEleve >70;

            $NbrMoyenne = round((($NbrReussite * 100 )/ $count), 02);


            $output .='
                <tr>
                    <td align="center" style="border: 1px solid black;">'.$count.'</td>
                    <td align="center" style="border: 1px solid black;">'.$row->Noms.'</td>
                    <td align="center" style="border: 1px solid black;">'.$row->sexeEleve.'</td>
                    <td align="center" style="border: 1px solid black;">'.$coteEleve.' /'.$maxCours.' points</td>
                    <td align="center" style="border: 1px solid black;">'.$PourcentageEleve.' %</td>
                    <td align="center" style="border: 1px solid black;">'.$this->getMention($PourcentageEleve).'</td>
                    <td align="center" style="border: 1px solid black;"></td>
                </tr>';
            
        }
        $output .='

                <tr>
                    <td  colspan="6" align="right" style="border: 1px solid black; font-weight: bold;">Total Reussite</td>
                    <td style="border: 1px solid black;font-weight: bold;">'.$NbrReussite.'/'.$count.' Elève(s)</td>
                   
                </tr>
                <tr>
                    <td colspan="6" align="right" style="border: 1px solid black; font-weight: bold;">Nombre des éhouants</td>
                    <td style="border: 1px solid black; font-weight: bold;">'.$NbrE.'/'.$count.' Elève(s)</td>
                   
                </tr>

                <tr>
                    <td colspan="6" align="right" style="border: 1px solid black; font-weight: bold;">Nombre de Distinction</td>
                    <td style="border: 1px solid black; font-weight: bold;">'.$NbrD.'/'.$count.' Elève(s)</td>
                   
                </tr>

                <tr>
                    <td colspan="6" align="right" style="border: 1px solid black; font-weight: bold;">Moyenne Générale de la classe</td>
                    <td style="border: 1px solid black; font-weight: bold;">'.$NbrMoyenne.'%</td>
                   
                </tr>

                

               
                

               



            </tbody>
        </table>';

        $output .=' 
        <br>
        <table width="100%">
            <tr>
                <td width="40%">
                    <b>Nom de l\'Enseignant responsable:</b> <br><br>
                    <b>N° de téléphone:</b><br>
                    <b>Signature:</b><br>
                </td>
                <td width="40%">
                
                    <b>Nom de chef de l\'Etablissement:</b> <br><br>
                    <b>N° de téléphone:</b><br>
                    <b>Signature:</b><br>

                </td>
                <td width="20%">
                
                    <b>Sceau de l\'Etablissement:</b><br><br>

                </td>
            </tr>
        </table>
        ';

        return $output;

    }


    /*
    *
    *=========================================
    * Impressions de cours par enseignant 
    *=========================================
    */

     /*
    *
    *=========================================
    * Impressions grille de cote
    *=========================================
    */

    //voir la liste des eleves par classe 
    function getListCoursParClassePeriode($idAnne, $idOption, $idClasse, $idPeriode)
    {
        $data = DB::table("attribution_cours")
        ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
        ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
        ->join('cours','cours.id','=','attribution_cours.idCours')
        ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

        ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
        ->join('options','options.id','=','attribution_cours.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','attribution_cours.idClasse')
        ->select("attribution_cours.id",
            //attribution_cours
            'attribution_cours.idCours','attribution_cours.idEnseignant',
            'attribution_cours.idPeriode','attribution_cours.idAnne',
            'attribution_cours.idOption','attribution_cours.idClasse',
            'attribution_cours.maximale','attribution_cours.codeAt',
            //cours
            'cours.nomCours','cours.idCatCours',
            //cat_cours
            "cat_cours.nomCatCours", 
            //periodes
            'periodes.nomPeriode',
            //enseignants 
            'enseignants.idAvenue','enseignants.nomEns',
            'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
            'enseignants.telEns','enseignants.tel2Ens',
            'enseignants.sexeEns','enseignants.etatcivilEns',
            'enseignants.prefEns','enseignants.degreprefEns',
            'enseignants.telprefEns','enseignants.codeEns',
            'enseignants.numCarteEns','enseignants.passwordEns',
            'enseignants.imageEns',
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
            
            "attribution_cours.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
        ->where([
            ['attribution_cours.idAnne', '=', $idAnne],
            ['attribution_cours.idOption', '=', $idOption],
            ['attribution_cours.idClasse', '=', $idClasse],
            ['attribution_cours.idPeriode', '=', $idPeriode],
        ])
        ->orderBy('attribution_cours.id', 'asc')
        ->get();

        return $data;


    }

     //voir la liste des eleves par classe 
    function getListPointCoursParPeriode($idAnne, $idOption, $idClasse, $idPeriode,$idCours, $idInscription)
    {
        $data = DB::table("cotations")
        ->join('inscriptions','inscriptions.id','=','cotations.idInscription')
        ->join('periodes','periodes.id','=','cotations.idPeriode')
        ->join('cours','cours.id','=','cotations.idCours')

        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')

        ->select("cotations.id",
            //cotations
            'cotations.idInscription','cotations.idCours',
            'cotations.idPeriode','cotations.cote',
            'cotations.codeCote', 'cotations.maxima',
            //cours
            'cours.nomCours',
            //periodes
            'periodes.nomPeriode',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
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
           
            "cotations.created_at")
        ->where([
            ['inscriptions.idAnne', '=', $idAnne],
            ['inscriptions.idOption', '=', $idOption],
            ['inscriptions.idClasse', '=', $idClasse],
            ['cotations.idPeriode', '=', $idPeriode],
            ['cotations.idCours', '=', $idCours],
            ['cotations.idInscription', '=', $idInscription],
        ])
        ->take(1)
        ->get();

        $cote = 0;
        foreach ($data as $row) {
            $cote = $row->cote;
        }

        return $cote;

    }



    function print_resultat_cotation_par_eleve(Request $request)
    {
        if ($request->get('idAnne') && $request->get('idOption') && $request->get('idClasse') && $request->get('idPeriode') && $request->get('idInscription')) 
        {
            $idAnne         = $request->get('idAnne');
            $idOption       = $request->get('idOption');
            $idClasse       = $request->get('idClasse');
            $idPeriode      = $request->get('idPeriode');
            $idInscription  = $request->get('idInscription');
            
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlCoursParEleve($idAnne,$idOption, $idClasse, $idPeriode, $idInscription);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('grille_de_cote_par_eleve:-'.$idInscription.'.pdf');

        }
    }

    function viewHtmlCoursParEleve($idAnne,$idOption, $idClasse, $idPeriode, $idInscription)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite()."<br> GRILLE DE COTE DE RESULTAT";
        $text3=strtoupper("Proclamation des résultats ".$this->getPromotionPeriode($idPeriode)." Pour  Année scolaire:".$this->getPromotionAnnee($idAnne)." - ".$this->getPromotionOption($idOption)."-".$this->getPromotionClasse($idClasse));

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        
        $output = '
        <!doctype html>
        <html lang="fr">
          <head>
            <!-- Required meta tags -->
            <title>'.$text3.' </title>

            <style>
              
                *{
                    font-size: 0.9rem !important;
                    font-family: Roboto, sans-serif !important;
                    letter-spacing: .0333333333em!important;
                    padding:1px;
                }
                

                

            </style>
          </head>
          <body>
            
            <div style="border:1px solid black;padding:1px; height:auto;">';
                
                $output .='
                <div style="margin:15px;">
                '.$this->entetePrintPDF($text1, $text2, $text3).'


                '.$this->tableau_cours_par_eleve($idAnne, $idOption, $idClasse, $idPeriode, $idInscription, $text3).'
                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }



    function tableau_cours_par_eleve($idAnne, $idOption, $idClasse, $idPeriode, $idInscription, $text3)
    {
        $data = $this->getListCoursParClassePeriode($idAnne, $idOption, $idClasse, $idPeriode);
        $maxCours = $this->querySumMaximaleCoursparClasse($idAnne, $idOption, $idClasse, $idPeriode);
        
        $output ='';
        $count = 0;
        $coteEleve = 0;
        $PourcentageEleve = 0;
        $MentionEleve = "";
        $NbrReussite = 0;
        $NbrD = 0;
        $NbrE = 0;
        $NbrMoyenne = 0;

        $coteEleve = round($this->querySumMaximaleCoursparEleve($idAnne, $idOption, $idClasse, $idPeriode, $idInscription), 01);

        $PourcentageEleve = round((($coteEleve * 100)/$maxCours), 02);

        $textQrcode = strtoupper($text3." - élève ".$this->getNomEleve($idInscription)." a
         reussi avec ".$PourcentageEleve." % avec la mention:".$this->getMention($PourcentageEleve));

        $output .=' 
        <table width="100%" style="border-collapse: collapse; margin: auto; border: 1px solid black;">


            <tr>
                <td align="right" width="50%" colspan="2" style="border: 1px solid black;">
                    &nbsp; <b>Nom de l\'élève: '.strtoupper($this->getNomEleve($idInscription)).'</b> <br>
                    &nbsp; <b>Classe: '.strtoupper($this->getPromotionClasse($idClasse).'-'.$this->getPromotionOption($idOption)).'</b><br>
                    &nbsp; <b>Période: '.strtoupper($this->getPromotionPeriode($idPeriode)).'</b><br>
                    &nbsp; <b>Année scolaire: '.strtoupper($this->getPromotionAnnee($idAnne)).'</b><br>
                    &nbsp; <b>Pourcentage: '.$PourcentageEleve.'%</b><br>
                    &nbsp; <b>Application: '.$this->getMention($PourcentageEleve).'</b> <br>
                </td>
                <td align="center" width="50%"  colspan="2" style="border: 1px solid black;">
                
                  
                    '.$this->generateQrcodeTiquet($textQrcode).'
                </td>
                
                
               
            </tr>
           
            <tr style="background-color:#ccc;">
                <th style="border: 1px solid black;">N°</th>
                <th style="border: 1px solid black;">Cours</th>
                <th style="border: 1px solid black;">Maxima</th>
                <th style="border: 1px solid black;">Points Obtenus</th>
               
            </tr>
            
            <tbody>';

        $color = "";
        foreach ($data as $row) {
            // code...
            $count ++;
            $coteObtenu = $this->getListPointCoursParPeriode($idAnne, $idOption, $idClasse, $idPeriode,$row->idCours, $idInscription);
            if ($coteObtenu < ($row->maximale / 2) ) {
                // code...
                $color = "red";
            } else {
                // code...
                $color = "black";
            }
            

            $output .='
                <tr>
                    <td align="center" style="border: 1px solid black;">'.$count.'</td>
                    <td align="center" style="border: 1px solid black; color:'.$color.'">'.$row->nomCours.'</td>
                    <td align="center" style="border: 1px solid black;">'.$row->maximale.'</td>
                   
                    <td align="center" style="border: 1px solid black; color:'.$color.'">'.$coteObtenu.'</td>
                </tr>';
            
        }
        $output .='

                <tr>
                    <td  colspan="3" align="right" style="border: 1px solid black; font-weight: bold;">Points Obtenus:</td>
                    <td style="border: 1px solid black;font-weight: bold;">&nbsp;'.$coteEleve.'/'.$maxCours.' Points</td>
                   
                </tr>
                

                <tr>
                    <td  colspan="3" align="right" style="border: 1px solid black; font-weight: bold;">Pourcentage:</td>
                    <td style="border: 1px solid black;font-weight: bold;">&nbsp;'.$PourcentageEleve.' %</td>
                   
                </tr>
                <tr>
                    <td colspan="3" align="right" style="border: 1px solid black; font-weight: bold;">Mention:</td>
                    <td style="border: 1px solid black; font-weight: bold;">&nbsp;'.$this->getMention($PourcentageEleve).'</td>
                   
                </tr>

                <tr>
                    <td colspan="3" align="right" style="border: 1px solid black; font-weight: bold;">Total de Cours:</td>
                    <td style="border: 1px solid black; font-weight: bold;">&nbsp;'.$count.' Cours</td>
                   
                </tr>
                <tr>
                    <td colspan="3" align="right" style="border: 1px solid black; font-weight: bold;">Moyenne de Cours:</td>
                    <td style="border: 1px solid black; font-weight: bold;">&nbsp;'.$NbrD.'/'.$count.' Cours</td>
                   
                </tr>

               
               

            </tbody>
        </table>';

       

        return $output;

    }




    /*
    *
    *=========================================
    * Impressions grille de cote
    *=========================================
    */


    
}
