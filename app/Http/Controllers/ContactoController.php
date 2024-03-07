<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Redirect;




class ContactoController extends Controller
{
     // Método para mostrar el formulario de contacto
     public function mostrarFormulario()
     {
         return view('contacto.formulario_contacto');
     }
 
     // Método para enviar el correo electrónico desde el formulario de contacto
     public function enviarCorreo(Request $request)
     {
         // Obtener el correo electrónico del usuario logueado
         $fromEmail = Auth::user()->email;
     
         // Obtener los datos del formulario
         $subject = $request->input('subject');
         $body = $request->input('body');
     
         // Enviar el correo electrónico
         Mail::to('miempresa@example.com')->send(new MyEmail($subject, $body, $fromEmail));
     
         // Redirigir al usuario a la página de contacto con un mensaje de éxito
         return Redirect::to('/contacto')->with('success', 'El correo electrónico se ha enviado correctamente.');
     }
}
