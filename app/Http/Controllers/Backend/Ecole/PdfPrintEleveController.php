<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Backend\Paiement\{Prevision};
use App\Traits\{GlobalMethod,Slug};
use DB;



class PdfPrintEleveController extends Controller
{
    use GlobalMethod, Slug;

    public function fetch_rapport_inscription_classe(Request $request)
    {
        //refDepartement  refBanque

        if ($request->get('idAnne') && $request->get('idClasse')&& $request->get('idOption')) {
            // code...
            $idAnne = $request->get('idAnne');
            $idClasse = $request->get('idClasse');
            $idOption = $request->get('idOption');
            
            $html = $this->printRapportInscriptionClasse($idAnne, $idClasse, $idOption);
            $pdf = \App::make('dompdf.wrapper');

            $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();            

        } else {
            // code...
        }  
        
    }

    function printRapportInscriptionClasse($idAnne, $idClasse, $idOption)
    {

            //Info Entreprise
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = '';
            $logo='';
    
            $data1 = DB::table('sites')
            ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
            'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nom;
                $adresseEse=$row->adresse;
                $Tel1Ese=$row->tel1;
                $Tel2Ese=$row->tel2;
                $siteEse=$row->mission;
                $emailEse=$row->email;
                $idNatEse='0000';
                $numImpotEse='0000';
                $busnessName=$row->objectif;
                $rccmEse='0000';
                $pic2 = $this->displayImg("images", $row->logo);
                $siege=$row->politique;         
            }

        $pic = $this->displayImg("images", 'armoirie.png');

        $totalPaie=0;
        $totalReste=0;
        $totalReduction=0;
         // 
         $data2 =  DB::table('inscriptions')
         ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')        
         ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
         ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
         ->where([
            ['idAnne','=', $idAnne],
            ['idClasse','=', $idClasse],
            ['idOption','=', $idOption]
        ])  
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {    
            $totalPaie=$row->totalPaie;
            $totalReste=$row->totalReste; 
            $totalReduction = $row->totalReduction;                        
         }
    

            $output='';           

            $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptPaiement</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:86px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:33px;"></td>
                        <td style="height:0px;width:67px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:63px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:171px;"></td>
                        <td style="height:0px;width:85px;"></td>
                        <td style="height:0px;width:87px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:125px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:6px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;INSCRIPTIONS(PAIEMENTS)</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                        <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                        <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                        <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                        <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                    </tr>
                    ';
                                                                            
                                                $output .= $this->showRapportInscriptionClasse($idAnne, $idClasse, $idOption); 
                                                                            
                                                $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                        <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                        <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                        <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                        <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>       
            ';  
        
