<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ventes\{tvente_fournisseur};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tvente_fournisseurController extends Controller
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
        //id,designation,author

        $data = DB::table('tvente_fournisseur')
        ->select("tvente_fournisseur.id","tvente_fournisseur.noms","tvente_fournisseur.contact",
        "tvente_fournisseur.mail","tvente_fournisseur.adresse","tvente_fournisseur.author",
        "tvente_fournisseur.created_at");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_fournisseur.noms', 'like', '%'.$query.'%')
            ->orderBy("tvente_fournisseur.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_list_fournisseur()
    {
         $data = DB::table('tvente_fournisseur')
         ->select("tvente_fournisseur.id","tvente_fournisseur.noms","tvente_fournisseur.contact",
         "tvente_fournisseur.mail","tvente_fournisseur.adresse","tvente_fournisseur.author",
         "tvente_fournisseur.created_at")
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
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tvente_fournisseur::where("id", $request->id)->update([
                'noms' =>  $request->noms,
                'contact' =>  $request->contact,
                'mail' =>  $request->mail,
                'adresse' =>  $request->adresse,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_fournisseur::create([
                'noms' =>  $request->noms,
                'contact' =>  $request->contact,
                'mail' =>  $request->mail,
                'adresse' =>  $request->adresse,
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
        $data = tvente_fournisseur::where('id', $id)->get();
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
        $data = tvente_fournisseur::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
