<?php

namespace App\Http\Controllers\Finances;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class BonEntreeCaissePdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_bon_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoFactureTug($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoFactureTug($id)
    {

                $titres="BON D'ENTREE CAISSE";

                $idDepense='';
                $montant='';
                $montantLettre='';
                $motif='';                
                $dateOperation='';
                $Compte='';
                $refMvt='';
                $author='';
                $modepaie='';
                $nom_banque='';
                $AcquitterPar='';
                $DateAcquitterPar='';
                $ApproCoordi='';
                $DateApproCoordi='';
                $codeOperation='';
                $Compte='';
                $numeroBE='';
                
                $data = DB::table('tdepense')
                ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
                ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
                ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
        
                ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
                "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
                'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
                ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
                "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
                "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
                "tdepense.created_at","tdepense.updated_at","numeroBE")
                ->selectRaw('CONCAT("BENT",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
                ->where('tdepense.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $idDepense=$row->id;
                    $montant=$row->montant;
                    $montantLettre=$row->montantLettre;
                    $motif=$row->motif;                
                    $dateOperation=$row->dateOperation;
                    $Compte=$row->Compte;
                    $refMvt=$row->refMvt;
                    $author=$row->author;
                    $modepaie=$row->modepaie;
                    $nom_banque=$row->nom_banque;
                    $AcquitterPar=$row->AcquitterPar;
                    $DateAcquitterPar=$row->DateAcquitterPar;
                    $ApproCoordi=$row->ApproCoordi;
                    $DateApproCoordi=$row->DateApproCoordi;
                    $codeOperation=$row->codeOperation;
                    $Compte=$row->Compte;
                    $numeroBE=$row->numeroBE;                
                }


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
        
                $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs52B43ED7 {color:#000000;background-color:transparent;border-left:#99B4D1 3px solid;border-top:#99B4D1 3px solid;border-right:#99B4D1 3px solid;border-bottom:#99B4D1 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs989D88EE {color:#000000;background-color:transparent;border-left:#99B4D1 3px solid;border-top:#99B4D1 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs85C4ADBC {color:#000000;background-color:transparent;border-left:#99B4D1 3px solid;border-top-style: none;border-right-style: none;border-bottom:#99B4D1 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs7073218C {color:#000000;background-color:transparent;border-left:#99B4D1 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs79DF234B {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs62767105 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs575406BA {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom-style: none;font-family:Lucida Calligraphy; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs524D8DFF {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE5F297B {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs3B8154A5 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs8E6BFA72 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .cs4B9D0B57 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right-style: none;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs4751E4D3 {color:#000000;background-color:transparent;border-left-style: none;border-top:#99B4D1 3px solid;border-right:#99B4D1 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5CCE14CC {color:#000000;background-color:transparent;border-left-style: none;border-top:#99B4D1 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csEE325747 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#99B4D1 3px solid;border-bottom:#99B4D1 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csEBB30003 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#99B4D1 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8057B1BE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#99B4D1 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:727px;height:706px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:6px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:64px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:60px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:6px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:10px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs989D88EE" colspan="2" style="width:13px;height:31px;"></td>
                        <td class="cs5CCE14CC" colspan="16" style="width:488px;height:31px;"></td>
                        <td class="cs5CCE14CC" colspan="3" style="width:31px;height:31px;"></td>
                        <td class="cs5CCE14CC" colspan="6" style="width:168px;height:31px;"></td>
                        <td class="cs4751E4D3" colspan="2" style="width:17px;height:31px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="16" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:23px;"></td>
                        <td class="" colspan="6" rowspan="7" style="width:162px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:162px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:162px;height:149px;" /></div>
                        </td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:23px;"></td>
                        <td class="csCE72709D" colspan="16" style="width:486px;height:23px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:23px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="16" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:22px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:22px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:22px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:22px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="16" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:21px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="6" style="width:168px;height:1px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="2" style="width:13px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="16" style="width:488px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:31px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="6" style="width:168px;height:19px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs989D88EE" colspan="7" style="width:143px;height:7px;"></td>
                        <td class="cs5CCE14CC" colspan="4" style="width:215px;height:7px;"></td>
                        <td class="cs5CCE14CC" colspan="6" style="width:126px;height:7px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:19px;height:7px;"></td>
                        <td class="cs5CCE14CC" colspan="4" style="width:65px;height:7px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:94px;height:7px;"></td>
                        <td class="cs4751E4D3" colspan="4" style="width:55px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="7" style="width:143px;height:11px;"></td>
                        <td class="cs8E6BFA72" colspan="10" rowspan="3" style="width:333px;height:33px;line-height:32px;text-align:left;vertical-align:top;">'.$titres.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:19px;height:11px;"></td>
                        <td class="cs575406BA" colspan="4" rowspan="4" style="width:57px;height:37px;line-height:36px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;:</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:94px;height:11px;"></td>
                        <td class="csEBB30003" colspan="4" style="width:55px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="7" style="width:143px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:19px;height:23px;"></td>
                        <td class="cs3B8154A5" colspan="2" style="width:84px;height:20px;line-height:18px;text-align:center;vertical-align:top;">'.$codeOperation.'</td>
                        <td class="csEBB30003" colspan="4" style="width:55px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="7" style="width:143px;height:2px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:19px;height:2px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:94px;height:2px;"></td>
                        <td class="csEBB30003" colspan="4" style="width:55px;height:2px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="7" style="width:143px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:215px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="6" style="width:126px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:19px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:94px;height:4px;"></td>
                        <td class="csEBB30003" colspan="4" style="width:55px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="7" style="width:143px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:215px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="6" style="width:126px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:19px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:65px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:94px;height:11px;"></td>
                        <td class="csEBB30003" colspan="4" style="width:55px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="7" style="width:143px;height:30px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:215px;height:30px;"></td>
                        <td class="cs4B9D0B57" colspan="14" style="width:299px;height:24px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Montant&nbsp;:&nbsp;&nbsp;&nbsp;'.$montant.'&nbsp;&nbsp;USD</nobr></td>
                        <td class="csEBB30003" colspan="4" style="width:55px;height:30px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="7" style="width:143px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:215px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="6" style="width:126px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:19px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:65px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:94px;height:15px;"></td>
                        <td class="csEBB30003" colspan="4" style="width:55px;height:15px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="cs989D88EE" colspan="3" style="width:16px;height:11px;"></td>
                        <td class="cs5CCE14CC" style="width:75px;height:11px;"></td>
                        <td class="cs5CCE14CC" colspan="5" style="width:164px;height:11px;"></td>
                        <td class="cs5CCE14CC" colspan="18" style="width:445px;height:11px;"></td>
                        <td class="cs4751E4D3" colspan="2" style="width:17px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="3" style="width:16px;height:30px;"></td>
                        <td class="cs524D8DFF" colspan="6" style="width:231px;height:27px;line-height:18px;text-align:left;vertical-align:top;"><nobr>La&nbsp;somme&nbsp;de&nbsp;(en&nbsp;toutes&nbsp;lettres)&nbsp;:</nobr></td>
                        <td class="csE5F297B" colspan="18" style="width:437px;height:27px;line-height:18px;text-align:left;vertical-align:top;">'.$montantLettre.'</td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:30px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:29px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="3" style="width:16px;height:29px;"></td>
                        <td class="cs524D8DFF" style="width:67px;height:26px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Motif&nbsp;:</nobr></td>
                        <td class="csE5F297B" colspan="23" style="width:601px;height:26px;line-height:18px;text-align:left;vertical-align:top;">'.$motif.'</td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:29px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="3" style="width:16px;height:30px;"></td>
                        <td class="cs524D8DFF" style="width:67px;height:27px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Libell&#233;&nbsp;:</nobr></td>
                        <td class="csE5F297B" colspan="23" style="width:601px;height:27px;line-height:18px;text-align:left;vertical-align:top;">'.$Compte.' - '.$nom_banque.'</td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:30px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs7073218C" colspan="3" style="width:16px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:75px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="5" style="width:164px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="18" style="width:445px;height:11px;"></td>
                        <td class="csEBB30003" colspan="2" style="width:17px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs989D88EE" style="width:7px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="4" style="width:106px;height:18px;"></td>
                        <td class="cs5CCE14CC" style="width:20px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:63px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:82px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:81px;height:18px;"></td>
                        <td class="cs5CCE14CC" style="width:2px;height:18px;"></td>
                        <td class="cs5CCE14CC" style="width:23px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:82px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="4" style="width:56px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:20px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:86px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:40px;height:18px;"></td>
                        <td class="cs5CCE14CC" colspan="2" style="width:42px;height:18px;"></td>
                        <td class="cs4751E4D3" style="width:7px;height:18px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td class="cs7073218C" style="width:7px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:106px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:81px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:2px;height:26px;"></td>
                        <td class="cs62767105" colspan="9" style="width:173px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:&nbsp;'.$this->CreatedFormat($dateOperation).'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:86px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:42px;height:26px;"></td>
                        <td class="csEBB30003" style="width:7px;height:26px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td class="cs7073218C" style="width:7px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:106px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:81px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:2px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:23px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:56px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:20px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:86px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:42px;height:20px;"></td>
                        <td class="csEBB30003" style="width:7px;height:20px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:31px;"></td>
                        <td></td>
                        <td class="cs7073218C" style="width:7px;height:31px;"></td>
                        <td class="cs62767105" colspan="5" rowspan="2" style="width:118px;height:40px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Approbation</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:31px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:31px;"></td>
                        <td class="cs62767105" colspan="2" style="width:73px;height:25px;line-height:18px;text-align:left;vertical-align:top;"><nobr>La&nbsp;caisse</nobr></td>
                        <td class="cs101A94F7" style="width:2px;height:31px;"></td>
                        <td class="cs101A94F7" style="width:23px;height:31px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:31px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:56px;height:31px;"></td>
                        <td class="cs62767105" colspan="6" style="width:138px;height:25px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Pour&nbsp;acquit</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:42px;height:31px;"></td>
                        <td class="csEBB30003" style="width:7px;height:31px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="cs7073218C" style="width:7px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:81px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:2px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:23px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:56px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:20px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:86px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:42px;height:15px;"></td>
                        <td class="csEBB30003" style="width:7px;height:15px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td class="cs7073218C" style="width:7px;height:26px;"></td>
                        <td class="cs62767105" colspan="7" style="width:181px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$ApproCoordi.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:26px;"></td>
                        <td class="cs62767105" colspan="6" style="width:180px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$author.'</td>
                        <td class="cs101A94F7" colspan="4" style="width:56px;height:26px;"></td>
                        <td class="cs62767105" colspan="8" style="width:180px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$AcquitterPar.'</td>
                        <td class="csEBB30003" style="width:7px;height:26px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs7073218C" style="width:7px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="7" style="width:181px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DATE:&nbsp;'.$this->CreatedFormat($DateApproCoordi).'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="6" style="width:180px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DATE:&nbsp;'.$this->CreatedFormat($dateOperation).'</nobr></td>
                        <td class="cs101A94F7" colspan="4" style="width:56px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="8" style="width:180px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DATE:&nbsp;'.$this->CreatedFormat($DateAcquitterPar).'</nobr></td>
                        <td class="csEBB30003" style="width:7px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs7073218C" style="width:7px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="4" style="width:98px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs101A94F7" style="width:20px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="4" style="width:98px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:82px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:56px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="4" style="width:98px;height:16px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SIGNATURE:</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:42px;height:22px;"></td>
                        <td class="csEBB30003" style="width:7px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:48px;"></td>
                        <td></td>
                        <td class="cs85C4ADBC" style="width:7px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="4" style="width:106px;height:45px;"></td>
                        <td class="cs8057B1BE" style="width:20px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="2" style="width:63px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="2" style="width:82px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="2" style="width:81px;height:45px;"></td>
                        <td class="cs8057B1BE" style="width:2px;height:45px;"></td>
                        <td class="cs8057B1BE" style="width:23px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="2" style="width:82px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="4" style="width:56px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="2" style="width:20px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="2" style="width:86px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="2" style="width:40px;height:45px;"></td>
                        <td class="cs8057B1BE" colspan="2" style="width:42px;height:45px;"></td>
                        <td class="csEE325747" style="width:7px;height:45px;"></td>
                    </tr>
                </table>
                </body>
                </html>
                
                ';
        return $output;

    }


//==================== RAPPORT JOURNALIER SELON LE COMPTE =================================



function printDataListCompte($date1, $date2, $refCompte)
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
                    $emailEse=$row->email;
                    $idNatEse='0000';
                    $numImpotEse='0000';
                    $busnessName=$row->objectif;
                    $rccmEse='0000';
                    $pic2 = $this->displayImg("images", $row->logo);
                    $siege=$row->politique;         
                }

         $totalPaie=0;
         $refMvt=1;
         
         $data2 = DB::table('tdepense')        
         ->select(DB::raw('SUM(montant) as TotalPaie'))        
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['tdepense.refCompte','=', $refCompte],
            ['tdepense.refMvt','=', $refMvt]
        ])       
         ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie;                
         }


         $datedebut=$date1;
         $datefin=$date2;
         $Compte='';

         $data3=DB::table('tdepense')
         ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
         ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt')
         ->select('tcompte.designation as Compte','refCompte')       
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],
            ['tdepense.refCompte','=', $refCompte],
            ['tdepense.refMvt','=', $refMvt]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $Compte=$row->Compte;                 
        }



        $output='

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RAPPORT DES RECETTES</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs8AAF79E9 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csE6D2AE99 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:912px;height:387px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:83px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:74px;"></td>
                <td style="height:0px;width:40px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:157px;"></td>
                <td style="height:0px;width:164px;"></td>
                <td style="height:0px;width:7px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:136px;"></td>
                <td style="height:0px;width:3px;"></td>
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
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:718px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td class="cs101A94F7" colspan="2" rowspan="7" style="width:172px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:172px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:172px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:718px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
                <td class="csB6F858D0" colspan="12" style="width:896px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;RECETTES</nobr></td>
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
                <td class="cs56F73198" colspan="6" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$this->CreatedFormat($date1).'&nbsp;&nbsp;au&nbsp; '.$this->CreatedFormat($date2).'</nobr></td>
                <td class="cs56F73198" colspan="6" style="width:562px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$Compte.'</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8AAF79E9" colspan="2" style="width:125px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;BS</nobr></td>
                <td class="cs8AAF79E9" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;($)</nobr></td>
                <td class="cs8AAF79E9" style="width:73px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs8AAF79E9" colspan="3" style="width:262px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MOTIF</nobr></td>
                <td class="cs8AAF79E9" colspan="3" style="width:206px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="csE6D2AE99" style="width:136px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CAISSIER(E)</nobr></td>
                <td></td>
            </tr>
            ';
                
                $output .= $this->showDetailPaieCompte($date1, $date2,$refCompte); 
                
            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="2" style="width:125px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="10" style="width:773px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
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
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.$this->CreatedFormat(date('Y-m-d')).'</nobr></td>
                <td></td>
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

