<?php

namespace App\Http\Controllers\Backend\Paiement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Paiement\{Paiement};
use App\Traits\{GlobalMethod,Slug};
use DB;

class PaiementController extends Controller
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
        $data = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        // ->join('users','users.id','=','paiements.idUser')

        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')

        // ->join('tconf_banque' , 'tconf_banque.id','=','paiements.refBanque')
        // ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        // ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        // ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        // ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        // ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        // ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
        
        ->select("paiements.id",
            //paiements
            'paiements.idTranche','paiements.idFrais',
            'paiements.idInscription','paiements.montant',
            'paiements.datePaiement','paiements.codePaiement',
            'paiements.idUser','paiements.etatPaiement',

            //tranches 
            // "tranches.nomTranche",

            //type tranche
            // 'type_tranches.nomTypeTranche', 

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

            'paie','fraisinscription','restoreinscription',

            //users
            // 'users.name','users.email','users.avatar',
            "paiements.created_at",
            // 'refBanque','numeroBordereau',
            // "tconf_banque.nom_banque","tconf_banque.numerocompte",
            // 'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
            // 'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
            // 'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
            // 'numero_classe','nom_typeposition',"nom_typecompte"
            )
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        // ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
        ->where('anne_scollaires.statut', '=', 1);

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('eleves.nomEleve', 'like', '%'.$query.'%')
            ->orWhere('paiements.datePaiement', 'like', '%'.$query.'%')
            ->orWhere('eleves.postNomEleve', 'like', '%'.$query.'%')
            ->orWhere('eleves.preNomEleve', 'like', '%'.$query.'%')
            ->orWhere('tranches.nomTranche', 'like', '%'.$query.'%')
            ->orWhere('type_tranches.nomTypeTranche', 'like', '%'.$query.'%')
            ->orWhere('classes.nomClasse', 'like', '%'.$query.'%')
            ->orWhere('options.nomOption', 'like', '%'.$query.'%')
            ->orderBy("paiements.id", "desc");

            return $this->apiData($data->paginate(5));


        }

        $data->orderBy("paiements.id", "desc");
        return $this->apiData($data->paginate(10));
    }


    // les requetes commencent
    function getDataInscription($idInscription){
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

            'paie','fraisinscription','restoreinscription',

            'inscriptions.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw('(reste - fraisinscription + restoreinscription - ROUND((((paie + reste - fraisinscription + restoreinscription) * reductionPaiement)/100),0)) as reste')
        ->where('inscriptions.id', $idInscription)
        ->take(1)->get();
        return $data;
    }

   
 
    function getInfoPaiementEleve($idInscription)
    {
        $inscriptions = $this->getDataInscription($idInscription);
        $idClasse;
        $idAnne;
        $idOption;
        $idDivision;
        $idInscription;

        $montantApayer;
        $montantPayer;
        $resteApayer;

        $nomOption;
        $nomClasse;
        $nomDivision;
        $nomSection;
        $nomEleve;

        $data = [];
        foreach ($inscriptions as $key) {
             // code...
            $idInscription  = $key->id;
            $idAnne         = $key->idAnne;
            $idOption       = $key->idOption;
            $idClasse       = $key->idClasse;
            $idDivision     = $key->idDivision;

            $nomOption      = $key->nomOption;
            $nomSection     = $key->nomSection;
            $nomClasse      = $key->nomClasse;
            $nomDivision    = $key->nomDivision;
            $nomEleve       = $key->nomEleve.' '.$key->postNomEleve.' '.$key->preNomEleve;

            $montantApayer = $this->getSumMontantApayer($key->idClasse, $key->idOption, $key->idAnne);
            $montantPayer = $this->getSumMontantPayerEleve($idInscription);
            $montantRemise = round((($montantApayer * $key->reductionPaiement) / 100), 0);
            $resteApayer = round((($montantApayer - $montantPayer) - $montantRemise - $key->fraisinscription + $key->restoreinscription) , 0);

            array_push($data, array(
                'idInscription'             =>  $idInscription,
                'idAnne'                    =>  $idAnne,
                'idOption'                  =>  $idOption,
                'idClasse'                  =>  $idClasse,
                'idDivision'                =>  $idDivision,

                'nomOption'                 =>  $nomOption,
                'nomSection'                =>  $nomSection,
                'nomClasse'                 =>  $nomClasse,
                'nomDivision'               =>  $nomDivision,
                'nomEleve'                  =>  $nomEleve,

                'montantApayer'             =>  $montantApayer,
                'montantPayer'              =>  $montantPayer,
                'resteApayer'               =>  $resteApayer,
                'montantRemise'             =>  $key->reductionPaiement."%, qui est ".$montantRemise,
                
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
            $datetest='';
            $data3 = DB::table('tfin_cloture_caisse')
            ->select('date_cloture')
            ->where('date_cloture','=', $request->datePaiement)
            ->take(1)
            ->orderBy('id', 'desc')         
            ->get();    
            foreach ($data3 as $row) 
            {                           
                $datetest=$row->date_cloture;          
            }

            if($datetest == $request->datePaiement)
            {
                    return response()->json([
                        'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
                    ]);            
            }
            else
            {
                $data = Paiement::where("id", $request->id)->update([
                    'idTranche'         =>  $request->idTranche,
                    'idFrais'           =>  $request->idFrais,
                    'idInscription'     =>  $request->idInscription,
                    'montant'           =>  $request->montant,
                    'datePaiement'      =>  $request->datePaiement,
                    'idUser'            =>  $request->idUser,
                    'refBanque'       =>  $request->refBanque,
                    'numeroBordereau'       =>  $request->numeroBordereau,
                   
                ]);
                return response()->json(['data'  =>  "Modification avec succès!!!"]);
            }            

        }
        else
        {
            //inscription

            $datetest='';
            $data3 = DB::table('tfin_cloture_caisse')
            ->select('date_cloture')
            ->where('date_cloture','=', $request->datePaiement)
            ->take(1)
            ->orderBy('id', 'desc')         
            ->get();    
            foreach ($data3 as $row) 
            {                           
                $datetest=$row->date_cloture;          
            }

            if($datetest == $request->datePaiement)
            {
                    return response()->json([
                        'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
                    ]);            
            }
            else
            {
                $idAnne=0;
                $idOption=0;
                $idClasse=0;
    
                $data2 =   DB::table('inscriptions')       
                ->select('idEleve','idAnne','idOption','idClasse','idDivision','dateInscription',
                'codeInscription','reductionPaiement')
                ->where([
                   ['inscriptions.id','=', $request->idInscription]
                ])    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {
                    $idAnne=$row->idAnne;
                    $idOption=$row->idOption;
                    $idClasse=$row->idClasse;
                }
                $montantPrev=0;
    
                $data3 =  DB::table('previsions')   
                ->select(DB::raw('ROUND(SUM(previsions.montant),0) as montantPrev'))
                ->where([
                   ['idClasse','=', $idClasse],
                   ['idOption','=', $idOption],
                   ['idAnne','=', $idAnne],
               ])   
                ->get(); 
                $output='';
                foreach ($data3 as $row) 
                {                                
                   $montantPrev=$row->montantPrev;                           
                }
                $montantPaie = (floatval($request->montant));
                
                $codePaiement= date('Y').'-'.date('m').'-'.mt_rand(5, 1000000);
                $data = Paiement::create([
                    'idTranche'         =>  $request->idTranche,
                    'idFrais'           =>  $request->idFrais,
                    'idInscription'     =>  $request->idInscription,
                    'montant'           =>  $request->montant,
                    'datePaiement'      =>  $request->datePaiement,
                    'codePaiement'      =>  $codePaiement,
                    'idUser'            =>  $request->idUser,
                    'refBanque'         =>  $request->refBanque,
                    'numeroBordereau'   =>  $request->numeroBordereau,
                ]);
                $data4 = DB::update(
                    'update inscriptions set paie = paie + :paie where id = :idInscription',
                    ['paie' => $montantPaie,'idInscription' => $request->idInscription]
                );
    
                $totalPaie=0;
    
                $data5 =   DB::table('inscriptions')->select('paie')
                ->where([
                   ['inscriptions.id','=', $request->idInscription]
                ])    
                ->get(); 
                foreach ($data5 as $row) 
                {
                   $totalPaie=$row->paie;
                }
                $reste=(floatval($montantPrev) - floatval($totalPaie));
    
                $data6 = DB::update(
                'update inscriptions set reste = :reste where id = :idInscription',
                ['reste' => $reste,'idInscription' => $request->idInscription]
                );
    
                return response()->json(['data'  =>  "Insertion avec succès!!!"]);
    
    
            }            

        }
    }

    function chect_validation_paiement($id, $etat)
    {
        if ($id !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                Paiement::where('id',$id)->update([
                    'etatPaiement'         =>  0
                ]);
                return $this->msgJson('le paiement a été invalidé avec succès!');

            } else {
                // activation
                Paiement::where('id',$id)->update([
                    'etatPaiement'         =>  1
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
        $data = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')
        ->join('tranches','tranches.id','=','paiements.idTranche')
        ->join('type_tranches','type_tranches.id','=','paiements.idFrais')
        ->join('users','users.id','=','paiements.idUser')

        ->join('eleves','eleves.id','=','inscriptions.idEleve')
        ->join('anne_scollaires','anne_scollaires.id','=','inscriptions.idAnne')
        ->join('options','options.id','=','inscriptions.idOption')
        ->join('sections','sections.id','=','options.idSection')
        ->join('classes','classes.id','=','inscriptions.idClasse')
        ->join('divisions','divisions.id','=','inscriptions.idDivision')

        ->join('tconf_banque' , 'tconf_banque.id','=','paiements.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
        
        ->select("paiements.id",
            //paiements
            'paiements.idTranche','paiements.idFrais',
            'paiements.idInscription','paiements.montant',
            'paiements.datePaiement','paiements.codePaiement',
            'paiements.idUser','paiements.etatPaiement',

            //tranches 
            "tranches.nomTranche",

            //type tranche
            'type_tranches.nomTypeTranche', 

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

            //users
            'users.name','users.email','users.avatar',
            "paiements.created_at",'refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
            'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
            'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
            'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
            'numero_classe','nom_typeposition',"nom_typecompte")
        ->where('paiements.id', $id)->get();
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
        $idAnne=0;
        $idOption=0;
        $idClasse=0;
        $idInscription=0;
        $montantPaie=0;

        $data2 = DB::table("paiements")
        ->join('inscriptions','inscriptions.id','=','paiements.idInscription')       
        ->select('idEleve','idAnne','idOption','idClasse','idDivision','dateInscription',
        'codeInscription','reductionPaiement','paiements.montant')
        ->where([
           ['paiements.id','=', $id]
        ])    
        ->get();

        foreach ($data2 as $row) 
        {
            $idAnne=$row->idAnne;
            $idOption=$row->idOption;
            $idClasse=$row->idClasse;
            $idInscription=$row->idInscription;
            $montantPaie=$row->montant;
        }

        $data6 = DB::update(
            'update inscriptions set paie = (paie - :paie), reste = (reste + :reste) where id = :idInscription',
            ['paie' => $montantPaie,'reste' => $montantPaie,'idInscription' => $idInscription]
        );

        //
        $data = Paiement::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
