<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\{Pays};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class PaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        $data = DB::table("pays")
        ->select("pays.id", "pays.nomPays", "pays.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('pays.nomPays', 'like', '%'.$query.'%')
            ->orWhere('pays.id', 'like', '%'.$query.'%')
            ->orderBy("pays.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        $data->orderBy("pays.id", "desc");
        return $this->apiData($data->paginate(4));
    }


    function fetch_pays_2()
    {
         $data = DB::table("pays")
        ->select("pays.id", "pays.nomPays", "pays.created_at")
        ->get();
        
        return response()->json(['data' => $data]);

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
            $data = Pays::where("id", $request->id)->update([
                'nomPays' =>  $request->nomPays
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = Pays::create([

                'nomPays' =>  $request->nomPays
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
        $data = Pays::where('id', $id)->get();
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
        $data = Pays::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
