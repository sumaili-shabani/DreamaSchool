<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_BonEngagementController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


    function pdf_bon_engagement(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoBonEngagement($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoBonEngagement($id)
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
                $data2 = DB::table('tt_treso_detail_angagement')
                ->join('ttreso_entete_angagement','ttreso_entete_angagement.id','=','tt_treso_detail_angagement.refEntete')
                ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_angagement.refRubrique')
                ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
                ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
                ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
        
                ->select(DB::raw('ROUND(SUM(Qte*PU),0) as TotalMontant'))
                ->where('refEntete','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalMontant=$row->TotalMontant;
                                    
                }

                $nomProvenance='';
                $designationBloc='';
                $dateEngagement='';
                $codeBE=''; 
                $motif='';
                $refEtatbesoin='';
                $nom_banque='';
                $Mois= '';
                $Annee= '';

                $dateValiderDemandeur= '';
                $ValiderDemandeur= '';
                $dateValidertDivision= '';
                $ValiderDivision= '';
                $dateValiderTresorerie= '';
                $ValiderTresorerie= '';
                $dateValiderAdministration= '';
                $ValiderAdministrateur= '';
                $dateValiderDirection= '';
                $ValiderDirecteur= '';
                $dateValidertGerant= '';
                $ValiderGerant= '';

                $titres="BON D'ENGAGEMENT DES DEPENSES";
                $piedpage="TOUTE DEPENSE SERA EFFECTUEE  APRES  L'APPROBATION DU GERANT ET MEDECIN DIRECTEUR";
       
                $data3=DB::table('ttreso_entete_angagement')
                ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
                ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
                ->leftjoin('vSommeBEngagement','vSommeBEngagement.refEntete','=','ttreso_entete_angagement.id')
    
                ->join('tconf_banque' , 'tconf_banque.id','=','ttreso_entete_angagement.refCaisse')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
        
                ->select("ttreso_entete_angagement.id","motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
                "ttreso_entete_angagement.author","desiBloc as designationBloc","tt_treso_provenance.nomProvenance",
                "dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
                "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
                "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
                "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
                "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
                "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
                "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant","tt_treso_provenance.codeProvenance",
                "ttreso_entete_angagement.created_at","TotalBE","nom_mode","refCaisse","tconf_banque.nom_banque",
                "tconf_banque.numerocompte",'tconf_banque.nom_mode',
                "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte")
                ->selectRaw('CONCAT("BE",YEAR(dateEngagement),"",MONTH(dateEngagement),"00",ttreso_entete_angagement.id) as codeBE')
                ->selectRaw('CONCAT("",MONTH(dateEngagement)) as Mois')
                ->selectRaw('CONCAT("",YEAR(dateEngagement)) as Annee')
                ->where('ttreso_entete_angagement.id','=', $id)     
                ->get();      
                $output='';
                
                foreach ($data3 as $row) 
                {
                    $nomProvenance=$row->nomProvenance;
                    $designationBloc=$row->designationBloc;
                    $dateEngagement=$row->dateEngagement;   
                    $codeBE=$row->codeBE; 
                    $motif=$row->motif; 
                    $refEtatbesoin= $row->refEtatbesoin; 
                    $nom_banque= $row->nom_banque;
                    $Mois= $row->Mois;
                    $Annee= $row->Annee;     
                    
                    $dateValiderDemandeur= $row->dateValiderDemandeur;
                    $ValiderDemandeur= $row->ValiderDemandeur;
                    $dateValidertDivision= $row->dateValidertDivision;
                    $ValiderDivision= $row->ValiderDivision;
                    $dateValiderTresorerie= $row->dateValiderTresorerie;
                    $ValiderTresorerie= $row->ValiderTresorerie;
                    $dateValiderAdministration= $row->dateValiderAdministration;
                    $ValiderAdministrateur= $row->ValiderAdministrateur;
                    $dateValiderDirection= $row->dateValiderDirection;
                    $ValiderDirecteur= $row->ValiderDirecteur;
                    $dateValidertGerant= $row->dateValidertGerant;
                    $ValiderGerant= $row->ValiderGerant;
                }
       
        
        
                $output=' 

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>BON ENGAGEMENT</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs928E3840 {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs2696C2A2 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:35px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .cs9CB86DFE {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csD9A3A08 {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs32F55C63 {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .csA8087750 {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; text-decoration: underline;}
                        .cs9C2C8294 {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .cs196EA71A {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csBEA84DDD {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top-style: none;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .cs18C15A24 {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .csC4495DE8 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs60D4DC48 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; text-decoration: underline;}
                        .cs3DFA02C5 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs20BD785A {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; }
                        .cs51CC3E6B {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .cs8F7C918A {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs218D2E3E {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .csD3E09727 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs39250889 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .cs129A1A7E {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDD232CCD {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; }
                        .cs3F6175E5 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .cs605FEAE2 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBE0C4D85 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .csCAA06467 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE71B6827 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .csE3FF0E6A {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csF31DC6CF {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csF3B9660B {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .cs508FEFDC {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5CA73D6D {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .csD193AA53 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:15px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs8A77DDF0 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs2A8593E6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csBF99781F {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:720px;height:879px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:140px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:30px;"></td>
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
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td class="csBF99781F" colspan="24" style="width:496px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td class="cs101A94F7" colspan="4" rowspan="7" style="width:183px;height:154px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:183px;height:154px;">
                            <img alt="" src="'.$pic2.'" style="width:183px;height:154px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="24" style="width:496px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="24" style="width:496px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="24" style="width:496px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="24" style="width:496px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="24" style="width:496px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="24" rowspan="2" style="width:496px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td></td>
                    </tr>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td class="cs2696C2A2" colspan="30" style="width:702px;height:41px;line-height:42px;text-align:center;vertical-align:middle;">'.$titres.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:31px;"></td>
                        <td></td>
                        <td class="cs2A8593E6" colspan="8" style="width:84px;height:31px;line-height:17px;text-align:center;vertical-align:middle;"><nobr>CODE/REF:</nobr></td>
                        <td class="cs8BD51C12" colspan="4" style="width:142px;height:31px;line-height:15px;text-align:center;vertical-align:middle;">'.$nomProvenance.'</td>
                        <td class="cs2A8593E6" colspan="2" style="width:23px;height:31px;line-height:17px;text-align:center;vertical-align:middle;"><nobr>/N&#176;</nobr></td>
                        <td class="cs8A77DDF0" colspan="7" style="width:151px;height:31px;line-height:17px;text-align:center;vertical-align:middle;"><nobr>'.$codeBE.'</nobr></td>
                        <td class="csD193AA53" colspan="9" style="width:286px;height:31px;line-height:17px;text-align:center;vertical-align:middle;"><nobr>/N&#176;REF/D:&nbsp;............/&nbsp;MOIS:&nbsp;&nbsp;'.$Mois.'&nbsp;/&nbsp;'.$Annee.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs9CB86DFE" colspan="23" style="width:448px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>COORDINATION,DIVISION,SERVICE&nbsp;OU&nbsp;BENEFICIAIRE</nobr></td>
                        <td class="cs20BD785A" colspan="7" style="width:255px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$nomProvenance.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs196EA71A" colspan="11" style="width:180px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>MOTIF&nbsp;DE&nbsp;DEPENSE</nobr></td>
                        <td class="csDD232CCD" colspan="19" style="width:523px;height:23px;line-height:17px;text-align:center;vertical-align:middle;">'.$motif.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs196EA71A" colspan="30" style="width:704px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>BESOINS&nbsp;DETAILLES</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs9CB86DFE" colspan="3" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="csC4495DE8" colspan="20" style="width:411px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DESIGNATION</nobr></td>
                        <td class="csC4495DE8" colspan="2" style="width:61px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                        <td class="csC4495DE8" colspan="3" style="width:153px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                        <td class="csC4495DE8" colspan="2" style="width:39px;height:22px;"></td>
                    </tr>
                     ';
                                                
                                           $output .= $this->showDetailBonEngagement($id); 
                                                
                                         $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs9CB86DFE" colspan="3" style="width:36px;height:22px;"></td>
                        <td class="cs51CC3E6B" colspan="20" style="width:411px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                        <td class="csC4495DE8" colspan="2" style="width:61px;height:22px;"></td>
                        <td class="cs60D4DC48" colspan="3" style="width:153px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalMontant.'$</nobr></td>
                        <td class="csC4495DE8" colspan="2" style="width:39px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs9C2C8294" style="width:13px;height:9px;"></td>
                        <td class="cs39250889" colspan="2" style="width:24px;height:9px;"></td>
                        <td class="cs39250889" colspan="3" style="width:18px;height:9px;"></td>
                        <td class="cs39250889" colspan="3" style="width:59px;height:9px;"></td>
                        <td class="cs39250889" colspan="4" style="width:123px;height:9px;"></td>
                        <td class="cs39250889" colspan="3" style="width:84px;height:9px;"></td>
                        <td class="cs218D2E3E" style="width:18px;height:9px;"></td>
                        <td class="csD3E09727" style="width:24px;height:9px;"></td>
                        <td class="csD3E09727" style="width:18px;height:9px;"></td>
                        <td class="csD3E09727" colspan="3" style="width:60px;height:9px;"></td>
                        <td class="csD3E09727" colspan="7" style="width:253px;height:9px;"></td>
                        <td class="cs8F7C918A" style="width:9px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:19px;"></td>
                        <td class="csF31DC6CF" colspan="2" style="width:20px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="cs928E3840" colspan="3" style="width:14px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="csE3FF0E6A" colspan="7" style="width:180px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SERVICE&nbsp;DEMANDEUR:</nobr></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:84px;height:19px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csF31DC6CF" style="width:20px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="cs928E3840" style="width:14px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="csE3FF0E6A" colspan="10" style="width:311px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>APPROBATION&nbsp;COORDINATION&nbsp;/DIVISION:</nobr></td>
                        <td class="cs605FEAE2" style="width:9px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="2" style="width:24px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:18px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:59px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="4" style="width:123px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:84px;height:10px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:10px;"></td>
                        <td class="cs508FEFDC" style="width:24px;height:10px;"></td>
                        <td class="cs508FEFDC" style="width:18px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:60px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="7" style="width:253px;height:10px;"></td>
                        <td class="cs605FEAE2" style="width:9px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="5" style="width:40px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date:</nobr></td>
                        <td class="csE3FF0E6A" colspan="10" style="width:264px;height:19px;line-height:13px;text-align:left;vertical-align:middle;">&nbsp;'.$dateValiderDemandeur.'&nbsp;&nbsp;&nbsp;Par&nbsp;&nbsp;'.$ValiderDemandeur.'</td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="2" style="width:40px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date:</nobr></td>
                        <td class="csE3FF0E6A" colspan="10" style="width:311px;height:19px;line-height:13px;text-align:left;vertical-align:middle;">&nbsp;'.$dateValidertDivision.'&nbsp;&nbsp;&nbsp;Par&nbsp;&nbsp;'.$ValiderDivision.'</td>
                        <td class="cs605FEAE2" style="width:9px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="2" style="width:24px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:18px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:59px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="4" style="width:123px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:84px;height:16px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:16px;"></td>
                        <td class="cs508FEFDC" style="width:24px;height:16px;"></td>
                        <td class="cs508FEFDC" style="width:18px;height:16px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:60px;height:16px;"></td>
                        <td class="cs508FEFDC" colspan="7" style="width:253px;height:16px;"></td>
                        <td class="cs605FEAE2" style="width:9px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="8" style="width:99px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs5CA73D6D" colspan="4" style="width:123px;height:19px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:84px;height:19px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="5" style="width:100px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs508FEFDC" colspan="7" style="width:253px;height:19px;"></td>
                        <td class="cs605FEAE2" style="width:9px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td class="csBEA84DDD" style="width:13px;height:25px;"></td>
                        <td class="csE71B6827" colspan="2" style="width:24px;height:25px;"></td>
                        <td class="csE71B6827" colspan="3" style="width:18px;height:25px;"></td>
                        <td class="csE71B6827" colspan="3" style="width:59px;height:25px;"></td>
                        <td class="csE71B6827" colspan="4" style="width:123px;height:25px;"></td>
                        <td class="csE71B6827" colspan="3" style="width:84px;height:25px;"></td>
                        <td class="cs3F6175E5" style="width:18px;height:25px;"></td>
                        <td class="csCAA06467" style="width:24px;height:25px;"></td>
                        <td class="csCAA06467" style="width:18px;height:25px;"></td>
                        <td class="csCAA06467" colspan="3" style="width:60px;height:25px;"></td>
                        <td class="csCAA06467" colspan="7" style="width:253px;height:25px;"></td>
                        <td class="cs129A1A7E" style="width:9px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs32F55C63" colspan="30" style="width:704px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs9C2C8294" style="width:13px;height:9px;"></td>
                        <td class="cs39250889" colspan="2" style="width:24px;height:9px;"></td>
                        <td class="cs39250889" colspan="3" style="width:18px;height:9px;"></td>
                        <td class="cs39250889" colspan="3" style="width:59px;height:9px;"></td>
                        <td class="cs39250889" colspan="7" style="width:207px;height:9px;"></td>
                        <td class="cs218D2E3E" style="width:18px;height:9px;"></td>
                        <td class="csD3E09727" style="width:24px;height:9px;"></td>
                        <td class="csD3E09727" style="width:18px;height:9px;"></td>
                        <td class="csD3E09727" colspan="3" style="width:60px;height:9px;"></td>
                        <td class="csD3E09727" colspan="5" style="width:220px;height:9px;"></td>
                        <td class="csD3E09727" colspan="2" style="width:33px;height:9px;"></td>
                        <td class="cs8F7C918A" style="width:9px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:19px;"></td>
                        <td class="csF31DC6CF" colspan="2" style="width:20px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="cs928E3840" colspan="3" style="width:14px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="csF3B9660B" colspan="10" style="width:264px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>COORDONATEUR&nbsp;TRESORERIE&nbsp;/ACHATS</nobr></td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csF31DC6CF" style="width:20px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="cs928E3840" style="width:14px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="csF3B9660B" colspan="10" style="width:311px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>ADMINISTRATION/ADMIN.&nbsp;GESTIONNAIRE</nobr></td>
                        <td class="cs605FEAE2" style="width:9px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="2" style="width:24px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:18px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:59px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="7" style="width:207px;height:10px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:10px;"></td>
                        <td class="cs508FEFDC" style="width:24px;height:10px;"></td>
                        <td class="cs508FEFDC" style="width:18px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:60px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="5" style="width:220px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="2" style="width:33px;height:10px;"></td>
                        <td class="cs605FEAE2" style="width:9px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="5" style="width:40px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date:</nobr></td>
                        <td class="csE3FF0E6A" colspan="10" style="width:264px;height:19px;line-height:13px;text-align:left;vertical-align:middle;">&nbsp;'.$dateValiderTresorerie.'&nbsp;&nbsp;&nbsp;Par&nbsp;&nbsp;'.$ValiderTresorerie.'</td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="2" style="width:40px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date:</nobr></td>
                        <td class="csE3FF0E6A" colspan="8" style="width:278px;height:19px;line-height:13px;text-align:left;vertical-align:middle;">&nbsp;'.$dateValiderAdministration.'&nbsp;&nbsp;&nbsp;Par&nbsp;&nbsp;'.$ValiderAdministrateur.'</td>
                        <td class="cs508FEFDC" colspan="2" style="width:33px;height:19px;"></td>
                        <td class="cs605FEAE2" style="width:9px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="2" style="width:24px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:18px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:59px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="7" style="width:207px;height:16px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:16px;"></td>
                        <td class="cs508FEFDC" style="width:24px;height:16px;"></td>
                        <td class="cs508FEFDC" style="width:18px;height:16px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:60px;height:16px;"></td>
                        <td class="cs508FEFDC" colspan="5" style="width:220px;height:16px;"></td>
                        <td class="cs508FEFDC" colspan="2" style="width:33px;height:16px;"></td>
                        <td class="cs605FEAE2" style="width:9px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" style="width:13px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="8" style="width:99px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs5CA73D6D" colspan="7" style="width:207px;height:19px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="5" style="width:100px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs508FEFDC" colspan="5" style="width:220px;height:19px;"></td>
                        <td class="cs508FEFDC" colspan="2" style="width:33px;height:19px;"></td>
                        <td class="cs605FEAE2" style="width:9px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td class="csBEA84DDD" style="width:13px;height:25px;"></td>
                        <td class="csE71B6827" colspan="2" style="width:24px;height:25px;"></td>
                        <td class="csE71B6827" colspan="3" style="width:18px;height:25px;"></td>
                        <td class="csE71B6827" colspan="3" style="width:59px;height:25px;"></td>
                        <td class="csE71B6827" colspan="7" style="width:207px;height:25px;"></td>
                        <td class="cs3F6175E5" style="width:18px;height:25px;"></td>
                        <td class="csCAA06467" style="width:24px;height:25px;"></td>
                        <td class="csCAA06467" style="width:18px;height:25px;"></td>
                        <td class="csCAA06467" colspan="3" style="width:60px;height:25px;"></td>
                        <td class="csCAA06467" colspan="5" style="width:220px;height:25px;"></td>
                        <td class="csCAA06467" colspan="2" style="width:33px;height:25px;"></td>
                        <td class="cs129A1A7E" style="width:9px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs32F55C63" colspan="30" style="width:704px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>AUTORISATION</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs9C2C8294" colspan="2" style="width:27px;height:9px;"></td>
                        <td class="cs39250889" colspan="3" style="width:24px;height:9px;"></td>
                        <td class="cs39250889" colspan="2" style="width:18px;height:9px;"></td>
                        <td class="cs39250889" colspan="3" style="width:59px;height:9px;"></td>
                        <td class="cs39250889" colspan="5" style="width:136px;height:9px;"></td>
                        <td class="cs39250889" style="width:57px;height:9px;"></td>
                        <td class="cs218D2E3E" style="width:18px;height:9px;"></td>
                        <td class="csD3E09727" style="width:24px;height:9px;"></td>
                        <td class="csD3E09727" style="width:18px;height:9px;"></td>
                        <td class="csD3E09727" colspan="3" style="width:60px;height:9px;"></td>
                        <td class="csD3E09727" colspan="2" style="width:28px;height:9px;"></td>
                        <td class="csD3E09727" colspan="3" style="width:192px;height:9px;"></td>
                        <td class="cs8F7C918A" colspan="3" style="width:42px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" colspan="2" style="width:27px;height:19px;"></td>
                        <td class="csF31DC6CF" colspan="3" style="width:20px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="cs928E3840" colspan="2" style="width:14px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="csF3B9660B" colspan="8" style="width:193px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>MEDECIN&nbsp;DIRECTEUR&nbsp;:</nobr></td>
                        <td class="cs5CA73D6D" style="width:57px;height:19px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csF31DC6CF" style="width:20px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="cs928E3840" style="width:14px;height:19px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>*</nobr></td>
                        <td class="csE3FF0E6A" colspan="5" style="width:86px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>GERANT:</nobr></td>
                        <td class="cs508FEFDC" colspan="3" style="width:192px;height:19px;"></td>
                        <td class="cs605FEAE2" colspan="3" style="width:42px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs18C15A24" colspan="2" style="width:27px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:24px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="2" style="width:18px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:59px;height:10px;"></td>
                        <td class="cs5CA73D6D" colspan="5" style="width:136px;height:10px;"></td>
                        <td class="cs5CA73D6D" style="width:57px;height:10px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:10px;"></td>
                        <td class="cs508FEFDC" style="width:24px;height:10px;"></td>
                        <td class="cs508FEFDC" style="width:18px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:60px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="2" style="width:28px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:192px;height:10px;"></td>
                        <td class="cs605FEAE2" colspan="3" style="width:42px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" colspan="2" style="width:27px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="5" style="width:40px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date:</nobr></td>
                        <td class="csE3FF0E6A" colspan="9" style="width:250px;height:19px;line-height:13px;text-align:left;vertical-align:middle;">&nbsp;'.$dateValiderDirection.'&nbsp;&nbsp;&nbsp;Par&nbsp;&nbsp;'.$ValiderDirecteur.'</td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="2" style="width:40px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date:</nobr></td>
                        <td class="csE3FF0E6A" colspan="8" style="width:278px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>&nbsp;'.$dateValidertGerant.'&nbsp;&nbsp;&nbsp;Par&nbsp;&nbsp;'.$ValiderGerant.'</nobr></td>
                        <td class="cs605FEAE2" colspan="3" style="width:42px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs18C15A24" colspan="2" style="width:27px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:24px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="2" style="width:18px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="3" style="width:59px;height:16px;"></td>
                        <td class="cs5CA73D6D" colspan="5" style="width:136px;height:16px;"></td>
                        <td class="cs5CA73D6D" style="width:57px;height:16px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:16px;"></td>
                        <td class="cs508FEFDC" style="width:24px;height:16px;"></td>
                        <td class="cs508FEFDC" style="width:18px;height:16px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:60px;height:16px;"></td>
                        <td class="cs508FEFDC" colspan="2" style="width:28px;height:16px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:192px;height:16px;"></td>
                        <td class="cs605FEAE2" colspan="3" style="width:42px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs18C15A24" colspan="2" style="width:27px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="8" style="width:99px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs5CA73D6D" colspan="5" style="width:136px;height:19px;"></td>
                        <td class="cs5CA73D6D" style="width:57px;height:19px;"></td>
                        <td class="csBE0C4D85" style="width:18px;height:19px;"></td>
                        <td class="csE3FF0E6A" colspan="5" style="width:100px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs508FEFDC" colspan="2" style="width:28px;height:19px;"></td>
                        <td class="cs508FEFDC" colspan="3" style="width:192px;height:19px;"></td>
                        <td class="cs605FEAE2" colspan="3" style="width:42px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td class="csBEA84DDD" colspan="2" style="width:27px;height:25px;"></td>
                        <td class="csE71B6827" colspan="3" style="width:24px;height:25px;"></td>
                        <td class="csE71B6827" colspan="2" style="width:18px;height:25px;"></td>
                        <td class="csE71B6827" colspan="3" style="width:59px;height:25px;"></td>
                        <td class="csE71B6827" colspan="5" style="width:136px;height:25px;"></td>
                        <td class="csE71B6827" style="width:57px;height:25px;"></td>
                        <td class="cs3F6175E5" style="width:18px;height:25px;"></td>
                        <td class="csCAA06467" style="width:24px;height:25px;"></td>
                        <td class="csCAA06467" style="width:18px;height:25px;"></td>
                        <td class="csCAA06467" colspan="3" style="width:60px;height:25px;"></td>
                        <td class="csCAA06467" colspan="2" style="width:28px;height:25px;"></td>
                        <td class="csCAA06467" colspan="3" style="width:192px;height:25px;"></td>
                        <td class="cs129A1A7E" colspan="3" style="width:42px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csA8087750" colspan="4" style="width:41px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N.B&nbsp;:</nobr></td>
                        <td class="csC4495DE8" colspan="26" style="width:663px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$piedpage.'</td>
                    </tr>
                </table>
                </body>
                </html>
                
                '; 

        return $output;

    }   


    function showDetailBonEngagement($id)
    {
        $data = DB::table('tt_treso_detail_angagement')
        ->join('ttreso_entete_angagement','ttreso_entete_angagement.id','=','tt_treso_detail_angagement.refEntete')
        ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_angagement.refRubrique')
        ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
        ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
        ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
        ->select("tt_treso_detail_angagement.id","refEntete","refRubrique","Qte","PU",
        "motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
        "tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique","refcateRubrik",
        "ttreso_entete_angagement.author","desiBloc as designationBloc","dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
        "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
        "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
        "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
        "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
        "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
        "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant",".nomProvenance","codeProvenance",
        "tt_treso_detail_angagement.created_at")
        ->selectRaw('(Qte*PU) as prixTotal')
        ->where('refEntete','=', $id) 
        ->get();

        $output='';
        $count = 0;
        foreach ($data as $row) 
        { 
            $count ++;

            $output .='
            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="csD9A3A08" colspan="3" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$count.'</td>
            <td class="cs3DFA02C5" colspan="20" style="width:411px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->desiRubriq.'</td>
            <td class="cs3DFA02C5" colspan="2" style="width:61px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->Qte.'</td>
            <td class="cs3DFA02C5" colspan="3" style="width:153px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
            <td class="cs3DFA02C5" colspan="2" style="width:39px;height:22px;"></td>
        </tr>
            ';            
        
        }

        return $output;

    }





    //============== PARTIE ETAT DE BESOIN ===========================================================================


    function pdf_bon_etatdebesoin(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoEtatdeBesoin($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);
            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoEtatdeBesoin($id)
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
                $data2 = DB::table('tt_treso_detail_etatbesoin')
                ->join('tt_treso_entete_etatbesoin','tt_treso_entete_etatbesoin.id','=','tt_treso_detail_etatbesoin.refEntete')
                ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
                ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_etatbesoin.refRubrique')
                ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')        
                ->select(DB::raw('ROUND(SUM(Qte*PU),0) as TotalMontant'))
                ->where('refEntete','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalMontant=$row->TotalMontant;
                                    
                }

                $nomProvenance='';
                $designationBloc='';
                $DateElaboration='';
                $codeEB=''; 
                $motif='';
                $refEtatbesoin='';
                $nom_banque='';
                $Mois= '';
                $Annee= '';

                $DateAcquitterPar= '';
                $AcquitterPar= '';
                $DateApproCoordi= '';
                $ApproCoordi= '';

                $titres="BON D'ENGAGEMENT DES DEPENSES";
                $piedpage="TOUTE DEPENSE SERA EFFECTUEE  APRES  L'APPROBATION DU GERANT ET MEDECIN DIRECTEUR";
       
                $data3=DB::table('tt_treso_entete_etatbesoin')
                ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
                ->select("tt_treso_entete_etatbesoin.id","motifDepense","DateElaboration",
                "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
                ,"DateApproCoordi","tt_treso_entete_etatbesoin.author","refProvenance",
                "tt_treso_provenance.nomProvenance","codeProvenance",
                "tt_treso_entete_etatbesoin.created_at")
                ->selectRaw('CONCAT("EB",YEAR(DateElaboration),"",MONTH(DateElaboration),"00",tt_treso_entete_etatbesoin.id) as codeEB')
                ->selectRaw('CONCAT("",MONTH(DateElaboration)) as Mois')
                ->selectRaw('CONCAT("",YEAR(DateElaboration)) as Annee')
                ->where('tt_treso_entete_etatbesoin.id','=', $id)     
                ->get();      
                $output='';
                
                foreach ($data3 as $row) 
                {
                    $AcquitterPar= $row->AcquitterPar;
                    $DateApproCoordi= $row->DateApproCoordi;
                    $ApproCoordi= $row->ApproCoordi;
                }
       
        
        
                $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>ETAT DE BESOIN</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs2696C2A2 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:35px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .cs9CB86DFE {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs5012ABFC {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; }
                        .cs32F55C63 {color:#000000;background-color:#FFFFFF;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                        .csC4495DE8 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs5CDA1C {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; }
                        .cs20BD785A {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs3AF473BB {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csD4852FAF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csBF99781F {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:697px;height:532px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:48px;"></td>
                        <td style="height:0px;width:56px;"></td>
                        <td style="height:0px;width:92px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:113px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:29px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:28px;"></td>
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
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csBF99781F" colspan="11" style="width:501px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td class="cs101A94F7" colspan="4" rowspan="7" style="width:172px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:172px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:172px;height:144px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="11" style="width:501px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="11" style="width:501px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="11" style="width:501px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="11" style="width:501px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="11" style="width:501px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="11" rowspan="2" style="width:501px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs2696C2A2" colspan="14" style="width:651px;height:41px;line-height:42px;text-align:center;vertical-align:middle;"><nobr>ETAT&nbsp;DE&nbsp;BESOIN</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs3AF473BB" colspan="3" style="width:194px;height:22px;line-height:17px;text-align:left;vertical-align:middle;"><nobr>SERVICE&nbsp;BENEFICIAIRE:</nobr></td>
                        <td class="csD4852FAF" colspan="11" style="width:457px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">'.$nomProvenance.'  - '.$codeEB.'</td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="3" style="width:194px;height:22px;line-height:17px;text-align:left;vertical-align:middle;"><nobr>MOTIF&nbsp;DE&nbsp;LA&nbsp;DEPENSE:</nobr></td>
                        <td class="csD4852FAF" colspan="11" style="width:457px;height:22px;line-height:17px;text-align:left;vertical-align:middle;">'.$motif.'</td>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9CB86DFE" style="width:46px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="csC4495DE8" colspan="6" style="width:371px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DESIGNATION</nobr></td>
                        <td class="csC4495DE8" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>QTE</nobr></td>
                        <td class="csC4495DE8" colspan="4" style="width:68px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="csC4495DE8" style="width:100px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                        <td></td>
                    </tr>
                    ';
                                                                
                                         $output .= $this->showDetailEtatdeBeoin($id); 
                                                                
                                      $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs32F55C63" colspan="13" style="width:552px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                        <td class="cs5CDA1C" style="width:100px;height:22px;line-height:17px;text-align:center;vertical-align:middle;"><nobr>'.$totalMontant.'$</nobr></td>
                        <td></td>
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
                        <td></td>
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
                        <td class="cs612ED82F" colspan="5" style="width:230px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">ACQUITTER&nbsp;PAR&nbsp;:&nbsp;'.$AcquitterPar.'</td>
                        <td></td>
                        <td class="cs612ED82F" colspan="9" style="width:310px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">APPROBATION&nbsp;COORDINATION&nbsp;:&nbsp;'.$ApproCoordi.'</td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="5" style="width:230px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DATE:&nbsp;'.$DateAcquitterPar.'</nobr></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="7" style="width:173px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DATE:&nbsp;'.$DateApproCoordi.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="3" style="width:104px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="3" style="width:104px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
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


    function showDetailEtatdeBeoin($id)
    {
        $data = DB::table('tt_treso_detail_etatbesoin')
        ->join('tt_treso_entete_etatbesoin','tt_treso_entete_etatbesoin.id','=','tt_treso_detail_etatbesoin.refEntete')
        ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
        ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_etatbesoin.refRubrique')
        ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
        ->select("tt_treso_detail_etatbesoin.id","tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique",
        "refcateRubrik","motifDepense","DateElaboration",
        "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","Qte","PU","tt_treso_detail_etatbesoin.author","refProvenance",
        "tt_treso_provenance.nomProvenance","codeProvenance",
        "tt_treso_detail_etatbesoin.created_at","service_beneficiaire")
        ->selectRaw('(Qte*PU) as prixTotal')
        ->where('refEntete','=', $id) 
        ->get();

        $output='';
        $count = 0;
        foreach ($data as $row) 
        { 

            $count ++;

            $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="cs5012ABFC" style="width:46px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$count.'</td>
                <td class="cs20BD785A" colspan="6" style="width:371px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->desiRubriq.'</td>
                <td class="cs20BD785A" colspan="2" style="width:64px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->Qte.'</td>
                <td class="cs20BD785A" colspan="4" style="width:68px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->PU.'$</td>
                <td class="cs20BD785A" style="width:100px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                <td></td>
            </tr>
                ';


         
        
        }

        return $output;

    }















    
    
}
