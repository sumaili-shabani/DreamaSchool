<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ventes\{tvente_categorie_client};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tvente_categorie_clientController extends Controller
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

        // $data = DB::table("classes")
        // ->select("classes.id", "classes.nomClasse", "classes.created_at");

        // if (!is_null($request->get('query'))) {
        //     # code...
        //     $query = $this->Gquery($request);

        //     $data->where('classes.nomClasse', 'like', '%'.$query.'%')
        //     ->orWhere('classes.id', 'like', '%'.$query.'%')
        //     ->orderBy("classes.id", "desc");

        //     return $this->apiData($data->paginate(10));


        // }
        // $data->orderBy("classes.id", "desc");
        // return $this->apiData($data->paginate(10));


        //id,designation,author

        $data = DB::table("tvente_categorie_client")
        ->select("tvente_categorie_client.id", "tvente_categorie_client.designation", 
        "tvente_categorie_client.created_at", "tvente_categorie_client.author");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_categorie_client.designation', 'like', '%'.$query.'%')
            ->orderBy("tvente_categorie_client.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("classes.id", "desc");
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_categorie_client_2()
    {
         $data = DB::table("tvente_categorie_client")
        ->select("tvente_categorie_client.id", "tvente_categorie_client.designation", 
        "tvente_categorie_client.created_at", "tvente_categorie_client.author")
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
            $data = tvente_categorie_client::where("id", $request->id)->update([
                'designation' =>  $request->designation,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_categorie_client::create([

                'designation' =>  $request->designation,
                'author' =>  $request->author
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
        $data = tvente_categorie_client::where('id', $id)->get();
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
        $data = tvente_categorie_client::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
