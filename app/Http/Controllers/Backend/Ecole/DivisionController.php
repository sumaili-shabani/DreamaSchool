<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Ecole\{Division};
use App\Traits\{GlobalMethod,Slug};
use DB;

class DivisionController extends Controller
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
        $data = DB::table("divisions")
        ->select("divisions.id", "divisions.nomDivision", "divisions.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('divisions.nomDivision', 'like', '%'.$query.'%')
            ->orWhere('divisions.id', 'like', '%'.$query.'%')
            ->orderBy("divisions.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("divisions.id", "desc");
        return $this->apiData($data->paginate(10));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_division_2()
    {
        //
        $data = DB::table("divisions")
        ->select("divisions.id", "divisions.nomDivision", "divisions.created_at")
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
            $data = Division::where("id", $request->id)->update([
                'nomDivision' =>  $request->nomDivision
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $data = Division::create([
                'nomDivision' =>  $request->nomDivision
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
        $data = Division::where('id', $id)->get();
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
        $data = Division::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }


}
