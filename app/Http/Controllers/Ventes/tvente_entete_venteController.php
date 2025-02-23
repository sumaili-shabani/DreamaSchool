<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_vente;
use App\Models\Ventes\tvente_detail_vente;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_entete_venteController extends Controller
{
    use GlobalMethod, Slug;
    //vEnteteEntree
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    { 

        $data = DB::table('tvente_entete_vente')
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

        ->select('tvente_entete_vente.id','refClient','dateVente','libelle',
        'tvente_entete_vente.author','tvente_entete_vente.created_at',
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
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('IFNULL(tvente_entete_vente.montant,0) as totalFacture')
        ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
        ->selectRaw('(IFNULL(tvente_entete_vente.montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.preNomEleve', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_vente.created_at", "desc");

            return $this->apiData($data->paginate(10));          

        }
        $data->orderBy("tvente_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
       
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_vente')
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

        ->select('tvente_entete_vente.id','refClient','dateVente','libelle',
        'tvente_entete_vente.author','tvente_entete_vente.created_at',
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
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('IFNULL(tvente_entete_vente.montant,0) as totalFacture')
        ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
        ->selectRaw('(IFNULL(tvente_entete_vente.montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.preNomEleve', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }   


    function fetch_single_data($id)
    {

        $data = DB::table('tvente_entete_vente')
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

        ->select('tvente_entete_vente.id','refClient','dateVente','libelle',
        'tvente_entete_vente.author','tvente_entete_vente.created_at',
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
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('IFNULL(tvente_entete_vente.montant,0) as totalFacture')
        ->selectRaw('IFNULL(tvente_entete_vente.paie,0) as totalPaie')
        ->selectRaw('(IFNULL(tvente_entete_vente.montant,0)-IFNULL(tvente_entete_vente.paie,0)) as RestePaie')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as noms")
        ->where('tvente_entete_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'id','refClient','dateVente','libelle','author'
    function insert_data(Request $request)
    {
       
        $data = tvente_entete_vente::create([
            'refClient'       =>  $request->refClient,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tvente_entete_vente::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data2 = tvente_detail_vente::where('refEnteteVente',$id)->delete();
        $data = tvente_entete_vente::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
