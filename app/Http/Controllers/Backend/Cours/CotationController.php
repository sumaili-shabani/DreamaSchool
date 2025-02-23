<?php

namespace App\Http\Controllers\Backend\Cours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Cours\{Cotation};
use App\Traits\{GlobalMethod,Slug};
use DB;

class CotationController extends Controller
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
        $data = DB::table("cotations")
        ->join('inscriptions','inscriptions.id','=','cotations.idInscription')
        ->join('periodes','periodes.id','=','cotations.idPeriode')
        ->join('cours','cours.id','=','cotations.idCours')

        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')

        ->select("cotations.id",
            //cotations
            'cotations.idInscription','cotations.idCours',
            'cotations.idPeriode','cotations.cote',
            'cotations.codeCote', 'cotations.maxima',
            //cours
            'cours.nomCours',
            //periodes
            'periodes.nomPeriode',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
            'inscriptions.codeInscription',
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
            //division
            'divisions.nomDivision',

            //eleves
            'eleves.idAvenue', 'eleves.nomEleve',
            'eleves.postNomEleve', 'eleves.preNomEleve',
            'eleves.etatCivilEleve', 'eleves.sexeEleve',
            'eleves.nomPere', 'eleves.nomMere',
            'eleves.numPere', 'eleves.numMere',
            'eleves.codeEleve','eleves.photoEleve',
            'eleves.numAdresseEleve', 'eleves.dateNaisEleve',
           
            "cotations.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw("CONCAT(eleves.nomEleve,' ', eleves.postNomEleve,' ',eleves.preNomEleve) as noms")
        ->where('anne_scollaires.statut', '=', 1);

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('cours.nomCours', 'like', '%'.$query.'%')
            ->orWhere('periodes.nomPeriode', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.postNomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.preNomEleve', 'like', '%'.$query.'%')
            ->orWhere('sections.nomSection', 'like', '%'.$query.'%')
            ->orWhere('classes.nomClasse', 'like', '%'.$query.'%')
            ->orderBy("cotations.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("cotations.id", "desc");
        return $this->apiData($data->paginate(10));
    }

    function countExistingCote($idPeriode, $idCours, $idInscription)
    {
        $data = Cotation::where([
            'idCours'           =>  $idCours,
            'idPeriode'         =>  $idPeriode,
            'idInscription'     =>  $idInscription,
        ])->count();

        return $data;
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
            $data = Cotation::where("id", $request->id)->update([
                'idInscription'         =>  $request->idInscription,
                'idCours'               =>  $request->idCours,
                'idPeriode'             =>  $request->idPeriode,
                'cote'                  =>  $request->cote,
                'maxima'                =>  $request->maxima,
               
            ]);

            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $codeCote = 'Cote-'.date('m').'-'.mt_rand(5, 100000000);
            $count = $this->countExistingCote($request->idPeriode, $request->idCours, $request->idInscription);
            if ($count <= 0) {
                // code...
                $data = Cotation::create([
                    'idInscription'         =>  $request->idInscription,
                    'idCours'               =>  $request->idCours,
                    'idPeriode'             =>  $request->idPeriode,
                    'cote'                  =>  $request->cote,
                    'codeCote'              =>  $codeCote,
                    'maxima'                =>  $request->maxima,
                ]);

                return response()->json(['data'  =>  "Insertion avec succès!!!"]);

            } else {
                // code...
                return response()->json(['data'  =>  "La cotation dans ce cours a été déjà enregistrer prière de choisir un autre cours svp!!!"]);
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
        $data = DB::table("cotations")
        ->join('inscriptions','inscriptions.id','=','cotations.idInscription')
        ->join('periodes','periodes.id','=','cotations.idPeriode')
        ->join('cours','cours.id','=','cotations.idCours')

        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')

        ->select("cotations.id",
            //cotations
            'cotations.idInscription','cotations.idCours',
            'cotations.idPeriode','cotations.cote',
            'cotations.codeCote', 'cotations.maxima',
            //cours
            'cours.nomCours',
            //periodes
            'periodes.nomPeriode',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
            'inscriptions.codeInscription',
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
            //division
            'divisions.nomDivision',

            //eleves
            'eleves.idAvenue', 'eleves.nomEleve',
            'eleves.postNomEleve', 'eleves.preNomEleve',
            'eleves.etatCivilEleve', 'eleves.sexeEleve',
            'eleves.nomPere', 'eleves.nomMere',
            'eleves.numPere', 'eleves.numMere',
            'eleves.codeEleve','eleves.photoEleve',
            'eleves.numAdresseEleve', 'eleves.dateNaisEleve',
           
            "cotations.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw("CONCAT(eleves.nomEleve,' ', eleves.postNomEleve,' ',eleves.preNomEleve) as noms")
        ->where('cotations.id', $id)->get();
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
        $data = Cotation::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }



}
