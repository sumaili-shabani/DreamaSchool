<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;
class PdfVenteController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    
//==================== RAPPORT JOURNALIER DES VenteS =================================

public function fetch_rapport_detailvente_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');


        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente($date1, $date2);       
        // $html .='<script>window.print()</script>';

        // echo($html); 

        
        $html = $this->printRapportDetailVente($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // $pdf->loadHTML($html)->setPaper('a4', 'portrait');
        return $pdf->stream();            

    } else {
        // code...
    }
    
    
}

function printRapportDetailVente($date1, $date2)
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
             $emailEse=$row->tel3;
             $idNatEse='0000';
             $numImpotEse='0000';
             $busnessName=$row->objectif;
             $rccmEse='0000';
             $pic2 = $this->displayImg("images", $row->logo);
             $siege=$row->politique;         
         }
 

         $totalFact=0;
         // 
         $data2 =  DB::table('tvente_detail_vente')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
         ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
 
         ->select(DB::raw('ROUND(SUM(qteVente*puVente),0) as TotalFacture'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;                           
         }

           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td></td>
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
           
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
           
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;FACTURATIONS</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailVente($date1,$date2); 

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
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </html>';  
       
        return $output; 

}

function showDetailVente($date1, $date2)
{
    $data = DB::table('tvente_detail_vente')
    ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
    ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
    ->join('inscriptions','inscriptions.id','=','tvente_entete_vente.refClient')
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
    ->select('tvente_detail_vente.id','refEnteteVente','refProduit','dateVente',
    'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
    'tvente_detail_vente.author','tvente_detail_vente.created_at',
    'tvente_detail_vente.devise','tvente_detail_vente.taux',
    'unite_paquet','puPaquet','qtePaquet',
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
    'anne_scollaires.designation as annee','anne_scollaires.statut',
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
    'inscriptions.paie as paieFrais','inscriptions.reste as resteFrais')
    ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                       (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END)) as PTVente")
    ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                       (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END))/tvente_detail_vente.taux) as PTVenteFC")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END) as puVente")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) as qteVente")
    ->selectRaw('((IFNULL(montant,0))*tvente_detail_vente.taux) as totalFactureFC')
    ->selectRaw('IFNULL(montant,0) as totalFacture')
    ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
    ->selectRaw('(IFNULL(montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
    ->selectRaw("(IFNULL(pu,0) - IFNULL((CASE WHEN (unite_paquet = 'Par Pièce') THEN IFNULL(pu,0) 
                       WHEN (unite_paquet = 'Par Kilo') THEN IFNULL(pu,0) 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END),0)) as Reduction")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN 'Pcs' WHEN (unite_paquet = 'Par Kilo') THEN 'Kg'
                       WHEN (unite_paquet = 'Par Paquet') THEN 'Paq' END) as Unites")
    ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
    ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
    ->where([
        ['dateVente','>=', $date1],
        ['dateVente','<=', $date2]
    ])
    ->orderBy("tvente_entete_vente.dateVente", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puVente.'$('.$row->Reduction.'$)</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
    </tr>';      
   
    }

    return $output;

}
//==================== RAPPORT DETAIL FACTURE SELON LES ORGANISATIONS =======================================

