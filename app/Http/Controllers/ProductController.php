<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Product;
 
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        
        //Primero es la carpeta y luego el archivo, en este caso sería /product/index.blade.php
        //En este caso, estoy pasando el arreglo $product a la vista
        return view('product.index', compact('products'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:10',
            'price' => 'required|numeric',
            'product_code' => 'required|numeric',
            'description' => 'nullable|string',
        ],[
            //Mensaje de validación customizado para el campo price
            'price.numeric' => 'El campo precio debe ser un número.',
        ]);

        Product::create($request->all());
 
        //Acá se va a redirigir a la ruta cuyo nombre es /products, definido en el archivo routes/web.php
        return redirect()->route('products')->with('success', 'Product added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
  
        //Primero es la carpeta y luego el archivo, en este caso sería /product/show.blade.php
        return view('product.show', compact('product'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
  
        //Primero es la carpeta y luego el archivo, en este caso sería /product/edit.blade.php
        return view('product.edit', compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:10',
            'price' => 'required|numeric',
            'product_code' => 'required|numeric',
            'description' => 'nullable|string',
        ],[
            //Mensaje de validación customizado para el campo price
            'price.numeric' => 'El campo precio debe ser un número.',
        ]);

        $product->update($request->all());
  
        //Acá se va a redirigir a la ruta cuyo nombre es /products, definido en el archivo routes/web.php
        return redirect()->route('products')->with('success', 'product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
  
        $product->delete();
  
        //Acá se va a redirigir a la ruta cuyo nombre es /products, definido en el archivo routes/web.php
        return redirect()->route('products')->with('success', 'product deleted successfully');
    }

    public function prueba(){
        //return view('carpetadeprueba.formdinamico');
        return view('carpetadeprueba.filtradortabla');
    }

    public function pruebaAction(Request $request){
        dd($request->all());
    }
}