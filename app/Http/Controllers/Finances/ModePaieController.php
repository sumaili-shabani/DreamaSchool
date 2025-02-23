<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tconf_modepaiement};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class ModePaieController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tconf_modepaiement')
            ->select("tconf_modepaiement.id","tconf_modepaiement.designation","tconf_modepaiement.created_at")
            ->where('designation', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tconf_modepaiement')
            ->select("tconf_modepaiement.id","tconf_modepaiement.designation","tconf_modepaiement.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }


    function fetch_tconf_modepaiement_2()
    {
        $data = DB::table('tconf_modepaiement')
        ->select("tconf_modepaiement.id","tconf_modepaiement.designation","tconf_modepaiement.created_at")
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
            $data = tconf_modepaiement::where("id", $request->id)->update([
                'designation' =>  $request->designation
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tconf_modepaiement::create([

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
        $data = tconf_modepaiement::where('id', $id)->get();
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
        $data = tconf_modepaiement::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
