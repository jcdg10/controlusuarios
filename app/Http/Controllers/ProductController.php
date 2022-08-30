<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->ajax()) {
             $datas = Product::all();
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
         return view('products.products');
     }


     public function store(Request $request)
     {
        $product = new Product();
        $product->name = $request->nombre;
        $product->price = $request->precio;
        
        if($product->save()){
            return "1";
        }
        else{
            return "0";
        }

        
     }

     public function destroy(Product $product)
     {
        try{
            if($product->delete()){
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

    public function show($id){

        return Product::findOrFail($id);
        
    }

    public function update(Request $request, $id)
	{
		$product = Product::findOrFail($id);
        $product->name = $request->nombre;
        $product->price = $request->precio;

		if($product->update()){
            echo "1";
        }
        else{
            echo "0";
        }
		
	}
}
