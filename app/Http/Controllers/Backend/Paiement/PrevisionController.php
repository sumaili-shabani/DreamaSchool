<?php

namespace App\Http\Controllers\Backend\Paiement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Paiement\{Prevision};
use App\Traits\{GlobalMethod,Slug};
use DB;

class PrevisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     use GlobalMethod;
    public function index(Request $request)
    {
        //
        $data = DB::table("previsions")
        ->join('tranches','tranches.id','=','previsions.idTranche')
        ->join('type_tranches','type_tranches.id','=','previsions.idFrais')
        
        ->join('classes','classes.id','=','previsions.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','previsions.idAnne')
        ->join('options','options.id','=','previsions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        
        ->select("previsions.id",
            //previsions
            'previsions.idTranche','previsions.idFrais',
            'previsions.idClasse','previsions.idOption',
            'previsions.idAnne','previsions.montant',
            'previsions.etatPrevision',
            'previsions.date_debit_prev','previsions.date_fin_prev',

            //tranches 
            "tranches.nomTranche",

            //type tranche
            'type_tranches.nomTypeTranche', 

           
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "previsions.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('previsions.montant', 'like', '%'.$query.'%')
            ->orWhere('tranches.nomTranche', 'like', '%'.$query.'%')
            ->orWhere('type_tranches.nomTypeTranche', 'like', '%'.$query.'%')
            ->orWhere('classes.nomClasse', 'like', '%'.$query.'%')
            ->orWhere('options.nomOption', 'like', '%'.$query.'%')
            ->orderBy("previsions.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("previsions.id", "desc");
        return $this->apiData($data->paginate(10));
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
            $data = Prevision::where("id", $request->id)->update([
                'idTranche'         =>  $request->idTranche,
                'idFrais'           =>  $request->idFrais,
                'idClasse'          =>  $request->idClasse,
                'idOption'          =>  $request->idOption,
                'idAnne'            =>  $request->idAnne,
                'montant'           =>  $request->montant,

                'date_debit_prev'   =>  $request->date_debit_prev,
                'date_fin_prev'     =>  $request->date_fin_prev,
                
               
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $countData = $this->showCountTablePrevision($request->idTranche,$request->idFrais, $request->idAnne, $request->idClasse);
            if ($countData <=0) {
                // code...
                $codePaiement= date('Y').'-'.date('m').'-'.mt_rand(5, 1000000);
                $data = Prevision::create([
                    'idTranche'         =>  $request->idTranche,
                    'idFrais'           =>  $request->idFrais,
                    'idClasse'          =>  $request->idClasse,
                    'idOption'          =>  $request->idOption,
                    'idAnne'            =>  $request->idAnne,
                    'montant'           =>  $request->montant,
                    'date_debit_prev'   =>  $request->date_debit_prev,
                    'date_fin_prev'     =>  $request->date_fin_prev,
                ]);
                return response()->json(['data'  =>  "Insertion avec succès!!!"]);
            } else {
                // code...
                // return response()->json(['data'  =>  "Désolé ce frais a été déjà enregistré dans cette promotion, prière de selectionner un autre frais Svp!!!"]);

                $codePaiement= date('Y').'-'.date('m').'-'.mt_rand(5, 1000000);
                $data = Prevision::create([
                    'idTranche'         =>  $request->idTranche,
                    'idFrais'           =>  $request->idFrais,
                    'idClasse'          =>  $request->idClasse,
                    'idOption'          =>  $request->idOption,
                    'idAnne'            =>  $request->idAnne,
                    'montant'           =>  $request->montant,
                    'date_debit_prev'   =>  $request->date_debit_prev,
                    'date_fin_prev'     =>  $request->date_fin_prev,
                ]);
                return response()->json(['data'  =>  "Insertion avec succès!!!"]);
                
            }
            


        }
    }

    function chect_validation_prevision($id, $etat)
    {
        if ($id !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                Prevision::where('id',$id)->update([
                    'etatPrevision'         =>  0
                ]);
                return $this->msgJson('le paiement a été invalidé avec succès!');

            } else {
                // activation
                Prevision::where('id',$id)->update([
                    'etatPrevision'         =>  1
                ]);
                return $this->msgJson('le paiement a été validé  avec succès!');
            }

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
        $data = DB::table("previsions")
        ->join('tranches','tranches.id','=','previsions.idTranche')
        ->join('type_tranches','type_tranches.id','=','previsions.idFrais')
        
        ->join('classes','classes.id','=','previsions.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','previsions.idAnne')
        ->join('options','options.id','=','previsions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        
        ->select("previsions.id",
            //previsions
            'previsions.idTranche','previsions.idFrais',
            'previsions.idClasse','previsions.idOption',
            'previsions.idAnne','previsions.montant',
            'previsions.etatPrevision',
            'previsions.date_debit_prev','previsions.date_fin_prev',

            //tranches 
            "tranches.nomTranche",

            //type tranche
            'type_tranches.nomTypeTranche', 

           
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "previsions.created_at")
        ->where('previsions.id', $id)->get();
        return response()->json(['data'  =>  $data]);
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
        $data = Prevision::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }


}
