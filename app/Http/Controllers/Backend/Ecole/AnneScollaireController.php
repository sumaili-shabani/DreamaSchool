<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Ecole\{AnneScollaire};
use App\Traits\{GlobalMethod,Slug};
use DB;

class AnneScollaireController extends Controller
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
        $data = DB::table("anne_scollaires")
        ->select("anne_scollaires.id",
            "anne_scollaires.designation","anne_scollaires.statut",
            "anne_scollaires.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('anne_scollaires.designation', 'like', '%'.$query.'%')
            ->orWhere('anne_scollaires.id', 'like', '%'.$query.'%')
            ->orderBy("anne_scollaires.id", "desc");

            return $this->apiData($data->paginate(4));


        }
        $data->orderBy("anne_scollaires.id", "desc");
        return $this->apiData($data->paginate(4));
    }


    function fetch_anne_scollaire_2()
    {
         $data = DB::table("anne_scollaires")
        ->select("anne_scollaires.id",
            "anne_scollaires.designation","anne_scollaires.statut",
            "anne_scollaires.created_at")
        ->orderBy("anne_scollaires.statut", "desc")
        ->get();

        return response()->json(['data' => $data]);

    }

    function chect_etat_anne_scolaire($id, $etat)
    {
        if ($id !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                AnneScollaire::where('id',$id)->update([
                    'statut'         =>  0
                ]);
                return $this->msgJson('année scolaire a été desactivée avec succès!');

            } else {
                // activation
                AnneScollaire::where('id',$id)->update([
                    'statut'         =>  1
                ]);
                return $this->msgJson('année scolaire a été activée avec succès!');
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
            $data = AnneScollaire::where("id", $request->id)->update([
                'designation' =>  $request->designation
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion
            $data = AnneScollaire::create([

                'designation' =>  $request->designation
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
        $data = DB::table("anne_scollaires")
        ->select("anne_scollaires.id",
            "anne_scollaires.designation","anne_scollaires.statut",
            "anne_scollaires.created_at")
        ->where('anne_scollaires.id', $id)->get();
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
        $data = AnneScollaire::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }



}
