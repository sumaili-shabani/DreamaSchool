<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_ComptabiliteController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;



//==================== RAPPORT FINANCE PAR COMPTE CASH =======================================

public function fetch_rapport_detailfacture_date_compte_cash(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refSousCompte')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refSousCompte = $request->get('refSousCompte');
        
        $html = $this->printRapportDetailFacture_Compte_Cash($date1, $date2,$refSousCompte);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        // $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}



function printRapportDetailFacture_Compte_Cash($date1, $date2,$refSousCompte)
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
             $pic2 = $this->displayImg("images", 'logo.png');
             $siege=$row->politique;         
         }
 

         $totalMontant=0;
                 
         //
         $data2 = DB::table('tfin_detailfacturation')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
         ->join('tMedecin','tMedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
 
         ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),0) as TotalFacture'))
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['refSousCompte','=', $refSousCompte],
            ['categoriemaladiemvt','=', 'PRIVE(E)'],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalMontant=$row->TotalFacture;                           
         }

         $nom_compte='';
         $numero_compte='';

         $data3=DB::table('tfin_detailfacturation')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
         ->join('tMedecin','tMedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
         'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
         'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
         "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
         "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
         "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
         "dateMouvement",'organisationAbonne','taux_prisecharge',
         'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
         "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
         "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
         'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
         'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
         'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
         'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
         'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
         'nom_typeposition',"nom_typecompte")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
         ->selectRaw('(quantite*prixunitaire) as prixTotal')
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['refSousCompte','=', $refSousCompte],
            ['categoriemaladiemvt','=', 'PRIVE(E)'],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_compte=$row->nom_departement;
            $numero_compte=$row->code_departement;                   
        }



           

        $output='

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RAPPORT FINANCIER DES COMPTES</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs18C8C797 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:387px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:113px;"></td>
                <td style="height:0px;width:96px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:211px;"></td>
                <td style="height:0px;width:56px;"></td>
                <td style="height:0px;width:54px;"></td>
                <td style="height:0px;width:11px;"></td>
                <td style="height:0px;width:69px;"></td>
                <td style="height:0px;width:99px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="7" rowspan="2" style="width:718px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td></td>
                <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                </td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="7" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="7" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="7" rowspan="2" style="width:718px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:16px;"></td>
                <td></td>
                <td></td>
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
                <td class="csB6F858D0" colspan="10" style="width:895px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;FINANCIER</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="3" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$this->CreatedFormat($date1).'&nbsp;&nbsp;au&nbsp; '.$this->CreatedFormat($date2).' </nobr></td>
                <td class="cs18C8C797" colspan="3" style="width:330px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$numero_compte.' : '.$nom_compte.'</td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;COMPTE</nobr></td>
                <td class="cs9FE9304F" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:400px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs9FE9304F" colspan="4" style="width:189px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;($)</nobr></td>
                <td class="csEAC52FCD" style="width:99px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
            </tr>
            ';
                                                
                    $output .= $this->showDetailFacturation_Cash_Compte($date1, $date2,$refSousCompte); 
                                                
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="9" style="width:786px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalMontant.'$</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="2" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
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

function showDetailFacturation_Cash_Compte($date1, $date2,$refSousCompte)
{
        $data = DB::table('tfin_detailfacturation')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
        ->join('tMedecin','tMedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
        'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
        'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
        "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->selectRaw('(quantite*prixunitaire) as prixTotal')
        ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['refSousCompte','=', $refSousCompte],
            ['categoriemaladiemvt','=', 'PRIVE(E)']
        ])
        ->orderBy("tfin_detailfacturation.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs6E02D7D2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                    <td class="cs6E02D7D2" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->datefacture.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:400px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_ssouscompte.'</td>
                    <td class="cs6E02D7D2" colspan="4" style="width:189px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                    <td class="cs6C28398D" style="width:99px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'FC</td>
                </tr>
            ';         
   
    }

    return $output;

}

//==================== RAPPORT FINANCE PAR COMPTE CREDIT =======================================

