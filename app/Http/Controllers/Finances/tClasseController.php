<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tfin_classe};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tClasseController extends Controller
{
    
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfin_classe')
            ->select("tfin_classe.id","tfin_classe.nom_classe","numero_classe",'author',
            "tfin_classe.created_at")
            ->where('nom_classe', 'like', '%'.$query.'%')
            ->orderBy("id", "asc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tfin_classe')
            ->select("tfin_classe.id","tfin_classe.nom_classe","numero_classe",'author',
            "tfin_classe.created_at")
            ->orderBy("id", "asc")
            ->paginate(10);

            return response($data, 200);
        }
    }


    function fetch_tfin_classe_2()
    {
        $data = DB::table('tfin_classe')
        ->select("tfin_classe.id","tfin_classe.nom_classe","numero_classe",'author',
        "tfin_classe.created_at")
        ->orderBy("id", "asc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //,'numero_classe','author'
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tfin_classe::where("id", $request->id)->update([
                'nom_classe' =>  $request->nom_classe,
                'numero_classe' =>  $request->numero_classe,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tfin_classe::create([
                'nom_classe' =>  $request->nom_classe,
                'numero_classe' =>  $request->numero_classe,
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
        $data = tfin_classe::where('id', $id)->get();
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
        $data = tfin_classe::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
