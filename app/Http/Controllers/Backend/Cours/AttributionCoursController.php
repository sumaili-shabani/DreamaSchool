<?php

namespace App\Http\Controllers\Backend\Cours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Cours\{AttributionCours};
use App\Traits\{GlobalMethod,Slug};
use DB;

class AttributionCoursController extends Controller
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
        $data = DB::table("attribution_cours")
        ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
        ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
        ->join('cours','cours.id','=','attribution_cours.idCours')
        ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

        ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
        ->join('options','options.id','=','attribution_cours.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','attribution_cours.idClasse')
        ->select("attribution_cours.id",
            //attribution_cours
            'attribution_cours.idCours','attribution_cours.idEnseignant',
            'attribution_cours.idPeriode','attribution_cours.idAnne',
            'attribution_cours.idOption','attribution_cours.idClasse',
            'attribution_cours.maximale','attribution_cours.codeAt',
            //cours
            'cours.nomCours','cours.idCatCours',
            //cat_cours
            "cat_cours.nomCatCours", 
            //periodes
            'periodes.nomPeriode',
            //enseignants 
            'enseignants.idAvenue','enseignants.nomEns',
            'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
            'enseignants.telEns','enseignants.tel2Ens',
            'enseignants.sexeEns','enseignants.etatcivilEns',
            'enseignants.prefEns','enseignants.degreprefEns',
            'enseignants.telprefEns','enseignants.codeEns',
            'enseignants.numCarteEns','enseignants.passwordEns',
            'enseignants.imageEns',
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
            
            "attribution_cours.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('enseignants.nomEns', 'like', '%'.$query.'%')
            ->orWhere('attribution_cours.maximale', 'like', '%'.$query.'%')
            ->orWhere('attribution_cours.codeAt', 'like', '%'.$query.'%')
            ->orWhere('cours.nomCours', 'like', '%'.$query.'%')
            ->orWhere('periodes.nomPeriode', 'like', '%'.$query.'%')
            ->orWhere('options.nomOption', 'like', '%'.$query.'%')
            ->orWhere('sections.nomSection', 'like', '%'.$query.'%')
            ->orWhere('classes.nomClasse', 'like', '%'.$query.'%')
            ->orderBy("attribution_cours.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("attribution_cours.id", "desc");
        return $this->apiData($data->paginate(10));
    }

    function getListCoursClasse($idAnne, $idOption, $idClasse, $idPeriode)
    {
        // $idAnne = $this->getAnneScolaireActive();
        $data = [];
               
        if ($idClasse !='' && $idOption =='') {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idClasse', $idClasse],
                ['attribution_cours.idPeriode', $idPeriode],
            ])->get();


            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);


        }elseif ($idOption !='' && $idClasse =='') {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idOption', $idOption],
                ['attribution_cours.idPeriode', $idPeriode],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);

        }elseif ($idOption !='' && $idClasse !='') {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idOption', $idOption],
                ['attribution_cours.idClasse', $idClasse],
                ['attribution_cours.idPeriode', $idPeriode],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    
                ));

            }

            return response()->json(['data'  =>  $blog]);

        } else {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idPeriode', $idPeriode],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);
        }
        

    }

    //get cours by idcat
    function getListCoursClasseByCatCours($idAnne, $idOption, $idClasse, $idPeriode, $idCatCours)
    {
        // $idAnne = $this->getAnneScolaireActive();
        $data = [];
               
        if ($idClasse !='' && $idOption =='') {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idClasse', $idClasse],
                ['attribution_cours.idPeriode', $idPeriode],
                ['cours.idCatCours', $idCatCours],
                
            ])->get();


            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);


        }elseif ($idOption !='' && $idClasse =='') {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idOption', $idOption],
                ['attribution_cours.idPeriode', $idPeriode],
                ['cours.idCatCours', $idCatCours],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);

        }elseif ($idOption !='' && $idClasse !='') {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idOption', $idOption],
                ['attribution_cours.idClasse', $idClasse],
                ['attribution_cours.idPeriode', $idPeriode],
                ['cours.idCatCours', $idCatCours],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    
                ));

            }

            return response()->json(['data'  =>  $blog]);

        } else {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idPeriode', $idPeriode],
                ['cours.idCatCours', $idCatCours],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);
        }
        

        
        
    }

    //get cours by idcat
    function getMaximaCours($idAnne, $idOption, $idClasse, $idPeriode, $idCours)
    {
        // $idAnne = $this->getAnneScolaireActive();
        $data = [];
               
        if ($idClasse !='' && $idOption !='' && $idPeriode !='' && $idCours !='') {
            // code...
            $blog = DB::table("attribution_cours")
            ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
            ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
            ->join('cours','cours.id','=','attribution_cours.idCours')
            ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

            ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
            ->join('options','options.id','=','attribution_cours.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','attribution_cours.idClasse')
            ->select("attribution_cours.id",
                //attribution_cours
                'attribution_cours.idCours','attribution_cours.idEnseignant',
                'attribution_cours.idPeriode','attribution_cours.idAnne',
                'attribution_cours.idOption','attribution_cours.idClasse',
                'attribution_cours.maximale','attribution_cours.codeAt',
                //cours
                'cours.nomCours','cours.idCatCours',
                //cat_cours
                "cat_cours.nomCatCours", 
                //periodes
                'periodes.nomPeriode',
                //enseignants 
                'enseignants.idAvenue','enseignants.nomEns',
                'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
                'enseignants.telEns','enseignants.tel2Ens',
                'enseignants.sexeEns','enseignants.etatcivilEns',
                'enseignants.prefEns','enseignants.degreprefEns',
                'enseignants.telprefEns','enseignants.codeEns',
                'enseignants.numCarteEns','enseignants.passwordEns',
                'enseignants.imageEns',
                //options
                'options.idSection','options.nomOption',
                //sections
                "sections.nomSection",
                //anne_scollaires
                'anne_scollaires.designation','anne_scollaires.statut',
                //classes
                'classes.nomClasse',
                
                "attribution_cours.created_at")
            ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
            ->where([
                ['attribution_cours.idAnne', $idAnne],
                ['attribution_cours.idClasse', $idClasse],
                ['attribution_cours.idPeriode', $idPeriode],
                ['attribution_cours.idCours', $idCours],
                
            ])->get();


            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idCours'           =>  $row->idCours,
                    'nomCours'          =>  $row->nomCours,
                    'nomPeriode'        =>  $row->nomPeriode,
                    'idCatCours'        =>  $row->idCatCours,
                    'maximale'          =>  $row->maximale,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);


        } else {
            // code...
           

            array_push($data, array(
                'id'                =>  0,
                'idCours'           =>  0,
                'nomCours'          =>  "",
                'nomPeriode'        =>  "",
                'idCatCours'        =>  0,
                'maximale'          =>  0,
                
            ));

            return response()->json(['data'  =>  $data]);
        }
        

        
        
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
            $data = AttributionCours::where("id", $request->id)->update([
                'idCours'               =>  $request->idCours,
                'idEnseignant'          =>  $request->idEnseignant,
                'idPeriode'             =>  $request->idPeriode,
                'idAnne'                =>  $request->idAnne,
                'idOption'              =>  $request->idOption,
                'idClasse'              =>  $request->idClasse,
                'maximale'              =>  $request->maximale,
               

            ]);

            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $codeAt = date('m').'-'.mt_rand(5, 100000000);
            $data = AttributionCours::create([
                'idCours'               =>  $request->idCours,
                'idEnseignant'          =>  $request->idEnseignant,
                'idPeriode'             =>  $request->idPeriode,
                'idAnne'                =>  $request->idAnne,
                'idOption'              =>  $request->idOption,
                'idClasse'              =>  $request->idClasse,
                'maximale'              =>  $request->maximale,
                'codeAt'                =>  $codeAt,
            ]);

            return response()->json(['data'  =>  "Insertion avec succès!!!"]);

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
        $data = DB::table("attribution_cours")
        ->join('enseignants','enseignants.id','=','attribution_cours.idEnseignant')
        ->join('periodes','periodes.id','=','attribution_cours.idPeriode')
        ->join('cours','cours.id','=','attribution_cours.idCours')
        ->join('cat_cours','cat_cours.id','=','cours.idCatCours')

        ->join('anne_scollaires','anne_scollaires.id','=','attribution_cours.idAnne')
        ->join('options','options.id','=','attribution_cours.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','attribution_cours.idClasse')
        ->select("attribution_cours.id",
            //attribution_cours
            'attribution_cours.idCours','attribution_cours.idEnseignant',
            'attribution_cours.idPeriode','attribution_cours.idAnne',
            'attribution_cours.idOption','attribution_cours.idClasse',
            'attribution_cours.maximale','attribution_cours.codeAt',
            //cours
            'cours.nomCours','cours.idCatCours',
            //cat_cours
            "cat_cours.nomCatCours", 
            //periodes
            'periodes.nomPeriode',
            //enseignants 
            'enseignants.idAvenue','enseignants.nomEns',
            'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
            'enseignants.telEns','enseignants.tel2Ens',
            'enseignants.sexeEns','enseignants.etatcivilEns',
            'enseignants.prefEns','enseignants.degreprefEns',
            'enseignants.telprefEns','enseignants.codeEns',
            'enseignants.numCarteEns','enseignants.passwordEns',
            'enseignants.imageEns',
            //options
            'options.idSection','options.nomOption',
            //sections
            "sections.nomSection",
            //anne_scollaires
            'anne_scollaires.designation','anne_scollaires.statut',
            //classes
            'classes.nomClasse',
            
            "attribution_cours.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
        ->where('attribution_cours.id', $id)->get();
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
        $data = AttributionCours::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
