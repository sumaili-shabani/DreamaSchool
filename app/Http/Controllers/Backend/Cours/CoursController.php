<?php

namespace App\Http\Controllers\Backend\Cours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Cours\{Cour};
use App\Traits\{GlobalMethod,Slug};
use DB;

class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    public function index(Request $request)
    {
        //
        $data = DB::table("cours")
        ->join('cat_cours','cat_cours.id','=','cours.idCatCours')
        ->select("cours.id",
            //cours 
            'cours.nomCours','cours.idCatCours',
            //cat_cours
            "cat_cours.nomCatCours", 
            "cours.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('cours.nomCours', 'like', '%'.$query.'%')
            ->orWhere('cat_cours.nomCatCours', 'like', '%'.$query.'%')
            ->orderBy("cours.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("cours.id", "desc");
        return $this->apiData($data->paginate(10));
    }


     public function fetch_cours_2()
    {
        //
        $data = DB::table("cours")
        ->join('cat_cours','cat_cours.id','=','cours.idCatCours')
        ->select("cours.id",
            //cours 
            'cours.nomCours','cours.idCatCours',
            //cat_cours
            "cat_cours.nomCatCours", 
            "cours.created_at")
        ->get();
        return response()->json(['data'  =>  $data]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_cours_by_catcours($idCatCours)
    {
        //
        $data = DB::table("cours")
        ->join('cat_cours','cat_cours.id','=','cours.idCatCours')
        ->select("cours.id",
            //cours 
            'cours.nomCours','cours.idCatCours',
            //cat_cours
            "cat_cours.nomCatCours", 
            "cours.created_at")
        ->where('cours.idCatCours', $idCatCours)
        ->get();
        return response()->json(['data'  =>  $data]);
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
            $data = Cour::where("id", $request->id)->update([
                'nomCours'      =>  $request->nomCours,
                'idCatCours'    =>  $request->idCatCours
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $data = Cour::create([
                'nomCours'      =>  $request->nomCours,
                'idCatCours'    =>  $request->idCatCours
            ]);
            return response()->json(['data'  =>  "Insertion avec succès!!!"]);


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
        $data = DB::table("cours")
        ->join('cat_cours','cat_cours.id','=','cours.idCatCours')
        ->select("cours.id",
            //cours 
            'cours.nomCours','cours.idCatCours',
            //cat_cours
            "cat_cours.nomCatCours", 
            "cours.created_at")
        ->where('cours.id', $id)->get();
        return response()->json(['data'  =>  $data]);
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
        $data = Cour::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }


}
