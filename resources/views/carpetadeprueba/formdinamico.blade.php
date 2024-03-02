<html>
  <head>
    <title>Dynamic Fields</title>
  </head>
  <body>
    <h1>Formulario dinámico!</h1>
    <div class="container">
        <form action="{{ route('prueba') }}" enctype="multipart/form-data" method="POST" >
          <!-- El token csrf es importante para que el formulario funcione-->
            @csrf
            <div id="formfield">
                <input type="text" name="text" class="text" size="50" placeholder="Name" required>
                <input type="text" name="email" class="text" size="50" placeholder="Email" required>
                <input type="text" name="optional_field" class="text" size="50" placeholder="Optional Field">
            </div>

            <input name="submit" type="Submit"  class="btn btn-primary" value="Submit">
        </form>
        <div class="controls">
            <!-- Botones para agregar y quitar campos-->
            <button class="add" onclick="add()"><i class="fa fa-plus"></i>Add</button>
            <button class="remove" onclick="remove()"><i class="fa fa-minus"></i>Remove</button>
        </div>
    </div>

    <!-- Pude abstraer los scripts en un archivo js aparte!!!!! se encuentra en app/public/js/agregar_eliminar_campos.js -->
    <script src="{{ asset('js/agregar_eliminar_campos.js')}}"></script>
  </body>
</html>