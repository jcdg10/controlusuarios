<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->ajax()) {
             $datas = User::all('id','name','email','phone','rfc');
             return datatables()->of($datas)
             ->addIndexColumn()
             ->addColumn('action', function($datas){
       
                $btn = '<button type="button" class="btn editar" id="'.$datas->id.'"><i class="far fa-edit"></i></button>&nbsp';
                $btn = $btn.'<button type="button" class="btn eliminar" id="'.$datas->id.'"><i class="far fa-trash-alt"></i></button>';

                 return $btn;
         })
         ->rawColumns(['action'])
         ->make(true);
         }        
         return view('users.users');
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
/*
        return response()->json([
            'status' => true,
            'message' => 'Usuario creado',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);*/

        return response()->json(
                $users
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if ($request->is('api/*')) {
            
            $validated = Validator::make($request->all(),
                [
                'name' => ['required',
                          'string',
                          'max:255'
                          ],
                'email' => ['required',
                          'email',
                          'unique:users',
                          'max:255'
                          ],
                'password' => ['required',
                          'min:10',
                          'max:40'
                          ],
                'rfc' => ['required',
                          'min:12',
                          'unique:users',
                          'max:13',
                          function ($attribute, $value, $fail) {
                                if (!$this->valida_rfc($value)) {
                                    $fail($attribute.' es inválido.');
                                }
                           }
                          ]
            ]);

            if($validated->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error de validacion',
                    'errors' => $validated->errors()
                ], 401);
            }

        }
        else{

            $validated = $request->validate([
                'name' => ['required',
                          'string',
                          'max:255'
                          ],
                'email' => ['required',
                          'email',
                          'unique:users',
                          'max:255'
                          ],
                'password' => ['required',
                          'min:10',
                          'max:40'
                          ],
                'rfc' => ['required',
                          'min:12',
                          'unique:users',
                          'max:13',
                          function ($attribute, $value, $fail) {
                                if (!$this->valida_rfc($value)) {
                                    $fail($attribute.' es inválido.');
                                }
                           }
                          ]
            ]);
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $ip = $this->getIp();
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->rfc = $request->rfc;
        $user->note = $request->note;
        $user->password = Hash::make($request->password);
        $user->ipaddress = preg_replace('/[^0-9.\-]/', '', $ip);
        
        if ($request->is('api/*')) {

            try{
                if($user->save()){
                    return response()->json([
                        'status' => true,
                        'message' => 'Usuario creado',
                        'token' => $user->createToken("API TOKEN")->plainTextToken
                    ], 200);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => "Ocurrio un error"
                    ], 401);
                }
            }
            catch (\Throwable $th) {

                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 401);
    
            }
            
        }else{
            if($user->save()){
                return "1";
            }
            else{
                return "0";
            }
        }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json(
            $user
        );
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   

        if ($request->is('api/*')) {
                $validated = Validator::make($request->all(),
                    [
                    'name' => [
                            'string',
                            'max:255'
                            ],
                    'email' => [
                            'email',
                            'unique:users,email,'.$id,
                            'max:255'
                            ],
                    'password' => [
                                function ($attribute, $value, $fail) {
                                        if (strlen($value) > 0) {
                                            if(strlen($value) < 10) {
                                                $fail('El campo password debe tener al menos 10 caracteres.');
                                            }
                                            if(strlen($value) > 40) {
                                                $fail('El campo password no puede tener más de 40 caracteres.');
                                            }
                                        }
                                }
                            ],
                    'rfc' => [
                            'min:12',
                            'unique:users,rfc,'.$id,
                            'max:13',
                            function ($attribute, $value, $fail) {
                                    if (!$this->valida_rfc($value)) {
                                        $fail($attribute.' es inválido.');
                                    }
                            }
                            ]
                ]);
                
                
                if($validated->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'Error de validacion',
                        'errors' => $validated->errors()
                    ], 401);
                }
                
                $user = User::findOrFail($id);
                if(trim($request->name) != ''){
                    $user->name = $request->name;
                }
                if(trim($request->email) != ''){
                    $user->email = $request->email;
                }
                if(trim($request->phone) != ''){
                    $user->phone = $request->phone;
                }
                if(trim($request->note) != ''){
                    $user->note = $request->note;
                }
                if(trim($request->rfc) != ''){
                    $user->rfc = $request->rfc;
                }

        }
        else{
            
            $validated = $request->validate([
                    'name' => ['required',
                            'string',
                            'max:255'
                            ],
                    'email' => ['required',
                            'email',
                            'unique:users,email,'.$id,
                            'max:255'
                            ],
                    'password' => [
                                function ($attribute, $value, $fail) {
                                        if (strlen($value) > 0) {
                                            if(strlen($value) < 10) {
                                                $fail('El campo password debe tener al menos 10 caracteres.');
                                            }
                                            if(strlen($value) > 40) {
                                                $fail('El campo password no puede tener más de 40 caracteres.');
                                            }
                                        }
                                }
                            ],
                    'rfc' => ['required',
                            'min:12',
                            'unique:users,rfc,'.$id,
                            'max:13',
                            function ($attribute, $value, $fail) {
                                    if (!$this->valida_rfc($value)) {
                                        $fail($attribute.' es inválido.');
                                    }
                            }
                            ]
                ]);

                $user = User::findOrFail($id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->rfc = $request->rfc;
                $user->note = $request->note;

        }        


        

        if(trim($request->password) != ''){
            $user->password = Hash::make($request->password);
        }

        if ($request->is('api/*')) {

            try{
                if($user->update()){
                    return response()->json([
                        'status' => true,
                        'message' => 'Usuario modificado'
                    ], 200);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => "Ocurrio un error"
                    ], 401);
                }
            }
            catch (\Throwable $th) {

                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 401);
    
            }
            
        }else{
            if($user->update()){
                return "1";
            }
            else{
                return "0";
            }
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            if($user->delete()){
                echo "1";
            }
            else{
                echo "0";            
            }
        }
        catch(Exception $e){
            Log::error($e);
            echo "0";
        }
    }

    public function getIp(){
        $shellexec = shell_exec('ipconfig');
        $findme = "IPv4. . . . . . . . . . . . . . :";
        $pos = strpos($shellexec, $findme);
        $pos = $pos + 33;
        $ip = substr($shellexec, $pos, 20);

        return $ip;
    }

    public function valida_rfc($valor){
 
        $valor = str_replace("-", "", $valor);
        $valor = str_replace('Ñ','N',$valor); 
        $cuartoValor = substr($valor, 3, 1);
        //RFC sin homoclave
        if(strlen($valor)==10){
            $letras = substr($valor, 0, 4); 
            $numeros = substr($valor, 4, 6);
            if (ctype_alpha($letras) && ctype_digit($numeros)) { 
                return true;
            }
            return false;            
        }
        // Sólo la homoclave
        else if (strlen($valor) == 3) {
            $homoclave = $valor;
            if(ctype_alnum($homoclave)){
                return true;
            }
            return false;
        }
        //RFC Persona Moral.
        else if (ctype_digit($cuartoValor) && strlen($valor) == 12) { 
            $letras = substr($valor, 0, 3); 
            $numeros = substr($valor, 3, 6); 
            $homoclave = substr($valor, 9, 3); 
            if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) { 
                return true; 
            } 
            return false;
        //RFC Persona Física. 
        } else if (ctype_alpha($cuartoValor) && strlen($valor) == 13) { 
            $letras = substr($valor, 0, 4); 
            $numeros = substr($valor, 4, 6);
            $homoclave = substr($valor, 10, 3); 
            if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) { 
                return true; 
            }
            return false; 
        }else { 
            return false; 
        }  
    }
}
