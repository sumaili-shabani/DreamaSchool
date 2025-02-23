<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tannexe_depense};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tannexe_depenseController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tannexe_depense')
            ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
            ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
            "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
            'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","numeroBE")
            ->where('noms_annexe', 'like', '%'.$query.'%')            
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);

        }
        else{
            $data = DB::table('tannexe_depense')
            ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
            ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
            "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
            'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","numeroBE")
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }


    public function fetch_annexe_depense(Request $request,$refDepense)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tannexe_depense')
            ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
            ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
            "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
            'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","numeroBE") 
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')              
            ->where([
                ['motif', 'like', '%'.$query.'%'],
                ['refDepense',$refDepense]
            ])                    
            ->orderBy("tannexe_depense.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tannexe_depense')
            ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
            ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
            "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
            'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","numeroBE")    
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')            
            ->where([
                ['refDepense',$refDepense]
            ])    
            ->orderBy("tannexe_depense.id", "desc")
            ->paginate(10);

            return response($data, 200);          
 
        }

    } 

    function fetch_single($id)
    {

        $data = DB::table('tannexe_depense')
        ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
        ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
        "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
        'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
        "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","numeroBE")  
        ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')  
        ->where('tannexe_depense.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }



    public function annexe_recette(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tannexe_depense')
            ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
            ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
            "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
            'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->where([
                ['noms_annexe', 'like', '%'.$query.'%'],
                ['tdepense.refMvt', '1']
            ])            
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);

        }
        else{
            $data = DB::table('tannexe_depense')
            ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
            ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
            "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
            'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","numeroBE")
            ->where([
                ['tdepense.refMvt', '1']
            ])
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }


    public function annexe_depense(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tannexe_depense')
            ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
            ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
            "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
            'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->where([
                ['noms_annexe', 'like', '%'.$query.'%'],
                ['tdepense.refMvt', '2']
            ])            
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);

        }
        else{
            $data = DB::table('tannexe_depense')
            ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
            ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
            "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
            'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","numeroBE")
            ->where([
                ['tdepense.refMvt', '2']
            ])
            ->orderBy("id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }


    function fetch_tannexe_depense_2()
    {
        $data = DB::table('tannexe_depense')
        ->join('tdepense','tdepense.id','=','tannexe_depense.refDepense')
        ->select("tannexe_depense.id",'noms_annexe','refDepense','annexe','tannexe_depense.author',
        "tannexe_depense.created_at",'montant','montantLettre','motif','dateOperation',
        'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
        "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","numeroBE")
        ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
        ->orderBy("id", "desc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

    }


    function insert_data(Request $request)
    {
        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 

  
            $data= tannexe_depense::create([
                'noms_annexe'       =>  $formData->noms_annexe,
                'refDepense'       =>  $formData->refDepense,
                'annexe'    =>  $imageName,
                'author'  =>  $formData->author        
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tannexe_depense::create([
            'noms_annexe'       =>  $formData->noms_annexe,
            'refDepense'       =>  $formData->refDepense,
            'annexe'    =>  'avatar.png',
            'author'  =>  $formData->author        
           ]);
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
   
        }

    }


    function update_data(Request $request, $id)
    {
        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName);
         
           $data= tannexe_depense::where('id',$formData->id)->update([
                'noms_annexe'       =>  $formData->noms_annexe,
                'refDepense'       =>  $formData->refDepense,
                'annexe'    =>  $imageName,
                'author'  =>  $formData->author      
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
        }
        else{
            $formData = json_decode($_POST['data']);
            $data= tannexe_depense::where('id',$formData->id)->update([
                'noms_annexe'       =>  $formData->noms_annexe,
                'refDepense'       =>  $formData->refDepense,
                'author'  =>  $formData->author
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
   
        }
       }


    function delete_data($id)
    {
        $data = tannexe_depense::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }


    public function downloadfile($filenamess)
    {
        $filepath = public_path('fichier/'.$filenamess.'');
        return response()->file($filepath);
    }




}