public function fetch_rapport_detailvente_date_categorie(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refCategorie')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refCategorie = $request->get('refCategorie');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Categorie($date1, $date2,$refCategorie);       
        // $html .='<script>window.print()</script>';

        // echo($html); 
        
        $html = $this->printRapportDetailVente_Categorie($date1, $date2,$refCategorie);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportDetailVente_Categorie($date1, $date2,$refCategorie)
{

         
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
             $emailEse=$row->tel3;
             $idNatEse='0000';
             $numImpotEse='0000';
             $busnessName=$row->objectif;
             $rccmEse='0000';
             $pic2 = $this->displayImg("images", 'logo.png');
             $siege=$row->politique;         
         }
 

         $totalFact=0;
                 
         //
         $data2 = DB::table('tvente_detail_vente')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
         ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
                 
         ->select(DB::raw('ROUND(SUM(qteVente*puVente),0) as TotalFacture'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['refCategorie','=', $refCategorie],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;                           
         }

         $CategorieClient='';

         $data3=DB::table('tvente_detail_vente')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
         ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
         ->join('inscriptions','inscriptions.id','=','tvente_entete_vente.refClient')
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
         ->select('tvente_detail_vente.id','refEnteteVente','refProduit','dateVente',
         'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
         'tvente_detail_vente.author','tvente_detail_vente.created_at',
         'tvente_detail_vente.devise','tvente_detail_vente.taux',
         'unite_paquet','puPaquet','qtePaquet',
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
         'inscriptions.paie as paieFrais','inscriptions.reste as resteFrais')
         ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                            (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END)) as PTVente")
         ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                            (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END))/tvente_detail_vente.taux) as PTVenteFC")
         ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END) as puVente")
         ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) as qteVente")
         ->selectRaw('((IFNULL(montant,0))*tvente_detail_vente.taux) as totalFactureFC')
         ->selectRaw('IFNULL(montant,0) as totalFacture')
         ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
         ->selectRaw('(IFNULL(montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
         ->selectRaw("(IFNULL(pu,0) - IFNULL((CASE WHEN (unite_paquet = 'Par Pièce') THEN IFNULL(pu,0) 
                            WHEN (unite_paquet = 'Par Kilo') THEN IFNULL(pu,0) 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END),0)) as Reduction")
         ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN 'Pcs' WHEN (unite_paquet = 'Par Kilo') THEN 'Kg'
                            WHEN (unite_paquet = 'Par Paquet') THEN 'Paq' END) as Unites")
         ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['refCategorie','=', $refCategorie],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $CategorieClient=$row->CategorieClient;              
        }


          

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td></td>
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
           
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VenteS</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$nom_departement.'</td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;Vente</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailVente_Categorie($date1,$date2,$refCategorie); 
        
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
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </html>';  
       
        return $output; 

}

function showDetailVente_Categorie($date1,$date2,$refCategorie)
{
        $data = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
        ->join('inscriptions','inscriptions.id','=','tvente_entete_vente.refClient')
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
        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','dateVente',
        'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tvente_detail_vente.author','tvente_detail_vente.created_at',
        'tvente_detail_vente.devise','tvente_detail_vente.taux',
        'unite_paquet','puPaquet','qtePaquet',
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
        'anne_scollaires.designation as annee','anne_scollaires.statut',
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
        'inscriptions.paie as paieFrais','inscriptions.reste as resteFrais')
        ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                           WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                           WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                           (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                           WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                           WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END)) as PTVente")
        ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                           WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                           WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                           (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                           WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                           WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END))/tvente_detail_vente.taux) as PTVenteFC")
        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                           WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                           WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END) as puVente")
        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                           WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                           WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) as qteVente")
        ->selectRaw('((IFNULL(montant,0))*tvente_detail_vente.taux) as totalFactureFC')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
        ->selectRaw("(IFNULL(pu,0) - IFNULL((CASE WHEN (unite_paquet = 'Par Pièce') THEN IFNULL(pu,0) 
                           WHEN (unite_paquet = 'Par Kilo') THEN IFNULL(pu,0) 
                           WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END),0)) as Reduction")
        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN 'Pcs' WHEN (unite_paquet = 'Par Kilo') THEN 'Kg'
                           WHEN (unite_paquet = 'Par Paquet') THEN 'Paq' END) as Unites")
        ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
        ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['refCategorie','=', $refCategorie]
        ])
        ->orderBy("tvente_entete_vente.dateVente", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;&nbsp;</td>
                    <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                    <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                    <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puVente.'$('.$row->Reduction.'$)</td>
                    <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
                </tr>
            ';
           
   
    }

    return $output;

}

//==================== RAPPORT DETAIL Vente BY MEDICAMENT =======================================