public function fetch_rapport_detailfacture_date_compte_credit(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refSousCompte')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refSousCompte = $request->get('refSousCompte');
        
        $html = $this->printRapportDetailFacture_Compte_Credit($date1, $date2,$refSousCompte);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        // $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}



function printRapportDetailFacture_Compte_Credit($date1, $date2,$refSousCompte)
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
             $pic2 = $this->displayImg("images", 'logo.png');
             $siege=$row->politique;         
         }
 

         $totalMontant=0;
                 
         //
         $data2 = DB::table('tfin_detailfacturation')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
         ->join('tMedecin','tMedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
 
         ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),0) as TotalFacture'))
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['refSousCompte','=', $refSousCompte],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalMontant=$row->TotalFacture;                           
         }

         $nom_compte='';
         $numero_compte='';

         $data3=DB::table('tfin_detailfacturation')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
         ->join('tMedecin','tMedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
         'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
         'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
         "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
         "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
         "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
         "dateMouvement",'organisationAbonne','taux_prisecharge',
         'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
         "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
         "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
         'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
         'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
         'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
         'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
         'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
         'nom_typeposition',"nom_typecompte")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
         ->selectRaw('(quantite*prixunitaire) as prixTotal')
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['refSousCompte','=', $refSousCompte],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_compte=$row->nom_departement;
            $numero_compte=$row->code_departement;                   
        }



           

        $output='
        
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RAPPORT FINANCIER DES COMPTES</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs18C8C797 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:387px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:113px;"></td>
                <td style="height:0px;width:96px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:211px;"></td>
                <td style="height:0px;width:56px;"></td>
                <td style="height:0px;width:54px;"></td>
                <td style="height:0px;width:11px;"></td>
                <td style="height:0px;width:69px;"></td>
                <td style="height:0px;width:99px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="7" rowspan="2" style="width:718px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td></td>
                <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                </td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="7" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="7" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="7" rowspan="2" style="width:718px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:16px;"></td>
                <td></td>
                <td></td>
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
                <td class="csB6F858D0" colspan="10" style="width:895px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;FINANCIER</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="3" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$this->CreatedFormat($date1).'&nbsp;&nbsp;au&nbsp; '.$this->CreatedFormat($date2).' </nobr></td>
                <td class="cs18C8C797" colspan="3" style="width:330px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$numero_compte.' : '.$nom_compte.'</td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;COMPTE</nobr></td>
                <td class="cs9FE9304F" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:400px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs9FE9304F" colspan="4" style="width:189px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;($)</nobr></td>
                <td class="csEAC52FCD" style="width:99px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
            </tr>
            ';
                                                
                    $output .= $this->showDetailFacturation_Credit_Compte($date1, $date2,$refSousCompte); 
                                                
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="9" style="width:786px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalMontant.'$</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="2" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
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

function showDetailFacturation_Credit_Compte($date1, $date2,$refSousCompte)
{
        $data = DB::table('tfin_detailfacturation')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
        ->join('tMedecin','tMedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
        'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
        'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
        "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->selectRaw('(quantite*prixunitaire) as prixTotal')
        ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['refSousCompte','=', $refSousCompte],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])
        ->orderBy("tfin_detailfacturation.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs6E02D7D2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                    <td class="cs6E02D7D2" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->datefacture.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:400px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_ssouscompte.'</td>
                    <td class="cs6E02D7D2" colspan="4" style="width:189px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                    <td class="cs6C28398D" style="width:99px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'FC</td>
                </tr>
            ';         
   
    }

    return $output;

}



//==================== RAPPORT JOURNAL CAISSE/BANQUE =======================================

