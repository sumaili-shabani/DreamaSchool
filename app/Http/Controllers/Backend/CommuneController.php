<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\{Commune};
use App\Traits\{GlobalMethod,Slug};
use DB;

class CommuneController extends Controller
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
        \DB::statement("SET SQL_MODE=''");
        
        $data = DB::table('communes')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('communes.id','communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'communes.created_at');
       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('provinces.nomProvince', 'like', '%'.$query.'%')
            ->orWhere('communes.nomCommune', 'like', '%'.$query.'%')
            ->orWhere('villes.nomVille', 'like', '%'.$query.'%')
            ->orWhere('pays.nomPays', 'like', '%'.$query.'%')
            ->orWhere('provinces.id', 'like', '%'.$query.'%')
            ->orderBy("communes.id", "desc");

            return $this->apiData($data->paginate(5));
           

        }
        $data->orderBy("communes.id", "desc");
        return $this->apiData($data->paginate(5));
    }


    function fetch_commune_tug_ville($idVille)
    {
        //
        $data = DB::table('communes')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('communes.id','communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'communes.created_at')
        ->where("communes.idVille", $idVille)
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
            $data = Commune::where("id", $request->id)->update([
                'idVille'               =>  $request->idVille,
                'nomCommune'            =>  $request->nomCommune
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = Commune::create([
                'idVille'               =>  $request->idVille,
                'nomCommune'            =>  $request->nomCommune
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
        $data = DB::table('communes')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('communes.id','communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'communes.created_at')
        ->where("communes.id", $id)
        ->get();

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
        $data= Commune::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
