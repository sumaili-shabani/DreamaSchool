<?php

namespace App\Http\Controllers\Backend\Cours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Cours\{CatCour};
use App\Traits\{GlobalMethod,Slug};
use DB;

class CatCoursController extends Controller
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
        $data = DB::table("cat_cours")
        ->select("cat_cours.id", "cat_cours.nomCatCours", "cat_cours.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('cat_cours.nomCatCours', 'like', '%'.$query.'%')
            ->orWhere('cat_cours.id', 'like', '%'.$query.'%')
            ->orderBy("cat_cours.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("cat_cours.id", "desc");
        return $this->apiData($data->paginate(10));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_cat_cours_2()
    {
        //
        $data = DB::table("cat_cours")
        ->select("cat_cours.id", "cat_cours.nomCatCours", "cat_cours.created_at")
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
            $data = CatCour::where("id", $request->id)->update([
                'nomCatCours' =>  $request->nomCatCours
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $data = CatCour::create([
                'nomCatCours' =>  $request->nomCatCours
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
        $data = CatCour::where('id', $id)->get();
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
        $data = CatCour::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
