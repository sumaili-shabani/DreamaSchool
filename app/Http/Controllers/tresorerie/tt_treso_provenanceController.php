<?php

namespace App\Http\Controllers\tresorerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\tresorerie\{tt_treso_provenance};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tt_treso_provenanceController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tt_treso_provenance')->select("tt_treso_provenance.id",
            "tt_treso_provenance.nomProvenance","codeProvenance",
            "tt_treso_provenance.created_at")->where('nomProvenance', 'like', '%'.$query.'%')
            ->orWhere('codeProvenance', 'like', '%'.$query.'%')
            ->orderBy("tt_treso_provenance.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            

            $data = DB::table('tt_treso_provenance')
            ->select("tt_treso_provenance.id","tt_treso_provenance.nomProvenance","codeProvenance","tt_treso_provenance.created_at")
            ->orderBy("tt_treso_provenance.id", "desc")->paginate(10);
            return response($data, 200);
        }
    }

 

    function fetch_provenance2()
    {
        $data = DB::table('tt_treso_provenance')->select("tt_treso_provenance.id",
        "tt_treso_provenance.nomProvenance","tt_treso_provenance.codeProvenance",
        "tt_treso_provenance.created_at")
        ->orderBy("nomProvenance", "asc")
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
            $data = tt_treso_provenance::where("id", $request->id)->update([
                'nomProvenance' =>  $request->nomProvenance,
                'codeProvenance' =>  $request->codeProvenance
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tt_treso_provenance::create([
                'nomProvenance' =>  $request->nomProvenance,
                'codeProvenance' =>  $request->codeProvenance
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
        $data = tt_treso_provenance::where('id', $id)->get();
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
        $data = tt_treso_provenance::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
