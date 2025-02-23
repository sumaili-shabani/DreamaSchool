<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tfin_typeposition};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tTypePositionController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfin_typeposition')
            ->select("tfin_typeposition.id","tfin_typeposition.nom_typeposition",'author',
            "tfin_typeposition.created_at")
            ->where('nom_typeposition', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tfin_typeposition')
            ->select("tfin_typeposition.id","tfin_typeposition.nom_typeposition",'author',
            "tfin_typeposition.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response($data, 200);
        }
    }


    function fetch_tfin_typeposition_2()
    {
        $data = DB::table('tfin_typeposition')
        ->select("tfin_typeposition.id","tfin_typeposition.nom_typeposition",'author',
        "tfin_typeposition.created_at")
        ->orderBy("id", "desc")
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
            $data = tfin_typeposition::where("id", $request->id)->update([
                'nom_typeposition' =>  $request->nom_typeposition,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tfin_typeposition::create([
                'nom_typeposition' =>  $request->nom_typeposition,
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
        $data = tfin_typeposition::where('id', $id)->get();
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
        $data = tfin_typeposition::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
