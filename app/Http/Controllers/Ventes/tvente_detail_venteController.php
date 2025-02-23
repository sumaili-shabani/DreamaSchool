<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_vente;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tvente_detail_venteController extends Controller
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
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.preNomEleve', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_vente.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
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
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.preNomEleve', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('tvente_detail_vente')
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
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")           
        ->where('tvente_detail_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
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
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
        ->Where('tvente_detail_vente.refEnteteVente',$id)               
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {        
        $taux=0.00;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get();
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0.00;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }
        //,'unite_paquet','puPaquet','qtePaquet'
        $unite_paquet='';
        $puPaquet=0.00;
        $qtePaquet=0.00;
        
        $qteDisponible=0;
        $qte=0.00;
        $qte_unite =0.00;
        $paquets=$request->paquets;
        $idProduit=$request->refProduit;  

        $qtePaquet=0.00;
        $prix_unitairesPacquet=0.00;
        
        $prix_unitaires=0.00;

        $unite_mesure = '';

        $data23 =   DB::table('tvente_produit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        
        ->select("tvente_produit.id","tvente_produit.designation as designation","refCategorie",
        "pu","unite","devise","qte","qte_unite","tvente_categorie_produit.designation as Categorie")
        ->where([
           ['tvente_produit.id','=', $idProduit]
       ])    
        ->get(); 
        $output='';
        foreach ($data23 as $row) 
        {                                
           $qte_unite=$row->qte_unite;  
           $unite_mesure=$row->unite;   
           $qteDisponible=$row->qte;                     
        }

        if($paquets == 'Par Pièce' || $paquets == 'Par Kilo')
        {
            if($unite_mesure != 'Paquet')
            {
                $qte=  round($request->qteVente, 2);
                $prix_unitaires = round((floatval($montants)) , 2);

                $unite_paquet = $paquets;
                $puPaquet = $prix_unitaires;
                $qtePaquet = $qte;
            }
            else
            {
                $qte=round((floatval($request->qteVente)), 2);
                $prix_unitaires = round( (floatval($montants)) , 2);

                $unite_paquet = $paquets;
                $puPaquet = round( (floatval($montants) * floatval($qte_unite)) , 2);
                $qtePaquet = round((floatval($request->qteVente) / floatval($qte_unite)), 2);
            }
                
            //}            
        }
        else if($paquets == 'Par Paquet')
        {
            if(floatval($qte_unite) > 1){
                $qte = round((floatval($request->qteVente) * floatval($qte_unite)), 2);
                $prix_unitaires = round((floatval($montants) / floatval($qte_unite)), 2);

                $qtePaquet=$qte;
                $prix_unitairesPacquet=$prix_unitaires;


                $unite_paquet = $paquets;
                $puPaquet = round(floatval($montants), 2);
                $qtePaquet = round(floatval($request->qteVente), 2);
            }            
        }

        $idDetail=$request->refProduit;
        $idFacture=$request->refEnteteVente;

        // if(floatval($qteDisponible) <= $qte){
            
            $data = tvente_detail_vente::create([
                'refEnteteVente'       =>  $request->refEnteteVente,
                'refProduit'    =>  $request->refProduit,
                'puVente'    =>  $prix_unitaires,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'qteVente'    =>  $qte,
                'unite_paquet'    =>  $unite_paquet,
                'puPaquet'    =>  $puPaquet,
                'qtePaquet'    =>  $qtePaquet,
                'author'       =>  $request->author
            ]);
    
            if($paquets == 'Par Paquet')
            {
                $data2 = DB::update(
                    'update tvente_produit set qte = qte - :qteVente where id = :refProduit',
                    ['qteVente' => $qte,'refProduit' => $idDetail]
                );
                $data3 = DB::update(
                    'update tvente_entete_vente set montant = montant + (:pu * :qte) where id = :refEnteteVente',
                    ['pu' => $prix_unitaires,'qte' => $qte,'refEnteteVente' => $idFacture]
                );
            }
    
            else if($paquets == 'Par Pièce' || $paquets == 'Par Kilo')
            {
                $data2 = DB::update(
                    'update tvente_produit set qte = qte - :qteVente where id = :refProduit',
                    ['qteVente' => $qte,'refProduit' => $idDetail]
                );
    
                $data3 = DB::update(
                    'update tvente_entete_vente set montant = montant + (:pu * :qte) where id = :refEnteteVente',
                    ['pu' => $prix_unitaires,'qte' => $qte,'refEnteteVente' => $idFacture]
                );
            }   
    
            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
    
        // }
        // else
        // {
        //      return response()->json([
        //          'data'  =>  "La quantité demandée est supérieur à la quantité disponible en stock !!!",
        //      ]);
        // }
       
    }

    function update_data(Request $request, $id)
    {

        $taux=0.00;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0.00;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }

        $unite_paquet='';
        $puPaquet=0.00;
        $qtePaquet=0.00;

        $qte=0.00;
        $qte_unite =0.00;
        $paquets=$request->paquets;
        $idProduit=$request->refProduit;  
        
        $prix_unitaires=0.00;

        $data23 =   DB::table('tvente_produit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        
        ->select("tvente_produit.id","tvente_produit.designation as designation","refCategorie",
        "pu","unite","devise","qte","qte_unite","tvente_categorie_produit.designation as Categorie")
        ->where([
           ['tvente_produit.id','=', $idProduit]
       ])    
        ->get(); 
        $output='';
        foreach ($data23 as $row) 
        {                                
           $qte_unite=$row->qte_unite;                          
        }

        if($paquets == 'Par Pièce' || $paquets == 'Par Kilo')
        {
            if(floatval($qte_unite) <= 1){
                $qte=$request->qteVente;
                $prix_unitaires = (floatval($montants));

                $unite_paquet = $paquets;
                $puPaquet = $prix_unitaires;
                $qtePaquet = $qte;
            }            
        }
        else if($paquets == 'Par Paquet')
        {
            if(floatval($qte_unite) > 1){
                $qte=(floatval($request->qteVente) * floatval($qte_unite));
                $prix_unitaires = (floatval($montants) / floatval($qte_unite));

                $unite_paquet = $paquets;
                $puPaquet = floatval($montants);
                $qtePaquet = floatval($request->qteVente);
            }            
        }

        $data = tvente_detail_vente::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $request->refProduit,
            'puVente'    =>  $prix_unitaires,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteVente'    =>  $qte,
            'unite_paquet'    =>  $unite_paquet,
            'puPaquet'    =>  $puPaquet,
            'qtePaquet'    =>  $qtePaquet,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $qte=0.00;
        $idDetail=0;
        $idFacture=0;
        $montants=0.00;

        $deleteds = DB::table('tvente_detail_vente')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteVente;
            $idDetail = $deleted->refProduit;
            $idFacture = $deleted->refEnteteVente;
            $montants = $deleted->puVente;
        }

        $data2 = DB::update(
            'update tvente_produit set qte = qte + :qteVente where id = :refProduit',
            ['qteVente' => $qte,'refProduit' => $idDetail]
        );

        $data3 = DB::update(
            'update tvente_entete_vente set montant = montant - (:pu * :qte) where id = :refEnteteVente',
            ['pu' => $montants,'qte' => $qte,'refEnteteVente' => $idFacture]
        );

        $data = tvente_detail_vente::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
