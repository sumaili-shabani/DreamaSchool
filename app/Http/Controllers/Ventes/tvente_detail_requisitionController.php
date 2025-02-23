<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_requisition;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tvente_detail_requisitionController extends Controller
{

    use GlobalMethod, Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 

        $data = DB::table('tvente_detail_requisition')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
        'qteCmd','noms','contact','mail','adresse','dateCmd',
        'libelle','montant as TotalCmd',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_requisition.author',
        'tvente_detail_requisition.created_at','tvente_detail_requisition.devise','tvente_detail_requisition.taux')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('((qteCmd*puCmd) * tvente_detail_requisition.taux) as PTCmdFC')
        ->selectRaw('((montant) * tvente_detail_requisition.taux) as TotalCmdFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_requisition.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_requisition')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
        'qteCmd','noms','contact','mail','adresse','dateCmd',
        'libelle','montant as TotalCmd',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_requisition.author',
        'tvente_detail_requisition.created_at','tvente_detail_requisition.devise','tvente_detail_requisition.taux')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('((qteCmd*puCmd)  * tvente_detail_requisition.taux) as PTCmdFC')
        ->selectRaw('((montant) * tvente_detail_requisition.taux) as TotalCmdFC')
        ->Where('refEnteteCmd',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_requisition.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    




    function fetch_single_data($id)
    {
        $data = DB::table('tvente_detail_requisition')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
        'qteCmd','noms','contact','mail','adresse','dateCmd',
        'libelle','montant as TotalCmd',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_requisition.author',
        'tvente_detail_requisition.created_at','tvente_entete_requisition.refFournisseur','tvente_detail_requisition.devise','tvente_detail_requisition.taux')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('((qteCmd*puCmd) * tvente_detail_requisition.taux) as PTCmdFC')
        ->selectRaw('((montant) * tvente_detail_requisition.taux) as TotalCmdFC')
        ->where('tvente_detail_requisition.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //fetch_detail_requisition_log
    //fetch_detail_requisition_vente

    function fetch_detail_requisition_vente($id)
    {
        $data = DB::table('tvente_detail_requisition')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
        'qteCmd','noms','contact','mail','adresse','dateCmd',
        'libelle','montant as TotalCmd',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_requisition.author',
        'tvente_detail_requisition.created_at','tvente_detail_requisition.devise','tvente_detail_requisition.taux')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('((qteCmd*puCmd) * tvente_detail_requisition.taux) as PTCmdFC')
        ->selectRaw('((montant) * tvente_detail_requisition.taux) as TotalCmdFC')
        ->Where('tvente_detail_requisition.refEnteteCmd',$id)               
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    } 
   //id,refEnteteCmd,refProduit,dateExpiration,numeroLot,puCmd,qteCmd,author
   
    function insert_data(Request $request)
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
            $montants = ($request->puCmd)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puCmd;
            $devises = $request->devise;
        }



        $data = tvente_detail_requisition::create([
            'refEnteteCmd'       =>  $request->refEnteteCmd,
            'refProduit'    =>  $request->refProduit,
            'puCmd'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteCmd'    =>  $request->qteCmd,
            'author'       =>  $request->author
        ]);

        $data3 = DB::update(
            'update tvente_entete_requisition set montant = montant + (:pu * :qte) where id = :refEnteteCmd',
            ['pu' => $montants,'qte' => $request->qteCmd,'refEnteteCmd' => $request->refEnteteCmd]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function update_data(Request $request, $id)
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
            $montants = ($request->puCmd)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puCmd;
            $devises = $request->devise;
        }

        $data = tvente_detail_requisition::where('id', $id)->update([
            'refEnteteCmd'       =>  $request->refEnteteCmd,
            'refProduit'    =>  $request->refProduit,
            'puCmd'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteCmd'    =>  $request->qteCmd,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $qte=0;
        $idDetail=0;
        $montants=0;
        $refEnteteCmd=0;
        $deleteds = DB::select('select qteCmd,refProduit,puCmd,refEnteteCmd from tvente_detail_requisition'); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteCmd;
            $idDetail = $deleted->refProduit;
            $montants = $deleted->puCmd;
            $refEnteteCmd = $deleted->refEnteteCmd;
        }       
        $data3 = DB::update(
            'update tvente_entete_requisition set montant = montant - (:pu * :qte) where id = :refEnteteCmd',
            ['pu' => $montants,'qte' => $qte,'refEnteteCmd' => $refEnteteCmd]
        );

        $data = tvente_detail_requisition::where('id',$id)->delete();              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }
}