public function fetch_rapport_detailvente_date_produit(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refProduit')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refProduit = $request->get('refProduit');
        
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Produit($date1, $date2,$refProduit);       
        // $html .='<script>window.print()</script>';

        // echo($html); 

        $html = $this->printRapportDetailVente_Produit($date1, $date2,$refProduit);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }
    
}

function printRapportDetailVente_Produit($date1, $date2,$refProduit)
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
             $emailEse=$row->tel3;
             $idNatEse='0000';
             $numImpotEse='0000';
             $busnessName=$row->objectif;
             $rccmEse='0000';
             $pic2 = $this->displayImg("images", $row->logo);
             $siege=$row->politique;         
         }
 

         $totalFact=0;
                 
         //
         $data2 = DB::table('tvente_detail_vente')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
         ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')        
         ->select(DB::raw('ROUND(SUM(qteVente*puVente),0) as TotalFacture'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['refProduit','=', $refProduit],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

         $designationProduit='';
         $categorieProduit='';

         $data3=DB::table('tvente_detail_vente')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
         ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
         ->join('inscriptions','inscriptions.id','=','tvente_entete_vente.refClient')
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
         ->select('tvente_detail_vente.id','refEnteteVente','refProduit','dateVente',
         'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
         'tvente_detail_vente.author','tvente_detail_vente.created_at',
         'tvente_detail_vente.devise','tvente_detail_vente.taux',
         'unite_paquet','puPaquet','qtePaquet',
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
         'anne_scollaires.designation as annee','anne_scollaires.statut',
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
         'inscriptions.paie as paieFrais','inscriptions.reste as resteFrais')
         ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                            (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END)) as PTVente")
         ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                            (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END))/tvente_detail_vente.taux) as PTVenteFC")
         ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END) as puVente")
         ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) as qteVente")
         ->selectRaw('((IFNULL(montant,0))*tvente_detail_vente.taux) as totalFactureFC')
         ->selectRaw('IFNULL(montant,0) as totalFacture')
         ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
         ->selectRaw('(IFNULL(montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
         ->selectRaw("(IFNULL(pu,0) - IFNULL((CASE WHEN (unite_paquet = 'Par Pièce') THEN IFNULL(pu,0) 
                            WHEN (unite_paquet = 'Par Kilo') THEN IFNULL(pu,0) 
                            WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END),0)) as Reduction")
         ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN 'Pcs' WHEN (unite_paquet = 'Par Kilo') THEN 'Kg'
                            WHEN (unite_paquet = 'Par Paquet') THEN 'Paq' END) as Unites")
         ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture') 
         ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['refProduit','=', $refProduit],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $designationProduit=$row->designation;
            $categorieProduit=$row->Categorie;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td></td>
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
           
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$designationProduit.' - '.$categorieProduit.'</td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;VENTE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailVente_Produit($date1,$date2,$refProduit); 
        
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
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </html>';  
       
        return $output; 

}

function showDetailVente_Produit($date1, $date2,$refProduit)
{
    $data = DB::table('tvente_detail_vente')
    ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
    ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
    ->join('inscriptions','inscriptions.id','=','tvente_entete_vente.refClient')
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
    ->select('tvente_detail_vente.id','refEnteteVente','refProduit','dateVente',
    'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
    'tvente_detail_vente.author','tvente_detail_vente.created_at',
    'tvente_detail_vente.devise','tvente_detail_vente.taux',
    'unite_paquet','puPaquet','qtePaquet',
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
    'anne_scollaires.designation as annee','anne_scollaires.statut',
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
    'inscriptions.paie as paieFrais','inscriptions.reste as resteFrais')
    ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                       (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END)) as PTVente")
    ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                       (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END))/tvente_detail_vente.taux) as PTVenteFC")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END) as puVente")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) as qteVente")
    ->selectRaw('((IFNULL(montant,0))*tvente_detail_vente.taux) as totalFactureFC')
    ->selectRaw('IFNULL(montant,0) as totalFacture')
    ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
    ->selectRaw('(IFNULL(montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
    ->selectRaw("(IFNULL(pu,0) - IFNULL((CASE WHEN (unite_paquet = 'Par Pièce') THEN IFNULL(pu,0) 
                       WHEN (unite_paquet = 'Par Kilo') THEN IFNULL(pu,0) 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END),0)) as Reduction")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN 'Pcs' WHEN (unite_paquet = 'Par Kilo') THEN 'Kg'
                       WHEN (unite_paquet = 'Par Paquet') THEN 'Paq' END) as Unites")
    ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
    ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
    ->where([
                ['dateVente','>=', $date1],
                ['dateVente','<=', $date2],
                ['refProduit','=', $refProduit]
            ])
    ->orderBy("tvente_entete_vente.dateVente", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;&nbsp;</td>
                <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puVente.'$('.$row->Reduction.'$)</td>
                <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
            </tr>
        ';
           
   
    }

    return $output;

}

 
//==================== RAPPORT JOURNALIER DES ENTREES ===========================================================================

