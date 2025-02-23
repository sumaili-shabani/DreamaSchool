<?php

namespace App\Http\Controllers\tresorerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\tresorerie\{tt_treso_detail_angagement};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tt_treso_detail_angagementController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query')))
         {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tt_treso_detail_angagement')
            ->join('ttreso_entete_angagement','ttreso_entete_angagement.id','=','tt_treso_detail_angagement.refEntete')
            ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_angagement.refRubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
            ->select("tt_treso_detail_angagement.id","refEntete","refRubrique","Qte","PU",
            "motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
            "tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique","refcateRubrik",
            "ttreso_entete_angagement.author","desiBloc as designationBloc","dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
            "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
            "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
            "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
            "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
            "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
            "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant",".nomProvenance","codeProvenance",
            "tt_treso_detail_angagement.created_at")
            ->selectRaw('(Qte*PU) as prixTotal')
            ->where('nomProvenance', 'like', '%'.$query.'%')
            ->orderBy("tt_treso_detail_angagement.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
            
            $data = DB::table('tt_treso_detail_angagement')
            ->join('ttreso_entete_angagement','ttreso_entete_angagement.id','=','tt_treso_detail_angagement.refEntete')
            ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_angagement.refRubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
            ->select("tt_treso_detail_angagement.id","refEntete","refRubrique","Qte","PU",
            "motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
            "tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique","refcateRubrik",
            "ttreso_entete_angagement.author","desiBloc as designationBloc","dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
            "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
            "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
            "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
            "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
            "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
            "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant",".nomProvenance","codeProvenance",
            "tt_treso_detail_angagement.created_at")
            ->selectRaw('(Qte*PU) as prixTotal')
            ->orderBy("tt_treso_detail_angagement.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }



    public function fetch_detail_for_entete(Request $request,$refEntete)
    {      
          
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tt_treso_detail_angagement')
            ->join('ttreso_entete_angagement','ttreso_entete_angagement.id','=','tt_treso_detail_angagement.refEntete')
            ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_angagement.refRubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
            ->select("tt_treso_detail_angagement.id","refEntete","refRubrique","Qte","PU",
            "motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
            "tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique","refcateRubrik",
            "ttreso_entete_angagement.author","desiBloc as designationBloc","dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
            "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
            "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
            "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
            "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
            "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
            "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant",".nomProvenance","codeProvenance",
            "tt_treso_detail_angagement.created_at")
            ->selectRaw('(Qte*PU) as prixTotal')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEntete',$refEntete]
            ])                     
            ->orderBy("tt_treso_detail_angagement.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
            $data = DB::table('tt_treso_detail_angagement')
            ->join('ttreso_entete_angagement','ttreso_entete_angagement.id','=','tt_treso_detail_angagement.refEntete')
            ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_angagement.refRubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
            ->select("tt_treso_detail_angagement.id","refEntete","refRubrique","Qte","PU",
            "motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
            "tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique","refcateRubrik",
            "ttreso_entete_angagement.author","desiBloc as designationBloc","dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
            "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
            "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
            "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
            "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
            "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
            "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant",".nomProvenance","codeProvenance",
            "tt_treso_detail_angagement.created_at")
            ->selectRaw('(Qte*PU) as prixTotal')
            ->Where('refEntete',$refEntete) 
            ->orderBy("tt_treso_detail_angagement.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    }    



 

    function fetch_ttreso_Detail_angagement()
    {
        $data = DB::table('tt_treso_detail_angagement')
        ->join('ttreso_entete_angagement','ttreso_entete_angagement.id','=','tt_treso_detail_angagement.refEntete')
        ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_angagement.refRubrique')
        ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
        ->join('tt_treso_bloc','tt_treso_bloc.id','=','ttreso_entete_angagement.refBloc')
        ->join('tt_treso_provenance','tt_treso_provenance.id','=','ttreso_entete_angagement.refProvenance')
        ->select("tt_treso_detail_angagement.id","refEntete","refRubrique","Qte","PU",
        "motif","refBloc","refProvenance",'refEtatbesoin',"dateEngagement",
        "tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique","refcateRubrik",
        "ttreso_entete_angagement.author","desiBloc as designationBloc","dateValiderDemandeur","StatutValiderDemandeur","ValiderDemandeur","dateValidertDivision","StatutValiderDivision",
        "ValiderDivision","dateAtesterDivision","StatutAtesterDivision","Atesterterdivision","dateValiderTresorerie",
        "ValiderStatuttresorerie","ValiderTresorerie","dateAtesterTresorerie","StatutAtesterTresorerie","AtesterterTresorier",
        "dateValiderAdministration","ValiderStatutAdministration","ValiderAdministrateur","dateAtesterAdministration",
        "StatutAtesterAdministration","AtesterterAdministrateur","dateValiderDirection","ValiderStatutDirection","ValiderDirecteur",
        "dateAtesterDirection","StatutAtesterDirection","AtesterterDirecteur","dateValidertGerant","ValiderStatutGerant",
        "ValiderGerant","dateAtesterGerant","StatutAtesterGerant","AtesterterGerant",".nomProvenance","codeProvenance",
        "tt_treso_detail_angagement.created_at")
        ->selectRaw('(Qte*PU) as prixTotal')
        ->orderBy("tt_treso_detail_angagement.id", "desc")
        ->paginate(10);
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

            $data = tt_treso_detail_angagement::where("id", $request->id)->update([
                'refEntete' =>  $request->refEntete,
                'refRubrique' =>  $request->refRubrique,
                'Qte' =>  $request->Qte,
                'PU' =>  $request->PU

            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            
            $qte= floatval($request->Qte);
            $montants=floatval($request->PU);
            $idFacture=$request->refEntete;

            $data = tt_treso_detail_angagement::create([
                'refEntete' =>  $request->refEntete,
                'refRubrique' =>  $request->refRubrique,
                'Qte' =>  $qte,
                'PU' =>  $montants,
            ]);

            $data3 = DB::update(
                'update ttreso_entete_angagement set montant = montant + (:pu * :qte) where id = :refEntete',
                ['PU' => $montants,'Qte' => $qte,'refEntete' => $idFacture]
            );

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
        $data = tt_treso_detail_angagement::where('id', $id)->get();
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

        $qte=0;
        $idFacture=0;
        $montants=0;

        $deleteds = DB::table('tt_treso_detail_angagement')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = floatval($deleted->Qte);
            $idFacture = $deleted->refEntete;
            $montants = floatval($deleted->PU);
        }

        $data3 = DB::update(
            'update ttreso_entete_angagement set montant = montant - (:pu * :qte) where id = :refEntete',
            ['PU' => $montants,'Qte' => $qte,'refEntete' => $idFacture]
        );

        $data = tt_treso_detail_angagement::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
