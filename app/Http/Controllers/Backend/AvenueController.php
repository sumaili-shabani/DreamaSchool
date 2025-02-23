<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\{Avenue};
use App\Traits\{GlobalMethod,Slug};
use DB;

class AvenueController extends Controller
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
        
        $data = DB::table('avenues')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('avenues.id','avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'avenues.created_at');
       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('provinces.nomProvince', 'like', '%'.$query.'%')
            ->orWhere('avenues.nomAvenue', 'like', '%'.$query.'%')
            ->orWhere('quartiers.nomQuartier', 'like', '%'.$query.'%')
            ->orWhere('communes.nomCommune', 'like', '%'.$query.'%')
            ->orWhere('villes.nomVille', 'like', '%'.$query.'%')
            ->orWhere('pays.nomPays', 'like', '%'.$query.'%')
            ->orWhere('provinces.id', 'like', '%'.$query.'%')
            ->orderBy("avenues.id", "desc");

            return $this->apiData($data->paginate(5));
           

        }
        $data->orderBy("avenues.id", "desc");
        return $this->apiData($data->paginate(5));
    }

    function getAvenueTug($idQuartier)
    {
        $data = Avenue::where('idQuartier', $idQuartier)->get();
        return response()->json(['data'  =>  $data]);
    }

    public function fetch_avenue_2()
    {
        //
        $data = DB::table('avenues')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('avenues.id','avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'quartiers.created_at')
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
            $data = Avenue::where("id", $request->id)->update([
                'idQuartier'           =>  $request->idQuartier,
                'nomAvenue'            =>  $request->nomAvenue
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = Avenue::create([
                'idQuartier'           =>  $request->idQuartier,
                'nomAvenue'            =>  $request->nomAvenue
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
        $data = DB::table('avenues')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('avenues.id','avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'quartiers.created_at')
        ->where("avenues.id", $id)
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
        $data= Avenue::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
