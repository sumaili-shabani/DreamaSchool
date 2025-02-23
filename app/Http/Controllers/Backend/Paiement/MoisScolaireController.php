<?php

namespace App\Http\Controllers\Backend\Paiement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Paiement\{MoisScolaire};
use App\Traits\{GlobalMethod,Slug};
use DB;

class MoisScolaireController extends Controller
{
    use GlobalMethod;
    public function index(Request $request)
    {
        //
        $data = DB::table("mois_scolaires")
        ->select("mois_scolaires.id", "mois_scolaires.nomMois", "mois_scolaires.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('mois_scolaires.nomMois', 'like', '%'.$query.'%')
            ->orWhere('mois_scolaires.id', 'like', '%'.$query.'%')
            ->orderBy("mois_scolaires.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("mois_scolaires.id", "desc");
        return $this->apiData($data->paginate(10));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_mois_scolaire_2()
    {
        //
        $data = DB::table("mois_scolaires")
        ->select("mois_scolaires.id", "mois_scolaires.nomMois", "mois_scolaires.created_at")
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
            $data = MoisScolaire::where("id", $request->id)->update([
                'nomMois' =>  $request->nomMois
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $data = MoisScolaire::create([
                'nomMois' =>  $request->nomMois
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
        $data = MoisScolaire::where('id', $id)->get();
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
        $data = MoisScolaire::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }


}