            return $output; 

    }

    function showRapportInscriptionClasse($idAnne, $idClasse, $idOption)
    {
            $count=0;

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
                //Paiement
                'paie','fraisinscription','restoreinscription',
                'inscriptions.created_at')  
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')            
            ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")
            ->selectRaw('((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription) as Prevision')
            ->selectRaw('ROUND((((paie + reste - fraisinscription) * ROUND(reductionPaiement,0))/100),0) as Reduction')
            ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
            ->where([
                ['idAnne','=', $idAnne],
                ['idClasse','=', $idClasse],
                ['idOption','=', $idOption]
            ])
            ->orderBy("nomEleve", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $count ++;

                $output .='
                    	<tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                        <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                        <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                        <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                        <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                        <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                        <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                        <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                        <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                    </tr>
                ';
    
        }

        return $output;

    }

    //============== RAPPORT ANNUEL DES INSCRIPTION ==============================================

    public function fetch_rapport_inscription_annuel(Request $request)
    {
        //refDepartement  refBanque

        if ($request->get('idAnne') && $request->get('idOption')) {
            // code...
            $idAnne = $request->get('idAnne');
            $idOption = $request->get('idOption');
            
            $html = $this->printRapportInscriptionAnnuel($idAnne, $idOption);
            $pdf = \App::make('dompdf.wrapper');

            $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();            

        } else {
            // code...
        }  
        
    }

    function printRapportInscriptionAnnuel($idAnne, $idOption)
    {

            //Info Entreprise
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = '';
            $logo='';
    
            $data1 = DB::table('sites')
            ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
            'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nom;
                $adresseEse=$row->adresse;
                $Tel1Ese=$row->tel1;
                $Tel2Ese=$row->tel2;
                $siteEse=$row->mission;
                $emailEse=$row->email;
                $idNatEse='0000';
                $numImpotEse='0000';
                $busnessName=$row->objectif;
                $rccmEse='0000';
                $pic2 = $this->displayImg("images", $row->logo);
                $siege=$row->politique;         
            }

            $pic = $this->displayImg("images", 'armoirie.png');


        $totalPaie=0;
        $totalReste=0;
        $totalReduction=0;
         // 
         $data2 =  DB::table('inscriptions')
         ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')
         ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
         ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
         ->where([
            ['idAnne','=', $idAnne],
            ['idOption','=', $idOption]
        ])  
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {    
            $totalPaie=$row->totalPaie;
            $totalReste=$row->totalReste; 
            $totalReduction = $row->totalReduction;                        
         }
    

            $output='';           

            $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptPaiement</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:86px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:33px;"></td>
                        <td style="height:0px;width:67px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:63px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:171px;"></td>
                        <td style="height:0px;width:85px;"></td>
                        <td style="height:0px;width:87px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:125px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:6px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;INSCRIPTIONS(PAIEMENTS)</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                        <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                        <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                        <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                        <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                    </tr>
                    ';
                                                                            
                                                $output .= $this->showRapportInscriptionAnnuel($idAnne, $idOption); 
                                                                            
                                                $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                        <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                        <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                        <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                        <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>       
            ';  
        
            return $output; 

    }

    function showRapportInscriptionAnnuel($idAnne, $idOption)
    {
            $count=0;

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
                //Paiement
                'paie','fraisinscription','restoreinscription',
                'inscriptions.created_at')  
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")
            ->selectRaw('(paie + reste + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
            ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * ROUND(reductionPaiement,0))/100),0) as Reduction')
            ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
            ->where([
                ['idAnne','=', $idAnne],
                ['idOption','=', $idOption]
            ])
            ->orderBy("nomEleve", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $count ++;

                $output .='
                    	<tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                        <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                        <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                        <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                        <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                        <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                        <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                        <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                        <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                    </tr>
                ';
    
        }

        return $output;

    }

    //============================== FICHE INSCRIPTION ===============================================

    //fetch_historique_paiement
    //fetch_fiche_inscription_classe

    public function fetch_fiche_inscription_classe(Request $request)
    {
        if ($request->get('idAnne') && $request->get('idClasse')&& $request->get('idOption')) {
            // code...
            $idAnne     = $request->get('idAnne');
            $idClasse   = $request->get('idClasse');
            $idOption   = $request->get('idOption');
            
            $html = $this->printFicheInscriptionClasse($idAnne, $idClasse, $idOption);
            $pdf = \App::make('dompdf.wrapper');

            $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();            

        } else {
            // code...
        }  
        
    }

    function printFicheInscriptionClasse($idAnne, $idClasse, $idOption)
    {

            //Info Entreprise
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = '';
            $logo='';
    
            $data1 = DB::table('sites')
            ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
            'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nom;
                $adresseEse=$row->adresse;
                $Tel1Ese=$row->tel1;
                $Tel2Ese=$row->tel2;
                $siteEse=$row->mission;
                $emailEse=$row->email;
                $idNatEse='0000';
                $numImpotEse='0000';
                $busnessName=$row->objectif;
                $rccmEse='0000';
                $pic2 = $this->displayImg("images", $row->logo);
                $siege=$row->politique;         
            }

            $pic = $this->displayImg("images", 'armoirie.png');  

            $output='';           

            $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptFicheInscription</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:297px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:85px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:33px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:68px;"></td>
                        <td style="height:0px;width:198px;"></td>
                        <td style="height:0px;width:103px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:145px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="10" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="10" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="10" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="10" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:&nbsp;'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="10" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:6px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="7" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;INSCRIPTION</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:57px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="5" style="width:273px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" style="width:52px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                        <td class="cs479D8C74" style="width:197px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:111px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                        <td class="cs479D8C74" colspan="3" style="width:173px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>OBSERVATION</nobr></td>
                    </tr>
                    ';
                                                                                            
                        $output .= $this->showFicheInscriptionClasse($idAnne, $idClasse, $idOption); 
                                                                                            
                        $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>
                  
            ';  
        
            return $output; 

    }

    function showFicheInscriptionClasse($idAnne, $idClasse, $idOption)
    {
            $count=0;

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
                //Paiement
                'paie','fraisinscription','restoreinscription',
                'inscriptions.created_at')
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw('(paie + reste  + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
            ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")
            ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as Reduction')
            ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
            ->where([
                ['idAnne','=', $idAnne],
                ['idClasse','=', $idClasse],
                ['idOption','=', $idOption]
            ])
            ->orderBy("nomEleve", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $count ++;

                $output .='

                    	<tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td class="cs86F8EF7F" style="width:57px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                            <td class="csD06EB5B2" colspan="5" style="width:273px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                            <td class="csD06EB5B2" style="width:52px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                            <td class="csD06EB5B2" colspan="2" style="width:80px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                            <td class="csD06EB5B2" style="width:197px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                            <td class="csD06EB5B2" colspan="2" style="width:111px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                            <td class="csD06EB5B2" colspan="3" style="width:173px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        </tr>
                ';    
        }

        return $output;

    }

    //============================== AVEC REDUCTION==================================================

    
    public function fetch_rapport_inscription_classe_reduction(Request $request)
    {
        //refDepartement  refBanque

        if ($request->get('idAnne') && $request->get('idClasse')&& $request->get('idOption')) {
            // code...
            $idAnne = $request->get('idAnne');
            $idClasse = $request->get('idClasse');
            $idOption = $request->get('idOption');
            
            $html = $this->printRapportInscriptionClasseReduction($idAnne, $idClasse, $idOption);
            $pdf = \App::make('dompdf.wrapper');

            $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();            

        } else {
            // code...
        }  
        
    }

    function printRapportInscriptionClasseReduction($idAnne, $idClasse, $idOption)
    {

            //Info Entreprise
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = '';
            $logo='';
    
            $data1 = DB::table('sites')
            ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
            'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nom;
                $adresseEse=$row->adresse;
                $Tel1Ese=$row->tel1;
                $Tel2Ese=$row->tel2;
                $siteEse=$row->mission;
                $emailEse=$row->email;
                $idNatEse='0000';
                $numImpotEse='0000';
                $busnessName=$row->objectif;
                $rccmEse='0000';
                $pic2 = $this->displayImg("images", $row->logo);
                $siege=$row->politique;         
            }

            $pic = $this->displayImg("images", 'armoirie.png');


        $totalPaie=0;
        $totalReste=0;
        $totalReduction=0;
         // 
         $data2 =  DB::table('inscriptions')
         ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')
         ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
         ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
         ->where([
            ['idAnne','=', $idAnne],
            ['idClasse','=', $idClasse],
            ['idOption','=', $idOption],
            ['reductionPaiement','>', 0]
        ])  
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {    
            $totalPaie=$row->totalPaie;
            $totalReste=$row->totalReste; 
            $totalReduction = $row->totalReduction;                        
         }
    

            $output='';           

            $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptPaiement</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:86px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:33px;"></td>
                        <td style="height:0px;width:67px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:63px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:171px;"></td>
                        <td style="height:0px;width:85px;"></td>
                        <td style="height:0px;width:87px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:125px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:6px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;MESURES INCITATIVES PAR CLASSE</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                        <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                        <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                        <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                        <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                    </tr>
                    ';
                                                                            
                                                $output .= $this->showRapportInscriptionClasseRed($idAnne, $idClasse, $idOption); 
                                                                            
                                                $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                        <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                        <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                        <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                        <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>          
            ';  
        
            return $output; 

    }

    function showRapportInscriptionClasseRed($idAnne, $idClasse, $idOption)
    {
            $count=0;

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
                //Paiement
                'paie','fraisinscription','restoreinscription',
                'inscriptions.created_at')
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
            ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")
            ->selectRaw('ROUND((((paie + reste + restoreinscription) * reductionPaiement)/100),0) as Reduction')
            ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
            ->where([
                ['idAnne','=', $idAnne],
                ['idClasse','=', $idClasse],
                ['idOption','=', $idOption],
                ['reductionPaiement','>', 0]
            ])
            ->orderBy("nomEleve", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $count ++;

                $output .='
                    	<tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                        <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                        <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                        <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                        <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                        <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                        <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                        <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                        <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                    </tr>
                ';
    
        }

        return $output;

    }
        //============================== AVEC REDUCTION ANNUEL==================================================

    
        public function fetch_rapport_inscription_classe_reduction_annuel(Request $request)
        {
            //refDepartement  refBanque
    
            if ($request->get('idAnne') && $request->get('idOption')) {
                // code...
                $idAnne = $request->get('idAnne');
                $idOption = $request->get('idOption');
                
                $html = $this->printRapportInscriptionClasseReductionAnnuel($idAnne, $idOption);
                $pdf = \App::make('dompdf.wrapper');
    
                $pdf->loadHTML($html)->setPaper('a4', 'landscape');
                return $pdf->stream();            
    
            } else {
                // code...
            }  
            
        }
    
        function printRapportInscriptionClasseReductionAnnuel($idAnne, $idOption)
        {
    
                //Info Entreprise
                $nomEse='';
                $adresseEse='';
                $Tel1Ese='';
                $Tel2Ese='';
                $siteEse='';
                $emailEse='';
                $idNatEse='';
                $numImpotEse='';
                $rccEse='';
                $siege='';
                $busnessName='';
                $pic='';
                $pic2 = '';
                $logo='';
        
                $data1 = DB::table('sites')
                ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
                'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
                ->get();
                $output='';
                foreach ($data1 as $row) 
                {                                
                    $nomEse=$row->nom;
                    $adresseEse=$row->adresse;
                    $Tel1Ese=$row->tel1;
                    $Tel2Ese=$row->tel2;
                    $siteEse=$row->mission;
                    $emailEse=$row->email;
                    $idNatEse='0000';
                    $numImpotEse='0000';
                    $busnessName=$row->objectif;
                    $rccmEse='0000';
                    $pic2 = $this->displayImg("images", $row->logo);
                    $siege=$row->politique;         
                }

                $pic = $this->displayImg("images", 'armoirie.png');
    
    
            $totalPaie=0;
            $totalReste=0;
            $totalReduction=0;
             // 
             $data2 =  DB::table('inscriptions')
             ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')
             ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
             ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
             ->where([
                ['idAnne','=', $idAnne],
                ['idOption','=', $idOption],
                ['reductionPaiement','>', 0]
            ])  
             ->get(); 
             $output='';
             foreach ($data2 as $row) 
             {    
                $totalPaie=$row->totalPaie;
                $totalReste=$row->totalReste; 
                $totalReduction = $row->totalReduction;                        
             }
        
    
                $output='';           
    
                $output='
    
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>rptPaiement</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                            .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                            .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                            .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                            .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                            .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                            .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                        </style>
                    </head>
                    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                        <tr>
                            <td style="width:0px;height:0px;"></td>
                            <td style="height:0px;width:10px;"></td>
                            <td style="height:0px;width:58px;"></td>
                            <td style="height:0px;width:86px;"></td>
                            <td style="height:0px;width:12px;"></td>
                            <td style="height:0px;width:43px;"></td>
                            <td style="height:0px;width:33px;"></td>
                            <td style="height:0px;width:67px;"></td>
                            <td style="height:0px;width:37px;"></td>
                            <td style="height:0px;width:63px;"></td>
                            <td style="height:0px;width:14px;"></td>
                            <td style="height:0px;width:171px;"></td>
                            <td style="height:0px;width:85px;"></td>
                            <td style="height:0px;width:87px;"></td>
                            <td style="height:0px;width:12px;"></td>
                            <td style="height:0px;width:27px;"></td>
                            <td style="height:0px;width:11px;"></td>
                            <td style="height:0px;width:20px;"></td>
                            <td style="height:0px;width:125px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:19px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:1px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td></td>
                            <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                                <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                            </td>
                            <td></td>
                            <td></td>
                            <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                                <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                            </td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:25px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:11px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:6px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:27px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;MESURES INCITATIVES PAR OPTION</nobr></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:11px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                            <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                            <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                            <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                            <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                            <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                            <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                            <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                            <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                        </tr>
                        ';
                                                                                
                                                    $output .= $this->showRapportInscriptionClasseRedAnnuel($idAnne, $idOption); 
                                                                                
                                                    $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                            <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                            <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                            <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                            <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:1px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    </body>
                    </html>          
                ';  
            
                return $output; 
    
        }
    
        function showRapportInscriptionClasseRedAnnuel($idAnne, $idOption)
        {
                $count=0;
    
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
                    //Paiement
                    'paie','fraisinscription','restoreinscription',
                    'inscriptions.created_at')
                ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
                ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
                ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")               
                ->selectRaw('ROUND((((paie + reste + restoreinscription) * reductionPaiement)/100),0) as Reduction')
                ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
                ->where([
                    ['idAnne','=', $idAnne],
                    ['idOption','=', $idOption],
                    ['reductionPaiement','>', 0]
                ])
                ->orderBy("nomEleve", "asc")
                ->get();
                $output='';
    
                foreach ($data as $row) 
                {
                    $count ++;
    
                    $output .='
                            <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                            <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                            <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                            <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                            <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                            <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                            <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                            <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                            <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                        </tr>
                    ';
        
            }
    
            return $output;
    
        }
    



