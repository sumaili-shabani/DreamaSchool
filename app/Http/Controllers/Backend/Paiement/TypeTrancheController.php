<?php

namespace App\Http\Controllers\Backend\Paiement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Paiement\{TypeTranche};
use App\Traits\{GlobalMethod,Slug};
use DB;

class TypeTrancheController extends Controller
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
        $data = DB::table("type_tranches")
        ->select("type_tranches.id", "type_tranches.nomTypeTranche", "type_tranches.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('type_tranches.nomTypeTranche', 'like', '%'.$query.'%')
            ->orWhere('type_tranches.id', 'like', '%'.$query.'%')
            ->orderBy("type_tranches.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("type_tranches.id", "desc");
        return $this->apiData($data->paginate(10));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_type_tranche_2()
    {
        //
        $data = DB::table("type_tranches")
        ->select("type_tranches.id", "type_tranches.nomTypeTranche", "type_tranches.created_at")
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
            $data = TypeTranche::where("id", $request->id)->update([
                'nomTypeTranche' =>  $request->nomTypeTranche
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $data = TypeTranche::create([
                'nomTypeTranche' =>  $request->nomTypeTranche
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
        $data = TypeTranche::where('id', $id)->get();
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
        $data = TypeTranche::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
