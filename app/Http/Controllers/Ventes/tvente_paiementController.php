<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_paiement;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tvente_paiementController extends Controller
{
    use GlobalMethod, Slug;
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    //'id','refEnteteVente','refProduit','puVente','qteVente','author'
    //'id','refClient','dateVente','libelle','author'

    public function all(Request $request)
    { 

        $data = DB::table('tvente_paiement')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
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


        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select('tvente_paiement.id','refEnteteVente','montant_paie','date_paie',
        'libelle','tvente_paiement.author','tvente_paiement.created_at',
        'tvente_paiement.devise','tvente_paiement.taux',
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",
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
        ->selectRaw('((montant_paie)/tvente_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_paiement.id) as codeRecu')
        ->selectRaw("CONCAT(eleves.nomEleve,' ', eleves.postNomEleve,' ',eleves.preNomEleve) as noms");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.preNomEleve', 'like', '%'.$query.'%')          
            ->orderBy("tvente_paiement.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_paiement.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_paiement')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
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


        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select('tvente_paiement.id','refEnteteVente','montant_paie','date_paie',
        'libelle','tvente_paiement.author','tvente_paiement.created_at',
        'tvente_paiement.devise','tvente_paiement.taux',
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",
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
        ->selectRaw('((montant_paie)/tvente_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_paiement.id) as codeRecu')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nomEleve', 'like', '%'.$query.'%')          
            ->orderBy("tvente_paiement.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_paiement.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('tvente_paiement')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
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


        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select('tvente_paiement.id','refEnteteVente','montant_paie','date_paie',
        'libelle','tvente_paiement.author','tvente_paiement.created_at',
        'tvente_paiement.devise','tvente_paiement.taux',
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",
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
        ->selectRaw('((montant_paie)/tvente_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_paiement.id) as codeRecu')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
        ->where('tvente_paiement.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //'refEnteteVente','montant_paie','date_paie'
    function insert_data(Request $request)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_paie)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
       {
        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }
        // 

        $idFacture=$request->refEnteteVente;

        $data = tvente_paiement::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'author'       =>  $request->author
        ]);

        $data3 = DB::update(
            'update tvente_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
            ['paiement' => $montants,'refEnteteVente' => $idFacture]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

       }



    }

    function update_data(Request $request, $id)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_paie)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
       {
        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }


        $data = tvente_paiement::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

       }
    }

    function delete_data($id)
    {
        $idFacture=0;
        $montants=0;

        $deleteds = DB::table('tvente_paiement')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteVente;
            $montants = $deleted->montant_paie;
        }
        $data3 = DB::update(
            'update tvente_entete_vente set paie = paie - (:paiement) where id = :refEnteteVente',
            ['paiement' => $montants,'refEnteteVente' => $idFacture]
        );

        $data = tvente_paiement::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
