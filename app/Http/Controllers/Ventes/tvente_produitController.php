<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ventes\{tvente_produit};
use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tvente_produitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {

        $data = DB::table('tvente_produit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        
        ->select("tvente_produit.id","tvente_produit.designation as designation","refCategorie",
        "pu","unite","devise","qte_unite","tvente_categorie_produit.designation as Categorie")
        ->selectRaw("(CASE WHEN (unite = 'Pièce') THEN ROUND(tvente_produit.qte,2) 
                           WHEN (unite = 'Kilo') THEN ROUND(tvente_produit.qte,2) 
                           WHEN (unite = 'Paquet') THEN ROUND((tvente_produit.qte/qte_unite),2) END) as qte");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_produit.designation', 'like', '%'.$query.'%')
            ->orderBy("tvente_produit.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        
        $data->orderBy("tvente_produit.id", "desc");
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_produit_2()
    {
        $data = DB::table('tvente_produit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        
        ->select("tvente_produit.id","tvente_produit.designation as designation","refCategorie",
         "pu","unite","devise","qte_unite","tvente_categorie_produit.designation as Categorie")
        ->selectRaw("(CASE WHEN (unite = 'Pièce') THEN ROUND(tvente_produit.qte,2) 
                            WHEN (unite = 'Kilo') THEN ROUND(tvente_produit.qte,2) 
                            WHEN (unite = 'Paquet') THEN ROUND((tvente_produit.qte/qte_unite),2) END) as qte")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            $montants = ($request->pu)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->pu;
            $devises = $request->devise;
        }


        //
        if ($request->id !='') 
        {
            # code...
            // update  qte_unite
            $data = tvente_produit::where("id", $request->id)->update([
                'designation'       =>  $request->designation,
                'pu'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'unite'    =>  $request->unite,
                'qte_unite'    =>  $request->qte_unite,
                'refCategorie'    =>  $request->refCategorie,
                'author'    =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_produit::create([
                'designation'       =>  $request->designation,
                'pu'    =>  $montants,                
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'unite'    =>  $request->unite,
                'qte_unite'    =>  $request->qte_unite,
                'refCategorie'    =>  $request->refCategorie,
                'author'    =>  $request->author
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = DB::table('tvente_produit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        
        ->select("tvente_produit.id","tvente_produit.designation as designation","refCategorie",
        "pu","unite","devise","qte_unite","tvente_produit.qte","tvente_categorie_produit.designation as Categorie")
        ->where('tvente_produit.id', $id)->get();
        return response()->json(['data' => $data]);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = tvente_produit::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
