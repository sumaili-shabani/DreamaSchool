<?php

namespace App\Http\Controllers\Backend\Cours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Cours\{AttributionCours};
use App\Traits\{GlobalMethod,Slug};
use DB;


class PdfCoursController extends Controller
{
   
    use GlobalMethod;
    
    /*
     * 
     *===========================================
     * Attribution des cours
     *===========================================
     * 
    */

    function queryCoursparClasse($idAnne, $idOption, $idClasse, $idPeriode)
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
        ->orderBy('cat_cours.nomCatCours', 'asc')
        ->get();

        return $data;

    }

    function queryCoursparClasseEns($idAnne, $idOption, $idClasse, $idPeriode)
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
        ->orderBy('enseignants.nomEns', 'asc')
        ->get();

        return $data;

    }
    

    function queryCoursparClasseParEnseignant($idAnne, $idPeriode, $idEnseignant)
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
            ['attribution_cours.idPeriode', '=', $idPeriode],
            ['attribution_cours.idEnseignant', '=', $idEnseignant],
            
        ])
        ->orderBy('cat_cours.nomCatCours', 'asc')
        ->get();

        return $data;

    }



    /*
    *
    *=========================================
    * Impressions de cours par classe
    *=========================================
    */

    function print_cours_par_classe(Request $request)
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
        $text3=strtoupper("Année scolaire:".$this->getPromotionAnnee($idAnne)." - ".$this->getPromotionOption($idOption)."-".$this->getPromotionClasse($idClasse));

        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');

        $data = $this->queryCoursparClasse($idAnne, $idOption, $idClasse, $idPeriode);
        

       
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

        $data = $this->queryCoursparClasse($idAnne, $idOption, $idClasse, $idPeriode);
        $output ='';

        $output .=' 
        <table width="100%" style="border-collapse: collapse; margin: auto; border: 1px solid black;">
            <thead>
                <tr style="background-color:#ccc;">
                    <th>Cours</th>
                    <th>Maxima</th>
                    <th>Catégorie</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($data as $row) {
            // code...
            $output .='
                <tr>
                    <td align="center" style="border: 1px solid black;">'.$row->nomCours.'</td>
                    <td align="center" style="border: 1px solid black;">'.$row->maximale.' Points</td>
                    <td align="center" style="border: 1px solid black;">'.$row->nomCatCours.' </td>
                </tr>';
            
        }
        $output .='</tbody>
            </table>';

        return $output;

    }


    /*
    *
    *=========================================
    * Impressions de cours par enseignant 
    *=========================================
    */

     function print_cours_par_enseignant(Request $request)
    {
        if ($request->get('idAnne')  && $request->get('idPeriode') && $request->get('idEnseignant')) 
        {
            $idAnne         = $request->get('idAnne');
            $idPeriode      = $request->get('idPeriode');
            $idEnseignant   = $request->get('idEnseignant');
            
            
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlCoursParClasseEnseignant($idAnne,$idPeriode, $idEnseignant);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('liste_des_cours_par_classe:-'.$idEnseignant.'.pdf');

        }
    }

    function viewHtmlCoursParClasseEnseignant($idAnne, $idPeriode, $idEnseignant)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite()."<br> LISTE DE COURS PAR REPARTITION DES CLASSES";
        $text3=strtoupper("Année scolaire:".$this->getPromotionAnnee($idAnne)." / ENSEIGNANT(E):".$this->getNomEnseignant($idEnseignant));

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

                '.$this->tableau_cours_par_enseignant($idAnne, $idPeriode, $idEnseignant).'

                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }

    function tableau_cours_par_enseignant($idAnne, $idPeriode, $idEnseignant)
    {

        $data = $this->queryCoursparClasseParEnseignant($idAnne, $idPeriode, $idEnseignant);
        $output ='';

        $output .=' 
        <table width="100%" style="border-collapse: collapse; margin: auto; border: 1px solid black;">
            <thead>
                <tr style="background-color:#ccc;">
                    <th>Cours</th>
                    <th>Maxima</th>
                    <th>Catégorie</th>
                    <th>Option</th>
                    <th>Classe</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($data as $row) {
            // code...
            $output .='
                <tr>
                    <td align="center" style="border: 1px solid black;">'.$row->nomCours.'</td>
                    <td align="center" style="border: 1px solid black;">'.$row->maximale.' Points</td>
                    <td align="center" style="border: 1px solid black;">'.$row->nomCatCours.' </td>
                    <td align="center" style="border: 1px solid black;">'.$row->nomOption.' </td>
                    <td align="center" style="border: 1px solid black;">'.$row->nomClasse.' </td>
                </tr>';
            
        }
        $output .='</tbody>
            </table>';

        return $output;

    }

   

    /*
     * 
     *===========================================
     * Fin Attribution des cours
     *===========================================
     * 
    */

    /*
    *
    *================================================
    * Impressions de cours enseignant  par classe
    *================================================
    */

    function print_cours_aux_enseignants_par_classe(Request $request)
    {
        if ($request->get('idAnne') && $request->get('idOption') && $request->get('idClasse') && $request->get('idPeriode')) 
        {
            $idAnne         = $request->get('idAnne');
            $idOption       = $request->get('idOption');
            $idClasse       = $request->get('idClasse');
            $idPeriode      = $request->get('idPeriode');
            
            $pdf = \App::make('dompdf.wrapper');

            $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html .= $this->viewHtmlCoursParClasseAuxEnseignants($idAnne,$idOption, $idClasse, $idPeriode);

            // echo($html);

            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream('liste_des_cours_par_classe:-'.$idClasse.'.pdf');

        }
    }

    function viewHtmlCoursParClasseAuxEnseignants($idAnne,$idOption, $idClasse, $idPeriode)
    {
        $text1="REPUBLQUE DEMOCRATIQUE DU CONGO";
        $text2="".$this->getNomSite()."<br> LISTE DE COURS PAR REPARTITION DE LA CLASSE";
        $text3=strtoupper("Année scolaire:".$this->getPromotionAnnee($idAnne)." - ".$this->getPromotionOption($idOption)."-".$this->getPromotionClasse($idClasse));

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


                '.$this->tableau_cours_aux_enseignants_par_classe($idAnne, $idOption, $idClasse, $idPeriode).'
                </div>

                <br><br>
                

            </div>

            
            
          </body>
        </html>
        ';

        return $output;

    }

    function tableau_cours_aux_enseignants_par_classe($idAnne, $idOption, $idClasse, $idPeriode)
    {

        $data = $this->queryCoursparClasseEns($idAnne, $idOption, $idClasse, $idPeriode);
        $output ='';

        $output .=' 
        <table width="100%" style="border-collapse: collapse; margin: auto; border: 1px solid black;">
            <thead>
                <tr style="background-color:#ccc;">
                    <th>Cours</th>
                    <th>Maxima</th>
                   
                    <th>Enseignant</th>
                    <th>Sexe/Age</th>
                    <th>Contacts</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($data as $row) {
            // code...
            $output .='
                <tr>
                    <td align="center" style="border: 1px solid black;">'.$row->nomCours.'</td>
                    <td align="center" style="border: 1px solid black;">'.$row->maximale.' Points</td>
                    

                    <td align="center" style="border: 1px solid black;">'.$row->nomEns.' </td>
                    <td align="center" style="border: 1px solid black;">'.$row->sexeEns.' / '.$row->ageEns.' ans </td>
                    <td align="center" style="border: 1px solid black;">'.$row->telEns.' </td>
                </tr>';
            
        }
        $output .='</tbody>
            </table>';

        return $output;

    }


    /*
    *
    *=========================================
    * Impressions de cours par enseignant 
    *=========================================
    */

    


}