public function fetch_rapport_journal_caisse(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refTresorerie')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refTresorerie = $request->get('refTresorerie');
        
        $html = $this->printRapportJournal_Caisse($date1, $date2,$refTresorerie);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportJournal_Caisse($date1, $date2,$refTresorerie)
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
        $pic2 = $this->displayImg("images", $row->logo);

        $siege=$row->politique;         
    }


         $totalCredit=0;
         $totalDebit=0;
                 
         //
         $data2 = DB::table('tfin_detail_operationcompte')
         ->join('tfin_entete_operationcompte','tfin_entete_operationcompte.id','=','tfin_detail_operationcompte.refEnteteOperation')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_detail_operationcompte.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('IFNULL(ROUND(SUM(montantOpration),0),0) as totalDebit'))
         ->where([
            ['dateOpration','>=', $date1],
            ['dateOpration','<=', $date2],
            ['refTresorerie','=', $refTresorerie],
            ['typeOperation','=', 'DEBIT'],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalDebit=$row->totalDebit;                           
         }

         $data4 = DB::table('tfin_detail_operationcompte')
         ->join('tfin_entete_operationcompte','tfin_entete_operationcompte.id','=','tfin_detail_operationcompte.refEnteteOperation')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_detail_operationcompte.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('IFNULL(ROUND(SUM(montantOpration),0),0) as Credits'))
         ->where([
            ['dateOpration','>=', $date1],
            ['dateOpration','<=', $date2],
            ['refTresorerie','=', $refTresorerie],
            ['typeOperation','=', 'CREDIT'],
        ])    
         ->get(); 
         $output='';
         foreach ($data4 as $row) 
         {                                
            $totalCredit=$row->Credits;                           
         }


         $nom_compte='';
         $numero_compte='';

         $data3=DB::table('tfin_entete_operationcompte')          
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_entete_operationcompte.refTresorerie')  
         ->select("tfin_entete_operationcompte.id","libelleOperation","dateOpration",
         "numOpereation","refTresorerie","tconf_banque.nom_banque","tconf_banque.numerocompte",
         'tconf_banque.nom_mode','tauxdujour','tfin_entete_operationcompte.author')
         ->where([
            ['dateOpration','>=', $date1],
            ['dateOpration','<=', $date2],
            ['refTresorerie','=', $refTresorerie]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_compte=$row->nom_banque;
            $numero_compte=$row->numerocompte;                   
        }



           

        $output='
        
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>JOURNAL DES OPERATIONS</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs92655590 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csC7331FEF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csCB26AF8D {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csACFC0003 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .csFEAE55AF {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:936px;height:412px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:79px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:267px;"></td>
                <td style="height:0px;width:54px;"></td>
                <td style="height:0px;width:11px;"></td>
                <td style="height:0px;width:37px;"></td>
                <td style="height:0px;width:98px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:27px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:718px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:718px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:16px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="csB6F858D0" colspan="12" style="width:895px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>JOURNAL&nbsp;DES&nbsp;OPERATIONS</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$this->CreatedFormat($date1).'&nbsp;&nbsp;au&nbsp; '.$this->CreatedFormat($date2).' </nobr></td>
                <td class="cs56F73198" colspan="2" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$numero_compte.' : '.$nom_compte.'</td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs92655590" style="width:78px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:120px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CREDIT</nobr></td>
                <td class="cs92655590" colspan="4" style="width:465px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs9FE9304F" colspan="4" style="width:199px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DEDIT</nobr></td>
                <td class="csC7331FEF" colspan="2" style="width:60px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csCB26AF8D" style="width:78px;height:24px;"></td>
                <td class="csCB26AF8D" style="width:54px;height:24px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DEBIT</nobr></td>
                <td class="csCB26AF8D" style="width:65px;height:24px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CREDIT</nobr></td>
                <td class="csCB26AF8D" colspan="4" style="width:465px;height:24px;"></td>
                <td class="csCB26AF8D" colspan="3" style="width:101px;height:24px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DEDIT</nobr></td>
                <td class="csCB26AF8D" style="width:97px;height:24px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CREDIT</nobr></td>
                <td class="csACFC0003" colspan="2" style="width:60px;height:23px;"></td>
            </tr>
             ';
                                                
                    $output .= $this->showJournal_Caisse($date1, $date2,$refTresorerie); 
                                                
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs36E0C1B8" colspan="7" style="width:665px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'. $totalDebit.'$</td>
                <td class="cs36E0C1B8" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalCredit.'$</td>
                <td class="csFEAE55AF" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
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
    //    
        return $output; 

}

function showJournal_Caisse($date1, $date2,$refTresorerie)
{
        $data = DB::table('tfin_detail_operationcompte')
        ->join('tfin_entete_operationcompte','tfin_entete_operationcompte.id','=','tfin_detail_operationcompte.refEnteteOperation')
        ->join('tconf_banque' , 'tconf_banque.id','=','tfin_entete_operationcompte.refTresorerie')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_detail_operationcompte.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            //MALADE
        ->select("tfin_detail_operationcompte.id","refEnteteOperation","refTresorerie",
        "typeOperation","montantOpration","tfin_detail_operationcompte.refSscompte",'refSousCompte','nom_ssouscompte',
        'numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe',"libelleOperation",
        "dateOpration","numOpereation",'tauxdujour','tfin_entete_operationcompte.author','nom_typeposition',"nom_typecompte")
        ->selectRaw("(CASE WHEN (typeOperation = 'DEBIT') THEN numero_ssouscompte END) as CompteDebit")
        ->selectRaw("(CASE WHEN (typeOperation = 'CREDIT') THEN numero_ssouscompte END) as CompteCredit")
        ->selectRaw("(CASE WHEN (typeOperation = 'DEBIT') THEN montantOpration END) as MontantDebit")
        ->selectRaw("(CASE WHEN (typeOperation = 'CREDIT') THEN montantOpration END) as MontantCredit")
        ->where([
            ['dateOpration','>=', $date1],
            ['dateOpration','<=', $date2],
            ['refTresorerie','=', $refTresorerie]
        ])
        ->orderBy("tfin_detail_operationcompte.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs6E02D7D2" style="width:78px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateOpration.'</td>
                    <td class="cs6E02D7D2" style="width:54px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->CompteDebit.'</td>
                    <td class="cs6E02D7D2" style="width:65px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->CompteCredit.'</td>
                    <td class="cs6E02D7D2" colspan="4" style="width:465px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_ssouscompte.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->MontantDebit.'</td>
                    <td class="cs6E02D7D2" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->MontantCredit.'</td>
                    <td class="cs6C28398D" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->tauxdujour.'</td>
                </tr>
            ';              
   
        }

    return $output;

}





//==================== RAPPORT BILAN ====================================================================================

public function fetch_rapport_bilan(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->printRapportBilan($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}



function printRapportBilan($date1, $date2)
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
        $pic2 = $this->displayImg("images", $row->logo);

        $siege=$row->politique;         
    }


         $totalProduit=0;
         $totalCharge=0;
                 
         //
         $data2 = DB::table('tdepense')
         ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
         ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalProduit'))
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['numero_classe','=', '7']
          ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalProduit=$row->totalProduit;                           
         }

         $data4 = DB::table('tdepense')
         ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
         ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as charges'))
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['numero_classe','=', '6']
        ])    
         ->get(); 
         $output='';
         foreach ($data4 as $row) 
         {                                
            $totalCharge=$row->charges;                           
         }

         $soldes=0;

        $data5 =   DB::select(
            'select (IFNULL(ROUND(SUM(montant),0),0) - :montants) as solde from tdepense  
             inner join tcompte on tcompte.id = tdepense.refCompte        
             inner join ttypemouvement on ttypemouvement.id=tdepense.refMvt
             inner join tfin_ssouscompte on tfin_ssouscompte.id = tcompte.refSscompte
             inner join tfin_souscompte on tfin_souscompte.id = tfin_ssouscompte.refSousCompte
             inner join tfin_compte on tfin_compte.id = tfin_souscompte.refCompte
             inner join tfin_classe on tfin_classe.id = tfin_compte.refClasse
             inner join tfin_typecompte on tfin_typecompte.id = tfin_compte.refTypecompte
             inner join tfin_typeposition on tfin_typeposition.id=tfin_compte.refPosition
             where numero_classe = 7 and dateOperation between :date1 and :date2',
             ['montants' => $totalCharge,'date1'=>$date1,'date2'=>$date2]
        ); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $soldes=$row->solde;                           
         }


        //  DB::update(
        //     'update tproduit set qte = qte - :qteSortie where id = :refProduit',
        //     ['qteSortie' => $qte,'refProduit' => $idDetail]
        // );
         

        $output='
        

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RapportBilan</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:716px;height:470px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:74px;"></td>
                <td style="height:0px;width:135px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:117px;"></td>
                <td style="height:0px;width:21px;"></td>
                <td style="height:0px;width:27px;"></td>
                <td style="height:0px;width:142px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td class="cs739196BC" colspan="5" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="5" rowspan="2" style="width:514px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td></td>
                <td class="cs101A94F7" colspan="2" rowspan="7" style="width:169px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:169px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:169px;height:144px;" /></div>
                </td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="5" style="width:514px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="5" style="width:514px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="5" style="width:514px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="5" style="width:514px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="5" style="width:514px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="5" rowspan="2" style="width:514px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:16px;"></td>
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
                <td class="csB6F858D0" colspan="8" style="width:702px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;BILAN</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="3" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$this->CreatedFormat($date1).'&nbsp;&nbsp;au&nbsp; '.$this->CreatedFormat($date2).' </nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:34px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:73px;height:32px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr><br/><nobr>COMPTE</nobr></td>
                <td class="cs9FE9304F" colspan="6" style="width:489px;height:32px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MOTIF</nobr></td>
                <td class="cs9FE9304F" style="width:141px;height:32px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;($)</nobr></td>
            </tr>
             ';
                                                        
                            $output .= $this->showRapportBilan_Produit($date1, $date2); 
                                                        
                            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="7" style="width:563px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;DES&nbsp;PRODUITS&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" style="width:142px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalProduit.'$</td>
            </tr>
            ';
                                                        
                            $output .= $this->showRapportBilan_Charge($date1, $date2); 
                                                        
                            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="7" style="width:563px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;DES&nbsp;CHARGES&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" style="width:142px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalCharge.'$</nobr></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SOLDE&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="7" style="width:632px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$soldes.'$</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="2" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
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

