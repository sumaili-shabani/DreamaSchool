<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_detail_operationcompte;
use App\Models\tDepense;

use DB;

class tfin_detail_operationcompteController extends Controller
{
    public function index()
    {
        return 'hello';
    }
//
    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }
   
    public function all(Request $request)
    {
        //tfin_detail_operationcompte
               
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tfin_detail_operationcompte')
            ->join('tfin_entete_operationcompte','tfin_entete_operationcompte.id','=','tfin_detail_operationcompte.refEnteteOperation')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_detail_operationcompte.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                //MALADE
            ->select("tfin_detail_operationcompte.id","refEnteteOperation","refSscompte",
            "typeOperation","montantOpration","refSscompte",'refSousCompte','nom_ssouscompte',
            'numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
            'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe',"libelleOperation",
            "dateOpration","numOpereation",'tauxdujour','tfin_entete_operationcompte.author','nom_typeposition',"nom_typecompte")
            ->where('nom_ssouscompte', 'like', '%'.$query.'%')           
            ->orderBy("tfin_detail_operationcompte.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tfin_detail_operationcompte')
            ->join('tfin_entete_operationcompte','tfin_entete_operationcompte.id','=','tfin_detail_operationcompte.refEnteteOperation')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_detail_operationcompte.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                //MALADE
            ->select("tfin_detail_operationcompte.id","refEnteteOperation","refSscompte",
            "typeOperation","montantOpration","refSscompte",'refSousCompte','nom_ssouscompte',
            'numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
            'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe',"libelleOperation",
            "dateOpration","numOpereation",'tauxdujour','tfin_entete_operationcompte.author','nom_typeposition',"nom_typecompte")
            ->orderBy("tfin_detail_operationcompte.id", "desc")              
            ->paginate(10);

            return response($data, 200);

            }

    }


    public function fetch_detail_entete(Request $request,$refEnteteOperation)
    {     
        //id,refEnteteOperation,refSscompte,typeOperation,montantOpration
        //  //id","libelleOperation","dateOpration","numOpereation",'tauxdujour','tfin_entete_operationcompte.author'  tfin_entete_operationcompte

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_detail_operationcompte')
            ->join('tfin_entete_operationcompte','tfin_entete_operationcompte.id','=','tfin_detail_operationcompte.refEnteteOperation')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_detail_operationcompte.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                //MALADE
            ->select("tfin_detail_operationcompte.id","refEnteteOperation","refSscompte",
            "typeOperation","montantOpration","refSscompte",'refSousCompte','nom_ssouscompte',
            'numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
            'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe',"libelleOperation",
            "dateOpration","numOpereation",'tauxdujour','tfin_entete_operationcompte.author','nom_typeposition',"nom_typecompte")
            ->where([
                ['nom_ssouscompte', 'like', '%'.$query.'%'],
                ['refEnteteOperation',$refEnteteOperation]
            ])                      
            ->orderBy("tfin_detail_operationcompte.id", "desc")
            ->paginate(10);

            return response($data, 200);         

        }
        else{
            $data = DB::table('tfin_detail_operationcompte')
            ->join('tfin_entete_operationcompte','tfin_entete_operationcompte.id','=','tfin_detail_operationcompte.refEnteteOperation')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_detail_operationcompte.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                //MALADE
            ->select("tfin_detail_operationcompte.id","refEnteteOperation","refSscompte",
            "typeOperation","montantOpration","refSscompte",'refSousCompte','nom_ssouscompte',
            'numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
            'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe',"libelleOperation",
            "dateOpration","numOpereation",'tauxdujour','tfin_entete_operationcompte.author','nom_typeposition',"nom_typecompte")
            ->where([
                ['refEnteteOperation',$refEnteteOperation]
            ])      
            ->orderBy("tfin_detail_operationcompte.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    } 

    function fetch_single_detail($id)
    {

        $data = DB::table('tfin_detail_operationcompte')
        ->join('tfin_entete_operationcompte','tfin_entete_operationcompte.id','=','tfin_detail_operationcompte.refEnteteOperation')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_detail_operationcompte.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            //MALADE
        ->select("tfin_detail_operationcompte.id","refEnteteOperation","refSscompte",
        "typeOperation","montantOpration","refSscompte",'refSousCompte','nom_ssouscompte',
        'numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe',"libelleOperation",
        "dateOpration","numOpereation",'tauxdujour','tfin_entete_operationcompte.author','nom_typeposition',"nom_typecompte")
        ->where('tfin_detail_operationcompte.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    function insert_detail(Request $request)
    {
        //id,refEnteteOperation,refSscompte,typeOperation,montantOpration
        $data = tfin_detail_operationcompte::create([
            'refEnteteOperation'       =>  $request->refEnteteOperation,
            'refSscompte'       =>  $request->refSscompte,
            'typeOperation'       =>  $request->typeOperation,
            'montantOpration'       =>  $request->montantOpration
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

    }


    function update_detail(Request $request, $id)
    {
        $data = tfin_detail_operationcompte::where('id', $id)->update([
            'refEnteteOperation'       =>  $request->refEnteteOperation,
            'refSscompte'       =>  $request->refSscompte,
            'typeOperation'       =>  $request->typeOperation,
            'montantOpration'       =>  $request->montantOpration
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

    }

    function delete_detail($id)
    {
        $data = tfin_detail_operationcompte::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
    


}
