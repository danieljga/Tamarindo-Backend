<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $users = User::get();
            return response()->json(['data'=>$users],200);
        }catch(\Exception $e){
            Log::info('No se pudieron obtener los usuarios: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage());
            return response('No se pudieron obtener los usuarios: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
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
        try {
            $credentials = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'

            ];

            $validator = Validator::make($credentials, $rules);

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ]);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return response()->json(['success'=> true],200);

        }catch(\Exception $e){
            return response('Error al guardar el usuario: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
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
        try{
            $user = User::find($id);
            return response()->json(['data'=>$user],200);
        }catch(\Exception $e){
            return response('No se pudo obtener el usuario: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
        }
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
        try{
            Log::info($request->all());

            $credentials = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required'
            ];
            $validator = Validator::make($credentials, $rules);

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ]);
            }

            $user = User::find($id);
            $user->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Actualización exitosa',
                'client' => $user
            ]);
        }catch(\Exception $e){
            Log::critical('Error en la actualización del usuario: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage());
            return response()->json(['success'=> false],500);
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
        //
    }
}
