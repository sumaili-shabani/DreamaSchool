<?php

namespace App\Http\Controllers\tresorerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\tresorerie\{tt_treso_bloc};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tt_treso_blocController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tt_treso_bloc')->select("tt_treso_bloc.id",
            "tt_treso_bloc.desiBloc",
            "tt_treso_bloc.created_at")->where('desiBloc', 'like', '%'.$query.'%')
            ->orderBy("tt_treso_bloc.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            

            $data = DB::table('tt_treso_bloc')
            ->select("tt_treso_bloc.id","tt_treso_bloc.desiBloc","tt_treso_bloc.created_at")
            ->orderBy("tt_treso_bloc.id", "desc")->paginate(10);
            return response($data, 200);
        }
    }

 

    function fetch_bloc2()
    {
        $data = DB::table('tt_treso_bloc')
        ->select("tt_treso_bloc.id","tt_treso_bloc.desiBloc","tt_treso_bloc.created_at")
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
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tt_treso_bloc::where("id", $request->id)->update([
                'desiBloc' =>  $request->desiBloc
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tt_treso_bloc::create([
                'desiBloc' =>  $request->desiBloc
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
        $data = tt_treso_bloc::where('id', $id)->get();
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
        $data = tt_treso_bloc::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
