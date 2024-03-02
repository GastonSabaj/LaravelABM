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

    public function filtrarProductosPorTitulo(Request $request)
    {
        // Obtener los datos del formulario de filtro
        $title = $request->input('title');

        // Consulta para filtrar productos
        $products = Product::where('title', 'like', "%$title%")->orderBy('created_at', 'DESC')->paginate(2);

        // Devolver la vista completa de productos y paginación
        return view('product.index', compact('products'));
    }
    
}
