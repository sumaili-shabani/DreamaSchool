<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ventes\{tvente_client};
use App\Traits\{GlobalMethod,Slug};
use DB;
class tvente_clientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    public function index(Request $request)
    {
        //
        $data = DB::table("tvente_client")  
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')     
        ->select('tvente_client.id','noms','sexe','contact','mail','adresse','pieceidentite',
        'numeroPiece','dateLivrePiece','lieulivraisonCarte','nationnalite',
        'datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) as age_profil');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_client.created_at", "asc");

            return $this->apiData($data->paginate(3));
           

        }
        $data->orderBy("tvente_client.created_at", "asc");
        return $this->apiData($data->paginate(3));
    }



    function fetch_tvente_client_2()
    {
         $data = DB::table("tvente_client")  
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')     
         ->select('tvente_client.id','noms','sexe','contact','mail','adresse','pieceidentite',
         'numeroPiece','dateLivrePiece','lieulivraisonCarte','nationnalite',
         'datenaissance','lieunaissance','profession','occupation','nombreEnfant',
         'dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
         'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation")
         ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) as age_profil')
        ->get();
        
        return response()->json(['data' => $data]);

    }

    function insertData(Request $request)
    {
        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->noms.''.$formData->noms,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tvente_client::create([
                'noms'     =>  $formData->noms,
                'sexe'     =>  $formData->sexe,
                'contact'     =>  $formData->contact,
                'mail'     =>  $formData->mail,
                'adresse'     =>  $formData->adresse,
                'pieceidentite'     =>  $formData->pieceidentite,
                'numeroPiece'     =>  $formData->numeroPiece,
                'dateLivrePiece'     =>  $formData->dateLivrePiece,
                'lieulivraisonCarte'     =>  $formData->lieulivraisonCarte,
                'nationnalite'     =>  $formData->nationnalite,
                'datenaissance'     =>  $formData->datenaissance,
                'lieunaissance'     =>  $formData->lieunaissance,
                'profession'     =>  $formData->profession,
                'occupation'     =>  $formData->occupation,
                'nombreEnfant'     =>  $formData->nombreEnfant,
                'dateArriverGoma'     =>  $formData->dateArriverGoma,
                'arriverPar'     =>  $formData->arriverPar,
                'refCategieClient'     =>  $formData->refCategieClient,
                'photo'         =>  $imageName,
                'slug'     =>  $slug,
                'author'     =>  $formData->author
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);

            //return $this->msgJson('Information ajoutée avec succès');
        }
        else{


            $formData = json_decode($_POST['data']);
            
            $stringToSlug=substr($formData->noms.''.$formData->noms,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tvente_client::create([
                'noms'     =>  $formData->noms,
                'sexe'     =>  $formData->sexe,
                'contact'     =>  $formData->contact,
                'mail'     =>  $formData->mail,
                'adresse'     =>  $formData->adresse,
                'pieceidentite'     =>  $formData->pieceidentite,
                'numeroPiece'     =>  $formData->numeroPiece,
                'dateLivrePiece'     =>  $formData->dateLivrePiece,
                'lieulivraisonCarte'     =>  $formData->lieulivraisonCarte,
                'nationnalite'     =>  $formData->nationnalite,
                'datenaissance'     =>  $formData->datenaissance,
                'lieunaissance'     =>  $formData->lieunaissance,
                'profession'     =>  $formData->profession,
                'occupation'     =>  $formData->occupation,
                'nombreEnfant'     =>  $formData->nombreEnfant,
                'dateArriverGoma'     =>  $formData->dateArriverGoma,
                'arriverPar'     =>  $formData->arriverPar,
                'refCategieClient'     =>  $formData->refCategieClient,
                'photo'         =>  "avatar.png",
                'slug'     =>  $slug,
                'author'     =>  $formData->author
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
            //return $this->msgJson('Information ajoutée avec succès');
//mail_profil
        }

    }

    function updateData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
            
            $stringToSlug=substr($formData->noms.''.$formData->noms,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
           
            tvente_client::where('id',$formData->id)->update([
                'noms'     =>  $formData->noms,
                'sexe'     =>  $formData->sexe,
                'contact'     =>  $formData->contact,
                'mail'     =>  $formData->mail,
                'adresse'     =>  $formData->adresse,
                'pieceidentite'     =>  $formData->pieceidentite,
                'numeroPiece'     =>  $formData->numeroPiece,
                'dateLivrePiece'     =>  $formData->dateLivrePiece,
                'lieulivraisonCarte'     =>  $formData->lieulivraisonCarte,
                'nationnalite'     =>  $formData->nationnalite,
                'datenaissance'     =>  $formData->datenaissance,
                'lieunaissance'     =>  $formData->lieunaissance,
                'profession'     =>  $formData->profession,
                'occupation'     =>  $formData->occupation,
                'nombreEnfant'     =>  $formData->nombreEnfant,
                'dateArriverGoma'     =>  $formData->dateArriverGoma,
                'arriverPar'     =>  $formData->arriverPar,
                'refCategieClient'     =>  $formData->refCategieClient,
                'photo'         =>  $imageName,
                'slug'     =>  $slug,
                'author'     =>  $formData->author       

            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);


            //return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);

            $stringToSlug=substr($formData->noms.''.$formData->noms,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
           

            tvente_client::where('id',$formData->id)->update([
                'noms'     =>  $formData->noms,
                'sexe'     =>  $formData->sexe,
                'contact'     =>  $formData->contact,
                'mail'     =>  $formData->mail,
                'adresse'     =>  $formData->adresse,
                'pieceidentite'     =>  $formData->pieceidentite,
                'numeroPiece'     =>  $formData->numeroPiece,
                'dateLivrePiece'     =>  $formData->dateLivrePiece,
                'lieulivraisonCarte'     =>  $formData->lieulivraisonCarte,
                'nationnalite'     =>  $formData->nationnalite,
                'datenaissance'     =>  $formData->datenaissance,
                'lieunaissance'     =>  $formData->lieunaissance,
                'profession'     =>  $formData->profession,
                'occupation'     =>  $formData->occupation,
                'nombreEnfant'     =>  $formData->nombreEnfant,
                'dateArriverGoma'     =>  $formData->dateArriverGoma,
                'arriverPar'     =>  $formData->arriverPar,
                'refCategieClient'     =>  $formData->refCategieClient,
                'photo'         =>  "avatar.png",
                'slug'     =>  $slug,
                'author'     =>  $formData->author
            ]);

            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);


            // return $this->msgJson('Modifcation avec succès');

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
        $data = DB::table("tvente_client")  
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')     
        ->select('tvente_client.id','noms','sexe','contact','mail','adresse','pieceidentite',
        'numeroPiece','dateLivrePiece','lieulivraisonCarte','nationnalite',
        'datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) as age_profil')
        ->where('tvente_client.id', $id)
        ->get();

        return response()->json(['data'    =>  $data]);
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
        $data = tvente_client::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

    
}
