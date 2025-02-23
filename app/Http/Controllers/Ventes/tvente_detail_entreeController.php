<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_entree;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tvente_detail_entreeController extends Controller
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
    //'id','refEnteteEntree','refProduit','puEntree','qteEntree','author'

    public function all(Request $request)
    { 

        $data = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','noms','contact','mail',
        'adresse','dateEntree',
        'libelle','montant as TotalEntree',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_entree.author',
        'tvente_detail_entree.created_at','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'unite_paquet','puPaquet','qtePaquet')
        ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
        (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END)) as PTEntree")
        ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
        (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END))*tvente_detail_entree.taux) as PTEntreeFC")
        ->selectRaw("((montant) * tvente_detail_entree.taux) as TotalEntreeFC")

        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END) as puEntree")
        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) as qteEntree");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_entree.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','noms','contact','mail',
        'adresse','dateEntree',
        'libelle','montant as TotalEntree',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_entree.author',
        'tvente_detail_entree.created_at','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'unite_paquet','puPaquet','qtePaquet')
        ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
        (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END)) as PTEntree")
        ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
        (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END))*tvente_detail_entree.taux) as PTEntreeFC")
        ->selectRaw("((montant) * tvente_detail_entree.taux) as TotalEntreeFC")

        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END) as puEntree")
        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) as qteEntree")
        ->Where('refEnteteEntree',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_entree.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    //mes scripts
      

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','noms','contact','mail',
        'adresse','dateEntree',
        'libelle','montant as TotalEntree',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_entree.author',
        'tvente_detail_entree.created_at','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'unite_paquet','puPaquet','qtePaquet')
        ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
        (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END)) as PTEntree")
        ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
        (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END))*tvente_detail_entree.taux) as PTEntreeFC")
        ->selectRaw("((montant) * tvente_detail_entree.taux) as TotalEntreeFC")

        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END) as puEntree")
        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) as qteEntree")
        ->where('tvente_detail_entree.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


 
    function fetch_detail_appro_vente($id)
    {
        $data = DB::table('tvente_detail_entree')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')
        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','noms','contact','mail',
        'adresse','dateEntree',
        'libelle','montant as TotalEntree',"tvente_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tvente_detail_entree.author',
        'tvente_detail_entree.created_at','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'unite_paquet','puPaquet','qtePaquet')
        ->selectRaw("((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
        (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END)) as PTEntree")
        ->selectRaw("(((CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) * 
        (CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END))*tvente_detail_entree.taux) as PTEntreeFC")
        ->selectRaw("((montant) * tvente_detail_entree.taux) as TotalEntreeFC")

        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.puEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.puPaquet END) as puEntree")
        ->selectRaw("(CASE WHEN (unite_paquet = 'Par Pièce') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Kilo') THEN tvente_detail_entree.qteEntree 
        WHEN (unite_paquet = 'Par Paquet') THEN tvente_detail_entree.qtePaquet END) as qteEntree")
        ->Where('tvente_detail_entree.refEnteteEntree',$id)               
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    } 

    function fetch_total_appro_vente($id)
    {
        $data = DB::table('tvente_detail_entree')        
        ->select(DB::raw('ROUND(SUM(qteEntree*puEntree),0) as TotalEntree'))
        ->select(DB::raw('ROUND(SUM(((qteEntree*puEntree)/tvente_detail_entree.taux)),0) as TotalEntreeFC'))
        ->Where('tvente_detail_entree.refEnteteEntree',$id)               
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
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0.00;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puEntree)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puEntree;
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
        $qtePaquet=0.00;
        $prix_unitairesPacquet=0.00;

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
        }


        if($paquets == 'Par Pièce' || $paquets == 'Par Kilo')
        {
            if($unite_mesure != 'Paquet'){
                $qte=$request->qteEntree;
                $prix_unitaires = (floatval($montants));

                $unite_paquet = $paquets;
                $puPaquet = $prix_unitaires;
                $qtePaquet = $qte;
            }
            else
            {

                $qte=round((floatval($request->qteEntree)), 2);
                $prix_unitaires = round( (floatval($montants)) , 2);

                $unite_paquet = 'Par Paquet';
                $puPaquet = round( (floatval($montants) * floatval($qte_unite)) , 2);
                $qtePaquet = round((floatval($request->qteEntree) / floatval($qte_unite)), 2);
            }
            
        }
        else if($paquets == 'Par Paquet')
        {
            if(floatval($qte_unite) > 1){
                $qte=round((floatval($request->qteEntree) * floatval($qte_unite)), 2);
                $prix_unitaires = round((floatval($montants) / floatval($qte_unite)), 2);

                $qtePaquet=$qte;
                $prix_unitairesPacquet=$prix_unitaires;

                $unite_paquet = $paquets;
                $puPaquet = floatval($montants);
                $qtePaquet = floatval($request->qteEntree);
            }
            
        }

        $idDetail=$request->refProduit;       
        
        $data = tvente_detail_entree::create([
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refProduit'    =>  $request->refProduit,
            'puEntree'    =>  $prix_unitaires,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteEntree'    =>  $qte,
            'unite_paquet'    =>  $unite_paquet,
            'puPaquet'    =>  $puPaquet,
            'qtePaquet'    =>  $qtePaquet,
            'author'       =>  $request->author
        ]);

        if($paquets == 'Par Paquet')
        {
            $data2 = DB::update(
                'update tvente_produit set qte = qte + :qteEntree where id = :refProduit',
                ['qteEntree' => $qte,'refProduit' => $idDetail]
            );
    
            $data3 = DB::update(
                'update tvente_entete_entree set montant = montant + (:pu * :qte) where id = :refEnteteEntree',
                ['pu' => $prix_unitaires,'qte' => $qte,'refEnteteEntree' => $request->refEnteteEntree]
            );
        }
        else if($paquets == 'Par Pièce' || $paquets == 'Par Kilo')
        {
            $data2 = DB::update(
                'update tvente_produit set qte = qte + :qteEntree where id = :refProduit',
                ['qteEntree' => $qte,'refProduit' => $idDetail]
            );
    
            $data3 = DB::update(
                'update tvente_entete_entree set montant = montant + (:pu * :qte) where id = :refEnteteEntree',
                ['pu' => $prix_unitaires,'qte' => $qte,'refEnteteEntree' => $request->refEnteteEntree]
            );

        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
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
            $montants = ($request->puEntree)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puEntree;
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
            $qte=$request->qteEntree;
            $prix_unitaires = (floatval($montants));

            $unite_paquet = $paquets;
            $puPaquet = $prix_unitaires;
            $qtePaquet = $qte;
        }
        else if($paquets == 'Par Paquet')
        {
            $qte=(floatval($request->qteEntree) * floatval($qte_unite));
            $prix_unitaires = (floatval($montants) / floatval($qte_unite));

            $unite_paquet = $paquets;
            $puPaquet = floatval($montants);
            $qtePaquet = floatval($request->qteEntree);
        }

        $data = tvente_detail_entree::where('id', $id)->update([
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refProduit'    =>  $request->refProduit,
            'puEntree'    =>  $prix_unitaires,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteEntree'    =>  $qte,
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
        $unite_paquet='';
        $puPaquet = 0.00;
        $qtePaquet=0.00;
        $qte=0.00;        
        $idDetail=0.00;
        $montants=0.00;
        $refEnteteEntree=0.00;
        
        $deleteds = DB::select('select qteEntree,refProduit,puEntree,refEnteteEntree,unite_paquet,puPaquet,qtePaquet from tvente_detail_entree'); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteEntree;
            $qtePaquet = $deleted->qtePaquet;
            $unite_paquet = $deleted->unite_paquet;
            $puPaquet = $deleted->puPaquet;
            $idDetail = $deleted->refProduit;
            $montants = $deleted->puEntree;
            $refEnteteEntree = $deleted->refEnteteEntree;
        }
        $data = tvente_detail_entree::where('id',$id)->delete();

        $data2 = DB::update(
            'update tvente_produit set qte = qte - :qteEntree where id = :refProduit',
            ['qteEntree' => $qte,'refProduit' => $idDetail]
        );

        $data3 = DB::update(
            'update tvente_entete_entree set montant = montant - (:pu * :qte) where id = :refEnteteEntree',
            ['pu' => $montants,'qte' => $qte,'refEnteteEntree' => $refEnteteEntree]
        );
               
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }


}
