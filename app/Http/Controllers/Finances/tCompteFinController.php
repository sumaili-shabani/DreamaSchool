<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_compte;
use DB;

class tCompteFinController extends Controller
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
        
    //        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tfin_compte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_compte.id','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_compte.author',
            'nom_typeposition',"nom_typecompte")           
            ->where('nom_compte', 'like', '%'.$query.'%')            
            ->orderBy("tfin_compte.id", "asc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tfin_compte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_compte.id','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_compte.author',
            'nom_typeposition',"nom_typecompte")
            ->orderBy("tfin_compte.id", "asc")
            ->paginate(10);

            return response($data, 200);
            }

    }


    public function fetch_compte_classe(Request $request,$refClasse)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_compte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_compte.id','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_compte.author',
            'nom_typeposition',"nom_typecompte")
            ->where([
                ['nom_compte', 'like', '%'.$query.'%'],
                ['refClasse',$refClasse]
            ])                    
            ->orderBy("nom_compte", "asc")
            ->paginate(10);

           return response($data, 200);         

        }
        else{
            $data = DB::table('tfin_compte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_compte.id','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_compte.author',
            'nom_typeposition',"nom_typecompte")        
            ->Where('refClasse',$refClasse)    
            ->orderBy("nom_compte", "asc")
            ->paginate(10);

            return response($data, 200);
        }

    }  
    
    function fetch_compte_classe2($refClasse)
    {

        $data = DB::table('tfin_compte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_compte.id','nom_compte','numero_compte','refClasse','refTypecompte',
        'refPosition','nom_classe','numero_classe','tfin_compte.author',
        'nom_typeposition',"nom_typecompte")                    
        ->where('refClasse', $refClasse)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    function fetch_compte2()
    {

        $data = DB::table('tfin_compte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_compte.id','nom_compte','numero_compte','refClasse','refTypecompte',
        'refPosition','nom_classe','numero_classe','tfin_compte.author',
        'nom_typeposition',"nom_typecompte")                    
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

   function fetch_single_compte($id)
    {

        $data = DB::table('tfin_compte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_compte.id','nom_compte','numero_compte','refClasse','refTypecompte',
        'refPosition','nom_classe','numero_classe','tfin_compte.author',
        'nom_typeposition',"nom_typecompte")                     
        ->where('tfin_compte.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    function insert_compte(Request $request)
    {
       
        $data = tfin_compte::create([
            'refClasse'       =>  $request->refClasse,
            'refTypecompte'       =>  $request->refTypecompte,
            'refPosition'       =>  $request->refPosition,
            'nom_compte'    =>  $request->nom_compte,
            'numero_compte'    =>  $request->numero_compte,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_compte(Request $request, $id)
    {
        $data = tfin_compte::where('id', $id)->update([
            'refClasse'       =>  $request->refClasse,
            'refTypecompte'       =>  $request->refTypecompte,
            'refPosition'       =>  $request->refPosition,
            'nom_compte'    =>  $request->nom_compte,
            'numero_compte'    =>  $request->numero_compte,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_compte($id)
    {
        $data = tfin_compte::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
