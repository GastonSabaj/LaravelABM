<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class AjaxController extends Controller
{
    /* 
        ¿Cómo se debuggea un controlador de ajax?
        reviso el laravel.log en storage/logs/laravel.log
    */
    public function getProducts()
    {
        $products = Product::all();
        //Log::info($products);
        $prices = $products->pluck('price')->toArray();
        Log::info($prices);
        return response()->json($prices);
    }

    public function filtrarProductos(Request $request)
    {
        // Obtener los datos del formulario de filtro
        $title = $request->input('title');
        $product_type = $request->input('product_type');

        // Consulta para filtrar productos
        // $products = Product::where('title', 'like', "%$title%")->orderBy('created_at', 'DESC')->paginate(2);

        // Consulta para filtrar productos
        $products = Product::where('title', 'like', "%$title%")->where('product_type', 'like', "%$product_type%")->orderBy('created_at', 'DESC')->paginate(2);

        // Devolver la vista completa de productos y paginación
        return view('product.index', compact('products'));
    }
    
}
