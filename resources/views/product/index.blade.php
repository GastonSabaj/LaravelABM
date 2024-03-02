@extends('layouts.app')

  
@section('title', 'Home Product')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">List Product</h1>
        <a href="{{ route('prueba') }}" type="button" class="btn btn-primary">Prueba</a>
        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
    </div>


    <button id="toggleFormBtn" type="button" class="btn btn-primary">Toggle Form</button>

    <!-- Aquí agregarás el formulario oculto -->
    <div id="productForm" style="display: none;">
        <!-- Formulario para filtrar registros -->
        <form id="filterForm">
            @csrf
            <h3>Filtrar registros</h3>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <button type="button" class="btn btn-secondary" id="resetFilterBtn">Reiniciar Filtro</button>

        </form>
    </div>


    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table id="productsTable" class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th id="columna_titulo">Title</th>
                <th>Price</th>
                <th>Product Code</th>
                <th>Description</th>
                <th>Product type </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($products->count() > 0)
                @foreach($products as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle product-title">{{ $rs->title }}</td>
                        <td class="align-middle">{{ $rs->price }}</td>
                        <td class="align-middle">{{ $rs->product_code }}</td>
                        <td class="align-middle">{{ $rs->description }}</td>  
                        <td class="align-middle">{{ $rs->product_type }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('products.show', $rs->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                <a href="{{ route('products.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('products.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Product not found</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="pagination justify-content-center">
        <ul class="pagination">
            {{-- Botón "Previous" --}}
            <li class="page-item {{ $products->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $products->previousPageUrl() }}">Previous</a>
            </li>

            {{-- Enlaces de páginas --}}
            @php
                // Calculamos el rango de enlaces de página a mostrar
                $start = max(1, $products->currentPage() - 1);
                $end = min($products->lastPage(), $products->currentPage() + 1);
            @endphp

            {{-- Enlace a la primera página --}}
            @if ($products->currentPage() > 2)
                <li class="page-item">
                    <a class="page-link" href="{{ $products->url(1) }}">1</a>
                </li>
                @if ($products->currentPage() > 3)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            {{-- Enlaces de páginas --}}
            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Enlace a la última página --}}
            @if ($products->currentPage() < $products->lastPage() - 1)
                @if ($products->currentPage() < $products->lastPage() - 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                </li>
            @endif

            {{-- Botón "Next" --}}
            <li class="page-item {{ $products->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $products->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </div>

@endsection

<!-- ACORDARSE QUE SI QUIERO SOBREESCRIBIR LOS SCRIPTS, DEBE TENER EL -->
@section('custom-scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('admin_assets/vendor/chart.js/Chart.min.js') }}"></script>
    <script>
            $(document).ready(function () {
                // Manejar el clic en el botón para mostrar/ocultar el formulario
                $('#toggleFormBtn').click(function () {
                    $('#productForm').fadeToggle();
                });

                $('#filterForm').submit(function (e) {
                    e.preventDefault();

                    // Obtener el valor del campo de título
                    var title = $('#title').val().trim().toLowerCase();

                    // Filtrar las filas de la tabla
                    $('tbody tr').each(function () {
                        // Obtener el valor de la columna de Title en esta fila
                        var titleValue = $(this).find('.product-title').text().trim().toLowerCase();
                        
                        // Ocultar o mostrar la fila según el título coincida o no
                        if (titleValue === title) {
                            console.log("lo muestro");
                            $(this).show();
                        } else {
                            console.log("NO lo muestro");
                            $(this).hide();
                        }
                    });
                });

                // $('#filterForm').submit(function (e) {
                //     e.preventDefault(); // Prevenir el envío del formulario por defecto

                //     // Obtener el valor del campo de título
                //     var title = $('#title').val().trim().toLowerCase();

                //     // Realizar la solicitud AJAX para filtrar productos
                //     $.ajax({
                //         url: '{{ route("filtrar_productos_por_titulo") }}',
                //         type: 'POST',
                //         data: {title: title},
                //         success: function (response) {
                //             // Actualizar la tabla con los productos filtrados y la paginación
                //             $('#productsTable tbody').html(response);
                //         },
                //         error: function (xhr, status, error) {
                //             console.error(xhr.responseText);
                //         }
                //     });
                // });
            });

             // Manejar el clic en el botón de reinicio del filtro
             $('#resetFilterBtn').click(function () {
                // Limpiar el valor del campo de título
                $('#title').val('');

                // Mostrar todas las filas de la tabla
                $('tbody tr').fadeIn();
            });
    </script>
@endsection
