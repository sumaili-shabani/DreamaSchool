<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Ecole\{Option};
use App\Traits\{GlobalMethod,Slug};
use DB;

class OptionController extends Controller
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
        $data = DB::table("options")
        ->join('sections','sections.id','=','options.idSection')
        ->select("options.id",
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            "options.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('options.nomOption', 'like', '%'.$query.'%')
            ->orWhere('sections.nomSection', 'like', '%'.$query.'%')
            ->orderBy("options.id", "desc");

            return $this->apiData($data->paginate(10));


        }
        $data->orderBy("options.id", "desc");
        return $this->apiData($data->paginate(10));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_option_by_section($idSection)
    {
        //
        $data = DB::table("options")
        ->join('sections','sections.id','=','options.idSection')
        ->select("options.id",
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            "options.created_at")
        ->where('options.idSection', $idSection)
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
            $data = Option::where("id", $request->id)->update([
                'idSection'     =>  $request->idSection,
                'nomOption'     =>  $request->nomOption
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $data = Option::create([
                'idSection'     =>  $request->idSection,
                'nomOption'     =>  $request->nomOption
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
        $data = DB::table("options")
        ->join('sections','sections.id','=','options.idSection')
        ->select("options.id",
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            "options.created_at")
        ->where('options.id', $id)->get();
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
        $data = Option::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
