<?php

namespace App\Http\Controllers\Backend\Cours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Cours\{Enseignant};
use App\Traits\{GlobalMethod,Slug};
use DB;

class EnseignantController extends Controller
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
        $data = DB::table("enseignants")
        ->join('avenues','avenues.id','=','enseignants.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        ->select("enseignants.id",
            //enseignants 
            'enseignants.idAvenue','enseignants.nomEns',
            'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
            'enseignants.telEns','enseignants.tel2Ens',
            'enseignants.sexeEns','enseignants.etatcivilEns',
            'enseignants.prefEns','enseignants.degreprefEns',
            'enseignants.telprefEns','enseignants.codeEns',
            'enseignants.numCarteEns','enseignants.passwordEns',
            'enseignants.imageEns',
            'enseignants.numMaisonEns', 'enseignants.dateNaisEns',
             //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',

            "enseignants.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('enseignants.nomEns', 'like', '%'.$query.'%')
            ->orWhere('avenues.nomAvenue', 'like', '%'.$query.'%')
            ->orderBy("enseignants.id", "desc");

            return $this->apiData($data->paginate(10));


        }

        $data->orderBy("enseignants.id", "desc");
        return $this->apiData($data->paginate(10));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch_enseignant_2()
    {
        //
        $data = DB::table("enseignants")
        ->join('avenues','avenues.id','=','enseignants.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        ->select("enseignants.id",
            //enseignants 
            'enseignants.idAvenue','enseignants.nomEns',
            'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
            'enseignants.telEns','enseignants.tel2Ens',
            'enseignants.sexeEns','enseignants.etatcivilEns',
            'enseignants.prefEns','enseignants.degreprefEns',
            'enseignants.telprefEns','enseignants.codeEns',
            'enseignants.numCarteEns','enseignants.passwordEns',
            'enseignants.imageEns',
            'enseignants.numMaisonEns', 'enseignants.dateNaisEns',
             //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',

            "enseignants.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
        ->get();
        return response()->json(['data'  =>  $data]);
    }


    function editPhotoEnseignant(Request $request)
    {
      if (!is_null($request->image))
      {
        $formData = json_decode($_POST['data']);
        $imageName = time().'.'.$request->image->getClientOriginalExtension();

        // $request->image->move(storage_path('app/public/images/'), $imageName);
        $request->image->move(public_path('/images'), $imageName);

        Enseignant::where('id',$formData->agentId)->update(['imageEns' => $imageName]);
        return $this->msgJson('Fichier ajouté avec succès');

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
            $data = Enseignant::where("id", $request->id)->update([
                'idAvenue'          =>  $request->idAvenue,
                'nomEns'            =>  $request->nomEns,
                'nationaliteEns'    =>  $request->nationaliteEns,
                'telEns'            =>  $request->telEns,
                'tel2Ens'           =>  $request->tel2Ens,
                'sexeEns'           =>  $request->sexeEns,
                'etatcivilEns'      =>  $request->etatcivilEns,
                'prefEns'           =>  $request->prefEns,
                'degreprefEns'      =>  $request->degreprefEns,
                'telprefEns'        =>  $request->telprefEns,
                'numCarteEns'       =>  $request->numCarteEns,
                'numMaisonEns'      =>  $request->numMaisonEns,
                'dateNaisEns'       =>  $request->dateNaisEns,
                
                

            ]);

            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion
            $codeEns = mt_rand(5, 100000000);
            $data = Enseignant::create([
                'idAvenue'          =>  $request->idAvenue,
                'nomEns'            =>  $request->nomEns,
                'nationaliteEns'    =>  $request->nationaliteEns,
                'telEns'            =>  $request->telEns,
                'tel2Ens'           =>  $request->tel2Ens,
                'sexeEns'           =>  $request->sexeEns,
                'etatcivilEns'      =>  $request->etatcivilEns,
                'prefEns'           =>  $request->prefEns,
                'degreprefEns'      =>  $request->degreprefEns,
                'telprefEns'        =>  $request->telprefEns,
                'codeEns'           =>  $codeEns,
                'numCarteEns'       =>  $request->numCarteEns,
                'numMaisonEns'      =>  $request->numMaisonEns,
                'dateNaisEns'       =>  $request->dateNaisEns,
                'imageEns'          =>  'avatar.png',
                
            ]);

            return response()->json(['data'  =>  "Insertion avec succès!!!"]);


        }
    }

    public function updateEnseignantLoginData(Request $request)
    {
        //
        if ($request->id !='')
        {
            # code... 
            $data = Enseignant::where("id", $request->id)->update([
                'nomUtilisateurEns'     =>  $request->nomUtilisateurEns,
                'passwordEns'           =>  $request->passwordEns,
                
            ]);
            
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

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
        $data = DB::table("enseignants")
        ->join('avenues','avenues.id','=','enseignants.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        ->select("enseignants.id",
            //enseignants 
            'enseignants.idAvenue','enseignants.nomEns',
            'enseignants.nomUtilisateurEns','enseignants.nationaliteEns',
            'enseignants.telEns','enseignants.tel2Ens',
            'enseignants.sexeEns','enseignants.etatcivilEns',
            'enseignants.prefEns','enseignants.degreprefEns',
            'enseignants.telprefEns','enseignants.codeEns',
            'enseignants.numCarteEns','enseignants.passwordEns',
            'enseignants.imageEns',
            'enseignants.numMaisonEns', 'enseignants.dateNaisEns',
             //localisation
            'avenues.idQuartier','avenues.nomAvenue',
            'quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays',

            "enseignants.created_at")
        ->selectRaw('TIMESTAMPDIFF(year, enseignants.dateNaisEns, CURDATE()) as ageEns')
        ->where('enseignants.id', $id)->get();
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
        $data = Enseignant::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
