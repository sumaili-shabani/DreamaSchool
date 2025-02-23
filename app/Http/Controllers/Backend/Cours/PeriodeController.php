<?php

namespace App\Http\Controllers\Backend\Cours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Cours\{Periode};
use App\Traits\{GlobalMethod,Slug};
use DB;

class PeriodeController extends Controller
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
        $data = DB::table("periodes")
        ->select("periodes.id", "periodes.nomPeriode","periodes.statutPeriode", "periodes.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('periodes.nomPeriode', 'like', '%'.$query.'%')
            ->orWhere('periodes.id', 'like', '%'.$query.'%')
            ->orderBy("periodes.id", "asc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("periodes.id", "asc");
        return $this->apiData($data->paginate(10));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_periode_2()
    {
        //
        $data = DB::table("periodes")
        ->select("periodes.id", "periodes.nomPeriode","periodes.statutPeriode", "periodes.created_at")
        ->get();
        return response()->json(['data'  =>  $data]);
    }


     function chect_etat_periode($id, $etat)
    {
        if ($id !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                Periode::where('id',$id)->update([
                    'statutPeriode'         =>  0
                ]);
                return $this->msgJson('période a été desactivée avec succès!');

            } else {
                // activation
                Periode::where('id',$id)->update([
                    'statutPeriode'         =>  1
                ]);
                return $this->msgJson('période a été activée avec succès!');
            }

        }
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
            $data = Periode::where("id", $request->id)->update([
                'nomPeriode' =>  $request->nomPeriode
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $data = Periode::create([
                'nomPeriode' =>  $request->nomPeriode
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
        $data = Periode::where('id', $id)->get();
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
        $data = Periode::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
