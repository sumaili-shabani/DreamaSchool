<?php

namespace App\Http\Controllers\Backend\Ecole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\Ecole\{Eleve};
use App\Traits\{GlobalMethod,Slug};
use DB;

class EleveController extends Controller
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

        $data = DB::table('eleves')
        ->join('avenues','avenues.id','=','eleves.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')

        ->select('eleves.id',
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

            'eleves.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw("CONCAT(eleves.nomEleve,' ', eleves.postNomEleve,' ',eleves.preNomEleve) as noms");


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
            ->orderBy("eleves.id", "desc");

            return $this->apiData($data->paginate(6));


        }
        $data->orderBy("eleves.id", "desc");
        return $this->apiData($data->paginate(6));
    }

    function getListEleve()
    {
        $blog = DB::table('eleves')
        ->join('avenues','avenues.id','=','eleves.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')

        ->select('eleves.id',
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

            'eleves.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw("CONCAT(eleves.nomEleve,' ', eleves.postNomEleve,' ',eleves.preNomEleve) as noms")
        ->orderBy("eleves.nomEleve", "Asc")
        ->get();
        $data = [];
        foreach ($blog as $row) {
            // code...
            array_push($data, array(
                'id'            =>  $row->id,
                'idEleve'       =>  $row->id,
                'ageEleve'      =>  $row->ageEleve,
                'sexeEleve'     =>  $row->sexeEleve,
                'nomEleve'      =>  $row->noms,
                'photoEleve'    =>  $row->photoEleve,
                
            ));
        }

        return response()->json(['data'  =>  $data]);
    }

    function editPhotoEleve(Request $request)
    {
      if (!is_null($request->image))
      {
        $formData = json_decode($_POST['data']);
        $imageName = time().'.'.$request->image->getClientOriginalExtension();

         // $request->image->move(storage_path('app/public/images/'), $imageName);
        $request->image->move(public_path('/images'), $imageName);

        Eleve::where('id',$formData->agentId)->update(['photoEleve' => $imageName]);
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
            $data = Eleve::where("id", $request->id)->update([
                'idAvenue'           =>  $request->idAvenue,
                'nomEleve'           =>  $request->nomEleve,
                'postNomEleve'       =>  $request->postNomEleve,
                'preNomEleve'        =>  $request->preNomEleve,
                'etatCivilEleve'     =>  $request->etatCivilEleve,
                'sexeEleve'          =>  $request->sexeEleve,
                'nomPere'            =>  $request->nomPere,
                'nomMere'            =>  $request->nomMere,
                'numPere'            =>  $request->numPere,
                'numMere'            =>  $request->numMere,
                'numAdresseEleve'    =>  $request->numAdresseEleve,
                'dateNaisEleve'      =>  $request->dateNaisEleve,

            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion
            $codeEleve = rand();
            $count = $this->showCountTableEleve($request->nomEleve, $request->postNomEleve, $request->preNomEleve);
            if ($count <=0) {
                // code...
                $data = Eleve::create([
                    'idAvenue'           =>  $request->idAvenue,
                    'nomEleve'           =>  $request->nomEleve,
                    'postNomEleve'       =>  $request->postNomEleve,
                    'preNomEleve'        =>  $request->preNomEleve,
                    'etatCivilEleve'     =>  $request->etatCivilEleve,
                    'sexeEleve'          =>  $request->sexeEleve,
                    'nomPere'            =>  $request->nomPere,
                    'nomMere'            =>  $request->nomMere,
                    'numPere'            =>  $request->numPere,
                    'numMere'            =>  $request->numMere,
                    'codeEleve'          =>  $codeEleve,
                    'numAdresseEleve'    =>  $request->numAdresseEleve,
                    'dateNaisEleve'      =>  $request->dateNaisEleve,
                    'photoEleve'         =>  'avatar.png',
                ]);

                return $this->msgJson('Insertion avec succès!!!');
            } else {
                // code...
                $nomComplet = $request->nomEleve." ".$request->postNomEleve." ".$request->preNomEleve;
                return $this->msgJson("Désolé l'élève ".$nomComplet."Existe déjà !!!");
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
        $data = DB::table('eleves')
        ->join('avenues','avenues.id','=','eleves.idAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')

        ->select('eleves.id',
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

            'eleves.created_at')
        ->selectRaw('TIMESTAMPDIFF(year, eleves.dateNaisEleve, CURDATE()) as ageEleve')
        ->selectRaw("CONCAT(eleves.nomEleve,' ', eleves.postNomEleve,' ',eleves.preNomEleve) as noms")
        ->where("eleves.id", $id)
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
        $data= Eleve::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }



}
