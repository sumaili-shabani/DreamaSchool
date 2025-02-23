<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Site\{Site};

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

use App\Traits\GlobalMethod;
use DB;
use URL;
use Auth;

class SiteController extends Controller
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
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 
        'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube');
        

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%')
            ->orderBy("id", "asc");

            return $this->apiData($data->paginate(4));
           
 
        }
        return $this->apiData($data->paginate(4));
    }

    function fetch_site_2()
    {
         $data = DB::table('sites')
         ->select('id', 'nom', 'description', 'email','adresse as adresseEntreprise',
         'tel1 as telephoneEntreprise','tel2 as telephone','tel3 as emailEntreprise','token', 
         'about','mission','objectif','politique','condition as rccm','logo','facebook','linkedin','twitter','youtube')
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
            $data = Site::where("id", $request->id)->update([
                'nom'               =>  $request->nom,
                'email'             =>  $request->email,
                'description'       =>  $request->description,
                'adresse'           =>  $request->adresse,
                'tel1'              =>  $request->tel1,
                'tel2'              =>  $request->tel2,
                'tel3'              =>  $request->tel3,
                'token'             =>  $request->token,
                'about'             =>  $request->about,
                'mission'           =>  $request->mission,
                'objectif'          =>  $request->objectif,
                'politique'         =>  $request->politique,

                'condition'         =>  $request->condition,
                'facebook'          =>  $request->facebook,
                'twitter'           =>  $request->twitter,
                'linkedin'          =>  $request->linkedin,
                'youtube'           =>  $request->youtube
                
            ]);

            return response()->json([
                'data'  =>  "Modification information avec succès!!!"
            ]);

            // $this->msgJson("Modification information avec succès!!!");

        }
        else
        {
            // insertion 
            $data = Site::create([
                'nom'               =>  $request->nom,
                'email'             =>  $request->email,
                'description'       =>  $request->description,
                'adresse'           =>  $request->adresse,
                'tel1'              =>  $request->tel1,
                'tel2'              =>  $request->tel2,
                'tel3'              =>  $request->tel3,
                'token'             =>  $request->token,
                'about'             =>  $request->about,
                'mission'           =>  $request->mission,
                'objectif'          =>  $request->objectif,
                'politique'         =>  $request->politique,

                'condition'         =>  $request->condition,

                'facebook'          =>  $request->facebook,
                'twitter'           =>  $request->twitter,
                'linkedin'          =>  $request->linkedin,
                'youtube'           =>  $request->youtube
            ]);

            

            return response()->json([
                'data'  =>  "Insertion avec succès!!!"
            ]);
           
           

        }

    }

    function editPhoto(Request $request)
    {
      if (!is_null($request->image)) 
      {
        $formData = json_decode($_POST['data']);
        $imageName = time().'.'.$request->image->getClientOriginalExtension();

        // $request->image->move(storage_path('app/public/images/'), $imageName);
        $request->image->move(public_path('/images'), $imageName);

        Site::where('id',$formData->agentId)->update(['logo' => $imageName]);
        return $this->msgJson('Fichier ajouté avec succès');

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
        $data = Site::where('id', $id)->get();
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
        $data = Site::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
