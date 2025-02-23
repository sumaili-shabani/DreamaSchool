<?php

namespace App\Http\Controllers\tresorerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\tresorerie\{tt_treso_detail_etatbesoin};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tt_treso_detail_etatbesoinController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //,
        //'author' =>  $request->author
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tt_treso_detail_etatbesoin')
            ->join('tt_treso_entete_etatbesoin','tt_treso_entete_etatbesoin.id','=','tt_treso_detail_etatbesoin.refEntete')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
            ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_etatbesoin.refRubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->select("tt_treso_detail_etatbesoin.id","tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique",
            "refcateRubrik","motifDepense","DateElaboration",
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","Qte","PU","tt_treso_detail_etatbesoin.author","refProvenance",
            "tt_treso_provenance.nomProvenance","codeProvenance",
            "tt_treso_detail_etatbesoin.created_at","service_beneficiaire")
            ->selectRaw('(Qte*PU) as prixTotal')
            ->where('nomProvenance', 'like', '%'.$query.'%')
            ->orWhere('codeProvenance', 'like', '%'.$query.'%')
            ->orderBy("tt_treso_detail_etatbesoin.id", "desc")
            ->paginate(10);
            return response($data, 200);
           

        }
        else{
            

            $data = DB::table('tt_treso_detail_etatbesoin')
            ->join('tt_treso_entete_etatbesoin','tt_treso_entete_etatbesoin.id','=','tt_treso_detail_etatbesoin.refEntete')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
            ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_etatbesoin.refRubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->select("tt_treso_detail_etatbesoin.id","tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique",
            "refcateRubrik","motifDepense","DateElaboration",
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","Qte","PU","tt_treso_detail_etatbesoin.author","refProvenance",
            "tt_treso_provenance.nomProvenance","codeProvenance",
            "tt_treso_detail_etatbesoin.created_at","service_beneficiaire")
            ->selectRaw('(Qte*PU) as prixTotal')
            ->orderBy("tt_treso_detail_etatbesoin.id", "desc")->paginate(10);
            return response($data, 200);
        }
    }


    public function fetch_detail_for_entete(Request $request,$refEntete)
    {      
          
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tt_treso_detail_etatbesoin')
            ->join('tt_treso_entete_etatbesoin','tt_treso_entete_etatbesoin.id','=','tt_treso_detail_etatbesoin.refEntete')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
            ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_etatbesoin.refRubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->select("tt_treso_detail_etatbesoin.id","tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique",
            "refcateRubrik","motifDepense","DateElaboration",
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","Qte","PU","tt_treso_detail_etatbesoin.author","refProvenance",
            "tt_treso_provenance.nomProvenance","codeProvenance",
            "tt_treso_detail_etatbesoin.created_at","service_beneficiaire")
            ->selectRaw('(Qte*PU) as prixTotal')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEntete',$refEntete]
            ])                     
            ->orderBy("tt_treso_detail_etatbesoin.id", "desc")
            ->paginate(10);

            return response($data, 200);         

        }
        else{
            $data = DB::table('tt_treso_detail_etatbesoin')
            ->join('tt_treso_entete_etatbesoin','tt_treso_entete_etatbesoin.id','=','tt_treso_detail_etatbesoin.refEntete')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
            ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_etatbesoin.refRubrique')
            ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
            ->select("tt_treso_detail_etatbesoin.id","tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique",
            "refcateRubrik","motifDepense","DateElaboration",
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","Qte","PU","tt_treso_detail_etatbesoin.author","refProvenance",
            "tt_treso_provenance.nomProvenance","codeProvenance",
            "tt_treso_detail_etatbesoin.created_at","service_beneficiaire")
            ->selectRaw('(Qte*PU) as prixTotal')
            ->Where('refEntete',$refEntete) 
            ->orderBy("tt_treso_detail_etatbesoin.id", "desc")
            ->paginate(10);
            return response($data, 200);
        }

    }    


 

    function fetch_treso_Detail_etatbesoin()
    {
        $data = DB::table('tt_treso_detail_etatbesoin')
        ->join('tt_treso_entete_etatbesoin','tt_treso_entete_etatbesoin.id','=','tt_treso_detail_etatbesoin.refEntete')
        ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
        ->join('tt_treso_rubrique','tt_treso_rubrique.id','=','tt_treso_detail_etatbesoin.refRubrique')
        ->join('tt_treso_categorie_rubrique','tt_treso_categorie_rubrique.id','=','tt_treso_rubrique.refcateRubrik')
        ->select("tt_treso_detail_etatbesoin.id","tt_treso_rubrique.desiRubriq","codeRubriq","NomCateRubrique",
        "refcateRubrik","motifDepense","DateElaboration",
        "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","Qte","PU","tt_treso_detail_etatbesoin.author","refProvenance",
        "tt_treso_provenance.nomProvenance","codeProvenance",
        "tt_treso_detail_etatbesoin.created_at","service_beneficiaire")
        ->selectRaw('(Qte*PU) as prixTotal')
        ->orderBy("tt_treso_detail_etatbesoin.id", "desc")
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

        //refEntete,refRubrique,Qte,PU,service_beneficiaire
        if ($request->id !='') 
        {
            //author
            # code...
            $data = tt_treso_detail_etatbesoin::where("id", $request->id)->update([
                'refEntete' =>  $request->refEntete,
                'refRubrique' =>  $request->refRubrique,
                'Qte' =>  $request->Qte,
                'PU' =>  $request->PU,
                'service_beneficiaire' =>  $request->service_beneficiaire,
                'author' =>  $request->author

            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tt_treso_detail_etatbesoin::create([
                'refEntete' =>  $request->refEntete,
                'refRubrique' =>  $request->refRubrique,
                'Qte' =>  $request->Qte,
                'PU' =>  $request->PU,
                'service_beneficiaire' =>  $request->service_beneficiaire,
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
        $data = tt_treso_detail_etatbesoin::where('id', $id)->get();
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
        $data = tt_treso_detail_etatbesoin::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
