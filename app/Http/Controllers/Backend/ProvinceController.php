<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\{Province};
use App\Traits\{GlobalMethod,Slug};
use DB;

class ProvinceController extends Controller
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
        
        $data = DB::table('provinces')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('provinces.id','provinces.nomProvince','provinces.idPays','pays.nomPays', 'provinces.created_at');
       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('provinces.nomProvince', 'like', '%'.$query.'%')
            ->orWhere('pays.nomPays', 'like', '%'.$query.'%')
            ->orWhere('provinces.id', 'like', '%'.$query.'%')
            ->orderBy("provinces.id", "desc");

            return $this->apiData($data->paginate(5));
           

        }
        $data->orderBy("provinces.id", "desc");
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
            $data = Province::where("id", $request->id)->update([
                'idPays'        =>  $request->idPays,
                'nomProvince'   =>  $request->nomProvince
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = Province::create([
                'idPays'        =>  $request->idPays,
                'nomProvince'   =>  $request->nomProvince
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }

    function fetch_province_2()
    {
        $data = DB::table('provinces')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('provinces.id','provinces.nomProvince','provinces.idPays','pays.nomPays', 'provinces.created_at')
        ->get();
        
        return response()->json(['data' => $data]);

    }

    function fetch_province_tug_pays($idPays)
    {
        $data = DB::table('provinces')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('provinces.id','provinces.nomProvince','provinces.idPays','pays.nomPays', 'provinces.created_at')
        ->where('provinces.idPays', $idPays)
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
        $data = DB::table('provinces')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('provinces.id','provinces.nomProvince','provinces.idPays','pays.nomPays', 'provinces.created_at')
        ->where("provinces.id", $id)
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
        $data= Province::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
