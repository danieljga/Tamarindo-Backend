<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
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
            $products = Product::get();
            return response()->json(['data'=>$products],200);
        }catch(\Exception $e){
            return response('No se pudieron obtener los productos: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
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
                'reference' => 'required',
                'product_category_id' => 'required'
            ];
            $validator = Validator::make($credentials, $rules);

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ]);
            }

            Product::create($request->all());

            return response()->json(['success'=> true],200);
        }catch(\Exception $e){
            Log::info('Error al guardar el producto: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
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
        try{
            $product = Product::find($id);
            return response()->json(['data'=>$product],200);
        }catch(\Exception $e){
            return response('No se pudo obtener el producto solicitado: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
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
            $credentials = $request->all();

            $rules = [
                'reference' => 'required',
                'product_category_id' => 'required'
            ];
            $validator = Validator::make($credentials, $rules);

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ]);
            }

            $product = Product::find($id);
            $product->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Actualización exitosa'
            ]);
        }catch(\Exception $e){
            Log::info('Error al actualizar el producto: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
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
            $product = Product::find($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'mensaje'=>'Se eliminó con exito'
            ]);
        }catch(\Exception $e){
            Log::info('Error al eliminar el producto: ' . $e->getCode() . ', ' . $e->getLine() . ', ' . $e->getMessage(), 500);
            return response()->json(['success'=> false],500);
        }
    }
}