function showDetailPaieCompte($date1, $date2,$refCompte)
{
    $refMvt=1;
    $data=DB::table('tdepense')
    ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
    ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
    ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  

    ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
    "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
    'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
    ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
    "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
    'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
    'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
    "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
    "tdepense.created_at","tdepense.updated_at","numeroBE")
    ->selectRaw('CONCAT("BENT",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2],
        ['tdepense.refCompte','=', $refCompte],
        ['tdepense.refMvt','=', $refMvt]
    ])    
    ->orderBy("tdepense.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='
        <tr style="vertical-align:top;">
		<td style="width:0px;height:24px;"></td>
		<td></td>
		<td class="cs3B0DD49A" colspan="2" style="width:125px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeOperation.'</td>
		<td class="csEE1F9023" colspan="2" style="width:92px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant.'$</td>
		<td class="cs3B0DD49A" style="width:73px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$this->CreatedFormat($row->dateOperation).'</td>
		<td class="cs3B0DD49A" colspan="3" style="width:262px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->motif.'</td>
		<td class="cs3B0DD49A" colspan="3" style="width:206px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->Compte.' - '.$row->nom_banque.'</td>
		<td class="cs803D2C52" style="width:136px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
		<td></td>
	</tr>
        ';   
           
    
    }

    return $output;

}


