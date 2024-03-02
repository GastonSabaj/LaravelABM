<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AjaxController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    /* 
    El orden es:
    Route::get('/definicionruta', 'nombreControladorAsociado')->name('nombreRuta');
    */
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
  
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
  
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});
  
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
 
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('products');
        Route::get('create', 'create')->name('products.create');
        Route::post('store', 'store')->name('products.store');
        Route::get('show/{id}', 'show')->name('products.show');
        Route::get('edit/{id}', 'edit')->name('products.edit');
        Route::put('edit/{id}', 'update')->name('products.update');
        Route::delete('destroy/{id}', 'destroy')->name('products.destroy');
    });
 
    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\AuthController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/productos', [App\Http\Controllers\AjaxController::class, 'getProducts'])->name('productos');
    Route::post('/filtrar-productos-por-titulo', [App\Http\Controllers\AjaxController::class, 'filtrarProductosPorTitulo'])->name('filtrar_productos_por_titulo');


    Route::get('/prueba', [App\Http\Controllers\ProductController::class, 'prueba'])->name('prueba');
    Route::post('/prueba', [App\Http\Controllers\ProductController::class, 'pruebaAction'])->name('prueba');
    
    //Ruta para crear pdfs
    Route::get('/pdf', function(){
        $data=[
            'users' => User::all() 
        ];
        $pdf = Pdf::loadView('users-pdf',$data);
        return $pdf->download('users-pdf.pdf');
    });

});
