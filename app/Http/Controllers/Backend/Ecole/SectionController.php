<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Ecole\{Section};
use App\Traits\{GlobalMethod,Slug};
use DB;

class SectionController extends Controller
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
        $data = DB::table("sections")
        ->select("sections.id", "sections.nomSection", "sections.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('sections.nomSection', 'like', '%'.$query.'%')
            ->orWhere('sections.id', 'like', '%'.$query.'%')
            ->orderBy("sections.id", "desc");

            return $this->apiData($data->paginate(10));


        }
        $data->orderBy("sections.id", "desc");
        return $this->apiData($data->paginate(10));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_section_2()
    {
        //
        $data = DB::table("sections")
        ->select("sections.id", "sections.nomSection", "sections.created_at")
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
            $data = Section::where("id", $request->id)->update([
                'nomSection' =>  $request->nomSection
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $data = Section::create([
                'nomSection' =>  $request->nomSection
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
        $data = Section::where('id', $id)->get();
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
        $data = Section::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }



}
