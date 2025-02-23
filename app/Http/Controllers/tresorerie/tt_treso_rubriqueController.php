<?php

namespace App\Http\Controllers\tresorerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\tresorerie\{tt_treso_rubrique};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tt_treso_rubriqueController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tt_treso_rubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->select("tt_treso_rubrique.id",
            "tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique","refcateRubrik",
            "tt_treso_rubrique.created_at")->where('desiRubriq', 'like', '%'.$query.'%')
            ->where('codeRubriq', 'like', '%'.$query.'%')
            ->orderBy("tt_treso_rubrique.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            

            $data = DB::table('tt_treso_rubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->select("tt_treso_rubrique.id","tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique","refcateRubrik","tt_treso_rubrique.created_at")
            ->orderBy("tt_treso_rubrique.id", "desc")
            ->paginate(10);
            return response($data, 200);
        }
    }

 

    function fetch_rubrique2()
    {
        $data = DB::table('tt_treso_rubrique')
        ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
        ->select("tt_treso_rubrique.id",
        "tt_treso_rubrique.desiRubriq","tt_treso_rubrique.codeRubriq","NomCateRubrique","refcateRubrik",
        "tt_treso_rubrique.created_at")
        ->orderBy("desiRubriq", "asc")
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
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tt_treso_rubrique::where("id", $request->id)->update([
                'desiRubriq' =>  $request->desiRubriq,
                'codeRubriq' =>  $request->codeRubriq,
                'refcateRubrik'=> $request->refcateRubrik
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tt_treso_rubrique::create([
                'desiRubriq' =>  $request->desiRubriq,
                'codeRubriq' =>  $request->codeRubriq,
                'refcateRubrik'=> $request->refcateRubrik
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }


    function update_rubrique(Request $request, $id)
    {
        $data = tt_treso_rubrique::where('id', $id)->update([
            'desiRubriq' =>  $request->desiRubriq,
            'codeRubriq' =>  $request->codeRubriq,
            'refcateRubrik'=> $request->refcateRubrik
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
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
        $data = tt_treso_rubrique::where('id', $id)->get();
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
        $data = tdyal_categorie_vaccin::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
