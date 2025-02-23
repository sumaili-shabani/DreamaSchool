<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\{Ville};
use App\Traits\{GlobalMethod,Slug};
use DB;

class VilleController extends Controller
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
        
        $data = DB::table('villes')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('villes.id','villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'provinces.created_at');
       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('provinces.nomProvince', 'like', '%'.$query.'%')
            ->orWhere('villes.nomVille', 'like', '%'.$query.'%')
            ->orWhere('pays.nomPays', 'like', '%'.$query.'%')
            ->orWhere('provinces.id', 'like', '%'.$query.'%')
            ->orderBy("provinces.id", "desc");

            return $this->apiData($data->paginate(5));
           

        }
        $data->orderBy("villes.id", "desc");
        return $this->apiData($data->paginate(5));
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
            $data = Ville::where("id", $request->id)->update([
                'idProvince'        =>  $request->idProvince,
                'nomVille'          =>  $request->nomVille
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = Ville::create([
                'idProvince'        =>  $request->idProvince,
                'nomVille'          =>  $request->nomVille
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }

    function fetch_ville_tug_pays($idProvince)
    {
        $data = DB::table('villes')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('villes.id','villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'provinces.created_at')
        ->where("villes.idProvince", $idProvince)
        ->get();
        
        return response()->json(['data' => $data]);

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
        $data = DB::table('villes')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('villes.id','villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'provinces.created_at')
        ->where("villes.id", $id)
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
        $data= Ville::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }



}
