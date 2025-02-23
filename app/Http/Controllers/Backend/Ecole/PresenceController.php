<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Ecole\{Presence};
use App\Traits\{GlobalMethod,Slug};
use DB;

class PresenceController extends Controller
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

        $data = DB::table('presences')
        ->join('inscriptions','inscriptions.id','=','presences.idInscription')
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

        ->select('presences.id',
            //presences
            'presences.idInscription','presences.date_entree',
            'presences.date_sortie','presences.statut_presence',
            'presences.motif', 'presences.mouvement',
            'presences.date1', 'presences.date2',
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',

            'presences.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve');


        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('presences.date_entree', 'like', '%'.$query.'%')
            ->orWhere('eleves.postNomEleve', 'like', '%'.$query.'%')
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


            ->orderBy("presences.id", "desc");

            return $this->apiData($data->paginate(5));


        }
        $data->orderBy("presences.id", "desc");
        return $this->apiData($data->paginate(5));
    }

    public function indexQrcode(Request $request)
    {
        //
        \DB::statement("SET SQL_MODE=''");

        $data = DB::table('presences')
        ->join('inscriptions','inscriptions.id','=','presences.idInscription')
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

        ->select('presences.id',
            //presences
            'presences.idInscription','presences.date_entree',
            'presences.date_sortie','presences.statut_presence',
            'presences.motif', 'presences.mouvement',
            'presences.date1', 'presences.date2',
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',

            'presences.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve');


        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('presences.date_entree', 'like', '%'.$query.'%')
            ->orWhere('eleves.postNomEleve', 'like', '%'.$query.'%')
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


            ->orderBy("presences.id", "desc");

            return $this->apiData($data->paginate(3));


        }
        $data->orderBy("presences.id", "desc");
        return $this->apiData($data->paginate(3));
    }

    public function getAttendanceDay($codeInscription)
    {
        //
        \DB::statement("SET SQL_MODE=''");

        $blog = DB::table('presences')
        ->join('inscriptions','inscriptions.id','=','presences.idInscription')
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

        ->select('presences.id',
            //presences
            'presences.idInscription','presences.date_entree',
            'presences.date_sortie','presences.statut_presence',
            'presences.motif', 'presences.mouvement',
            'presences.date1', 'presences.date2',
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',

            'presences.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->where('inscriptions.codeInscription', $codeInscription)
        ->get();
        $data = [];
        $color = 'red';
        $etatExcuse = false;
        $name="";
        foreach ($blog as $row) {
            // code...
            if ($row->statut_presence == 'Présent(e)') {
                // code...
                $color = 'green';
                $name = $row->statut_presence;
            }elseif ($row->statut_presence == 'Excusé(e)') {
                // code...
                $color = 'yellow darken-3';
                $etatExcuse = true;
                $name = $row->statut_presence." Motif:".$row->motif;
            } else {
                // code...
                $color = 'red';
                $name = $row->statut_presence;
            }
            
            array_push($data, array(
                'name'          => $name,
                'start'         => $row->date_entree,
                'end'           => $row->date_entree,
                'timed'         => $etatExcuse,
                'color'         => $color,
                'nomEleve'      =>  $row->nomEleve,
                'photoEleve'    =>  $row->photoEleve,
            ));
        }

         return response()->json(['data'  =>  $data]);


        
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
            $created_at = date('Y-m-d');

            $date1 = date($request->date_entree.' H:i:s');
            $date2 = date($request->date_sortie.' H:i:s');
            $date_entree = $request->date_entree;
            $date_sortie = $request->date_sortie;

            if ($request->statut_presence == 'Excusé(e)') {
                // code...
                
                $data = Presence::where("id", $request->id)->update([
                    'idInscription'             =>  $request->idInscription,
                    'date_entree'               =>  $request->date_entree,
                    'date_sortie'               =>  $request->date_sortie,
                    'date1'                     =>  $date1,
                    'date2'                     =>  $date2,
                    'motif'                     =>  $request->motif,
                    'mouvement'                 =>  $request->mouvement,
                    'statut_presence'           =>  $request->statut_presence,

                ]);
                return $this->msgJson('Modification avec succès!!!');

            } else {
                if ($request->mouvement == 'Sortie') {
                    // code...
                    $data = Presence::where("id", $request->id)->update([
                        'idInscription'             =>  $request->idInscription,
                        'date_sortie'               =>  $request->date_sortie,
                        'date2'                     =>  $date2,
                        'motif'                     =>  $request->motif,
                        'statut_presence'           =>  $request->statut_presence,
                        'mouvement'                 =>  $request->mouvement,

                    ]);
                    return $this->msgJson('Modification avec succès!!!');


                } else {
                    // code...
                    $data = Presence::where("id", $request->id)->update([
                        'idInscription'             =>  $request->idInscription,
                        'date_entree'               =>  $request->date_entree,
                        'date1'                     =>  $date1,
                        'motif'                     =>  $request->motif,
                        'statut_presence'           =>  $request->statut_presence,
                        'mouvement'                 =>  $request->mouvement,

                    ]);

                    return $this->msgJson('Modification avec succès!!!');
                }
                
                
                // code...
            }


           

        }
        else
        {
            // insertion
            $created_at = date('Y-m-d');

            $date1 = date($request->date_entree.' H:i:s');
            $date2 = date($request->date_sortie.' H:i:s');
            $date_entree = $request->date_entree;
            $date_sortie = $request->date_sortie;
            if ($request->statut_presence == 'Excusé(e)') {
                // code...
                $count = $this->showCountTablePresenceOffQrcode($request->idInscription, $date_entree);
                if ($count <=0) {
                    // code...
                    $data = Presence::create([
                        'idInscription'             =>  $request->idInscription,
                        'date_entree'               =>  $date_entree,
                        'date_sortie'               =>  $date_sortie,
                        'date1'                     =>  $date1,
                        'date2'                     =>  $date2,
                        'motif'                     =>  $request->motif,
                        'statut_presence'           =>  $request->statut_presence,
                        'mouvement'                 =>  $request->mouvement,

                    ]);

                    return $this->msgJson('Insertion avec succès!!!');
                } else {
                    // code...
                    return $this->msgJson("La présence a été ajouté avec succès !!!");

                }
            } else {
                if ($request->mouvement == 'Sortie') {
                    // code...
                    $count = $this->showCountTablePresenceOffQrcode($request->idInscription, $date_entree);
                    if ($count <=0) {
                        // code...
                        $data = Presence::create([
                            'idInscription'             =>  $request->idInscription,                            
                            'date_sortie'               =>  $date_sortie,
                            'date2'                     =>  $date2,
                            'motif'                     =>  $request->motif,
                            'statut_presence'           =>  $request->statut_presence,
                            'mouvement'                 =>  $request->mouvement,
                        ]);

                        return $this->msgJson('Insertion avec succès!!!');
                    } else {
                        // code...
                        return $this->msgJson("La présence a été ajouté avec succès !!!");

                    }

                } else {
                    // code...
                    $count = $this->showCountTablePresenceOffQrcode($request->idInscription, $date_entree);
                    if ($count <=0) {
                        // code...
                        $data = Presence::create([
                            'idInscription'             =>  $request->idInscription,
                            'date_entree'               =>  $date_entree,
                            'date1'                     =>  $date1,
                            'motif'                     =>  $request->motif,
                            'statut_presence'           =>  $request->statut_presence,
                            'mouvement'                 =>  $request->mouvement,
                        ]);

                        return $this->msgJson('Insertion avec succès!!!');
                    } else {
                        // code...
                        return $this->msgJson("La présence a été ajouté avec succès !!!");

                    }
                }
                
                
                // code...
            }
            
            

        }
    }


    public function storeQrcode(Request $request)
    {
        //
        if ($request->id !='')
        {
            # code...
            // update
            $idInscription = $this->getIdInscription($request->codeInscription);

            $created_at = date('Y-m-d');
            $date1 = date($request->date_entree.' H:i:s');
            $date2 = date($request->date_sortie.' H:i:s');
            $date_entree = $request->date_entree;
            $date_sortie = $request->date_sortie;

            if ($request->statut_presence == 'Excusé(e)') {
                // code...
                
                $data = Presence::where("id", $request->id)->update([
                    'idInscription'             =>  $idInscription,
                    'date_entree'               =>  $request->date_entree,
                    'date_sortie'               =>  $request->date_sortie,
                    'date1'                     =>  $date1,
                    'date2'                     =>  $date2,
                    'motif'                     =>  $request->motif,
                    'mouvement'                 =>  $request->mouvement,
                    'statut_presence'           =>  $request->statut_presence,

                ]);
                return $this->msgJson('Modification avec succès!!!');

            } else {
                if ($request->mouvement == 'Sortie') {
                    // code...
                    $data = Presence::where("id", $request->id)->update([
                        'idInscription'             =>  $idInscription,
                        'date_sortie'               =>  $request->date_sortie,
                        'date2'                     =>  $date2,
                        'motif'                     =>  $request->motif,
                        'statut_presence'           =>  $request->statut_presence,
                        'mouvement'                 =>  $request->mouvement,

                    ]);
                    return $this->msgJson('Modification avec succès!!!');


                } else {
                    // code...
                    $data = Presence::where("id", $request->id)->update([
                        'idInscription'             =>  $idInscription,
                        'date_entree'               =>  $request->date_entree,
                        'date1'                     =>  $date1,
                        'motif'                     =>  $request->motif,
                        'statut_presence'           =>  $request->statut_presence,
                        'mouvement'                 =>  $request->mouvement,

                    ]);

                    return $this->msgJson('Modification avec succès!!!');
                }
                
                
                // code...
            }


           

        }
        else
        {
            // insertion

            $idInscription = $this->getIdInscription($request->codeInscription);


            $created_at = date('Y-m-d');
            $date1 = date($request->date_entree.' H:i:s');
            $date2 = date($request->date_sortie.' H:i:s');
            $date_entree = $request->date_entree;
            $date_sortie = $request->date_sortie;
            if ($request->statut_presence == 'Excusé(e)') {
                // code...
                $count = $this->showCountTablePresence($idInscription, $created_at);
                if ($count <=0) {
                    // code...
                    $data = Presence::create([
                        'idInscription'             =>  $idInscription,
                        'date_entree'               =>  $date_entree,
                        'date_sortie'               =>  $date_sortie,
                        'date1'                     =>  $date1,
                        'date2'                     =>  $date2,
                        'motif'                     =>  $request->motif,
                        'statut_presence'           =>  $request->statut_presence,
                        'mouvement'                 =>  $request->mouvement,
                    ]);

                    return $this->msgJson('Insertion avec succès!!!');
                } else {
                    // code...
                    return $this->msgJson("La présence a été ajouté avec succès !!!");

                }
            } else {
                if ($request->mouvement == 'Sortie') {
                    // code...
                    $count = $this->showCountTablePresence($idInscription, $created_at);
                    if ($count <=0) {
                        // code...
                        $data = Presence::create([
                            'idInscription'             =>  $idInscription,                            
                            'date_sortie'               =>  $date_sortie,
                            'date2'                     =>  $date2,
                            'motif'                     =>  $request->motif,
                            'statut_presence'           =>  $request->statut_presence,
                            'mouvement'                 =>  $request->mouvement,
                        ]);

                        return $this->msgJson('Insertion avec succès!!!');
                    } else {
                        // code...
                        return $this->msgJson("La présence a été ajouté avec succès !!!");

                    }

                } else {
                    // code...
                    $count = $this->showCountTablePresence($idInscription, $created_at);
                    if ($count <=0) {
                        // code...
                        $data = Presence::create([
                            'idInscription'             =>  $idInscription,
                            'date_entree'               =>  $date_entree,
                            'date1'                     =>  $date1,
                            'motif'                     =>  $request->motif,
                            'statut_presence'           =>  $request->statut_presence,
                            'mouvement'                 =>  $request->mouvement,
                        ]);

                        return $this->msgJson('Insertion avec succès!!!');
                    } else {
                        // code...
                        return $this->msgJson("La présence a été ajouté avec succès !!!");

                    }
                }
                
                
                // code...
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
        $data = DB::table('presences')
        ->join('inscriptions','inscriptions.id','=','presences.idInscription')
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

        ->select('presences.id',
            //presences
            'presences.idInscription','presences.date_entree',
            'presences.date_sortie','presences.statut_presence',
            'presences.motif', 'presences.mouvement',
            'presences.date1', 'presences.date2',
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
            //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',

            'presences.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->where("presences.id", $id)
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
        $data= Presence::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
