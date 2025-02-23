<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tfin_typeoperation};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tTypeOperationController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfin_typeoperation')
            ->select("tfin_typeoperation.id","tfin_typeoperation.nom_typeoperation",'author',
            "tfin_typeoperation.created_at")
            ->where('nom_typeoperation', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tfin_typeoperation')
            ->select("tfin_typeoperation.id","tfin_typeoperation.nom_typeoperation",'author',
            "tfin_typeoperation.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }


    function fetch_tfin_typeoperation_2()
    {
        $data = DB::table('tfin_typeoperation')
        ->select("tfin_typeoperation.id","tfin_typeoperation.nom_typeoperation",'author',
        "tfin_typeoperation.created_at")
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
            $data = tfin_typeoperation::where("id", $request->id)->update([
                'nom_typeoperation' =>  $request->nom_typeoperation,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tfin_typeoperation::create([
                'nom_typeoperation' =>  $request->nom_typeoperation,
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
        $data = tfin_typeoperation::where('id', $id)->get();
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
        $data = tfin_typeoperation::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