function showRapportBilan_Produit($date1, $date2)
{
        $data =  DB::table('tdepense')
        ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  

        ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
        "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
        'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscompteBanque","tcompte.refSscompte as refSscompteLibelle",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
        "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
        "tdepense.created_at","tdepense.updated_at","numeroBE")
        ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['numero_classe','=', '7']
        ])
        ->orderBy("tdepense.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                <td class="cs6E02D7D2" colspan="6" style="width:489px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_ssouscompte.' -  '.$row->Compte.'</td>
                <td class="cs6E02D7D2" style="width:141px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant.'$</td>
            </tr>
            '; 
   
        }

    return $output;

}



function showRapportBilan_Charge($date1, $date2)
{
        $data =  DB::table('tdepense')
        ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  

        ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
        "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
        'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscompteBanque","tcompte.refSscompte as refSscompteLibelle",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
        "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
        "tdepense.created_at","tdepense.updated_at","numeroBE")
        ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['numero_classe','=', '6']
        ])
        ->orderBy("tdepense.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs6E02D7D2" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                    <td class="cs6E02D7D2" colspan="6" style="width:489px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_ssouscompte.'</td>
                    <td class="cs6E02D7D2" style="width:141px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant.'$</td>
                </tr>            
            ';
   
        }

    return $output;

}



















//======================= LIVRE DE CAISSE =====================================================================================
//=========================================================================================================================

