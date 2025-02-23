<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Role\{Role};
use App\Traits\GlobalMethod;
use DB;

class RoleController extends Controller
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
        $data = DB::table("roles")
        ->select("roles.id", "roles.nom", "roles.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('roles.nom', 'like', '%'.$query.'%')
            ->orWhere('roles.id', 'like', '%'.$query.'%')
            ->orderBy("roles.id", "desc");

            return $this->apiData($data->paginate(15));
           

        }
        return $this->apiData($data->paginate(15));
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
            $data = Role::where("id", $request->id)->update([
                'nom' =>  $request->nom
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = Role::create([
                'nom' =>  $request->nom
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
        $data = Role::where('id', $id)->get();
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
        $data = Role::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