public function fetch_rapport_detailentree_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailEntree($date1, $date2);       
        // $html .='<script>window.print()</script>';

        // echo($html); 
        
        $html = $this->printRapportDetailEntree($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }
    
    
}

function printRapportDetailEntree($date1, $date2)
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
             $emailEse=$row->tel3;
             $idNatEse='0000';
             $numImpotEse='0000';
             $busnessName=$row->objectif;
             $rccmEse='0000';
             $pic2 = $this->displayImg("images", $row->logo);
             $siege=$row->politique;         
         }

         $totalFact=0;
                 
         // 
         $data2 =   DB::table('tvente_detail_entree')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
         ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
         ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
 
         ->select(DB::raw('ROUND(SUM(qteEntree*puEntree),0) as TotalFacture'))
         ->where([
            ['dateEntree','>=', $date1],
            ['dateEntree','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td></td>
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
           
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;ENTREES</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FOURNISSEUR</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;ENTREE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailEntree($date1,$date2); 

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
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </html>';  
       
        return $output; 

}

function showDetailEntree($date1, $date2)
{
    $data = DB::table('tvente_detail_entree')
    ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
    ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
    ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
    ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','noms','contact','mail',
    'adresse','dateEntree',
    'libelle','montant as TotalEntree',"tvente_produit.designation","refCategorie","pu","unite",
    "tvente_categorie_produit.designation as Categorie",'tvente_detail_entree.author',
    'tvente_detail_entree.created_at','tvente_detail_entree.devise','tvente_detail_entree.taux',
    'unite_paquet','puPaquet','qtePaquet')
    ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
    WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
    WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
    (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
    WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
    WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END)) as PTEntree")
    ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
    WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
    WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
    (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
    WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
    WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END))*tvente_detail_entree.taux) as PTEntreeFC")
    ->selectRaw("((montant) * tvente_detail_entree.taux) as TotalEntreeFC")

    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
    WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
    WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END) as puEntree")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
    WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
    WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) as qteEntree")
    ->selectRaw('CONCAT("BE",YEAR(dateEntree),"",MONTH(dateEntree),"00",refEnteteEntree) as codeFacture')
    ->where([
        ['dateEntree','>=', $date1],
        ['dateEntree','<=', $date2]
    ])
    ->orderBy("tvente_entete_entree.dateEntree", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateEntree.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteEntree.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puEntree.'$</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTEntree.'$</td>
    </tr>';      
   
    }

    return $output;

}

//==================== RAPPORT JOURNALIER DES REQUISITIONS ===========================================================================

