<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Ecole\{Inscription};
use App\Traits\{GlobalMethod,Slug};
use DB;

class InscriptionController extends Controller
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
        \DB::statement("SET SQL_MODE=''");

        $data = DB::table('inscriptions')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        //localisation
        ->join('avenues','avenues.id','=','eleves.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')

        ->select('inscriptions.id',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
            'inscriptions.codeInscription',
            'inscriptions.reductionPaiement',
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',
            //Paiement     anne_scollaires.statut
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw('(paie + reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
        ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
        ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")
        ->where('anne_scollaires.statut', '=', 1);


        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('eleves.postNomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.preNomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.numMere', 'like', '%'.$query.'%')
            ->orWhere('eleves.numPere', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomPere', 'like', '%'.$query.'%')
            ->orWhere('eleves.nomMere', 'like', '%'.$query.'%')
            ->orWhere('avenues.nomAvenue', 'like', '%'.$query.'%')
            ->orWhere('provinces.nomProvince', 'like', '%'.$query.'%')
            ->orWhere('quartiers.nomQuartier', 'like', '%'.$query.'%')
            ->orWhere('communes.nomCommune', 'like', '%'.$query.'%')
            ->orWhere('villes.nomVille', 'like', '%'.$query.'%')
            ->orWhere('pays.nomPays', 'like', '%'.$query.'%')
            ->orWhere('provinces.id', 'like', '%'.$query.'%')

            ->orWhere('inscriptions.dateInscription', 'like', '%'.$query.'%')
            ->orWhere('classes.nomClasse', 'like', '%'.$query.'%')
            ->orWhere('options.nomOption', 'like', '%'.$query.'%')
            ->orWhere('divisions.nomDivision', 'like', '%'.$query.'%')


            ->orderBy("inscriptions.id", "desc");

            return $this->apiData($data->paginate(10));


        }
        $data->orderBy("inscriptions.id", "desc");
        return $this->apiData($data->paginate(10));
    }


    function fetch_inscription_2()
    {
         $data = DB::table('inscriptions')
         ->join('eleves','eleves.id','=','inscriptions.idEleve')
         ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
         ->join('options','options.id','=','inscriptions.idOption')
         ->join('sections','sections.id','=','options.idSection')
         ->join('classes','classes.id','=','inscriptions.idClasse')
         ->join('divisions','divisions.id','=','inscriptions.idDivision')
         //localisation
         ->join('avenues','avenues.id','=','eleves.idAvenue')
         ->join('quartiers','quartiers.id','=','avenues.idQuartier')
         ->join('communes','communes.id','=','quartiers.idCommune')
         ->join('villes','villes.id','=','communes.idVille')
         ->join('provinces','provinces.id','=','villes.idProvince')
         ->join('pays','pays.id','=','provinces.idPays')
 
         ->select('inscriptions.id',
             //inscriptions
             'inscriptions.idEleve','inscriptions.idAnne',
             'inscriptions.idOption','inscriptions.idClasse',
             'inscriptions.idDivision','inscriptions.dateInscription',
             'inscriptions.codeInscription',
             'inscriptions.reductionPaiement',
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
             //localisation
             'avenues.idQuartier','avenues.nomAvenue',
             'quartiers.idCommune','quartiers.nomQuartier',
             'communes.idVille','communes.nomCommune',
             'villes.nomVille','villes.idProvince',
             'provinces.nomProvince','provinces.idPays','pays.nomPays',
             //Paiement     anne_scollaires.statut
             'paie','fraisinscription','restoreinscription',
             'inscriptions.created_at')
         ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
         ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
         ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
         ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')
         ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")
        ->get();
        
        return response()->json(['data' => $data]);

    }


    function getListEleveInscritsClasse($idAnne, $idOption, $idClasse)
    {
        // $idAnne = $this->getAnneScolaireActive();
        $data = [];
        
       
        if ($idClasse !='' && $idOption =='') {
            // code...
            $blog = DB::table('inscriptions')
            ->join('eleves','eleves.id','=','inscriptions.idEleve')
            ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
            ->join('options','options.id','=','inscriptions.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','inscriptions.idClasse')
            ->join('divisions','divisions.id','=','inscriptions.idDivision')
            //localisation
            ->join('avenues','avenues.id','=','eleves.idAvenue')
            ->join('quartiers','quartiers.id','=','avenues.idQuartier')
            ->join('communes','communes.id','=','quartiers.idCommune')
            ->join('villes','villes.id','=','communes.idVille')
            ->join('provinces','provinces.id','=','villes.idProvince')
            ->join('pays','pays.id','=','provinces.idPays')

            ->select('inscriptions.id',
                //inscriptions
                'inscriptions.idEleve','inscriptions.idAnne',
                'inscriptions.idOption','inscriptions.idClasse',
                'inscriptions.idDivision','inscriptions.dateInscription',
                'inscriptions.codeInscription',
                'inscriptions.reductionPaiement',
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
                //localisation
                'avenues.idQuartier','avenues.nomAvenue',
                'quartiers.idCommune','quartiers.nomQuartier',
                'communes.idVille','communes.nomCommune',
                'villes.nomVille','villes.idProvince',
                'provinces.nomProvince','provinces.idPays','pays.nomPays',
                //Paiement
                'paie','fraisinscription','restoreinscription',
                'inscriptions.created_at')
            
            ->orderBy('anne_scollaires.statut','desc')
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
            ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
            ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')    
            ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")
            ->where([
                    ['inscriptions.idAnne', $idAnne],
                    ['inscriptions.idClasse', $idClasse],
            ])->get();


            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idInscription'     =>  $row->id,
                    'ageEleve'          =>  $row->ageEleve,
                    'nomSection'        =>  $row->nomSection,
                    'nomOption'         =>  $row->nomOption,
                    'nomClasse'         =>  $row->nomClasse,
                    'nomDivision'       =>  $row->nomDivision,
                    'nomEleve'          =>  $row->nomEleve." ".$row->postNomEleve." ".$row->preNomEleve,
                    'sexeEleve'         =>  $row->sexeEleve,
                    'designation'       =>  $row->designation,
                    'photoEleve'        =>  $row->photoEleve,
                    'paie'              =>  $row->paie,
                    'reste'             =>  $row->reste,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);


        }elseif ($idOption !='' && $idClasse =='') {
            // code...
            $blog = DB::table('inscriptions')
            ->join('eleves','eleves.id','=','inscriptions.idEleve')
            ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
            ->join('options','options.id','=','inscriptions.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','inscriptions.idClasse')
            ->join('divisions','divisions.id','=','inscriptions.idDivision')
            //localisation
            ->join('avenues','avenues.id','=','eleves.idAvenue')
            ->join('quartiers','quartiers.id','=','avenues.idQuartier')
            ->join('communes','communes.id','=','quartiers.idCommune')
            ->join('villes','villes.id','=','communes.idVille')
            ->join('provinces','provinces.id','=','villes.idProvince')
            ->join('pays','pays.id','=','provinces.idPays')

            ->select('inscriptions.id',
                //inscriptions
                'inscriptions.idEleve','inscriptions.idAnne',
                'inscriptions.idOption','inscriptions.idClasse',
                'inscriptions.idDivision','inscriptions.dateInscription',
                'inscriptions.codeInscription',
                'inscriptions.reductionPaiement',
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
                //localisation
                'avenues.idQuartier','avenues.nomAvenue',
                'quartiers.idCommune','quartiers.nomQuartier',
                'communes.idVille','communes.nomCommune',
                'villes.nomVille','villes.idProvince',
                'provinces.nomProvince','provinces.idPays','pays.nomPays',
                //Paiement
                'paie','fraisinscription','restoreinscription',
                'inscriptions.created_at')
            
            ->orderBy('anne_scollaires.statut','desc')
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
            ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
            ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')    
            ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")
            ->where([
                ['inscriptions.idAnne', $idAnne],
                ['inscriptions.idOption', $idOption],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idInscription'     =>  $row->id,
                    'ageEleve'          =>  $row->ageEleve,
                    'nomSection'        =>  $row->nomSection,
                    'nomOption'         =>  $row->nomOption,
                    'nomClasse'         =>  $row->nomClasse,
                    'nomDivision'       =>  $row->nomDivision,
                    'nomEleve'          =>  $row->nomEleve." ".$row->postNomEleve." ".$row->preNomEleve,
                    'sexeEleve'         =>  $row->sexeEleve,
                    'designation'       =>  $row->designation,
                    'photoEleve'        =>  $row->photoEleve,
                    'paie'              =>  $row->paie,
                    'reste'             =>  $row->reste,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);

        }elseif ($idOption !='' && $idClasse !='') {
            // code...
            $blog = DB::table('inscriptions')
            ->join('eleves','eleves.id','=','inscriptions.idEleve')
            ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
            ->join('options','options.id','=','inscriptions.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','inscriptions.idClasse')
            ->join('divisions','divisions.id','=','inscriptions.idDivision')
            //localisation
            ->join('avenues','avenues.id','=','eleves.idAvenue')
            ->join('quartiers','quartiers.id','=','avenues.idQuartier')
            ->join('communes','communes.id','=','quartiers.idCommune')
            ->join('villes','villes.id','=','communes.idVille')
            ->join('provinces','provinces.id','=','villes.idProvince')
            ->join('pays','pays.id','=','provinces.idPays')

            ->select('inscriptions.id',
                //inscriptions
                'inscriptions.idEleve','inscriptions.idAnne',
                'inscriptions.idOption','inscriptions.idClasse',
                'inscriptions.idDivision','inscriptions.dateInscription',
                'inscriptions.codeInscription',
                'inscriptions.reductionPaiement',
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
                //localisation
                'avenues.idQuartier','avenues.nomAvenue',
                'quartiers.idCommune','quartiers.nomQuartier',
                'communes.idVille','communes.nomCommune',
                'villes.nomVille','villes.idProvince',
                'provinces.nomProvince','provinces.idPays','pays.nomPays',
                //Paiement
                'paie','fraisinscription','restoreinscription',
                'inscriptions.created_at')
            
            ->orderBy('anne_scollaires.statut','desc')
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
            ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
            ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')    
            ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")
            ->where([
                ['inscriptions.idAnne', $idAnne],
                ['inscriptions.idOption', $idOption],
                ['inscriptions.idClasse', $idClasse],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idInscription'     =>  $row->id,
                    'ageEleve'          =>  $row->ageEleve,
                    'nomSection'        =>  $row->nomSection,
                    'nomOption'         =>  $row->nomOption,
                    'nomClasse'         =>  $row->nomClasse,
                    'nomDivision'       =>  $row->nomDivision,
                    'nomEleve'          =>  $row->nomEleve." ".$row->postNomEleve." ".$row->preNomEleve,
                    'sexeEleve'         =>  $row->sexeEleve,
                    'designation'       =>  $row->designation,
                    'photoEleve'        =>  $row->photoEleve,
                    'paie'              =>  $row->paie,
                    'reste'             =>  $row->reste,
                    
                ));

            }

            return response()->json(['data'  =>  $blog]);

        } else {
            // code...
            $blog = DB::table('inscriptions')
            ->join('eleves','eleves.id','=','inscriptions.idEleve')
            ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
            ->join('options','options.id','=','inscriptions.idOption')
            ->join('sections','sections.id','=','options.idSection')
            ->join('classes','classes.id','=','inscriptions.idClasse')
            ->join('divisions','divisions.id','=','inscriptions.idDivision')
            //localisation
            ->join('avenues','avenues.id','=','eleves.idAvenue')
            ->join('quartiers','quartiers.id','=','avenues.idQuartier')
            ->join('communes','communes.id','=','quartiers.idCommune')
            ->join('villes','villes.id','=','communes.idVille')
            ->join('provinces','provinces.id','=','villes.idProvince')
            ->join('pays','pays.id','=','provinces.idPays')

            ->select('inscriptions.id',
                //inscriptions
                'inscriptions.idEleve','inscriptions.idAnne',
                'inscriptions.idOption','inscriptions.idClasse',
                'inscriptions.idDivision','inscriptions.dateInscription',
                'inscriptions.codeInscription',
                'inscriptions.reductionPaiement',
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
                //localisation
                'avenues.idQuartier','avenues.nomAvenue',
                'quartiers.idCommune','quartiers.nomQuartier',
                'communes.idVille','communes.nomCommune',
                'villes.nomVille','villes.idProvince',
                'provinces.nomProvince','provinces.idPays','pays.nomPays',
                //Paiement
                'paie','fraisinscription','restoreinscription',
                'inscriptions.created_at')
            
            ->orderBy('anne_scollaires.statut','desc')
            ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
            ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
            ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
            ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')    
            ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")
            ->where([
                ['inscriptions.idAnne', $idAnne],
            ])->get();

            foreach ($blog as $row) {
                // code...
                array_push($data, array(
                    'id'                =>  $row->id,
                    'idInscription'     =>  $row->id,
                    'ageEleve'          =>  $row->ageEleve,
                    'nomSection'        =>  $row->nomSection,
                    'nomOption'         =>  $row->nomOption,
                    'nomClasse'         =>  $row->nomClasse,
                    'nomDivision'       =>  $row->nomDivision,
                    'nomEleve'          =>  $row->nomEleve." ".$row->postNomEleve." ".$row->preNomEleve,
                    'sexeEleve'         =>  $row->sexeEleve,
                    'designation'       =>  $row->designation,
                    'photoEleve'        =>  $row->photoEleve,
                    'paie'              =>  $row->paie,
                    'reste'             =>  $row->reste,
                    
                ));

            }

            return response()->json(['data'  =>  $data]);
        }
        

        
        
    }

    function getPeriodeEnCours()
    {
        $data = [];
        array_push($data, array(
            'idAnne'        =>  $this->igIdAnneeScolaireEncours(),
            'idPeriode'     =>  $this->igIdPeriodeEncours(),
        ));

        return response()->json([
            'data'      =>  $data,
        ]);
    }


    function getListEleveInscrits()
    {
        $idAnne = $this->getAnneScolaireActive();
        $blog = DB::table('inscriptions')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        //localisation
        ->join('avenues','avenues.id','=','eleves.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')

        ->select('inscriptions.id',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
            'inscriptions.codeInscription',
            'inscriptions.reductionPaiement',
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
        ->where('inscriptions.idAnne', $idAnne)
        ->orderBy('anne_scollaires.statut','desc')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
        ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
        ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')    
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")    
        ->get();

        $data = [];
        foreach ($blog as $row) {
            // code...
            array_push($data, array(
                'id'                =>  $row->id,
                'idInscription'     =>  $row->id,
                'ageEleve'          =>  $row->ageEleve,
                'nomSection'        =>  $row->nomSection,
                'nomOption'         =>  $row->nomOption,
                'nomClasse'         =>  $row->nomClasse,
                'nomDivision'       =>  $row->nomDivision,
                'nomEleve'          =>  $row->nomEleve." ".$row->postNomEleve." ".$row->preNomEleve,
                'sexeEleve'         =>  $row->sexeEleve,
                'designation'       =>  $row->designation,
                'photoEleve'        =>  $row->photoEleve,
                'paie'         =>  $row->paie,
                'reste'         =>  $row->reste,
                
            ));
            ////Paiement
            //'paie','reste',
        }
        return response()->json(['data'  =>  $data]);
    }

    function getCountInscriptionEffectif($idClasse, $idOption)
    {
        $idAnne = $this->getAnneScolaireActive();
        $effectifClasse = DB::table('inscriptions')        
        ->select('inscriptions.id',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
            'inscriptions.codeInscription',
            'inscriptions.reductionPaiement',
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
            // ->selectRaw('(reste - fraisinscription) as reste')
        ->where([
            ['inscriptions.idClasse', $idClasse],
            ['inscriptions.idOption', $idOption],
            ['inscriptions.idAnne', $idAnne]
        ])
        ->count();

        $data = [];
        array_push($data, array(
            'effectifClasse'    =>  $effectifClasse,            
        ));

        return response()->json(['data'  =>  $data]);

    }

    /*
    *
    *=========================
    * Reduction paiement
    *=========================
    */

    public function updateReductionPaiement(Request $request)
    {
        //
        if ($request->id !='')
        {
            # code...
            // update
            $data = Inscription::where("id", $request->id)->update([
                'reductionPaiement'  =>  $request->reductionPaiement,
            ]);
            return $this->msgJson('Modification avec succès!!!');

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
            // update   restoreinscription
            $data = Inscription::where("id", $request->id)->update([
                'idEleve'               =>  $request->idEleve,
                'idAnne'                =>  $request->idAnne,
                'idOption'              =>  $request->idOption,
                'idClasse'              =>  $request->idClasse,
                'idDivision'            =>  $request->idDivision,
                'dateInscription'       =>  $request->dateInscription,
                'fraisinscription'      =>  $request->fraisinscription,
                'restoreinscription'    =>  $request->restoreinscription,
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion
            $codeInscription = rand();
            $count = $this->showCountTableInscription($request->idEleve, $request->idAnne, $request->idClasse);
            if ($count <=0) {
                // code...
                $data = Inscription::create([
                    'idEleve'               =>  $request->idEleve,
                    'idAnne'                =>  $request->idAnne,
                    'idOption'              =>  $request->idOption,
                    'idClasse'              =>  $request->idClasse,
                    'idDivision'            =>  $request->idDivision,
                    'dateInscription'       =>  $request->dateInscription,
                    'codeInscription'       =>  $codeInscription,
                    'fraisinscription'       =>  $request->fraisinscription,
                    'restoreinscription'       =>  $request->restoreinscription,
                ]);

                return $this->msgJson('Insertion avec succès!!!');
            } else {
                // code...
                return $this->msgJson("Désolé cet élève existe déjà dans cette classe !!!");

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
        $data = DB::table('inscriptions')
        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')
        //localisation
        ->join('avenues','avenues.id','=','eleves.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')

        ->select('inscriptions.id',
            //inscriptions
            'inscriptions.idEleve','inscriptions.idAnne',
            'inscriptions.idOption','inscriptions.idClasse',
            'inscriptions.idDivision','inscriptions.dateInscription',
            'inscriptions.codeInscription',
            'inscriptions.reductionPaiement',
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',
            //Paiement
            'paie','fraisinscription','restoreinscription',
            'inscriptions.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw('(paie + reste - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as Prevision')
        ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
        ->selectRaw('ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0) as PrevisionReduction')
        ->selectRaw("CONCAT(nomEleve,' ', postNomEleve,' ',preNomEleve) as Noms")
        ->where("inscriptions.id", $id)
        ->get();

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
        $data= Inscription::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
