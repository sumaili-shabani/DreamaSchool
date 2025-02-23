<?php 
namespace App\Traits;
use DB;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait GlobalMethod{

	//global query
    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    function f_date($date)
    {
      $date = new Date($date);
      return substr($date->format('d/m/Y'), 0,10);
    }

    function CreatedAt($date)
    {
       $created_at = nl2br(substr(date(DATE_RFC822, strtotime($date)), 0, 23));
       return $created_at; 
    }
     function CreatedFormat($date)
    {
        $created_at = strftime('%d/%m/%Y',strtotime($date));
        return $created_at;
    }


    function apiData($data)
    {
      return response($data, 200);
    }


    function msgJson($message)
    {
        return response()->json(['data' => $message]);
    }

    function msgError($message)
    {
      return response()->json(['error'  => $message]);
    }


    function generateOpt($n)
  	{
  	    $generator="1234567890AZERTYUIOPQSDFGHJKLMWXCVBN";
  	    $result="";
  	    for ($i=0; $i <$n ; $i++)
  	    {
  	      $result.=substr($generator, (rand()%(strlen($generator))),1);
  	    }
  	    return $result;
  	}

    /*
    ========================
    // mes scripts ajouts
    *=======================
    *
    *
    */
    // voir les nombre sur les tables 
    function showCountTableWhere($table,$column, $valeur)
    {
      $data = DB::table($table)->where($column,'=', $valeur)->count();
      return $data;
    }

    function showCountTableWhere2($table,$column, $valeur,$column2, $valeur2)
    {
      $data = DB::table($table) ->where([
        [$column,'=', $valeur],
        [$column2,'=', $valeur2]
      ])->count();
      return $data;
    }

    function igIdAnneeScolaireEncours()
    {
      $data = DB::table('inscriptions')
      ->join('eleves','eleves.id','=','inscriptions.idEleve')
      ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
      ->where([
        ['anne_scollaires.statut','=', 1]
      ])
      ->take(1)
      ->get();
      $idAnnee = 0;
      foreach ($data as $row) {
          // code...
        $idAnnee = $row->id;
      }
      return $idAnnee;
    }

    function igIdPeriodeEncours()
    {
        $data = DB::table("periodes")
        ->select("periodes.id", "periodes.nomPeriode","periodes.statutPeriode", "periodes.created_at")
        ->where([
            ['periodes.statutPeriode','=', 1]
        ])
        ->take(1)
        ->get();
        $idPeriode = 0;
        foreach ($data as $row) {
              // code...
            $idPeriode = $row->id;
        }
        return $idPeriode;

    }


    function showCountInscrit()
    {
      $data = DB::table('inscriptions')
      ->join('eleves','eleves.id','=','inscriptions.idEleve')
      ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
      ->where([
        ['anne_scollaires.statut','=', 1]
      ])->count();
      return $data;
    }

    function showCountInscritHomme()
    {
      $data = DB::table('inscriptions')
      ->join('eleves','eleves.id','=','inscriptions.idEleve')
      ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
      ->where([
        ['anne_scollaires.statut','=', 1],
        ['sexeEleve','=', 'M']
      ])->count();
      return $data;
    }

    function showCountInscritFemme()
    {
      $data = DB::table('inscriptions')
      ->join('eleves','eleves.id','=','inscriptions.idEleve')
      ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
      ->where([
        ['anne_scollaires.statut','=', 1],
        ['sexeEleve','=', 'F']
      ])->count();
      return $data;
    }

    function showCountInscritReduction()
    {
      $data = DB::table('inscriptions')
      ->join('eleves','eleves.id','=','inscriptions.idEleve')
      ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
      ->where([
        ['anne_scollaires.statut','=', 1],
        ['reductionPaiement','>', 0]
      ])->count();
      return $data;
    }




    function showSommeCaisseTotalRecette()
    {
      $data = DB::table('tdepense')
      ->where([
        ['tdepense.refMvt','=', 1],
        ['modepaie','=', 'CASH']
      ])->sum('tdepense.montant');
      return $data;
    }

    function showSommeCaisseTotalDepense()
    {
      $data = DB::table('tdepense')
      ->where([
        ['tdepense.refMvt','=', 2],
        ['modepaie','=', 'CASH']
      ])->sum('tdepense.montant');
      return $data;
    }


    function showSommeBanqueTotalRecette()
    {
      $data = DB::table('tdepense')
      ->where([
        ['tdepense.refMvt','=', 1],
        ['modepaie','=', 'BANQUE']
      ])->sum('tdepense.montant');
      return $data;
    }

    function showSommeBanqueTotalDepense()
    {
      $data = DB::table('tdepense')
      ->where([
        ['tdepense.refMvt','=', 2],
        ['modepaie','=', 'BANQUE']
      ])->sum('tdepense.montant');
      return $data;
    }





    function showCountTableWhere3($table,$column, $valeur,$column2, $valeur2)
    {
      $data = DB::table($table) ->where([
        [$column,'=', $valeur],
        [$column2,'>', $valeur2]
      ])->count();
      return $data;
    }

    // voir les nombre sur les tables 
    function showCountTable($table)
    {
      $data = DB::table($table)->count();
      return $data;
    }

    // utulisateur en action connecté 
    function UsersActionConnected($id_user)
    {
        $contributions = DB::table("users")
        ->join('roles','users.id_role','=','roles.id')
        
        ->select('users.id','users.name','users.email','users.id_role','roles.role_name as role', 'users.created_at')
        ->where('users.id', '=', $id_user)->get();
        $data = [];
        foreach ($contributions as $row) {
            # code...
            array_push($data, array(
                'name'          =>  $row->name,
                'privilege'     =>  $row->role,
            ));

        }
        return $data;
    }

    function mesEmprunt($id_user, $table)
    {
        $credits = DB::table($table)->where('id_user', '=', $id_user)->get();
        $data = [];
        foreach ($credits as $row) {
            # code...
            array_push($data, array(
                'jour'          =>  $row->datejour,
                'montant'       =>  $row->montant,
                'created_at'    =>  $row->created_at,
                'connected'     =>  $this->UsersActionConnected($row->connected)
                
            ));

        }
        return $data;
    }

    // voir la somme de contributions ou de remboursement par utilisateur
    function showSumData2($table,$column, $valeur,$column2, $valeur2, $money)
    {
        $somme = DB::table($table)
        ->where([
            [$column,'=', $valeur],
            [$column2,'=', $valeur2]
          ])
        ->sum($table.'.'.$money);
        return $somme;
    }


    function showSumMontantUser($table,$column, $valeur, $money)
    {
        $somme = DB::table($table)->where($column, '=', $valeur)->sum($table.'.'.$money);
        return $somme;
    }

    function showSumMontantTable($table, $money)
    {
        $somme = DB::table($table)->sum($table.'.'.$money);
        return $somme;
    }

    function showNumberDataTableUser($table, $column, $valeur)
    {
       $tests = DB::table($table)->where([
            [$column,     '=', $valeur]

        ])->get();
        $count = $tests->count();

        return  $count;
    }

    function showNumberDataTable($table)
    {
       $tests = DB::table($table)->get();
       $count = $tests->count();

      return  $count;
    }

    function showCount($id, $table)
    {
        $demandes = DB::table($table)->where([
            ['id', '=', $id],
            ['etat', '=', 1]
        ])->get();

        $count = $demandes->count();
        return $count;

    }

    //eleve
    function showCountTableEleve($nomEleve, $postNomEleve, $preNomEleve)
    {
      $data = DB::table("eleves")
      ->where([
        ['eleves.nomEleve', $nomEleve],
        ['eleves.postNomEleve', $postNomEleve],
        ['eleves.preNomEleve', $preNomEleve]
      ])
      ->count();
      return $data;
    }

     //inscription
    function showCountTableInscription($idEleve, $idAnne, $idClasse)
    {
      $data = DB::table("inscriptions")
      ->where([
        ['inscriptions.idEleve', $idEleve],
        ['inscriptions.idAnne', $idAnne],
        ['inscriptions.idClasse', $idClasse]
      ])
      ->count();
      return $data;
    }

     //presence
    function showCountTablePresence($idInscription, $created_at)
    {
      $data = DB::table("presences")
      ->where([
        ['presences.idInscription', $idInscription],
        ['presences.created_at', '>=',$created_at],
      ])
      ->count();
      return $data;
    }

      //presence
    function showCountTablePresenceOffQrcode($idInscription, $created_at)
    {
      $data = DB::table("presences")
      ->where([
        ['presences.idInscription', $idInscription],
        ['presences.date_entree',$created_at],
      ])
      ->count();
      return $data;
    }

    //get idiscription 
     function getIdInscription($codeInscription)
    {
      $data = DB::table("inscriptions")
      ->where([
        ['inscriptions.codeInscription', $codeInscription],
      ])
      ->take(1)
      ->get();
      $idInscription;
      foreach ($data as $row) {
          // code...
        $idInscription = $row->id;
      }
      return $idInscription;
    }


    function getAnneScolaireActive(){
        $data = DB::table('anne_scollaires')
        ->select("anne_scollaires.id",
            "anne_scollaires.designation","anne_scollaires.statut",
            "anne_scollaires.created_at")
        ->where('anne_scollaires.statut', 1)
        ->orderBy("anne_scollaires.statut", "desc")
        ->take(1)
        ->get();
        $idAnnee;
        foreach ($data as $row) {
            // code...
            $idAnnee = $row->id;

        }

        return $idAnnee;

    }

    //pour le paiement 
    function showCountTablePrevision($idTranche,$idFrais, $idAnne, $idClasse)
    {
      $data = DB::table("previsions")
      ->where([
        ['previsions.idTranche', $idTranche],
        ['previsions.idFrais', $idFrais],
        ['previsions.idAnne', $idAnne],
        ['previsions.idClasse', $idClasse]
      ])
      ->count();
      return $data;
    }

     //pour le paiement 
    function showCountTableClauture($refMois, $idAnne, $idClasse)
    {
      $data = DB::table("clautures")
      ->where([
        ['clautures.refMois', $refMois],
        ['clautures.idAnne', $idAnne],
        ['clautures.idClasse', $idClasse]
      ])
      ->count();
      return $data;
    }



     /*
    *
    *=========================================
    *Pour les configurations de l'application
    *=========================================
    *
    */



    function getEmailSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->email;
        }
        return strtoupper($info);
    }

    function getTokenSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->token;
        }
        return strtoupper($info);
    }

    function getNumDevSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->tel3;
        }
        return strtoupper($info);
    }


    function getLogoSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->logo;
        }
        return $info;
    }
    function getNomSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->nom;
        }
        return strtoupper($info);
    }

    function getAdresseSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->adresse;
        }
        return $info;
    }


    function displayImg($schema, $file)
    {
        $logo=base_path('public/'.$schema.'/'.$file);
        $f=file_get_contents($logo);
        $pic='data:image/png;base64,'.base64_encode($f);
        return $pic;
    }

    function displayImgDynamique($avatar)
    {
        $logo=base_path('public/storage/'.$avatar);
        $f=file_get_contents($logo);
        $pic='data:image/png;base64,'.base64_encode($f);
        return $pic;
    }


    //gerate qrcode
    public function generateQrcode($text) {

        $qrc = QrCode::size(100)->generate($text);
        $qrcode='<img src="data:image/svg+xml;base64,'.base64_encode($qrc).'"
        style="
            margin-bottom: 1px;
            border-radius: 2px 2px 0 0;
            overflow: hidden;
            width : 100vw;
            height : 100vh;
            max-width : 140px;
            max-height : 140px;
        "
        >';
        return $qrcode;
    }

    //gerate qrcode
    public function generateQrcodeTiquet($text) {

        $qrc = QrCode::size(100)->generate($text);
        $qrcode='<img src="data:image/svg+xml;base64,'.base64_encode($qrc).'"
        style="
            margin-bottom: 1px;
            border-radius: 2px 2px 0 0;
            overflow: hidden;
            width : 100vw;
            height : 100vh;
            max-width : 120px;
            max-height : 120px;
        "
        >';
        return $qrcode;
    }

    public function generateQrcodeTiquetCard($text) {

        $qrc = QrCode::size(100)->generate($text);
        $qrcode='<img src="data:image/svg+xml;base64,'.base64_encode($qrc).'"
        style="
            margin-bottom: 1px;
            border-radius: 2px 2px 0 0;
            overflow: hidden;
            width : 100vw;
            height : 100vh;
            max-width : 110px;
            max-height : 110px;
        "
        >';
        return $qrcode;
    }

    /*
    *
    *=====================================
    *COonversion d'un nombre en chiffre
    *=====================================
    *
    */

    function chiffreEnLettre($a)
    {
        $convert = explode('.',$a);
        if (isset($convert[1]) && $convert[1]!=''){
        return $this->chiffreEnLettre($convert[0]).' Virgule '.'  '.$this->chiffreEnLettre($convert[1]).' Centimes' ;
        }
        if ($a<0) return 'moins '.$this->chiffreEnLettre(-$a);
        if ($a<17){
        switch ($a){
        case 0: return 'Zero';
        case 1: return 'Un';
        case 2: return 'Deux';
        case 3: return 'Trois';
        case 4: return 'Quatre';
        case 5: return 'Cinq';
        case 6: return 'Six';
        case 7: return 'Sept';
        case 8: return 'Huit';
        case 9: return 'Neuf';
        case 10: return 'Dix';
        case 11: return 'Onze';
        case 12: return 'Douze';
        case 13: return 'Treize';
        case 14: return 'Quatorze';
        case 15: return 'Quinze';
        case 16: return 'Seize';

        case 17: return 'Dix-sept';
        case 18: return 'Dix-huit';
        case 19: return 'Dix-neuf';

        }
        } else if ($a<20){
        return 'dix-'.$this->chiffreEnLettre($a-10);
        } else if ($a<100){
        if ($a%10==0){
        switch ($a){
        case 20: return 'Vingt';
        case 30: return 'Trente';
        case 40: return 'Quarante';
        case 50: return 'Cinquante';
        case 60: return 'Soixante';
        case 70: return 'Soixante-dix';
        case 80: return 'Quatre-vingt';
        case 90: return 'Quatre-vingt-dix';
        }
        } elseif (substr($a, -1)==1){
        if( ((int)($a/10)*10)<70 ){
        return $this->chiffreEnLettre((int)($a/10)*10).'-et-un';
        } elseif ($a==71) {
        return 'Soixante-et-onze';
        } elseif ($a==81) {
        return 'Quatre-vingt-un';
        } elseif ($a==91) {
        return 'Quatre-vingt-onze';
        }
        } elseif ($a<70){
        return $this->chiffreEnLettre($a-$a%10).'-'.$this->chiffreEnLettre($a%10);
        } elseif ($a<80){
        return $this->chiffreEnLettre(60).'-'.$this->chiffreEnLettre($a%20);
        } else{
        return $this->chiffreEnLettre(80).'-'.$this->chiffreEnLettre($a%20);
        }
        } else if ($a==100){
        return 'Cent';
        } else if ($a<200){
        return $this->chiffreEnLettre(100).' '.$this->chiffreEnLettre($a%100);
        } else if ($a<1000){
        return $this->chiffreEnLettre((int)($a/100)).' '.$this->chiffreEnLettre(100).' '.$this->chiffreEnLettre($a%100);
        } else if ($a==1000){
        return 'Mille';
        } else if ($a<2000){
        return $this->chiffreEnLettre(1000).' '.$this->chiffreEnLettre($a%1000).' ';
        } else if ($a<1000000){
        return $this->chiffreEnLettre((int)($a/1000)).' '.$this->chiffreEnLettre(1000).' '.$this->chiffreEnLettre($a%1000);
        }
        else if ($a==1000000){
        return 'Millions';
        }
        else if ($a<2000000){
        return $this->chiffreEnLettre(1000000).' '.$this->chiffreEnLettre($a%1000000).' ';
        }
        else if ($a<1000000000){
        return $this->chiffreEnLettre((int)($a/1000000)).' '.$this->chiffreEnLettre(1000000).' '.$this->chiffreEnLettre($a%1000000);
        }
    }

    /*
    *
    *==========================
    * printer
    *==========================
    *
    */

    function entetePrintPDF($text1, $text2, $text3)
    {
        $output = '';
        $nomSite = $this->getNomSite();
        $logordc = $this->displayImg('images', 'rdc.png');
        $logodgrpi = $this->displayImg('images', 'armoirie.png');
        $logoSite =$this->displayImg('images', $this->getLogoSite());

        $etat='';
        if ($text3 !='') {
            // code...
            $etat .='
               <div style="background-color:#0080FF; color:white; text-align:center;">

                    <h2 style="padding:5px;">'.$text3.'</h2>
                    
                </div>
            <br>
            ';

        } else {
            $etat='';
        }


        $output .='

        <table width="100%" border="0" cellspacing="0" cellpadding="1" >
            <tr>
                <td width="25%" align="right">
                    <img src="'.$logordc.'"   style="margin-top: 15px;
                        margin-bottom: 5px;
                        border-radius: 10px 10px 10px 10px;
                        overflow: hidden;
                        width : 100vw;
                        height : 100vh;
                        max-width : 80px;
                        max-height : 80px;
                        margin-right:60px;

                    " />
                </td>
                <td width="50%">
                    <div style="width:100%;font-weight:bold; text-align: center;">

                        <span style="left:16.9744em;top:3.5092em;font-size:15px;">
                            '.$text1.'
                        </span>

                       <div style="text-align: center; left:16.9744em;top:3.5092em;font-size:11px;">
                        '.$text2.' 
                        </div>

                        
                    </div>



                </td>
                <td width="25%">
                    <img src="'.$logodgrpi.'"  style="margin-top: 15px;
                        margin-bottom: 5px;
                        border-radius: 10px 10px 0 0;
                        overflow: hidden;
                        width : 100vw;
                        height : 100vh;
                        max-width : 80px;
                        max-height : 80px;
                        margin-left:60px;
                    " />
                </td>
            </tr>
        </table>
        '.$etat.'
        ';
        return $output;
    }


    /*
    *
    * ========================
    * Sommation de paiement
    * ========================
    */

    function getSumMontantApayer($idClasse, $idOption, $idAnne){
        $somme = DB::table("previsions")
        ->where([
            ['previsions.idClasse', $idClasse],
            ['previsions.idOption', $idOption],
            ['previsions.idAnne', $idAnne],
        ])
        ->sum("previsions.montant");

        return $somme;

    }

    function getSumMontantPayerEleve($idInscription){
        $somme = DB::table("paiements")
        ->where([
            ['paiements.idInscription', $idInscription],
            ['paiements.etatPaiement', 1]
        ])
        ->sum("paiements.montant");

        return $somme;
    }

    function getNomEleve($idInscription){
        $data = DB::table('inscriptions')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->selectRaw("(CONCAT(nomEleve,' ', postNomEleve,' ', preNomEleve)) as noms")
        ->where([
            ['inscriptions.id', $idInscription]
        ])
        ->take(1)
        ->get();

        $noms ='';
        foreach ($data as $row) {
            $noms =$row->noms;
        }
        return $noms;
    }

    function getClasseEleve($idInscription){
        $data = DB::table('inscriptions')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->select("classes.nomClasse")
        ->where([
            ['inscriptions.id', $idInscription]
        ])
        ->take(1)
        ->get();

        $nomClasse ='';
        foreach ($data as $row) {
            $nomClasse =$row->nomClasse;
        }
        return $nomClasse;
    }
 

    function getOptionEleve($idInscription){
        $data = DB::table('inscriptions')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        ->select("options.nomOption")
        ->where([
            ['inscriptions.id', $idInscription]
        ])
        ->take(1)
        ->get();

        $nomOption ='';
        foreach ($data as $row) {
            $nomOption =$row->nomOption;
        }
        return $nomOption;
    }

    function showSumMontantPayerParClasse($idAnne, $idOption, $idSection, $idClasse)
    {
        $somme = DB::table("previsions")
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
        ->sum("previsions.montant");

        return $somme;
    }
    /*
    *
    *============================
    * Nom promotion par id
    *============================
    *
    */
    function getPromotionAnnee($id)
    {
        $data = DB::table("anne_scollaires")
        ->select("anne_scollaires.id",
            "anne_scollaires.designation","anne_scollaires.statut",
            "anne_scollaires.created_at")
        ->where([
            ['anne_scollaires.id', $id],
        ])
        ->take(1)
        ->get();

        $nomPromotion ='';

        foreach ($data as $row) {
            // code...
            $nomPromotion =$row->designation;
        }

        return $nomPromotion;
    }

    function getPromotionOption($id)
    {
        $data = DB::table("options")
        ->join('sections','sections.id','=','options.idSection')
        ->select("options.id",
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            "options.created_at")
        ->where([
            ['options.id', $id],
        ])
        ->take(1)
        ->get();

        $nomPromotion ='';

        foreach ($data as $row) {
            // code...
            $nomPromotion =$row->nomOption;
        }

        return $nomPromotion;
    }

    function getPromotionClasse($id)
    {
        $data = DB::table("classes")
        ->select("classes.id", "classes.nomClasse", "classes.created_at")
        ->where([
            ['classes.id', $id],
        ])
        ->take(1)
        ->get();

        $nomPromotion ='';

        foreach ($data as $row) {
            // code...
            $nomPromotion =$row->nomClasse;
        }

        return $nomPromotion;
    }

    function getPromotionSection($id)
    {
        $data = DB::table("sections")
        ->select("sections.id", "sections.nomSection", "sections.created_at")
        ->where([
            ['sections.id', $id],
        ])
        ->take(1)
        ->get();

        $nomPromotion ='';

        foreach ($data as $row) {
            // code...
            $nomPromotion =$row->nomSection;
        }

        return $nomPromotion;
    }

    function getPromotionPeriode($id)
    {
        $data = DB::table("periodes")
        ->select("periodes.id", "periodes.nomPeriode","periodes.statutPeriode", "periodes.created_at")
        ->where([
            ['periodes.id', $id],
        ])
        ->take(1)
        ->get();

        $nomPeriode ='';

        foreach ($data as $row) {
            // code...
            $nomPeriode =$row->nomPeriode;
        }

        return $nomPeriode;
    }


    /*
    *
    *============================
    * Fin Nom promotion par id
    *============================
    *
    */

     /*
    *
    *=================================
    * Gestion de recettes et depenses
    *=================================
    *
    */

    function getTauxDujour()
    {
        $data = DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
        ->take(1)
        ->get();
        $taux = 0;
        foreach ($data as $row) {
            $taux= $row->taux;
        }

        return $taux;
    }

    function getNomEnseignant($idEnseignant)
    {
        //
        $data = DB::table("enseignants")
        ->join('avenues','avenues.id','=','enseignants.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        ->select("enseignants.id",
            //enseignants 
            'enseignants.idAvenue','enseignants.nomEns',
            'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
            'enseignants.telEns','enseignants.tel2Ens',
            'enseignants.sexeEns','enseignants.etatcivilEns',
            'enseignants.prefEns','enseignants.degreprefEns',
            'enseignants.telprefEns','enseignants.codeEns',
            'enseignants.numCarteEns','enseignants.passwordEns',
            'enseignants.imageEns',
            'enseignants.numMaisonEns', 'enseignants.dateNaisEns',
             //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',

            "enseignants.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
        ->where('enseignants.id', $idEnseignant)->take(1)->get();
        $nom='';
        foreach ($data as $row) {
            // code...
            $nom = $row->nomEns;
        }

        return $nom;
        
    }

    function getMention($PourcentageEleve)
    {
        $mention ='';
        if ($PourcentageEleve<50) {
            // code...
            $mention = "Echouant";
        }elseif ($PourcentageEleve>=50 && $PourcentageEleve<=59) {
            $mention = "AB";
        }elseif ($PourcentageEleve>=60 && $PourcentageEleve<=69) {
            $mention = "B";
        }elseif ($PourcentageEleve>=70 && $PourcentageEleve<=79) {
            $mention = "TB";
        }elseif ($PourcentageEleve>=80 && $PourcentageEleve<=89) {
           $mention = "Excellent";
        }elseif ($PourcentageEleve>=90 && $PourcentageEleve<=99) {
            $mention = "Très Excellent";
        } else {
            // code...
            $mention = "Ras";
        }

        return $mention;
        
    }



    







}




?>