public function fetch_rapport_detailcmd_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailRequisition($date1, $date2);       
        // $html .='<script>window.print()</script>';

        // echo($html); 
        
        $html = $this->printRapportDetailRequisition($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportDetailRequisition($date1, $date2)
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
             $emailEse=$row->tel3;
             $idNatEse='0000';
             $numImpotEse='0000';
             $busnessName=$row->objectif;
             $rccmEse='0000';
             $pic2 = $this->displayImg("images", $row->logo);
             $siege=$row->politique;         
         }
 

         $totalFact=0;
                 
         // 
         $data2 =  DB::table('tvente_detail_requisition')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
         ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
         ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
 
         ->select(DB::raw('ROUND(SUM(qteCmd*puCmd),0) as TotalFacture'))
         ->where([
            ['dateCmd','>=', $date1],
            ['dateCmd','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td></td>
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
           
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;ENTREES</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FOURNISSEUR</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;ENTREE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailRequisition($date1,$date2); 

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
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </html>';  
       
        return $output; 

}

function showDetailRequisition($date1, $date2)
{
    $data = DB::table('tvente_detail_requisition')
    ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
    ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
    ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
    ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
    'qteCmd','noms','contact','mail','adresse','dateCmd',
    'libelle',"tvente_produit.designation","refCategorie","pu","unite",
    "tvente_categorie_produit.designation as Categorie",'tvente_detail_requisition.author',
    'tvente_detail_requisition.created_at','tvente_detail_requisition.devise','tvente_detail_requisition.taux')
    ->selectRaw('(qteCmd*puCmd) as prixTotal')
    ->selectRaw('CONCAT("BE",YEAR(dateCmd),"",MONTH(dateCmd),"00",refEnteteCmd) as codeFacture')
    ->where([
        ['dateCmd','>=', $date1],
        ['dateCmd','<=', $date2]
    ])
    ->orderBy("tvente_entete_requisition.dateCmd", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateCmd.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteCmd.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puCmd.'$</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
    </tr>';      
   
    }

    return $output;

}








//=================================================================================================================================
//==================== FICHE DE STOCK ========================================================================================================


function pdf_fiche_stock_vente(Request $request)
{

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        
        $html = $this->getInfoFicheStock($date1,$date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{
    }    
}

function pdf_fiche_stock_vente_categorie(Request $request)
{

    if ($request->get('date1') && $request->get('date2')&& $request->get('idCategorie')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idCategorie = $request->get('idCategorie');
        
        $html = $this->getInfoFicheStockCategorie($date1,$date2,$idCategorie);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{
    }    
}

function getInfoFicheStock($date1,$date2)
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
               $emailEse=$row->tel3;
               $idNatEse='0000';
               $numImpotEse='0000';
               $busnessName=$row->objectif;
               $rccmEse='0000';
               $pic2 = $this->displayImg("images", $row->logo);
               $siege=$row->politique;         
           }
               // 
            $totalVente=0;  
            $uniteVente=0;
            //
            $data2 = DB::table('tvente_detail_vente')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
            ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')            
            ->select(DB::raw('ROUND(SUM(qteVente*puVente),0) as TotalFacture'))
            ->where([
                ['tvente_entete_vente.dateVente','>=', $date1],
                ['tvente_entete_vente.dateVente','<=', $date2]
            ])               
            ->get();

            foreach ($data2 as $row2) 
            {                                
               $totalVente=$row2->TotalFacture;                           
            }


    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>FicheStock</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1B222893 {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE0D816CD {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csF3AA49E4 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE78F4A6 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs2C96DE68 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
                    .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:352px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:163px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:108px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:88px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
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
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:13px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
               
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:34px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs1B222893" colspan="6" style="width:437px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;STOCK</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:7px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="csE71035DC" colspan="10" style="width:676px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;VENTE(USD)</nobr></td>
                    <td class="csAB3AA82A" colspan="5" style="width:273px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'$</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SI</nobr></td>
                    <td class="csF3AA49E4" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="csF3AA49E4" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs2C96DE68" colspan="15" style="width:948px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date1.'</nobr></td>
                </tr>
                ';
                                                                
                   $output .= $this->showCategorieFicheStock($date1,$date2); 
                                                                
                 $output.='
            </table>
            </body>
            </html>

            '; 

    return $output;

}   


function getInfoFicheStockCategorie($date1,$date2,$idCategorie)
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
               $emailEse=$row->tel3;
               $idNatEse='0000';
               $numImpotEse='0000';
               $busnessName=$row->objectif;
               $rccmEse='0000';
               $pic2 = $this->displayImg("images", $row->logo);
               $siege=$row->politique;         
           }
               // 
            $totalVente=0;  
            //
            $data2 = DB::table('tvente_detail_vente')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
            ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
            ->select(DB::raw('ROUND(SUM(qteVente*puVente),0) as TotalFacture'))
            ->where([
                ['tvente_entete_vente.dateVente','>=', $date1],
                ['tvente_entete_vente.dateVente','<=', $date2],
                ['tvente_produit.refCategorie','=', $idCategorie]
            ])               
            ->get();

            foreach ($data2 as $row2) 
            {                                
               $totalVente=$row2->TotalFacture;                           
            }


    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>FicheStock</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1B222893 {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE0D816CD {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csF3AA49E4 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE78F4A6 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs2C96DE68 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
                    .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:352px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:163px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:108px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:88px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
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
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:13px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
               
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:34px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs1B222893" colspan="6" style="width:437px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;STOCK</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:7px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="csE71035DC" colspan="10" style="width:676px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;VENTE(USD)</nobr></td>
                    <td class="csAB3AA82A" colspan="5" style="width:273px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'$</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SI</nobr></td>
                    <td class="csF3AA49E4" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="csF3AA49E4" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs2C96DE68" colspan="15" style="width:948px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date1.'</nobr></td>
                </tr>
                ';
                                                                
                   $output .= $this->showCategorieFicheStockCategorie($date1,$date2,$idCategorie); 
                                                                
                 $output.='
            </table>
            </body>
            </html>

            '; 

    return $output;

}  

//

function showCategorieFicheStock($date1,$date2)
{
    $data = DB::table("tvente_categorie_produit")
    ->select("tvente_categorie_produit.id", "tvente_categorie_produit.designation", 
    "tvente_categorie_produit.created_at", "tvente_categorie_produit.author")
    ->orderBy("tvente_categorie_produit.designation", "asc")
    ->get();
    
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csE0D816CD" colspan="15" style="width:948px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->designation.'</td>
            </tr>
            ';
                                                    
                $output .= $this->showDetailFicheStock($date1,$date2,$row->id);                                                     
                $output.='
        ';      
    }

    return $output;

}


function showCategorieFicheStockCategorie($date1,$date2,$idCategorie)
{
    $data = DB::table("tvente_categorie_produit")
    ->select("tvente_categorie_produit.id", "tvente_categorie_produit.designation", 
    "tvente_categorie_produit.created_at", "tvente_categorie_produit.author")
    ->where([
        ['tvente_categorie_produit.id','=', $idCategorie]
    ])
    ->orderBy("tvente_categorie_produit.designation", "asc")
    ->get();
    
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csE0D816CD" colspan="15" style="width:948px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->designation.'</td>
            </tr>
            ';
                                                    
                $output .= $this->showDetailFicheStock($date1,$date2,$row->id);                                                     
                $output.='
        ';      
    }

    return $output;

}


function showDetailFicheStock($date1,$date2,$refCategorie)
{
    $data1 = DB::table('tvente_produit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        
    ->select("tvente_produit.id","tvente_produit.designation as designation","refCategorie",
    "pu","unite","tvente_categorie_produit.designation as Categorie","devise","qte")
    ->where([
        ['tvente_produit.refCategorie','=', $refCategorie]
    ])
    ->orderBy("tvente_produit.designation", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $totalSI=0;        
        $totalEntree=0;
        $totalG=0;
        $totalSortie=0;        
        $totalSF=0;
        $totalPT=0;
        $totalPU=0; 
        $totalVente=0;
        $totalApprov=0;
        $puVente=0;  
        //
        $data2 = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')

        ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as totalEntree'))
        ->where([               
            ['tvente_entete_entree.dateEntree','<', $date1],
            ['tvente_produit.id','=', $row1->id]
        ])               
        ->get();
        foreach ($data2 as $row2) 
        {                                
           $totalEntree=$row2->totalEntree;                           
        }

        $data3 = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')        
        ->select(DB::raw('IFNULL(ROUND(SUM(qteVente),0),0) as totalSortie'))
        ->where([               
            ['tvente_entete_vente.dateVente','<', $date1],
            ['tvente_produit.id','=', $row1->id]
        ])->get(); 
        
        foreach ($data3 as $row3) 
        {                                
           $totalSortie=$row3->totalSortie;                           
        }            
       

        $data4 =   DB::select(
            'select (IFNULL(ROUND(:quanteEntree,0),0) - IFNULL(ROUND(:quanteSortie,0),0)) as SI from tvente_produit  
             where (tvente_produit.id = :idPro)',
             ['idPro' => $row1->id,'quanteEntree' => $totalEntree,'quanteSortie'=>$totalSortie]
        );         
         foreach ($data4 as $row4) 
         {                                
            $totalSI=$row4->SI;                           
         }

         $data5 = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')       
        ->select(DB::raw('IFNULL(ROUND(SUM(qteVente),0),0) as totalSortie'))
        ->where([               
            ['tvente_entete_vente.dateVente','>=', $date1],
            ['tvente_entete_vente.dateVente','<=', $date2],
            ['tvente_produit.id','=', $row1->id]
        ])->get(); 
        
        foreach ($data5 as $row5) 
        {                                
           $totalVente=$row5->totalSortie;                           
        }

        $data6 = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')

        ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as totalEntree'))
        ->where([
            ['tvente_entete_entree.dateEntree','>=', $date1],
            ['tvente_entete_entree.dateEntree','<=', $date2],
            ['tvente_produit.id','=', $row1->id]
        ])
        ->get();        
        foreach ($data6 as $row6) 
        {                                
           $totalApprov=$row6->totalEntree;                           
        }

        $data7 =   DB::select(
            'select (IFNULL(ROUND(:SI,0),0) + IFNULL(ROUND(:quanteEntree,0),0)) as totalG from tvente_produit  
             where (tvente_produit.id = :idPro)',
             ['idPro' => $row1->id,'SI' => $totalSI,'quanteEntree'=>$totalApprov]
        );         
        foreach ($data7 as $row7) 
        {                                
           $totalG=$row7->totalG;                           
        }

        $data8 =   DB::select(
            'select (IFNULL(ROUND(:SI,0),0) + IFNULL(ROUND(:quanteEntree,0),0) - IFNULL(ROUND(:quanteSortie,0),0)) as SF from tvente_produit  
             where (tvente_produit.id = :idPro)',
             ['idPro' => $row1->id,'SI' => $totalSI,'quanteEntree'=>$totalApprov,'quanteSortie'=>$totalVente]
        );         
        foreach ($data8 as $row8) 
        {                                
           $totalSF=$row8->SF;                           
        }
  
        $data9 = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')        
        ->select(DB::raw('IFNULL(ROUND(SUM(qteVente*puVente),1),0) as PTVente'))
        ->where([               
            ['tvente_entete_vente.dateVente','>=', $date1],
            ['tvente_entete_vente.dateVente','<=', $date2],
            ['tvente_produit.id','=', $row1->id]
        ])->get(); 
        
        foreach ($data9 as $row9) 
        {                                
           $totalPT=$row9->PTVente;                           
        }
        
        $data10 =   DB::select(
            'select ROUND(((IFNULL(ROUND(:PTVente,1),0)) / (IFNULL(ROUND(:quantiteVente,1),0))),1) as PU from tvente_produit  
             where tvente_produit.id = :idPro',
             ['PTVente'=>$totalPT,'quantiteVente'=>$totalVente,'idPro' => $row1->id]
        );         
        foreach ($data10 as $row10) 
        { 
           $puVente=$row10->PU;                         
        }

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row1->designation.'</td>
                <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSI.'</td>
                <td class="csE78F4A6" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalApprov.'</td>
                <td class="csD149F8AB" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalG.'</td>
                <td class="csE78F4A6" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSF.'</td>
                <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalVente.'</td>
                <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$puVente.'$</td>
                <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalPT.'$</td>
            </tr>
        ';     
    }

    return $output;

}


//========================== LES DETTES DES VENTES ========================================================================
//=========================================================================================================================


//==================== RAPPORT JOURNALIER DES VenteS =================================

public function fetch_rapport_detailvente_dette_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVenteDette($date1, $date2);       
        // $html .='<script>window.print()</script>';

        // echo($html); 

        
        $html = $this->printRapportDetailVente($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportDetailVenteDette($date1, $date2)
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
             $emailEse=$row->tel3;
             $idNatEse='0000';
             $numImpotEse='0000';
             $busnessName=$row->objectif;
             $rccmEse='0000';
             $pic2 = $this->displayImg("images", $row->logo);
             $siege=$row->politique;         
         }
 

         $totalFact=0;
         // 
         $data2 =  DB::table('tvente_detail_vente')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
         ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
         ->select(DB::raw('ROUND(SUM(qteVente*puVente),0) as TotalFacture'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tvente_entete_vente.paie','=', 0]
        ])
        ->orWhere([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tvente_entete_vente.montant','>', 'tvente_entete_vente.paie']
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;                           
         }

           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td></td>
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
           
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
           
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;FACTURATIONS</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>


                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailVenteDette($date1,$date2); 

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
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </html>';  
       
        return $output; 

}

function showDetailVenteDette($date1, $date2)
{
    $data = DB::table('tvente_detail_vente')
    ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
    ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')
    ->join('inscriptions','inscriptions.id','=','tvente_entete_vente.refClient')
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
    ->select('tvente_detail_vente.id','refEnteteVente','refProduit','dateVente',
    'libelle',"tvente_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
    'tvente_detail_vente.author','tvente_detail_vente.created_at',
    'tvente_detail_vente.devise','tvente_detail_vente.taux',
    'unite_paquet','puPaquet','qtePaquet',
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
    'anne_scollaires.designation as annee','anne_scollaires.statut',
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
    'inscriptions.paie as paieFrais','inscriptions.reste as resteFrais')
    ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                       (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END)) as PTVente")
    ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) * 
                       (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END))/tvente_detail_vente.taux) as PTVenteFC")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.puVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END) as puVente")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_vente.qteVente 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.qtePaquet END) as qteVente")
    ->selectRaw('((IFNULL(montant,0))*tvente_detail_vente.taux) as totalFactureFC')
    ->selectRaw('IFNULL(montant,0) as totalFacture')
    ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
    ->selectRaw('(IFNULL(montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
    ->selectRaw("(IFNULL(pu,0) - IFNULL((CASE WHEN (unite_paquet = 'Par Pièce') THEN IFNULL(pu,0) 
                       WHEN (unite_paquet = 'Par Kilo') THEN IFNULL(pu,0) 
                       WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_vente.puPaquet END),0)) as Reduction")
    ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN 'Pcs' WHEN (unite_paquet = 'Par Kilo') THEN 'Kg'
                       WHEN (unite_paquet = 'Par Paquet') THEN 'Paq' END) as Unites")
    ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
    ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
    ->where([
        ['dateVente','>=', $date1],
        ['dateVente','<=', $date2],
        ['tvente_entete_vente.paie','=', 0]
    ])
    ->orWhere([
        ['dateVente','>=', $date1],
        ['dateVente','<=', $date2],
        ['tvente_entete_vente.montant','>', 'tvente_entete_vente.paie']
    ])
    ->orderBy("tvente_detail_vente.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puVente.'$('.$row->Reduction.'$)</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
    </tr>';      
   
    }

    return $output;

}












}
