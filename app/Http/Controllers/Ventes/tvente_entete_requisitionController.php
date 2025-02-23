<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_requisition;
use App\Models\Ventes\tvente_detail_requisition;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_entete_requisitionController extends Controller
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

    public function all(Request $request)
    { 

        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
        'libelle','montant','tvente_entete_requisition.author','tvente_entete_requisition.created_at');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_requisition.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
        'libelle','montant','tvente_entete_requisition.author','tvente_entete_requisition.created_at')
        ->Where('refFournisseur',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_requisition.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    


  

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
        'libelle','montant','tvente_entete_requisition.author','tvente_entete_requisition.refFournisseur','tvente_entete_requisition.created_at')
        ->where('tvente_entete_requisition.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    //montant
    function insert_data(Request $request)
    {       
        $data = tvente_entete_requisition::create([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateCmd'    =>  $request->dateCmd,
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
        $data = tvente_entete_requisition::where('id', $id)->update([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateCmd'    =>  $request->dateCmd,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data2 = tvente_detail_requisition::where('refEnteteCmd',$id)->delete();
        $data = tvente_entete_requisition::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
