<?php

namespace App\Http\Controllers\Backend\Paiement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Paiement\{Clauture};
use App\Traits\{GlobalMethod,Slug};
use DB;

class ClautureController extends Controller
{
     use GlobalMethod;
    public function index(Request $request)
    {
        //
        $data = DB::table("clautures")
        ->join('classes','classes.id','=','clautures.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','clautures.idAnne')
        ->join('options','options.id','=','clautures.idOption')
        ->join('sections','sections.id','=','options.idSection')

        ->leftjoin('mois_scolaires','mois_scolaires.id','=','clautures.refMois')
        
        ->select("clautures.id",
            //clautures
            'clautures.idAnne','clautures.idOption',
            'clautures.idClasse','clautures.idSection',
            'clautures.refMois','clautures.mois',
            'clautures.effectifClasse','clautures.effectifAbandon',
            'clautures.effectifTotal',

            //mois scolaire
            "mois_scolaires.nomMois",

            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "clautures.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('clautures.effectifTotal', 'like', '%'.$query.'%')
            ->orWhere('clautures.effectifClasse', 'like', '%'.$query.'%')
            ->orWhere('clautures.effectifAbandon', 'like', '%'.$query.'%')
            ->orWhere('classes.nomClasse', 'like', '%'.$query.'%')
            ->orWhere('sections.nomSection', 'like', '%'.$query.'%')
            ->orWhere('options.nomOption', 'like', '%'.$query.'%')
            ->orderBy("clautures.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("clautures.id", "desc");
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
            $data = Clauture::where("id", $request->id)->update([
                'idClasse'          =>  $request->idClasse,
                'idOption'          =>  $request->idOption,
                'idAnne'            =>  $request->idAnne,
                'idSection'         =>  $request->idSection,
                'refMois'           =>  $request->refMois,
                'mois'              =>  $request->mois,
                'effectifClasse'    =>  $request->effectifClasse,

                'effectifAbandon'   =>  $request->effectifAbandon,
                'effectifTotal'     =>  $request->effectifTotal,
                
               
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $countData = $this->showCountTableClauture($request->refMois, $request->idAnne, $request->idClasse);
            if ($countData <=0) {
                // code...
                $data = Clauture::create([
                    'idClasse'          =>  $request->idClasse,
                    'idOption'          =>  $request->idOption,
                    'idAnne'            =>  $request->idAnne,
                    'idSection'         =>  $request->idSection,
                    'refMois'           =>  $request->refMois,
                    'mois'              =>  $request->mois,
                    'effectifClasse'    =>  $request->effectifClasse,

                    'effectifAbandon'   =>  $request->effectifAbandon,
                    'effectifTotal'     =>  $request->effectifTotal,
                ]);
                return response()->json(['data'  =>  "Insertion avec succès!!!"]);
            } else {
                // code...
                // return response()->json(['data'  =>  "Désolé ce frais a été déjà enregistré dans cette promotion, prière de selectionner un autre frais Svp!!!"]);

                $data = Clauture::create([
                    'idClasse'          =>  $request->idClasse,
                    'idOption'          =>  $request->idOption,
                    'idAnne'            =>  $request->idAnne,
                    'idSection'         =>  $request->idSection,
                    'refMois'           =>  $request->refMois,
                    'mois'              =>  $request->mois,
                    'effectifClasse'    =>  $request->effectifClasse,

                    'effectifAbandon'   =>  $request->effectifAbandon,
                    'effectifTotal'     =>  $request->effectifTotal,
                ]);
                return response()->json(['data'  =>  "Insertion avec succès!!!"]);
                
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
        $data = DB::table("clautures")
        ->join('classes','classes.id','=','clautures.idClasse')
        ->join('anne_scollaires','anne_scollaires.id','=','clautures.idAnne')
        ->join('options','options.id','=','clautures.idOption')
        ->join('sections','sections.id','=','options.idSection')

        ->leftjoin('mois_scolaires','mois_scolaires.id','=','clautures.refMois')
        
        ->select("clautures.id",
            //clautures
            'clautures.idAnne','clautures.idOption',
            'clautures.idClasse','clautures.idSection',
            'clautures.refMois','clautures.mois',
            'clautures.effectifClasse','clautures.effectifAbandon',
            'clautures.effectifTotal',

            //mois scolaire
            "mois_scolaires.nomMois",

            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
           
            
            "clautures.created_at")
        ->where('clautures.id', $id)->get();
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
        $data = Clauture::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }





}
