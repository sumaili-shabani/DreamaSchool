<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_entree;
use App\Models\Ventes\tvente_detail_entree;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_entete_entreeController extends Controller
{

    use GlobalMethod, Slug;

    // protected $fillable=['id','refFournisseur','dateEntree','libelle','author'];
    // protected $table = 'tvente_entete_entree';
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

        $data = DB::table('tvente_entete_entree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_entete_entree.id','noms','contact','mail','adresse','dateEntree',
        'libelle','montant','tvente_entete_entree.author','tvente_entete_entree.created_at');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_entree.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 
        $data = DB::table('tvente_entete_entree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_entete_entree.id','noms','contact','mail','adresse','dateEntree',
        'libelle','montant','tvente_entete_entree.author','tvente_entete_entree.created_at')
        ->Where('refFournisseur',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_entree.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    function fetch_list_fournisseur()
    {
        $data = DB::table('tvente_fournisseur')->select("tvente_fournisseur.id","tvente_fournisseur.noms")->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_entete_entree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_entete_entree.id','noms','contact','mail','adresse','dateEntree',
        'libelle','montant','tvente_entete_entree.author', 'tvente_entete_entree.refFournisseur', 'tvente_entete_entree.created_at')
        ->where('tvente_entete_entree.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //id,refFournisseur,dateEntree,libelle,author
    function insert_data(Request $request)
    {       
        $data = tvente_entete_entree::create([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateEntree'    =>  $request->dateEntree,
            'libelle'    =>  $request->libelle,
            'montant'    =>  0,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tvente_entete_entree::where('id', $id)->update([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateEntree'    =>  $request->dateEntree,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data2 = tvente_detail_entree::where('refEnteteEntree',$id)->delete();
        $data = tvente_entete_entree::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
