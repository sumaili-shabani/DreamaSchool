<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tconf_banque};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tBanqueController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tconf_banque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

            ->select("tconf_banque.id","tconf_banque.nom_banque",
            "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tconf_banque.author',
            'nom_typeposition',"nom_typecompte","tconf_banque.created_at")
            ->where('nom_banque', 'like', '%'.$query.'%')            
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);

        }
        else{
            $data = DB::table('tconf_banque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

            ->select("tconf_banque.id","tconf_banque.nom_banque",
            "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tconf_banque.author',
            'nom_typeposition',"nom_typecompte","tconf_banque.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }


    function fetch_tconf_banque_2()
    {
        $data = DB::table('tconf_banque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        
        ->select("tconf_banque.id","tconf_banque.nom_banque",
        "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tconf_banque.author',
        'nom_typeposition',"nom_typecompte","tconf_banque.created_at")
        ->orderBy("id", "desc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

    }

    function fetch_list_banque($nom_mode)
    {
        $data = DB::table('tconf_banque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        
        ->select("tconf_banque.id","tconf_banque.nom_banque",
        "tconf_banque.numerocompte","tconf_banque.nom_mode",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tconf_banque.author',
        'nom_typeposition',"nom_typecompte","refSscompte")
        ->where('tconf_banque.nom_mode', $nom_mode)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }


    // function fetch_list_banque_id($nom_mode)
    // {
    //     $data = DB::table('tconf_banque')
    //     ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
    //     ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
    //     ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
    //     ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
    //     ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
    //     ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        
    //     ->select("tconf_banque.id","tconf_banque.nom_banque",
    //     "tconf_banque.numerocompte","tconf_banque.nom_mode",
    //     'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
    //     'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
    //     'refTypecompte','refPosition','nom_classe','numero_classe','tconf_banque.author',
    //     'nom_typeposition',"nom_typecompte","refSscompte")
    //     ->where('tconf_banque.nom_mode', $nom_mode)
    //     ->get();

    //     return response()->json([
    //         'data'  => $data,
    //     ]);
    // }


    
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
            // ,"author"
            $data = tconf_banque::where("id", $request->id)->update([
                'nom_banque' =>  $request->nom_banque,
                'numerocompte' =>  $request->numerocompte,
                'nom_mode' =>  $request->nom_mode,
                'refSscompte' =>  $request->refSscompte,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tconf_banque::create([

                'nom_banque' =>  $request->nom_banque,
                'numerocompte' =>  $request->numerocompte,
                'nom_mode' =>  $request->nom_mode,
                'refSscompte' =>  $request->refSscompte,
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
        $data = tconf_banque::where('id', $id)->get();
        return response()->json(['data' => $data]);
    }

    function fetch_list_mode()
    {

        $data = DB::table('tconf_modepaie')->select("tconf_modepaie.id","tconf_modepaie.nom_mode")->get();

        return response()->json([
            'data'  => $data,
        ]);
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
        $data = tconf_banque::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
