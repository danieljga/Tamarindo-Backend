<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    /**
     * Create a new SupplierController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $suppliers = Supplier::get();
            return response()->json(['data'=>$suppliers],200);
        }catch(\Exception $e){
            return response('No se pudieron obtener las proveedores: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
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
        try{
            $credentials = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required'
            ];
            $validator = Validator::make($credentials, $rules);

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ]);
            }

            Supplier::create($request->all());

            return response()->json(['success'=> true],200);
        }catch(\Exception $e){
            Log::info('Error al guardar el proveedor: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
            return response()->json(['success'=> false],500);
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
        try{
            $credentials = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required'
            ];
            $validator = Validator::make($credentials, $rules);

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ]);
            }

            $supplier = Supplier::find($id);
            $supplier->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Actualización exitosa'
            ]);
        }catch(\Exception $e){
            Log::info('Error al actualizar el proveedor: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
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
        try{
            $supplier = Supplier::find($id);
            $supplier->delete();

            return response()->json([
                'success' => true,
                'mensaje'=>'Se eliminó con exito'
            ]);
        }catch(\Exception $e){
            Log::info('Error al eliminar el proveedor: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
            return response()->json(['success'=> false],500);
        }
    }
}
