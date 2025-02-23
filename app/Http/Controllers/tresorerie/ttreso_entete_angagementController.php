<?php

namespace App\Http\Controllers\Tresorerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\tresorerie\{ttreso_entete_angagement};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class ttreso_entete_angagementController extends Controller
{
    use GlobalMethod;
    use Slug;
   
    public function index(Request $request)
    {
        //


        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('ttreso_entete_angagement')
            ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')

            ->join('tconf_banque' , 'tconf_banque.id','=','ttreso_entete_angagement.refCaisse')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
    
            ->select("ttreso_entete_angagement.id","motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
            "ttreso_entete_angagement.author","desiBloc as designationBloc","tt_treso_provenance.nomProvenance",
            "dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
            "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
            "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
            "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
            "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
            "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
            "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant","tt_treso_provenance.codeProvenance",
            "ttreso_entete_angagement.created_at","montant as TotalBE","nom_mode","refCaisse","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte")
            ->selectRaw('CONCAT("BE",YEAR(dateEngagement),"",MONTH(dateEngagement),"00",ttreso_entete_angagement.id) as codeBE')
            ->where('nomProvenance', 'like', '%'.$query.'%')
            ->orWhere('codeProvenance', 'like', '%'.$query.'%')
            ->orderBy("ttreso_entete_angagement.id", "desc")
            ->paginate(10);

            return response($data, 200);         

        }
        else{           

            $data = DB::table('ttreso_entete_angagement')
            ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
          
            ->join('tconf_banque' , 'tconf_banque.id','=','ttreso_entete_angagement.refCaisse')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
    
            ->select("ttreso_entete_angagement.id","motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
            "ttreso_entete_angagement.author","desiBloc as designationBloc","tt_treso_provenance.nomProvenance",
            "dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
            "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
            "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
            "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
            "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
            "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
            "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant","tt_treso_provenance.codeProvenance",
            "ttreso_entete_angagement.created_at","montant as TotalBE","nom_mode","refCaisse","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte")
            ->selectRaw('CONCAT("BE",YEAR(dateEngagement),"",MONTH(dateEngagement),"00",ttreso_entete_angagement.id) as codeBE')
            ->orderBy("ttreso_entete_angagement.id", "desc")
            ->paginate(10);
            return response($data, 200);
        }
    }
 

    function fetch_single_entete_angagement()
    {
        $data = DB::table('ttreso_entete_angagement')
        ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
        ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')

        ->join('tconf_banque' , 'tconf_banque.id','=','ttreso_entete_angagement.refCaisse')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select("ttreso_entete_angagement.id","motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
        "ttreso_entete_angagement.author","desiBloc as designationBloc","tt_treso_provenance.nomProvenance",
        "dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
        "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
        "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
        "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
        "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
        "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
        "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant","tt_treso_provenance.codeProvenance",
        "ttreso_entete_angagement.created_at","montant as TotalBE","refCaisse","nom_mode","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte")
        ->selectRaw('CONCAT("BE",YEAR(dateEngagement),"",MONTH(dateEngagement),"00",ttreso_entete_angagement.id) as codeBE')
        ->orderBy("ttreso_entete_angagement.id", "desc")
        ->get();
        return response($data, 200);

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
            //refCaisse
            $data = ttreso_entete_angagement::where("id", $request->id)->update([
                'refProvenance' =>  $request->refProvenance,
                'refBloc' =>  $request->refBloc,
                'motif' =>  $request->motif,
                'dateEngagement' =>  $request->dateEngagement,
                'refCaisse' =>  $request->refCaisse,  
                'dateValiderDemandeur' =>  date('Y-m-d'),
                'StatutValiderDemandeur' =>  'OUI',
                'ValiderDemandeur' =>  $request->author,

                'dateValidertDivision' =>  date('Y-m-d'),
                'StatutValiderDivision' =>  'OUI',
                'ValiderDivision' =>  $request->author,
                'dateAtesterDivision' =>  date('Y-m-d'),
                'StatutAtesterDivision' =>  'OUI',
                'Atesterterdivision' =>  $request->author,

                'dateValiderTresorerie' =>  date('Y-m-d'),
                'ValiderStatuttresorerie' =>  'OUI',
                'ValiderTresorerie' =>  $request->author,
                'dateAtesterTresorerie' =>  date('Y-m-d'),
                'StatutAtesterTresorerie' =>  'OUI',
                'AtesterterTresorier' =>  $request->author,

                'dateValiderAdministration' =>  date('Y-m-d'),
                'ValiderStatutAdministration' =>  'OUI',
                'ValiderAdministrateur' =>  $request->author,
                'dateAtesterAdministration' =>  date('Y-m-d'),
                'StatutAtesterAdministration' =>  'OUI',
                'AtesterterAdministrateur' =>  $request->author,

                'dateValiderDirection' =>  date('Y-m-d'),
                'ValiderStatutDirection' =>  'OUI',
                'ValiderDirecteur' =>  $request->author,
                'dateAtesterDirection' =>  date('Y-m-d'),
                'StatutAtesterDirection' =>  'OUI',
                'AtesterterDirecteur' =>  $request->author,

                'dateValidertGerant' =>  date('Y-m-d'),
                'ValiderStatutGerant' =>  'OUI',
                'ValiderGerant' =>  $request->author,
                'dateAtesterGerant' =>  date('Y-m-d'),
                'StatutAtesterGerant' =>  'OUI',
                'AtesterterGerant' =>  $request->author,

                'refEtatbesoin' =>  $request->refEtatbesoin,
                'author' =>  $request->author,

            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 

            //id,refProvenance,refBloc,motif,dateEngagement,dateValiderDemandeur,StatutValiderDemandeur,
            //ValiderDemandeur,refEtatbesoin,author

            $data = ttreso_entete_angagement::create([
                'refProvenance' =>  $request->refProvenance,
                'refBloc' =>  $request->refBloc,
                'motif' =>  $request->motif,
                'dateEngagement' =>  $request->dateEngagement,
                'refCaisse' =>  $request->refCaisse,  
                'dateValiderDemandeur' =>  date('Y-m-d'),
                'StatutValiderDemandeur' =>  'OUI',
                'ValiderDemandeur' =>  $request->author,

                'dateValidertDivision' =>  date('Y-m-d'),
                'StatutValiderDivision' =>  'OUI',
                'ValiderDivision' =>  $request->author,
                'dateAtesterDivision' =>  date('Y-m-d'),
                'StatutAtesterDivision' =>  'OUI',
                'Atesterterdivision' =>  $request->author,

                'dateValiderTresorerie' =>  date('Y-m-d'),
                'ValiderStatuttresorerie' =>  'OUI',
                'ValiderTresorerie' =>  $request->author,
                'dateAtesterTresorerie' =>  date('Y-m-d'),
                'StatutAtesterTresorerie' =>  'OUI',
                'AtesterterTresorier' =>  $request->author,

                'dateValiderAdministration' =>  date('Y-m-d'),
                'ValiderStatutAdministration' =>  'OUI',
                'ValiderAdministrateur' =>  $request->author,
                'dateAtesterAdministration' =>  date('Y-m-d'),
                'StatutAtesterAdministration' =>  'OUI',
                'AtesterterAdministrateur' =>  $request->author,

                'dateValiderDirection' =>  date('Y-m-d'),
                'ValiderStatutDirection' =>  'OUI',
                'ValiderDirecteur' =>  $request->author,
                'dateAtesterDirection' =>  date('Y-m-d'),
                'StatutAtesterDirection' =>  'OUI',
                'AtesterterDirecteur' =>  $request->author,

                'dateValidertGerant' =>  date('Y-m-d'),
                'ValiderStatutGerant' =>  'OUI',
                'ValiderGerant' =>  $request->author,
                'dateAtesterGerant' =>  date('Y-m-d'),
                'StatutAtesterGerant' =>  'OUI',
                'AtesterterGerant' =>  $request->author,

                'refEtatbesoin' =>  $request->refEtatbesoin,
                'author' =>  $request->author,

            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }

    function valider_divison(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateValidertDivision' =>  date('Y-m-d'),
            'StatutValiderDivision' =>  'OUI',
            'ValiderDivision' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
    function attester_divison(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateAtesterDivision' =>  date('Y-m-d'),
            'StatutAtesterDivision' =>  'OUI',
            'Atesterterdivision' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }



    function valider_tresorerie(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateValiderTresorerie' =>  date('Y-m-d'),
            'ValiderStatuttresorerie' =>  'OUI',
            'ValiderTresorerie' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
    function attester_tresorerie(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateAtesterTresorerie' =>  date('Y-m-d'),
            'StatutAtesterTresorerie' =>  'OUI',
            'AtesterterTresorier' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }




    function valider_administration(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateValiderAdministration' =>  date('Y-m-d'),
            'ValiderStatutAdministration' =>  'OUI',
            'ValiderAdministrateur' =>  $request->author                
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
    function attester_administration(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateAtesterAdministration' =>  date('Y-m-d'),
            'StatutAtesterAdministration' =>  'OUI',
            'AtesterterAdministrateur' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }



    function valider_direction(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateValiderDirection' =>  date('Y-m-d'),
            'ValiderStatutDirection' =>  'OUI',
            'ValiderDirecteur' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function attester_direction(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateAtesterDirection' =>  date('Y-m-d'),
            'StatutAtesterDirection' =>  'OUI',
            'AtesterterDirecteur' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }


    function valider_gerant(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateValidertGerant' =>  date('Y-m-d'),
            'ValiderStatutGerant' =>  'OUI',
            'ValiderGerant' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function attester_gerant(Request $request, $id)
    {
        $data = ttreso_entete_angagement::where('id', $id)->update([
            'dateAtesterGerant' =>  date('Y-m-d'),
            'StatutAtesterGerant' =>  'OUI',
            'AtesterterGerant' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
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
        $data = ttreso_entete_angagement::where('id', $id)->get();
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
        $data = ttreso_entete_angagement::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
