<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tfin_cloture_caisse};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tClotureCaisseController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //'id','refSscompte','date_cloture','montant_cloture','taux_dujour','author'
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfin_cloture_caisse')           
            ->select("tfin_cloture_caisse.id" ,"tfin_cloture_caisse.date_cloture",
            "tfin_cloture_caisse.montant_cloture",'tfin_cloture_caisse.taux_dujour',
            "tfin_cloture_caisse.refSscompte",'tfin_cloture_caisse.author',"tfin_cloture_caisse.created_at")
            ->where('date_cloture', 'like', '%'.$query.'%')            
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);

        }
        else{
            $data = DB::table('tfin_cloture_caisse')           
            ->select("tfin_cloture_caisse.id" ,"tfin_cloture_caisse.date_cloture",
            "tfin_cloture_caisse.montant_cloture",'tfin_cloture_caisse.taux_dujour',
            "tfin_cloture_caisse.refSscompte",'tfin_cloture_caisse.author',"tfin_cloture_caisse.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            
            return response($data, 200);
        }
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = tfin_cloture_caisse::where('id', $id)->get();
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
        $data = tfin_cloture_caisse::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    

}
