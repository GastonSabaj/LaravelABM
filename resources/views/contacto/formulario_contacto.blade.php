@extends('layouts.app')
  
@section('title', 'Formulario de contacto')
  
@section('contents')
    @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
    @endif

    <form action="{{ route('enviarCorreo') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="subject" class="form-label">Asunto</label>
            <input type="text" name="subject" class="form-control" id="subject">
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Cuerpo</label>
            <textarea name="body" class="form-control" id="body" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
@endsection
