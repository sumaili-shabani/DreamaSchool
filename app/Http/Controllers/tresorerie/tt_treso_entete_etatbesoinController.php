<?php

namespace App\Http\Controllers\tresorerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\tresorerie\{tt_treso_entete_etatbesoin};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tt_treso_entete_etatbesoinController extends Controller
{
    use GlobalMethod;
    use Slug;

    
    public function index(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tt_treso_entete_etatbesoin')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
            ->select("tt_treso_entete_etatbesoin.id","motifDepense","DateElaboration",
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tt_treso_entete_etatbesoin.author","refProvenance",
            "tt_treso_provenance.nomProvenance","codeProvenance",
            "tt_treso_entete_etatbesoin.created_at")
            ->selectRaw('CONCAT("EB",YEAR(DateElaboration),"",MONTH(DateElaboration),"00",tt_treso_entete_etatbesoin.id) as codeEB')
            ->where('nomProvenance', 'like', '%'.$query.'%')
            ->orWhere('codeProvenance', 'like', '%'.$query.'%')
            ->orderBy("tt_treso_entete_etatbesoin.id", "desc")
            ->paginate(10);

            return response($data, 200);         

        }
        else{           

            $data = DB::table('tt_treso_entete_etatbesoin')
            ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
            ->select("tt_treso_entete_etatbesoin.id","motifDepense","DateElaboration",
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tt_treso_entete_etatbesoin.author","refProvenance",
            "tt_treso_provenance.nomProvenance","codeProvenance",
            "tt_treso_entete_etatbesoin.created_at")
            ->orderBy("tt_treso_entete_etatbesoin.id", "desc")
            ->selectRaw('CONCAT("EB",YEAR(DateElaboration),"",MONTH(DateElaboration),"00",tt_treso_entete_etatbesoin.id) as codeEB')
            ->paginate(10);
            return response($data, 200);
        }
    }

 

    function fetch_treso_entete_etatbesoin()
    {
        $data = DB::table('tt_treso_entete_etatbesoin')
        ->join('tt_treso_provenance','tt_treso_provenance.id','=','tt_treso_entete_etatbesoin.refProvenance')
        ->select("tt_treso_entete_etatbesoin.id","motifDepense","DateElaboration",
        "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","tt_treso_entete_etatbesoin.author","refProvenance",
        "tt_treso_provenance.nomProvenance","codeProvenance",
        "tt_treso_entete_etatbesoin.created_at")
        ->selectRaw('CONCAT("EB",YEAR(DateElaboration),"",MONTH(DateElaboration),"00",tt_treso_entete_etatbesoin.id) as codeEB')
        ->orderBy("tt_treso_entete_etatbesoin.id", "desc")
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
        //refProvenance,motifDepense,DateElaboration,AcquitterPar,StatutAcquitterPar,DateAcquitterPar,ApproCoordi,StatutApproCoordi

        if ($request->id !='') 
        {
            //author
            # code...
            $data = tt_treso_entete_etatbesoin::where("id", $request->id)->update([
                'refProvenance' =>  $request->refProvenance,
                'motifDepense' =>  $request->motifDepense,
                'DateElaboration' =>  $request->DateElaboration,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // refProvenance , motifDepense, DateElaboration,author
            $data = tt_treso_entete_etatbesoin::create([
                'refProvenance' =>  $request->refProvenance,
                'motifDepense' =>  $request->motifDepense,
                'DateElaboration' =>  $request->DateElaboration,
                'author' =>  $request->author
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }
    


    function aquitter_etatbesoin(Request $request, $id)
    {
        $data = tt_treso_entete_etatbesoin::where('id', $id)->update([
            'DateAcquitterPar' =>  date('Y-m-d'),
            'StatutAcquitterPar' =>  'OUI',
            'AcquitterPar' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function approuver_etatbesoin(Request $request, $id)
    {
        $data = tt_treso_entete_etatbesoin::where('id', $id)->update([
            'DateApproCoordi' =>  date('Y-m-d'),
            'StatutApproCoordi' =>  'OUI',
            'ApproCoordi' =>  $request->author
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
        $data = tt_treso_entete_etatbesoin::where('id', $id)->get();
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
        $data = tt_treso_entete_etatbesoin::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
