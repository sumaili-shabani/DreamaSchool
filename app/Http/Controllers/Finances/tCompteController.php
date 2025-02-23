<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Finances\tcompte;
use DB;

class tCompteController extends Controller
{
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    {     
        
        $data = DB::table('tcompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tcompte.refMvt')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')      
        ->select("tcompte.id","tcompte.refMvt","tcompte.designation as Compte","refMvt",'refSscompte',
        "ttypemouvement.designation as TypeMouvement",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe',
        'nom_typeposition',"nom_typecompte","tcompte.created_at");
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tcompte.designation', 'like', '%'.$query.'%')
            ->orWhere('ttypemouvement.designation', 'like', '%'.$query.'%')
            ->orderBy("tcompte.id", "asc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tcompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tcompte.refMvt')  
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')      
            ->select("tcompte.id","tcompte.refMvt","tcompte.designation as Compte","refMvt",'refSscompte',
            "ttypemouvement.designation as TypeMouvement",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe',
            'nom_typeposition',"nom_typecompte","tcompte.created_at")
            ->orderBy("tcompte.id", "asc")
            ->paginate(10);

            return response($data, 200);
        }

    }   



    //mes scripts
    

    function fetch_typemouvement()
    {

        $data = DB::table('ttypemouvement')->select("ttypemouvement.id","ttypemouvement.designation")
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }
   
    function fetch_single_compte($id)
    {

        $data = DB::table('tcompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tcompte.refMvt')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')      
        ->select("tcompte.id","tcompte.refMvt","tcompte.designation as Compte","refMvt",'refSscompte',
        "ttypemouvement.designation as TypeMouvement",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe',
        'nom_typeposition',"nom_typecompte","tcompte.created_at")
        ->where('tcompte.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //refSscompte
    function insert_compte(Request $request)
    {
       
        $data = tcompte::create([
            'designation'       =>  $request->designation,
            'refMvt'    =>  $request->refMvt,
            'refSscompte'    =>  $request->refSscompte
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_compte(Request $request, $id)
    {
        $data = tcompte::where('id', $id)->update([
            'designation'       =>  $request->designation,
            'refMvt'    =>  $request->refMvt,
            'refSscompte'    =>  $request->refSscompte
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_compte($id)
    {
        $data = tcompte::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