function pdf_livre_caisse(Request $request)
{

    if ($request->get('dateOperation')) 
    {
        $dateOperation = $request->get('dateOperation');
        $html = $this->getInfoLivreCaisse($dateOperation);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{

    }   
    
}

function getInfoLivreCaisse($dateOperation)
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
            $totalEntree=0;
            $totalSortie=0;
            $report=0;
            $total_production=0;
            $modepaie='CASH';   
            //
            $data2 = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
    
            ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalEntree'))
            ->where([               
                ['tdepense.dateOperation','<', $dateOperation],
                ['tdepense.refMvt','=', '1'],
                ['tconf_banque.nom_mode','=', 'CASH']
            ])               
            ->get();

            foreach ($data2 as $row) 
            {                                
               $totalEntree=$row->totalEntree;                           
            }

            $data3 = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
    
            ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalSortie'))
            ->where([               
                ['tdepense.dateOperation','<', $dateOperation],
                ['tdepense.refMvt','=', '2'],
                ['tconf_banque.nom_mode','=', 'CASH']
            ])               
            ->get(); 
            
            foreach ($data3 as $row) 
            {                                
               $totalSortie=$row->totalSortie;                           
            }            
           

            $data4 =   DB::select(
                'select (IFNULL(ROUND(SUM(montant),0),0) - :montants) as solde from tdepense  
                 inner join tcompte on tcompte.id = tdepense.refCompte        
                 inner join ttypemouvement on ttypemouvement.id=tdepense.refMvt
                 inner join tconf_banque on tconf_banque.id = tdepense.refBanque 
                 inner join tfin_ssouscompte on tfin_ssouscompte.id = tconf_banque.refSscompte
                 inner join tfin_souscompte on tfin_souscompte.id = tfin_ssouscompte.refSousCompte
                 inner join tfin_compte on tfin_compte.id = tfin_souscompte.refCompte
                 inner join tfin_classe on tfin_classe.id = tfin_compte.refClasse
                 inner join tfin_typecompte on tfin_typecompte.id = tfin_compte.refTypecompte
                 inner join tfin_typeposition on tfin_typeposition.id=tfin_compte.refPosition
                 where (tdepense.refMvt = 1) and (dateOperation < :date1) and (nom_mode = :mode)',
                 ['montants' => $totalSortie,'date1'=>$dateOperation,'mode'=>$modepaie]
            ); 
             
             foreach ($data4 as $row) 
             {                                
                $report=$row->solde;                           
             }


             $sommeEntree=0;
             $sommeSortie=0;
             //
             $data5 = DB::table('tdepense')
             ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
             ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
             ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
             ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
             ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
             ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
             ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
             ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
             ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
     
             ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalEntree'))
             ->where([               
                 ['tdepense.dateOperation','=', $dateOperation],
                 ['tdepense.refMvt','=', '1'],
                 ['tconf_banque.nom_mode','=', 'CASH']
             ])               
             ->get(); 
             
             foreach ($data5 as $row) 
             {                                
                $sommeEntree=$row->totalEntree;                           
             }
 
             $data6 = DB::table('tdepense')
             ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
             ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
             ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
             ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
             ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
             ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
             ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
             ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
             ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
     
             ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalSortie'))
             ->where([               
                 ['tdepense.dateOperation','=', $dateOperation],
                 ['tdepense.refMvt','=', '2'],
                 ['tconf_banque.nom_mode','=', 'CASH']
             ])               
             ->get(); 
             
             foreach ($data6 as $row) 
             {                                
                $sommeSortie=$row->totalSortie;                           
             } 
                     
            
 //'tconf_banque.nom_mode','=', 'CASH'
             $data7 =   DB::select(
                 'select (IFNULL(ROUND(SUM(montant),0),0) - (:montants) + (:reports)) as solde_final from tdepense  
                  inner join tcompte on tcompte.id = tdepense.refCompte 
                  inner join ttypemouvement on ttypemouvement.id=tdepense.refMvt
                  inner join tconf_banque on tconf_banque.id = tdepense.refBanque 
                  inner join tfin_ssouscompte on tfin_ssouscompte.id = tconf_banque.refSscompte
                  inner join tfin_souscompte on tfin_souscompte.id = tfin_ssouscompte.refSousCompte
                  inner join tfin_compte on tfin_compte.id = tfin_souscompte.refCompte
                  inner join tfin_classe on tfin_classe.id = tfin_compte.refClasse
                  inner join tfin_typecompte on tfin_typecompte.id = tfin_compte.refTypecompte
                  inner join tfin_typeposition on tfin_typeposition.id=tfin_compte.refPosition
                  where (tdepense.refMvt = 1) and (dateOperation = :date1)  and (nom_mode = :mode)',
                  ['montants' => $sommeSortie,'date1'=>$dateOperation,'reports'=>$report,'mode'=>$modepaie]
             ); 
              
              foreach ($data7 as $row) 
              {                                
                 $total_production=$row->solde_final;                           
              }

    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>LIVRE DE CAISSE</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csEA66161B {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:30px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs7B44FCB {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:38px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csDC7EEB9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
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
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:949px;height:413px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:64px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:67px;"></td>
                    <td style="height:0px;width:190px;"></td>
                    <td style="height:0px;width:161px;"></td>
                    <td style="height:0px;width:94px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:103px;"></td>
                    <td style="height:0px;width:52px;"></td>
                    <td style="height:0px;width:40px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="8" style="width:718px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="8" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="8" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="8" rowspan="2" style="width:718px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    <td style="width:0px;height:44px;"></td>
                    <td></td>
                    <td class="cs7B44FCB" colspan="12" style="width:895px;height:44px;line-height:45px;text-align:center;vertical-align:middle;"><nobr>LIVRE&nbsp;DE&nbsp;CAISSE</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:35px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csEA66161B" colspan="6" style="width:575px;height:35px;line-height:35px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;/REF.D</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:417px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DESIGNATION</nobr></td>
                    <td class="cs9FE9304F" style="width:93px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:89px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="cs9FE9304F" style="width:102px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SOLDE</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CODE</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$dateOperation.'</td>
                    <td class="cs9FE9304F" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>C/A</nobr></td>
                    <td class="cs9FE9304F" colspan="7" style="width:601px;height:22px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>&gt;&nbsp;REPORT</nobr></td>
                    <td class="cs9FE9304F" style="width:102px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$report.'$</td>
                    <td class="csEAC52FCD" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUCTION</nobr></td>
                </tr>
                ';
                                                    
                        $output .= $this->showDetailCaisse($dateOperation); 
                                                    
                        $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$dateOperation.'</td>
                    <td class="cs9FE9304F" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>C/P</nobr></td>
                    <td class="cs9FE9304F" colspan="7" style="width:601px;height:22px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>TOTAL&nbsp;PRODUCTIONS&nbsp;CASH</nobr></td>
                    <td class="cs9FE9304F" style="width:102px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$total_production.'&nbsp;$</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUCTION</nobr></td>
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
                    <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
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

//

function showDetailCaisse($dateOperation)
{
    $data = DB::table('tconf_banque')
    ->select("tconf_banque.id","tconf_banque.nom_banque",
    "tconf_banque.numerocompte",'tconf_banque.nom_mode',"tconf_banque.created_at")
    ->where('tconf_banque.nom_mode','=', 'CASH')
    ->orderBy("numerocompte", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $tempEntree=0;
        $tempSortie=0;
        $tempSolde=0;

        $data6 = DB::table('tdepense')
        ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totEntree'))
        ->where([               
            ['tdepense.dateOperation','=', $dateOperation],
            ['tdepense.refBanque','=', $row->id],
            ['tdepense.refMvt','=', '1']
        ])               
        ->get(); 
       
        foreach ($data6 as $rows) 
        {                                
           $tempEntree=$rows->totEntree;                           
        }
        
        $data7 = DB::table('tdepense')
        ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totSortie'))
        ->where([               
            ['tdepense.dateOperation','=', $dateOperation],
            ['tdepense.refBanque','=', $row->id],
            ['tdepense.refMvt','=', '2']
        ])               
        ->get(); 
        
        foreach ($data7 as $rowss) 
        {                                
           $tempSortie=$rowss->totSortie;                           
        }

        $data8 =   DB::select(
            'select (IFNULL(ROUND(SUM(montant),0),0) - :montants) as solde from tdepense  
             inner join tcompte on tcompte.id = tdepense.refCompte        
             inner join ttypemouvement on ttypemouvement.id=tdepense.refMvt
             inner join tconf_banque on tconf_banque.id = tdepense.refBanque 
             inner join tfin_ssouscompte on tfin_ssouscompte.id = tconf_banque.refSscompte
             inner join tfin_souscompte on tfin_souscompte.id = tfin_ssouscompte.refSousCompte
             inner join tfin_compte on tfin_compte.id = tfin_souscompte.refCompte
             inner join tfin_classe on tfin_classe.id = tfin_compte.refClasse
             inner join tfin_typecompte on tfin_typecompte.id = tfin_compte.refTypecompte
             inner join tfin_typeposition on tfin_typeposition.id=tfin_compte.refPosition
             where (tdepense.refMvt = 1) and (dateOperation = :date1) and refBanque = :id',
             ['montants' => $tempSortie,'date1'=>$dateOperation,'id'=>$row->id]
        ); 
         
         foreach ($data8 as $rowsss) 
         {                                
            $tempSolde=$rowsss->solde;                           
         }



         $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$dateOperation.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.substr($row->numerocompte, 0,8).'</td>
                <td class="csDC7EEB9" colspan="3" style="width:417px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>TTOTAL&nbsp;PRODUCTION&nbsp;CASH/'.$row->nom_banque.'</nobr></td>
                <td class="cs6E02D7D2" style="width:93px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$tempEntree.'$</td>
                <td class="cs6E02D7D2" colspan="3" style="width:89px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$tempSortie.'$</td>
                <td class="cs6E02D7D2" style="width:102px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$tempSolde.'$</td>
                <td class="cs6C28398D" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUCTION</nobr></td>
            </tr>
         ';
       
    }

    return $output;

}




//======================= LIVRE DES BANQUES =====================================================================================
//=========================================================================================================================

function pdf_livre_banque(Request $request)
{

    if ($request->get('dateOperation')) 
    {
        $dateOperation = $request->get('dateOperation');
        $html = $this->getInfoLivreBanque($dateOperation);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{

    }   
    
}

function getInfoLivreBanque($dateOperation)
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
            $totalEntree=0;
            $totalSortie=0;
            $report=0;
            $total_production=0;
            $modepaie='BANQUE';   
            //
            $data2 = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
    
            ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalEntree'))
            ->where([               
                ['tdepense.dateOperation','<', $dateOperation],
                ['tdepense.refMvt','=', '1'],
                ['tconf_banque.nom_mode','=', $modepaie]
            ])               
            ->get();

            foreach ($data2 as $row) 
            {                                
               $totalEntree=$row->totalEntree;                           
            }

            $data3 = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
    
            ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalSortie'))
            ->where([               
                ['tdepense.dateOperation','<', $dateOperation],
                ['tdepense.refMvt','=', '2'],
                ['tconf_banque.nom_mode','=', $modepaie]
            ])               
            ->get(); 
            
            foreach ($data3 as $row) 
            {                                
               $totalSortie=$row->totalSortie;                           
            }            
           

            $data4 =   DB::select(
                'select (IFNULL(ROUND(SUM(montant),0),0) - :montants) as solde from tdepense  
                 inner join tcompte on tcompte.id = tdepense.refCompte        
                 inner join ttypemouvement on ttypemouvement.id=tdepense.refMvt
                 inner join tconf_banque on tconf_banque.id = tdepense.refBanque 
                 inner join tfin_ssouscompte on tfin_ssouscompte.id = tconf_banque.refSscompte
                 inner join tfin_souscompte on tfin_souscompte.id = tfin_ssouscompte.refSousCompte
                 inner join tfin_compte on tfin_compte.id = tfin_souscompte.refCompte
                 inner join tfin_classe on tfin_classe.id = tfin_compte.refClasse
                 inner join tfin_typecompte on tfin_typecompte.id = tfin_compte.refTypecompte
                 inner join tfin_typeposition on tfin_typeposition.id=tfin_compte.refPosition
                 where (tdepense.refMvt = 1) and (dateOperation < :date1) and (nom_mode = :mode)',
                 ['montants' => $totalSortie,'date1'=>$dateOperation,'mode'=>$modepaie]
            ); 
             
             foreach ($data4 as $row) 
             {                                
                $report=$row->solde;                           
             }





             $sommeEntree=0;
             $sommeSortie=0;
             //
             $data5 = DB::table('tdepense')
             ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
             ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
             ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
             ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
             ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
             ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
             ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
             ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
             ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
     
             ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalEntree'))
             ->where([               
                 ['tdepense.dateOperation','=', $dateOperation],
                 ['tdepense.refMvt','=', '1'],
                 ['tconf_banque.nom_mode','=', $modepaie]
             ])               
             ->get(); 
             
             foreach ($data5 as $row) 
             {                                
                $sommeEntree=$row->totalEntree;                           
             }
 
             $data6 = DB::table('tdepense')
             ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
             ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
             ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
             ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
             ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
             ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
             ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
             ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
             ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
     
             ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totalSortie'))
             ->where([               
                 ['tdepense.dateOperation','=', $dateOperation],
                 ['tdepense.refMvt','=', '2'],
                 ['tconf_banque.nom_mode','=', $modepaie]
             ])               
             ->get(); 
             
             foreach ($data6 as $row) 
             {                                
                $sommeSortie=$row->totalSortie;                           
             } 
                     
            
 //'tconf_banque.nom_mode','=', 'CASH'
             $data7 =   DB::select(
                 'select (IFNULL(ROUND(SUM(montant),0),0) - (:montants) + (:reports)) as solde_final from tdepense  
                  inner join tcompte on tcompte.id = tdepense.refCompte 
                  inner join ttypemouvement on ttypemouvement.id=tdepense.refMvt
                  inner join tconf_banque on tconf_banque.id = tdepense.refBanque 
                  inner join tfin_ssouscompte on tfin_ssouscompte.id = tconf_banque.refSscompte
                  inner join tfin_souscompte on tfin_souscompte.id = tfin_ssouscompte.refSousCompte
                  inner join tfin_compte on tfin_compte.id = tfin_souscompte.refCompte
                  inner join tfin_classe on tfin_classe.id = tfin_compte.refClasse
                  inner join tfin_typecompte on tfin_typecompte.id = tfin_compte.refTypecompte
                  inner join tfin_typeposition on tfin_typeposition.id=tfin_compte.refPosition
                  where (tdepense.refMvt = 1) and (dateOperation = :date1)  and (nom_mode = :mode)',
                  ['montants' => $sommeSortie,'date1'=>$dateOperation,'reports'=>$report,'mode'=>$modepaie]
             ); 
              
              foreach ($data7 as $row) 
              {                                
                 $total_production=$row->solde_final;                           
              }

    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>LIVRE DE CAISSE</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csEA66161B {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:30px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs7B44FCB {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:38px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csDC7EEB9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
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
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:949px;height:413px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:64px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:67px;"></td>
                    <td style="height:0px;width:190px;"></td>
                    <td style="height:0px;width:161px;"></td>
                    <td style="height:0px;width:94px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:103px;"></td>
                    <td style="height:0px;width:52px;"></td>
                    <td style="height:0px;width:40px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="8" style="width:718px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="8" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="8" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="8" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="8" rowspan="2" style="width:718px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    <td style="width:0px;height:44px;"></td>
                    <td></td>
                    <td class="cs7B44FCB" colspan="12" style="width:895px;height:44px;line-height:45px;text-align:center;vertical-align:middle;"><nobr>LIVRE&nbsp;DE&nbsp;BANQUE</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:35px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csEA66161B" colspan="6" style="width:575px;height:35px;line-height:35px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;/REF.D</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:417px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DESIGNATION</nobr></td>
                    <td class="cs9FE9304F" style="width:93px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:89px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="cs9FE9304F" style="width:102px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SOLDE</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CODE</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$dateOperation.'</td>
                    <td class="cs9FE9304F" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>C/A</nobr></td>
                    <td class="cs9FE9304F" colspan="7" style="width:601px;height:22px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>&gt;&nbsp;REPORT</nobr></td>
                    <td class="cs9FE9304F" style="width:102px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$report.'$</td>
                    <td class="csEAC52FCD" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUCTION</nobr></td>
                </tr>
                ';
                                                    
                        $output .= $this->showDetailBanque($dateOperation); 
                                                    
                        $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$dateOperation.'</td>
                    <td class="cs9FE9304F" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>C/P</nobr></td>
                    <td class="cs9FE9304F" colspan="7" style="width:601px;height:22px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>TOTAL&nbsp;PRODUCTIONS&nbsp;CASH</nobr></td>
                    <td class="cs9FE9304F" style="width:102px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$total_production.'&nbsp;$</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUCTION</nobr></td>
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
                    <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.$this->CreatedFormat(date("Y-m-d")).'</nobr></td>
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

//

function showDetailBanque($dateOperation)
{
    $data = DB::table('tconf_banque')
    ->select("tconf_banque.id","tconf_banque.nom_banque",
    "tconf_banque.numerocompte",'tconf_banque.nom_mode',"tconf_banque.created_at")
    ->where('tconf_banque.nom_mode','=', 'BANQUE')
    ->orderBy("numerocompte", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $tempEntree=0;
        $tempSortie=0;
        $tempSolde=0;

        $data6 = DB::table('tdepense')
        ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totEntree'))
        ->where([               
            ['tdepense.dateOperation','=', $dateOperation],
            ['tdepense.refBanque','=', $row->id],
            ['tdepense.refMvt','=', '1']
        ])               
        ->get(); 
       
        foreach ($data6 as $rows) 
        {                                
           $tempEntree=$rows->totEntree;                           
        }
        
        $data7 = DB::table('tdepense')
        ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select(DB::raw('IFNULL(ROUND(SUM(montant),0),0) as totSortie'))
        ->where([               
            ['tdepense.dateOperation','=', $dateOperation],
            ['tdepense.refBanque','=', $row->id],
            ['tdepense.refMvt','=', '2']
        ])               
        ->get(); 
        
        foreach ($data7 as $rowss) 
        {                                
           $tempSortie=$rowss->totSortie;                           
        }

        $data8 =   DB::select(
            'select (IFNULL(ROUND(SUM(montant),0),0) - :montants) as solde from tdepense  
             inner join tcompte on tcompte.id = tdepense.refCompte        
             inner join ttypemouvement on ttypemouvement.id=tdepense.refMvt
             inner join tconf_banque on tconf_banque.id = tdepense.refBanque 
             inner join tfin_ssouscompte on tfin_ssouscompte.id = tconf_banque.refSscompte
             inner join tfin_souscompte on tfin_souscompte.id = tfin_ssouscompte.refSousCompte
             inner join tfin_compte on tfin_compte.id = tfin_souscompte.refCompte
             inner join tfin_classe on tfin_classe.id = tfin_compte.refClasse
             inner join tfin_typecompte on tfin_typecompte.id = tfin_compte.refTypecompte
             inner join tfin_typeposition on tfin_typeposition.id=tfin_compte.refPosition
             where (tdepense.refMvt = 1) and (dateOperation = :date1) and (refBanque = :id)',
             ['montants' => $tempSortie,'date1'=>$dateOperation,'id'=>$row->id]
        ); 
         
         foreach ($data8 as $rowsss) 
         {                                
            $tempSolde=$rowsss->solde;                           
         }



         $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$dateOperation.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.substr($row->numerocompte, 0,8).'</td>
                <td class="csDC7EEB9" colspan="3" style="width:417px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>TTOTAL&nbsp;PRODUCTION&nbsp;BANQUE/'.$row->nom_banque.'</nobr></td>
                <td class="cs6E02D7D2" style="width:93px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$tempEntree.'$</td>
                <td class="cs6E02D7D2" colspan="3" style="width:89px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$tempSortie.'$</td>
                <td class="cs6E02D7D2" style="width:102px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$tempSolde.'$</td>
                <td class="cs6C28398D" colspan="2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUCTION</nobr></td>
            </tr>
         ';
       
    }

    return $output;

}









}
