<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_ssouscompte;
use DB;

class tSSousCompteFinController extends Controller
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
            $data = DB::table('tfin_ssouscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_ssouscompte.id','refSousCompte','nom_ssouscompte','numero_ssouscompte',
            'nom_souscompte','numero_souscompte',
            'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")           
            ->where('nom_ssouscompte', 'like', '%'.$query.'%')            
            ->orderBy("tfin_ssouscompte.id", "asc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tfin_ssouscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_ssouscompte.id','refSousCompte','nom_ssouscompte','numero_ssouscompte',
            'nom_souscompte','numero_souscompte',
            'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->orderBy("tfin_ssouscompte.id", "asc")
            ->paginate(10);

            return response($data, 200);

            }

    }


    public function fetch_ssouscompte_sous(Request $request,$refSousCompte)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_ssouscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_ssouscompte.id','refSousCompte','nom_ssouscompte','numero_ssouscompte',
            'nom_souscompte','numero_souscompte',
            'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->where([
                ['nom_ssouscompte', 'like', '%'.$query.'%'],
                ['refSousCompte',$refSousCompte]
            ])                    
            ->orderBy("numero_ssouscompte", "asc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
            $data = DB::table('tfin_ssouscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_ssouscompte.id','refSousCompte','nom_ssouscompte','numero_ssouscompte',
            'nom_souscompte','numero_souscompte',
            'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
            'refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")        
            ->Where('refSousCompte',$refSousCompte)    
            ->orderBy("numero_ssouscompte", "asc")
            ->paginate(10);

            return response($data, 200);
        }

    }  
    
    function fetch_ssouscompte_sous2($refSousCompte)
    {

        $data = DB::table('tfin_ssouscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_ssouscompte.id','refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte',
        'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
        'refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")                     
        ->Where('refSousCompte',$refSousCompte)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

   function fetch_single_ssouscompte($id)
    {

        $data =  DB::table('tfin_ssouscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_ssouscompte.id','refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte',
        'refCompte','nom_compte','numero_compte','refClasse','refTypecompte',
        'refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")                    
        ->where('tfin_ssouscompte.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    //'id','refSousCompte','nom_ssouscompte','numero_ssouscompte','author'

    function insert_ssouscompte(Request $request)
    {
       
        $data = tfin_ssouscompte::create([
            'refSousCompte'       =>  $request->refSousCompte,           
            'nom_ssouscompte'    =>  $request->nom_ssouscompte,
            'numero_ssouscompte'    =>  $request->numero_ssouscompte,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_ssouscompte(Request $request, $id)
    {
        $data = tfin_ssouscompte::where('id', $id)->update([
            'refSousCompte'       =>  $request->refSousCompte,           
            'nom_ssouscompte'    =>  $request->nom_ssouscompte,
            'numero_ssouscompte'    =>  $request->numero_ssouscompte,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_ssouscompte($id)
    {
        $data = tfin_ssouscompte::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
