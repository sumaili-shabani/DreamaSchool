<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_souscompte;
use DB;

class tSousCompteFinController extends Controller
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
            //tfin_souscompte
            $data = DB::table('tfin_souscompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_souscompte.id','nom_souscompte','numero_souscompte',
            'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_souscompte.author',
            'nom_typeposition',"nom_typecompte")           
            ->where('nom_souscompte', 'like', '%'.$query.'%')            
            ->orderBy("tfin_souscompte.id", "asc")          
            ->paginate(10);

            return response($data, 200);          

        }
        else{
            $data = DB::table('tfin_souscompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_souscompte.id','nom_souscompte','numero_souscompte',
            'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_souscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->orderBy("tfin_souscompte.id", "asc")
            ->paginate(10);

            return response($data, 200);

            }

    }


    public function fetch_souscompte_compte(Request $request,$refCompte)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_souscompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_souscompte.id','nom_souscompte','numero_souscompte',
            'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_souscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->where([
                ['nom_souscompte', 'like', '%'.$query.'%'],
                ['refCompte',$refCompte]
            ])                    
            ->orderBy("numero_souscompte", "asc")
            ->paginate(10);

           return response($data, 200);          

        }
        else{
            $data = DB::table('tfin_souscompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_souscompte.id','nom_souscompte','numero_souscompte',
            'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_souscompte.author',
            'nom_typeposition',"nom_typecompte")        
            ->Where('refCompte',$refCompte)    
            ->orderBy("numero_souscompte", "asc")
            ->paginate(10);

            return response($data, 200);
        }

    }  
    
    function fetch_souscompte_compte2($refCompte)
    {

        $data = DB::table('tfin_souscompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_souscompte.id','nom_souscompte','numero_souscompte',
        'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
        'refPosition','nom_classe','numero_classe','tfin_souscompte.author',
        'nom_typeposition',"nom_typecompte")                    
        ->Where('refCompte',$refCompte)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

   function fetch_single_souscompte($id)
    {

        $data = DB::table('tfin_souscompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_souscompte.id','nom_souscompte','numero_souscompte',
        'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
        'refPosition','nom_classe','numero_classe','tfin_souscompte.author',
        'nom_typeposition',"nom_typecompte")                     
        ->where('tfin_souscompte.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    function insert_souscompte(Request $request)
    {
       
        $data = tfin_souscompte::create([
            'refCompte'       =>  $request->refCompte,           
            'nom_souscompte'    =>  $request->nom_souscompte,
            'numero_souscompte'    =>  $request->numero_souscompte,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_souscompte(Request $request, $id)
    {
        $data = tfin_souscompte::where('id', $id)->update([
            'refCompte'       =>  $request->refCompte,           
            'nom_souscompte'    =>  $request->nom_souscompte,
            'numero_souscompte'    =>  $request->numero_souscompte,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_souscompte($id)
    {
        $data = tfin_souscompte::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
