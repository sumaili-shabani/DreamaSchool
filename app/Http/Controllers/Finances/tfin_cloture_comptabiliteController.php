<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tfin_cloture_comptabilite};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tfin_cloture_comptabiliteController extends Controller
{
    
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
       
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfin_cloture_comptabilite')
            ->select("tfin_cloture_comptabilite.id","dateCloture","tauxdujour",'author',
            "tfin_cloture_comptabilite.created_at")
            ->where('dateCloture', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tfin_cloture_comptabilite')
            ->select("tfin_cloture_comptabilite.id","dateCloture","tauxdujour",'author',
            "tfin_cloture_comptabilite.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }


    function fetch_tfin_cloture_comptabilite_2()
    {
        $data = DB::table('tfin_cloture_comptabilite')
        ->select("tfin_cloture_comptabilite.id","dateCloture","tauxdujour",'author',
        "tfin_cloture_comptabilite.created_at")
        ->orderBy("id", "asc")
        ->get();
        
        return response($data, 200);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //,'numero_classe','author'
        if ($request->id !='') 
        {
            $data = tfin_cloture_comptabilite::where("id", $request->id)->update([
                'dateCloture' =>  $request->dateCloture,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
                       
            $taux=0;
            $tauxList = DB::table('tfin_taux')
            ->select("tfin_taux.id","tfin_taux.montant_taux","tfin_taux.created_at")
            ->get();
            foreach ($tauxList as $listTaux) {
                $taux= $listTaux->montant_taux;
            }
            // insertion 
            $data = tfin_cloture_comptabilite::create([
                'dateCloture' =>  $request->dateCloture,
                'tauxdujour' =>  $taux,
                'author' =>  $request->author
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
        $data = tfin_cloture_comptabilite::where('id', $id)->get();
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
        $data = tfin_cloture_comptabilite::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