//======== RAPPORT JOURNALIER GLOBAL ===================================================================================================
//================================================================================================================================================

function printDataList($date1, $date2)
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
                    $emailEse=$row->email;
                    $idNatEse='0000';
                    $numImpotEse='0000';
                    $busnessName=$row->objectif;
                    $rccmEse='0000';
                    $pic2 = $this->displayImg("images", $row->logo);
                    $siege=$row->politique;         
                }
         $totalPaie=0;
         $refMvt=1;
         
         $data2 = DB::table('tdepense')        
         ->select(DB::raw('SUM(montant) as TotalPaie'))        
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],           
            ['tdepense.refMvt','=', $refMvt]
        ])       
         ->get();
         $output='';
         foreach ($data2 as $row) 
         {                                
             $totalPaie=$row->TotalPaie;                
         }


         $datedebut=$date1;
         $datefin=$date2;
         $Compte='';
         
         $data3=DB::table('tdepense')
         ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
         ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt')
         ->select('tcompte.designation as Compte','refCompte')       
         ->where([
            ['dateOperation','>=', $date1],
            ['dateOperation','<=', $date2],         
            ['tdepense.refMvt','=', $refMvt]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $Compte=$row->Compte;                 
        }



        $output='
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RAPPORT DES RECETTES</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs8AAF79E9 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csE6D2AE99 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:912px;height:387px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:83px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:74px;"></td>
                <td style="height:0px;width:40px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:157px;"></td>
                <td style="height:0px;width:164px;"></td>
                <td style="height:0px;width:7px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:136px;"></td>
                <td style="height:0px;width:3px;"></td>
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
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:718px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td class="cs101A94F7" colspan="2" rowspan="7" style="width:172px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:172px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:172px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:718px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
                <td class="csB6F858D0" colspan="12" style="width:896px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;RECETTES</nobr></td>
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
                <td class="cs56F73198" colspan="6" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$this->CreatedFormat($date1).'&nbsp;&nbsp;au&nbsp; '.$this->CreatedFormat($date2).'</nobr></td>
                <td class="cs56F73198" colspan="6" style="width:562px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$Compte.'</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8AAF79E9" colspan="2" style="width:125px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;BS</nobr></td>
                <td class="cs8AAF79E9" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;($)</nobr></td>
                <td class="cs8AAF79E9" style="width:73px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs8AAF79E9" colspan="3" style="width:262px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MOTIF</nobr></td>
                <td class="cs8AAF79E9" colspan="3" style="width:206px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="csE6D2AE99" style="width:136px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CAISSIER(E)</nobr></td>
                <td></td>
            </tr>
            ';
                
                            $output .= $this->showDetailPaie($date1, $date2); 
                
                            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="2" style="width:125px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="10" style="width:773px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
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
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.$this->CreatedFormat(date('Y-m-d')).'</nobr></td>
                <td></td>
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

function showDetailPaie($date1, $date2)
{
    $refMvt=1;
    $data=DB::table('tdepense')
    ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
    ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
    ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  

    ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
    "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
    'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
    ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
    "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
    'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
    'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
    "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
    "tdepense.created_at","tdepense.updated_at","numeroBE")
    ->selectRaw('CONCAT("BE",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
    ->where([
        ['dateOperation','>=', $date1],
        ['dateOperation','<=', $date2],
        ['tdepense.refMvt','=', $refMvt]
    ])    
    ->orderBy("tdepense.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {  
        $output .='
        <tr style="vertical-align:top;">
		<td style="width:0px;height:24px;"></td>
		<td></td>
		<td class="cs3B0DD49A" colspan="2" style="width:125px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeOperation.'</td>
		<td class="csEE1F9023" colspan="2" style="width:92px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant.'$</td>
		<td class="cs3B0DD49A" style="width:73px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$this->CreatedFormat($row->dateOperation).'</td>
		<td class="cs3B0DD49A" colspan="3" style="width:262px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->motif.'</td>
		<td class="cs3B0DD49A" colspan="3" style="width:206px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->Compte.' - '.$row->nom_banque.'</td>
		<td class="cs803D2C52" style="width:136px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
		<td></td>
	</tr>
        ';
    
    }

    return $output;

}



public function fetch_rapport_entree_compte_date(Request $request)
{
    if ($request->get('date1') && $request->get('date2'))
    {
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataList($date1, $date2);       
        // $html .='<script>window.print()</script>';

        // echo($html); 
        
        $html = $this->printDataList($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();  
    }
     else {
        // code...
    }

    
}


public function fetch_rapport_entree_compte_date_rubrique(Request $request)
{
    if ($request->get('date1') && $request->get('date2') && $request->get('refRubEntree'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refRubEntree = $request->get('refRubEntree');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListCompte($date1, $date2,$refRubEntree);       
        // $html .='<script>window.print()</script>';

        // echo($html); 

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    }
    else {
        // code...
    }
    
}




    


    
    

    
}