//==================== RAPPORT DES PAIEMENTS PAR DATE =======================================



public function fetch_rapport_paiement_frais_date(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->printRapportPaiementFraisDate($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportPaiementFraisDate($date1, $date2)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = '';
         $logo='';
 
         $data1 = DB::table('sites')
         ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
         'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nom;
             $adresseEse=$row->adresse;
             $Tel1Ese=$row->tel1;
             $Tel2Ese=$row->tel2;
             $siteEse=$row->mission;
             $emailEse=$row->email;
             $idNatEse='0000';
             $numImpotEse='0000';
             $busnessName=$row->objectif;
             $rccmEse='0000';
             $pic2 = $this->displayImg("images", $row->logo);
             $siege=$row->politique;

                      
         }

         $pic = $this->displayImg("images", 'armoirie.png');
 

         $totalMontant=0;
                 
         // 
         $data2 = DB::table('paiements')
         ->select(DB::raw('ROUND(SUM(paiements.montant),0) as TotalPaiement'))
         ->where([
            ['datePaiement','>=', $date1],
            ['datePaiement','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalMontant=$row->TotalPaiement;                           
         }

        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptDetailPaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">

                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:343px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:39px;"></td>
                    <td style="height:0px;width:105px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:80px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:34px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:60px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:72px;"></td>
                    <td style="height:0px;width:95px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:48px;"></td>
                    <td style="height:0px;width:91px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:145px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="12" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td class="cs101A94F7" rowspan="7" style="width:145px;height:129px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:129px;">
                        <img alt="" src="'.$pic.'" style="width:145px;height:129px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="12" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="12" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="12" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="12" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td class="csE93F7424" colspan="17" style="width:947px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORT&nbsp;JOURNALIERS&nbsp;DES&nbsp;PAIEMENT&nbsp;DES&nbsp;FRAIS&nbsp;SCOLAIRES</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csBB9284F7" colspan="6" style="width:333px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$this->CreatedFormat($date1).'&nbsp;&nbsp;au&nbsp;'.$this->CreatedFormat($date2).'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:37px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="3" style="width:196px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" style="width:35px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:156px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                    <td class="cs479D8C74" style="width:71px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MODE&nbsp;PAIE</nobr></td>
                    <td class="cs479D8C74" style="width:94px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;PAIE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:96px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;PAIE</nobr></td>
                    <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                    <td class="cs479D8C74" colspan="3" style="width:166px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>AUTHOR</nobr></td>
                </tr>
            ';
                                                            
                                $output .= $this->showRapportPaiementFraisDate($date1, $date2); 
                                                            
                                $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs91032837" colspan="11" style="width:594px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;PAIEMENT</nobr></td>
                <td class="cs479D8C74" colspan="6" style="width:354px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalMontant.'$</nobr></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:15px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs1698ECB3" colspan="7" style="width:337px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        </body>
        </html>
        
        ';  
       
        return $output; 

}

function showRapportPaiementFraisDate($date1, $date2)
{
        $count=0;

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

            'paie','fraisinscription','restoreinscription',

            //users
            'users.name','users.email','users.avatar',
            "paiements.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw("CASE  
        WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
        WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
        ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
        ELSE 0
    END as reste")           
        ->selectRaw('CONCAT("R",YEAR(datePaiement),"",MONTH(datePaiement),"00",paiements.id) as codeRecu')
        ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
        ->where([
            ['datePaiement','>=', $date1],
            ['datePaiement','<=', $date2]
        ])
        ->orderBy("paiements.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;


            $output .='	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:37px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="3" style="width:196px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                    <td class="csD06EB5B2" style="width:35px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:156px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'/'.$row->nomSection.'/'.$row->nomOption.'</nobr></td>
                    <td class="csD06EB5B2" style="width:71px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>CASH</nobr></td>
                    <td class="csD06EB5B2" style="width:94px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->datePaiement.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:96px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant.'$</nobr></td>
                    <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                    <td class="csD06EB5B2" colspan="3" style="width:166px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->name.'</nobr></td>
                </tr>';    
   
    }

    return $output;

}

//==================== RAPPORT DES PAIEMENTS PAR DATE CLASSE =======================================

public function fetch_rapport_paiement_frais_date_classe(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2') && $request->get('idAnne') 
    && $request->get('idClasse')&& $request->get('idOption')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idAnne = $request->get('idAnne');
        $idClasse = $request->get('idClasse');
        $idOption = $request->get('idOption');
        
        $html = $this->printRapportPaiementFraisDateClasse($date1, $date2, $idAnne, $idClasse, $idOption);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportPaiementFraisDateClasse($date1, $date2, $idAnne, $idClasse, $idOption)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("images", 'logo.png');
         $logo='';
 
         $data1 = DB::table('sites')
         ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
         'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nom;
             $adresseEse=$row->adresse;
             $Tel1Ese=$row->tel1;
             $Tel2Ese=$row->tel2;
             $siteEse=$row->mission;
             $emailEse=$row->email;
             $idNatEse='0000';
             $numImpotEse='0000';
             $busnessName=$row->objectif;
             $rccmEse='0000';
             $pic2 = $this->displayImg("images", $row->logo);
             $siege=$row->politique;         
         }

         $pic = $this->displayImg("images", 'armoirie.png');
 

         $totalMontant=0;
                 
         //
         $data2 = DB::table('paiements')
         ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
         ->select(DB::raw('ROUND(SUM(paiements.montant),0) as TotalPaiement'))
         ->where([
            ['datePaiement','>=', $date1],
            ['datePaiement','<=', $date2],
            ['idAnne','=', $idAnne],
            ['idClasse','=', $idClasse],
            ['idOption','=', $idOption]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalMontant=$row->TotalPaiement;                           
         }

        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptDetailPaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:343px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:39px;"></td>
                    <td style="height:0px;width:105px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:80px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:34px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:60px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:72px;"></td>
                    <td style="height:0px;width:95px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:48px;"></td>
                    <td style="height:0px;width:91px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:145px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="12" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td class="cs101A94F7" rowspan="7" style="width:145px;height:129px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:129px;">
                        <img alt="" src="'.$pic.'" style="width:145px;height:129px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="12" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="12" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="12" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="12" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td class="csE93F7424" colspan="17" style="width:947px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORT&nbsp;JOURNALIERS&nbsp;DES&nbsp;PAIEMENT&nbsp;DES&nbsp;FRAIS&nbsp;SCOLAIRES</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csBB9284F7" colspan="6" style="width:333px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$this->CreatedFormat($date1).'&nbsp;&nbsp;au&nbsp;'.$this->CreatedFormat($date2).'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:37px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="3" style="width:196px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" style="width:35px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:156px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                    <td class="cs479D8C74" style="width:71px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MODE&nbsp;PAIE</nobr></td>
                    <td class="cs479D8C74" style="width:94px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;PAIE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:96px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;PAIE</nobr></td>
                    <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                    <td class="cs479D8C74" colspan="3" style="width:166px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>AUTHOR</nobr></td>
                </tr>
              ';
                                                            
                                $output .= $this->showRapportPaiementFraisDateClasse($date1, $date2, $idAnne, $idClasse, $idOption); 
                                                            
                                $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs91032837" colspan="11" style="width:594px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;PAIEMENT</nobr></td>
                <td class="cs479D8C74" colspan="6" style="width:354px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalMontant.'$</nobr></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:15px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs1698ECB3" colspan="7" style="width:337px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        </body>
        </html>
        
        ';  
       
        return $output; 

}

function showRapportPaiementFraisDateClasse($date1, $date2, $idAnne, $idClasse, $idOption)
{
        $count=0;

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

            'paie','fraisinscription','restoreinscription',

            //users
            'users.name','users.email','users.avatar',
            "paiements.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve') 
        ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")          
        ->selectRaw('CONCAT("R",YEAR(datePaiement),"",MONTH(datePaiement),"00",paiements.id) as codeRecu')
        ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
        ->where([
            ['datePaiement','>=', $date1],
            ['datePaiement','<=', $date2],
            ['idAnne','=', $idAnne],
            ['idClasse','=', $idClasse],
            ['idOption','=', $idOption]
        ])
        ->orderBy("paiements.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;


            $output .='	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:37px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="3" style="width:196px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                    <td class="csD06EB5B2" style="width:35px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:156px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'/'.$row->nomSection.'/'.$row->nomOption.'</nobr></td>
                    <td class="csD06EB5B2" style="width:71px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>CASH</nobr></td>
                    <td class="csD06EB5B2" style="width:94px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->datePaiement.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:96px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant.'$</nobr></td>
                    <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                    <td class="csD06EB5B2" colspan="3" style="width:166px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->name.'</nobr></td>
                </tr>';    
   
    }

    return $output;

}


//==================== HISTORIQUE DE PAIEMENT =========================================================

public function fetch_historique_paiement(Request $request)
{
    //refDepartement  refBanque

    if ($request->get('idInscription')) {
        // code...
        $idInscription = $request->get('idInscription');

        $html = $this->printHistoriquePaiement($idInscription);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printHistoriquePaiement($idInscription)
{

        //Info Entreprise
        $nomEse='';
        $adresseEse='';
        $Tel1Ese='';
        $Tel2Ese='';
        $siteEse='';
        $emailEse='';
        $idNatEse='';
        $numImpotEse='';
        $rccEse='';
        $siege='';
        $busnessName='';
        $pic='';
        $pic2 = '';
        $logo='';

        $data1 = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
        'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
        ->get();
        $output='';
        foreach ($data1 as $row) 
        {                                
            $nomEse=$row->nom;
            $adresseEse=$row->adresse;
            $Tel1Ese=$row->tel1;
            $Tel2Ese=$row->tel2;
            $siteEse=$row->mission;
            $emailEse=$row->email;
            $idNatEse='0000';
            $numImpotEse='0000';
            $busnessName=$row->objectif;
            $rccmEse='0000';
            $pic2 = $this->displayImg("images", $row->logo);
            $siege=$row->politique;         
        }

        $pic = $this->displayImg("images", 'armoirie.png');


    $totalPaie=0;
    $totalReste=0;
    $totalPrevision=0;
    $nomEleve = ''; 
    $postNomEleve = '';
    $preNomEleve='';
    $nomClasse=''; 
    $nomSection=''; 
    $nomOption='';
    $noms = '';
     // 
     $data2 =  DB::table('inscriptions')
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
         'paie','fraisinscription',
         'inscriptions.created_at')
     ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
     ->selectRaw('(paie + reste + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
     ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")
     ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PourcentagePrev')
     ->selectRaw("CONCAT(nomEleve,' ',postNomEleve,' ',preNomEleve) as noms")
     ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
     ->where([
        ['inscriptions.id','=', $idInscription]
    ])  
     ->get(); 
     $output='';
     foreach ($data2 as $row) 
     {    
        $totalPaie = $row->paie;
        $totalReste = $row->reste; 
        $totalPrevision = $row->Prevision;   
        $nomEleve = $row->nomEleve; 
        $postNomEleve = $row->postNomEleve;
        $preNomEleve = $row->preNomEleve;
        $nomClasse = $row->nomClasse; 
        $nomSection =$row->nomSection; 
        $nomOption = $row->nomOption;  
        $noms = $row->noms;                 
     }


        $output='';           

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptHistoriquePaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs4A517927 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csB9948AEE {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs2A8593E6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE9F2AA97 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs567D9653 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:695px;height:348px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:9px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:45px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:55px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:170px;"></td>
                    <td style="height:0px;width:69px;"></td>
                    <td style="height:0px;width:159px;"></td>
                    <td style="height:0px;width:5px;"></td>
                    <td style="height:0px;width:5px;"></td>
                    <td style="height:0px;width:116px;"></td>
                    <td style="height:0px;width:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="5" style="width:117px;height:108px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:117px;height:108px;">
                        <img alt="" src="'.$pic2.'" style="width:117px;height:108px;" /></div>
                    </td>
                    <td></td>
                    <td class="csE9F2AA97" colspan="4" style="width:426px;height:24px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="5" style="width:117px;height:108px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:117px;height:108px;">
                        <img alt="" src="'.$pic.'" style="width:117px;height:108px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE9F2AA97" colspan="4" style="width:426px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs2A8593E6" colspan="4" style="width:426px;height:22px;line-height:17px;text-align:center;vertical-align:middle;"><nobr>&nbsp;'.$adresseEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs567D9653" colspan="4" style="width:426px;height:24px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:&nbsp;'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs567D9653" colspan="4" rowspan="2" style="width:426px;height:25px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                    <td class="cs8A513397" colspan="6" style="width:493px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$noms.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Classe&nbsp;:</nobr></td>
                    <td class="cs8A513397" colspan="6" style="width:493px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$nomClasse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Option&nbsp;:</nobr></td>
                    <td class="cs8A513397" colspan="6" style="width:493px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$nomSection.'/'.$nomOption.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs4A517927" colspan="2" style="width:43px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs4A517927" colspan="4" style="width:110px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="cs4A517927" style="width:166px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Tranche</nobr></td>
                    <td class="cs4A517927" colspan="3" style="width:229px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Frais</nobr></td>
                    <td class="cs4A517927" colspan="2" style="width:117px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Montant&nbsp;($)</nobr></td>
                    <td></td>
                </tr>
                ';
                                                                                        
                    $output .= $this->showHitoriquePaiement($idInscription); 
                                                                                        
                    $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csB9948AEE" colspan="10" style="width:558px;height:20px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>Total&nbsp;Montant&nbsp;&#224;&nbsp;Payer</nobr></td>
                    <td class="csB9948AEE" colspan="2" style="width:115px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPrevision.'$</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csB9948AEE" colspan="10" style="width:558px;height:20px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>Montant&nbsp;total&nbsp;d&#233;j&#224;&nbsp;Pay&#233;</nobr></td>
                    <td class="csB9948AEE" colspan="2" style="width:115px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csB9948AEE" colspan="10" style="width:558px;height:20px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>Total&nbsp;Reste&nbsp;&#224;&nbsp;Payer</nobr></td>
                    <td class="csB9948AEE" colspan="2" style="width:115px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>     
        ';  
    
        return $output; 

}

function showHitoriquePaiement($idInscription)
{
        $count=0;

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

            'paie','fraisinscription','restoreinscription',

            //users
            'users.name','users.email','users.avatar',
            "paiements.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")
        ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
        ->where([
            ['paiements.idInscription','=', $idInscription],
            ['anne_scollaires.statut', '=', 1]
        ])
        ->orderBy("paiements.id", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                	<tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csB9948AEE" colspan="2" style="width:41px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                        <td class="csB9948AEE" colspan="4" style="width:108px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->datePaiement.'</nobr></td>
                        <td class="cs4A517927" style="width:166px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$row->nomTranche.'</nobr></td>
                        <td class="cs4A517927" colspan="3" style="width:229px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$row->nomTypeTranche.'</nobr></td>
                        <td class="csB9948AEE" colspan="2" style="width:115px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant.'$</nobr></td>
                        <td></td>
                    </tr>
            ';

    }

    return $output;

}




//=============== FICHE DE RECOUVREMENT ============================================================================

public function fetch_rapport_recouvrement_classe(Request $request)
{
    //refDepartement  refBanque

    if ($request->get('idAnne') && $request->get('idClasse')&& $request->get('idOption')&& $request->get('montant')) {
        // code...
        $idAnne = $request->get('idAnne');
        $idClasse = $request->get('idClasse');
        $idOption = $request->get('idOption');
        $montant = $request->get('montant');
        
        $html = $this->printRapportRecouvrementClasse($idAnne, $idClasse, $idOption, $montant);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportRecouvrementClasse($idAnne, $idClasse, $idOption, $montant)
{

        //Info Entreprise
        $nomEse='';
        $adresseEse='';
        $Tel1Ese='';
        $Tel2Ese='';
        $siteEse='';
        $emailEse='';
        $idNatEse='';
        $numImpotEse='';
        $rccEse='';
        $siege='';
        $busnessName='';
        $pic='';
        $pic2 = '';
        $logo='';

        $data1 = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
        'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
        ->get();
        $output='';
        foreach ($data1 as $row) 
        {                                
            $nomEse=$row->nom;
            $adresseEse=$row->adresse;
            $Tel1Ese=$row->tel1;
            $Tel2Ese=$row->tel2;
            $siteEse=$row->mission;
            $emailEse=$row->email;
            $idNatEse='0000';
            $numImpotEse='0000';
            $busnessName=$row->objectif;
            $rccmEse='0000';
            $pic2 = $this->displayImg("images", $row->logo);
            $siege=$row->politique;         
        }

        $pic = $this->displayImg("images", 'armoirie.png');

    
    $totalPaie=0;
    $totalReste=0;
    $totalReduction=0;
     // restoreinscription
     $data2 =  DB::table('inscriptions')
     ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')
     ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
     ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
     ->where([
        ['idAnne','=', $idAnne],
        ['idClasse','=', $idClasse],
        ['idOption','=', $idOption],
        ['paie','>=', floatval($montant)]
    ])  
     ->get(); 
     $output='';
     foreach ($data2 as $row) 
     {    
        $totalPaie=$row->totalPaie;
        $totalReste=$row->totalReste; 
        $totalReduction = $row->totalReduction;                        
     }


        $output='';           

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptPaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:67px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:171px;"></td>
                    <td style="height:0px;width:85px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:125px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;ELEVES EN ORDRE</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                    <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                    <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                    <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                    <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                </tr>
                ';
                                                                        
                                            $output .= $this->showRapportRecouvrementClasse($idAnne, $idClasse, $idOption,$montant); 
                                                                        
                                            $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                    <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                    <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                    <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>       
        ';  
    
        return $output; 

}

function showRapportRecouvrementClasse($idAnne, $idClasse, $idOption,$montant)
{
        $count=0;

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
            'inscriptions.codeInscription','inscriptions.reductionPaiement',
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
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw('(paie + reste  + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription)*reductionPaiement)/100),0)) as Prevision')
        ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")
        ->selectRaw('ROUND((((paie + reste - fraisinscription)*reductionPaiement)/100),0) as Reduction')
        ->where([
            ['idAnne','=', $idAnne],
            ['idClasse','=', $idClasse],
            ['idOption','=', $idOption],
            ['paie','>=', floatval($montant)]
        ])
        ->orderBy("nomEleve", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                    <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                    <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                    <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                    <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                    <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                </tr>
            ';

    }

    return $output;

}


//=============== FICHE DE RECOUVREMENT ============================================================================

public function fetch_rapport_retardpaie_classe(Request $request)
{
    //refDepartement  refBanque

    if ($request->get('idAnne') && $request->get('idClasse')&& $request->get('idOption')&& $request->get('montant')) {
        // code...
        $idAnne = $request->get('idAnne');
        $idClasse = $request->get('idClasse');
        $idOption = $request->get('idOption');
        $montant = $request->get('montant');
        
        $html = $this->printRapportRetardPaieClasse($idAnne, $idClasse, $idOption, $montant);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportRetardPaieClasse($idAnne, $idClasse, $idOption, $montant)
{

        //Info Entreprise
        $nomEse='';
        $adresseEse='';
        $Tel1Ese='';
        $Tel2Ese='';
        $siteEse='';
        $emailEse='';
        $idNatEse='';
        $numImpotEse='';
        $rccEse='';
        $siege='';
        $busnessName='';
        $pic='';
        $pic2 = '';
        $logo='';

        $data1 = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
        'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
        ->get();
        $output='';
        foreach ($data1 as $row) 
        {                                
            $nomEse=$row->nom;
            $adresseEse=$row->adresse;
            $Tel1Ese=$row->tel1;
            $Tel2Ese=$row->tel2;
            $siteEse=$row->mission;
            $emailEse=$row->email;
            $idNatEse='0000';
            $numImpotEse='0000';
            $busnessName=$row->objectif;
            $rccmEse='0000';
            $pic2 = $this->displayImg("images", $row->logo);
            $siege=$row->politique;         
        }

        $pic = $this->displayImg("images", 'armoirie.png');
    
    $totalPaie=0;
    $totalReste=0;
    $totalReduction=0;
     //restoreinscription   
     $data2 =  DB::table('inscriptions')
     ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')
     ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
     ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
     // ->selectRaw('(ROUND(reductionPaiement,0) as reductionPaiement')
     ->where([
        ['idAnne','=', $idAnne],
        ['idClasse','=', $idClasse],
        ['idOption','=', $idOption],
        ['paie','<', floatval($montant)]
    ])  
     ->get(); 
     $output='';
     foreach ($data2 as $row) 
     {    
        $totalPaie=$row->totalPaie;
        $totalReste=$row->totalReste; 
        $totalReduction = $row->totalReduction;                        
     }


        $output='';           

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptPaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:67px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:171px;"></td>
                    <td style="height:0px;width:85px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:125px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;ELEVES EN RETATD DE PAIEMENT</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                    <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                    <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                    <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                    <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                </tr>
                ';
                                                                        
                    $output .= $this->showRapportRetardPaieClasse($idAnne, $idClasse, $idOption,$montant); 
                                                                        
                                            $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                    <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                    <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                    <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>       
        ';  
    
        return $output; 

}

function showRapportRetardPaieClasse($idAnne, $idClasse, $idOption,$montant)
{
        $count=0;
        $Prevision=0;
        $Reduction=0;


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
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")

        ->selectRaw('(paie + reste -  ROUND((paie + reste - fraisinscription) * (reductionPaiement) /100 ,0)) as Prevision')
        // ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription )*(ROUND(reductionPaiement,0))/100),0)) as Prevision')
        ->selectRaw('ROUND((((paie + reste - fraisinscription)*(ROUND(reductionPaiement,0)))/100),0) as Reduction')
        ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
        ->where([
            ['idAnne','=', $idAnne],
            ['idClasse','=', $idClasse],
            ['idOption','=', $idOption],
            ['paie','<', floatval($montant)]
        ])
        ->orderBy("nomEleve", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;
            $Reduction = $row->Reduction;
            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                    <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                    <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                    <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">
                        <nobr> 
                        '.$Reduction.'$('.$row->reductionPaiement.'%) 
                        </nobr>
                    </td>
                    <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">
                        <nobr>'.$row->paie.'$</nobr>
                    </td>
                    <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">
                        <nobr>'.$row->reste.'$</nobr>
                    </td>
                    <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">
                        <nobr>'.$row->numPere.'</nobr>
                    </td>
                </tr>
            ';

    }

    return $output;

}

//=============== FICHE DE RECOUVREMENT ============================================================================



public function fetch_rapport_retardpaie_option(Request $request)
{
    //refDepartement  refBanque

    if ($request->get('idAnne') && $request->get('idOption')&& $request->get('montant')) {
        // code...
        $idAnne = $request->get('idAnne');
        $idOption = $request->get('idOption');
        $montant = $request->get('montant');
        
        $html = $this->printRapportRetardPaieOption($idAnne, $idOption, $montant);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportRetardPaieOption($idAnne, $idOption, $montant)
{

        //Info Entreprise
        $nomEse='';
        $adresseEse='';
        $Tel1Ese='';
        $Tel2Ese='';
        $siteEse='';
        $emailEse='';
        $idNatEse='';
        $numImpotEse='';
        $rccEse='';
        $siege='';
        $busnessName='';
        $pic='';
        $pic2 = '';
        $logo='';

        $data1 = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
        'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
        ->get();
        $output='';
        foreach ($data1 as $row) 
        {                                
            $nomEse=$row->nom;
            $adresseEse=$row->adresse;
            $Tel1Ese=$row->tel1;
            $Tel2Ese=$row->tel2;
            $siteEse=$row->mission;
            $emailEse=$row->email;
            $idNatEse='0000';
            $numImpotEse='0000';
            $busnessName=$row->objectif;
            $rccmEse='0000';
            $pic2 = $this->displayImg("images", $row->logo);
            $siege=$row->politique;         
        }

        $pic = $this->displayImg("images", 'armoirie.png');

    
    $totalPaie=0;
    $totalReste=0;
    $totalReduction=0;
     //restoreinscription   
     $data2 =  DB::table('inscriptions')
     ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')
     ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
     ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
    //  ->selectRaw('(ROUND(reductionPaiement,0) as reductionPaiement')
     ->where([
        ['idAnne','=', $idAnne],
        ['idOption','=', $idOption],
        ['paie','<', floatval($montant)]
    ])  
     ->get(); 
     $output='';
     foreach ($data2 as $row) 
     {    
        $totalPaie=$row->totalPaie;
        $totalReste=$row->totalReste; 
        $totalReduction = $row->totalReduction;                        
     }


        $output='';           

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptPaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:67px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:171px;"></td>
                    <td style="height:0px;width:85px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:125px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;ELEVES EN RETATD DE PAIEMENT</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                    <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                    <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                    <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                    <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                </tr>
                ';
                                                                        
                                            $output .= $this->showRapportRetardPaieOption($idAnne, $idOption,$montant); 
                                                                        
                                            $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                    <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                    <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                    <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>       
        ';  
    
        return $output; 

}

function showRapportRetardPaieOption($idAnne, $idOption,$montant)
{
        $count=0;

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
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw('(paie + reste  + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription)*reductionPaiement)/100),0)) as Prevision')
            ->selectRaw("CASE  
                        WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                        WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                        ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                        ELSE 0
                    END as reste")
            ->selectRaw('ROUND((((paie + reste - fraisinscription)*reductionPaiement)/100),0) as Reduction')
            ->selectRaw('reductionPaiement as reductionPaiement')
        ->where([
            ['idAnne','=', $idAnne],            
            ['idOption','=', $idOption],
            ['paie','<', floatval($montant)]
        ])
        ->orderBy("nomEleve", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                    <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                    <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                    <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                    <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                    <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                </tr>
            ';

    }

    return $output;

}


//=============== FICHE DE RECOUVREMENT ============================================================================

public function fetch_rapport_recouvrement_option(Request $request)
{
    //refDepartement  refBanque

    if ($request->get('idAnne')&& $request->get('idOption')&& $request->get('montant')) {
        // code...
        $idAnne = $request->get('idAnne');
        $idOption = $request->get('idOption');
        $montant = $request->get('montant');
        
        $html = $this->printRapportRecouvrementOption($idAnne, $idOption, $montant);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportRecouvrementOption($idAnne, $idOption, $montant)
{

        //Info Entreprise
        $nomEse='';
        $adresseEse='';
        $Tel1Ese='';
        $Tel2Ese='';
        $siteEse='';
        $emailEse='';
        $idNatEse='';
        $numImpotEse='';
        $rccEse='';
        $siege='';
        $busnessName='';
        $pic='';
        $pic2 = '';
        $logo='';

        $data1 = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
        'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
        ->get();
        $output='';
        foreach ($data1 as $row) 
        {                                
            $nomEse=$row->nom;
            $adresseEse=$row->adresse;
            $Tel1Ese=$row->tel1;
            $Tel2Ese=$row->tel2;
            $siteEse=$row->mission;
            $emailEse=$row->email;
            $idNatEse='0000';
            $numImpotEse='0000';
            $busnessName=$row->objectif;
            $rccmEse='0000';
            $pic2 = $this->displayImg("images", $row->logo);
            $siege=$row->politique;         
        }

        $pic = $this->displayImg("images", 'armoirie.png');

    
    $totalPaie=0;
    $totalReste=0;
    $totalReduction=0;
     // restoreinscription
     $data2 =  DB::table('inscriptions')
     ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')
     ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
     ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription) * reductionPaiement)/100)),0),0) as totalReduction')
     ->where([
        ['idAnne','=', $idAnne],
        ['idOption','=', $idOption],
        ['paie','>=', floatval($montant)]
    ])  
     ->get(); 
     $output='';
     foreach ($data2 as $row) 
     {    
        $totalPaie=$row->totalPaie;
        $totalReste=$row->totalReste; 
        $totalReduction = $row->totalReduction;                        
     }


        $output='';           

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptPaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:67px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:171px;"></td>
                    <td style="height:0px;width:85px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:125px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;ELEVES EN ORDRE</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                    <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                    <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                    <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                    <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                </tr>
                ';
                                                                        
                                            $output .= $this->showRapportRecouvrementOption($idAnne, $idOption,$montant); 
                                                                        
                                            $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                    <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                    <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                    <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>       
        ';  
    
        return $output; 

}

function showRapportRecouvrementOption($idAnne, $idOption,$montant)
{
        $count=0;

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
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw('(paie + reste  + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription)*reductionPaiement)/100),0)) as Prevision')
        ->selectRaw("CASE  
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                    WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                    ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                    ELSE 0
                END as reste")
        ->selectRaw('ROUND((((paie + reste - fraisinscription)*reductionPaiement)/100),0) as Reduction')
        ->selectRaw('reductionPaiement as reductionPaiement')
        ->where([
            ['idAnne','=', $idAnne],
            ['idOption','=', $idOption],
            ['paie','>=', floatval($montant)]
        ])
        ->orderBy("nomEleve", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                    <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                    <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                    <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                    <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                    <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                </tr>
            ';

    }

    return $output;

}


//=============== LISTE DES NOUVEAUX INSCRITS ============================================================================



public function fetch_rapport_nouveau_option(Request $request)
{
    //refDepartement  refBanque

    if ($request->get('idAnne') && $request->get('idOption')) {
        // code...
        $idAnne = $request->get('idAnne');
        $idOption = $request->get('idOption');

        $html = $this->printRapportNouveauOption($idAnne, $idOption);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportNouveauOption($idAnne, $idOption)
{

        //Info Entreprise
        $nomEse='';
        $adresseEse='';
        $Tel1Ese='';
        $Tel2Ese='';
        $siteEse='';
        $emailEse='';
        $idNatEse='';
        $numImpotEse='';
        $rccEse='';
        $siege='';
        $busnessName='';
        $pic='';
        $pic2 = '';
        $logo='';

        $data1 = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
        'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
        ->get();
        $output='';
        foreach ($data1 as $row) 
        {                                
            $nomEse=$row->nom;
            $adresseEse=$row->adresse;
            $Tel1Ese=$row->tel1;
            $Tel2Ese=$row->tel2;
            $siteEse=$row->mission;
            $emailEse=$row->email;
            $idNatEse='0000';
            $numImpotEse='0000';
            $busnessName=$row->objectif;
            $rccmEse='0000';
            $pic2 = $this->displayImg("images", $row->logo);
            $siege=$row->politique;         
        }

        $pic = $this->displayImg("images", 'armoirie.png');
    
    $totalPaie=0;
    $totalReste=0;
    $totalReduction=0;
     //restoreinscription   
     $data2 =  DB::table('inscriptions')
     ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')
     ->selectRaw("CASE  
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                    WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                    (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                    ELSE 0
                END as totalReste")
     ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
    //  ->selectRaw('(ROUND(reductionPaiement,0) as reductionPaiement')
     ->where([
        ['idAnne','=', $idAnne],
        ['idOption','=', $idOption],
        ['fraisinscription','>', 0]
    ])  
     ->get(); 
     $output='';
     foreach ($data2 as $row) 
     {    
        $totalPaie=$row->totalPaie;
        $totalReste=$row->totalReste; 
        $totalReduction = $row->totalReduction;                        
     }


        $output='';           

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptPaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:67px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:171px;"></td>
                    <td style="height:0px;width:85px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:125px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;ELEVES EN RETATD DE PAIEMENT</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                    <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                    <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                    <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                    <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                </tr>
                ';
                                                                        
                                            $output .= $this->showRapportNouveauOption($idAnne, $idOption); 
                                                                        
                                            $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                    <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                    <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                    <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>       
        ';  
    
        return $output; 

}

function showRapportNouveauOption($idAnne, $idOption)
{
        $count=0;

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
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw('(paie + reste  + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription)*reductionPaiement)/100),0)) as Prevision')
            ->selectRaw("CASE  
                        WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                        WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                        ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                        ELSE 0
                    END as reste")
            ->selectRaw('ROUND((((paie + reste - fraisinscription)*reductionPaiement)/100),0) as Reduction')
            ->selectRaw('reductionPaiement as reductionPaiement')
        ->where([
            ['idAnne','=', $idAnne],            
            ['idOption','=', $idOption],
            ['fraisinscription','>', 0]
        ])
        ->orderBy("nomEleve", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                    <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                    <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                    <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                    <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                    <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                </tr>
            ';
    }

    return $output;

}



//==================== LISTE INSCRIPTION DES NOUVEAUX EELEVES PAR CLASSE =================================


public function fetch_rapport_inscription_nouveau_classe(Request $request)
{
    //refDepartement  refBanque

    if ($request->get('idAnne') && $request->get('idClasse')&& $request->get('idOption')) {
        // code...
        $idAnne = $request->get('idAnne');
        $idClasse = $request->get('idClasse');
        $idOption = $request->get('idOption');
        
        $html = $this->printRapportInscriptionNouveauClasse($idAnne, $idClasse, $idOption);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportInscriptionNouveauClasse($idAnne, $idClasse, $idOption)
{

        //Info Entreprise
        $nomEse='';
        $adresseEse='';
        $Tel1Ese='';
        $Tel2Ese='';
        $siteEse='';
        $emailEse='';
        $idNatEse='';
        $numImpotEse='';
        $rccEse='';
        $siege='';
        $busnessName='';
        $pic='';
        $pic2 = '';
        $logo='';

        $data1 = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
        'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')
        ->get();
        $output='';
        foreach ($data1 as $row) 
        {                                
            $nomEse=$row->nom;
            $adresseEse=$row->adresse;
            $Tel1Ese=$row->tel1;
            $Tel2Ese=$row->tel2;
            $siteEse=$row->mission;
            $emailEse=$row->email;
            $idNatEse='0000';
            $numImpotEse='0000';
            $busnessName=$row->objectif;
            $rccmEse='0000';
            $pic2 = $this->displayImg("images", $row->logo);
            $siege=$row->politique;         
        }

        $pic = $this->displayImg("images", 'armoirie.png');


    $totalPaie=0;
    $totalReste=0;
    $totalReduction=0;
     // 
     $data2 =  DB::table('inscriptions')
     ->selectRaw('IFNULL(ROUND(SUM(paie),0),0) as totalPaie')        
     ->selectRaw("CASE  
                WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) < 0 THEN 0 
                WHEN (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie)) >= 0 THEN 
                (((IFNULL(ROUND(SUM(paie),0),0) + IFNULL(ROUND(SUM(reste),0),0) - IFNULL(ROUND(SUM(fraisinscription),0),0)) * (SUM(reductionPaiement)) / (100)) - SUM(paie))              
                ELSE 0
            END as totalReste")
     ->selectRaw('IFNULL(ROUND(SUM((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100)),0),0) as totalReduction')
     ->where([
        ['idAnne','=', $idAnne],
        ['idClasse','=', $idClasse],
        ['idOption','=', $idOption],
        ['fraisinscription','>', 0]
    ])  
     ->get(); 
     $output='';
     foreach ($data2 as $row) 
     {    
        $totalPaie=$row->totalPaie;
        $totalReste=$row->totalReste; 
        $totalReduction = $row->totalReduction;                        
     }


        $output='';           

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptPaiement</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:310px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:67px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:171px;"></td>
                    <td style="height:0px;width:85px;"></td>
                    <td style="height:0px;width:87px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:125px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:635px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>REPUBLIQUE&nbsp;DEMOBCRATIQUE&nbsp;DU&nbsp;CONGO</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" style="width:635px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:635px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.' , '.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:635px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'&nbsp;</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>LISTE&nbsp;DES&nbsp;INSCRIPTIONS(PAIEMENTS)</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:56px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="5" style="width:240px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" style="width:36px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:76px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CLASSE</nobr></td>
                    <td class="cs479D8C74" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>SECTION&nbsp;/&nbsp;OPTION</nobr></td>
                    <td class="cs479D8C74" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REDUCTION</nobr></td>
                    <td class="cs479D8C74" style="width:86px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PAYE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:69px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RESTE</nobr></td>
                    <td class="cs479D8C74" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                </tr>
                ';
                                                                        
                                            $output .= $this->showRapportInscriptionNouveauClasse($idAnne, $idClasse, $idOption); 
                                                                        
                                            $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs8CFBEB27" style="width:169px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs58C16240" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReduction.'$</nobr></td>
                    <td class="cs58C16240" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                    <td class="cs58C16240" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                    <td class="cs58C16240" style="width:124px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs1698ECB3" colspan="5" style="width:230px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            </body>
            </html>       
        ';  
    
        return $output; 

}

function showRapportInscriptionNouveauClasse($idAnne, $idClasse, $idOption)
{
        $count=0;

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
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')  
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')            
        ->selectRaw("CASE  
                WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) < 0 THEN 0 
                WHEN ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie)) >= 0 THEN 
                ((((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription))-(paie))              
                ELSE 0
            END as reste")
        ->selectRaw('((paie + reste - ROUND((((paie + reste - fraisinscription) * reductionPaiement)/100),0)) - fraisinscription) as Prevision')
        ->selectRaw('ROUND((((paie + reste - fraisinscription) * ROUND(reductionPaiement,0))/100),0) as Reduction')
        ->selectRaw('ROUND(reductionPaiement,0) as reductionPaiement')
        ->where([
            ['idAnne','=', $idAnne],
            ['idClasse','=', $idClasse],
            ['idOption','=', $idOption],
            ['fraisinscription','>', 0]
        ])
        ->orderBy("nomEleve", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:56px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="5" style="width:240px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomEleve.' '.$row->postNomEleve.' '.$row->preNomEleve.'</nobr></td>
                    <td class="csD06EB5B2" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->sexeEleve.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:76px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomClasse.'</nobr></td>
                    <td class="csD06EB5B2" style="width:170px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nomSection.'&nbsp;/&nbsp;'.$row->nomOption.'</nobr></td>
                    <td class="csD06EB5B2" style="width:84px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Reduction.'$('.$row->reductionPaiement.'%)</nobr></td>
                    <td class="csD06EB5B2" style="width:86px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->paie.'$</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:69px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->reste.'$</nobr></td>
                    <td class="csD06EB5B2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->numPere.'</nobr></td>
                </tr>
            ';

    }

    return $output;

}








}
