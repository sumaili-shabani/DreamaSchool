<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{User};

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;


use App\Traits\GlobalMethod;
use DB;
use URL;
use Auth;

class UserController extends Controller
{
    //
    use GlobalMethod;

    public function index(Request $request)
    {
        //
       
        $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id as user_id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active');
        

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('users.name', 'like', '%'.$query.'%')
            ->orWhere('users.email', 'like', '%'.$query.'%')
            ->orWhere('roles.nom', 'like', '%'.$query.'%')
            ->orderBy("users.id", "asc");

            return $this->apiData($data->paginate(4));
           

        }
        $data->orderBy("users.id", "desc");
        return $this->apiData($data->paginate(4));
       
        
    }

    function fetch_user_ceo()
    {
        $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id as user_id','users.id as id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->where('id_role', 2)
        ->get();
        return response()->json([
            'data'  =>  $data
        ]);
        

        
    }

    function fetch_user_medecin()
    {
        $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id as user_id','users.id as id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->where('users.id_role', 3)
        ->orderBy('users.name', 'ASC')
        ->get();
        return response()->json([
            'data'  =>  $data
        ]);
        

        
    }

     function fetch_user_infirmier()
    {
        $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id as user_id','users.id as id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->where('users.id_role', 9)
        ->orderBy('users.name', 'ASC')
        ->get();
        return response()->json([
            'data'  =>  $data
        ]);
        

        
    }

    function fetch_user_all()
    {
        $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id as user_id','users.id as id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->whereNotNull("users.telephone")
        ->get();
        return response()->json([
            'data'  =>  $data
        ]);
        

        
    }

    function fetch_user_all_agent()
    {
        $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id as user_id','users.id as id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->get();
        return response()->json([
            'data'  =>  $data
        ]);
        

        
    }


    function checkEtat_Compte($id, $etat)
    {
        if ($id !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                User::where('id',$id)->update([
                    'active'         =>  0
                ]);
                return $this->msgJson('Le compte utilisateur a été desactivée avec succès!');

            } else {
                // activation
                User::where('id',$id)->update([
                    'active'         =>  1
                ]);
                return $this->msgJson('Le compte utilisateur a été activée avec succès!');
            }
            
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
            $data = User::where("id", $request->id)->update([
                'name'              =>  $request->name, 
                'email'             =>  $request->email,
                'telephone'         =>  $request->telephone,
                'adresse'           =>  $request->adresse,
                'sexe'              =>  $request->sexe
                
            ]);

            return response()->json([
                'data'  =>  "Modification information avec succès!!!"
            ]);

            // $this->msgJson("Modification information avec succès!!!");

        }
        else
        {
            // insertion 
            $data = User::create([
                'name'              =>  $request->name, 
                'email'             =>  $request->email,
                'sexe'              =>  $request->sexe,
                'telephone'         =>  $request->telephone,
                'adresse'           =>  $request->adresse,
                'password'          =>  Hash::make($request->password),
                'remember_token'    =>  Hash::make(rand(0,10)),
                'id_role'           =>  2
            ]);

            

            return response()->json([
                'data'  =>  $data
            ]);

            // return $this->msgJson("Insertion avec succès!!!");
           
           

        }
    }


    function insert_user(Request $request)
    {
        try{

            $data =  DB::table('users')->insert(
            [
                    'name'              => 'John',
                    'email'             => 'john@example.com', 
                    'sexe'              => 'M',
                    'password'          => "123456",
                    'remember_token'    => "123456",
                    'id_role'           =>  2

                ]
            );

            return $this->msgJson("Insertion avec succès!!!");

        }
        catch(PDOException $e)
        {
            return $this->msgJson($e->getMessage());
        }


    }



    function ChangePassword(Request $request)
    {

        $data = User::where('id', $request->id)->update([
            'password'          =>  Hash::make($request->password),
            'remember_token'    =>  Hash::make(rand(0,10)),
            'id_role'           =>  $request->id_role
        ]);

        return $this->msgJson("Modification réussue avec succès!!!");

    }


    function ChangeMyPasswordSecure(Request $request)
    {
       
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
           // return $this->msgJson("Success!!!");
            $data_updated = User::where('id', $request->id)->update([
                'password'          =>  Hash::make($request->password_nouveau),
                'remember_token'    =>  Hash::make(rand(0,10))
            ]);

            return $this->msgJson("Mot de passse changer  avec succès!!!");
        }
        else{
            return $this->msgJson("Informations incorectes!!!");
        }

       

    }

    function ChangeRole(Request $request)
    {

        $data = User::where('id', $request->id)->update([
           'id_role'           =>  $request->id_role
        ]);
        return $this->msgJson("User updated");

    }





    function convertHtmlTug($id)
    {
        $output = '
        <!doctype html>
        <html lang="en">
          <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

            <title>Hello, world!</title>
          </head>
          <body>
            <h1>Hello, world!</h1>

            
            
          </body>
        </html>
        ';

        return $output;

    }


    function printBill(Request $request)
    {
        if ($request->get('id_user')) 
       {
            $id_user = $request->get('id_user');
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($this->convertHtmlTug($id_user));
            return $pdf->stream();
       }
    }

    function editPhoto(Request $request)
    {
      if (!is_null($request->image)) 
      {
        $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();

         // $request->image->move(storage_path('app/public/images/'), $imageName);
          $request->image->move(public_path('/images'), $imageName);

        User::where('id',$formData->agentId)->update(['avatar' => $imageName]);
        return $this->msgJson('Fichier ajouté avec succès');

      }
       
    }



    public function showUser($id)
    {
        //
        $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->where("users.id", $id)
        ->get();
        return response()->json(['data'  =>  $data]);
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
        $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id as user_id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->where("users.id", $id)
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
        $data = User::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }


    //les autres scripts

    public function validatePasswordRequest(Request $request)
    {
        $user = DB::table('users')->where('email', '=', $request->email)
        ->count();
        //Check if the user exists
        if ($user < 1) {
            // return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
            return response()->json([
                'data'      =>  "User does not exist"
            ]);
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            // return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));

            //Generate, the password reset link. The token generated is embedded in the link
            // $link = config('base_url') . 'password/reset/' . $tokenData->token . '?email=' . urlencode($request->email);

            $link = 'reset/' . $tokenData->token . '/' . urlencode($request->email);
            $my_link = url($link);

            $user = DB::table('users')->where('email', $request->email)->select('name', 'email')->get();
            foreach ($user as $row) {
                // code...
                $name = $row->name;
                $email = $row->email;
                $lien = $my_link;
                $message = "Votre lien de réunitialisation de votre mot de passe. prière de cliquer sur le lien";

                $this->send_mail($name,$email,$message, $lien);
            }
            

            return $this->msgJson("Un lien de réinitialisation a été envoyé à votre adresse e-mail.");
        } else {
            // return redirect()->back()->withErrors(['error' => trans("Une erreur réseau s'est produite. Veuillez réessayer.")]);
            return $this->msgJson("Une erreur réseau s'est produite. Veuillez réessayer.");
        }
    }


    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = URL::to("/password/reset/" . $token . "?email=" . urlencode($user->email)."");

        try {
            //Here send the link with CURL with an external email API 
            return true;

        } catch (\Exception $e) {
            return false;
        }

    }

    function send_mail($name,$email,$message, $lien)
    {

        $data = array(
            'name'      =>  $name,
            'email'     =>  $email,
            'message'   =>  $message,
            'lien'      =>  $lien
        );

        //here we send mail to web-tutorial@programmer.net
        Mail::to('application@code.info')->send(new ContactMail($data));

        // return json_encode(["data" => "Merci de nous avoir contacté !"]);
        
    }

    public function reset_password($token, $email)
    {
        $data = array(
            'token'     =>  $token,
            'email'     =>  $email,

        );
         return view('frontend.reset', $data);
    }



   

    
    public function resetPassword(Request $request)
    {
        

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
        ->where('token', $request->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return $this->msgJson("Impossible de faire l'opération!!!.");

        $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user) return $this->msgJson("Adresse email non trouvé!!!.");
        //Hash and update the new password
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        if ($user) {
            # code...
            return response()->json([
                'data'      => "votre compte a été Reinitialisé avec succès!!!",
                'success'   =>  true
            ]);
            //login the user immediately they change password successfully
            Auth::login($user);

            //Delete the token
            DB::table('password_resets')->where('email', $user->email)
            ->delete();
        }
        else{

            return response()->json([
                'data'      => "Impossible de faire l'opération!!!",
                'success'   =>  true
            ]);
        }

    }







    





}
