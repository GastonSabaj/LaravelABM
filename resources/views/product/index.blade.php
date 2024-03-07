@extends('layouts.app')

  
@section('title', 'Home Product')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">List Product</h1>
        <!-- <a href="{{ route('prueba') }}" type="button" class="btn btn-primary">Prueba</a> -->
        <!-- <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> -->
        <span class="sr-only">Loading...</span>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add a Product</a>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            MODAL PARA CREAR PRODUCTO
        </button>

    @include('carpetadeprueba.add_product_modal')
    </div>


    <button id="toggleFormBtn" type="button" class="btn btn-primary">Filtrar</button>

    <!-- Aquí agregarás el formulario oculto -->
    <div id="productForm" style="display: none;">
        <!-- Formulario para filtrar registros -->
        <form id="filterForm">
            @csrf
            <h3>Filtrar registros</h3>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="titleInput" name="title">
                <label for="productType">Product type:</label>
                <input type="text" class="form-control" id="productTypeInput" name="productType">
            </div>

            <!-- <div class="row mb-3">
                <div class="col">
                    <select name="select-products" id="select-products" class="form-select" style="width: 100%;">
                        <option value="">Select Product</option>
                    </select>
                </div>
            </div> -->

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
                        <td class="align-middle product-price">{{ $rs->price }}</td>
                        <td class="align-middle">{{ $rs->product_code }}</td>
                        <td class="align-middle">{{ $rs->description }}</td>  
                        <td class="align-middle product-type">{{ $rs->product_type }}</td>
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

    <div style="display: flex;">
        <canvas id="myChart" style="width:50%;max-width:350px"></canvas>
        <canvas id="myChart1" style="width:50%;max-width:350px"></canvas>
        <canvas id="myChart2" style="width:50%;max-width:350px"></canvas>

    </div>


@endsection

<!-- ACORDARSE QUE SI QUIERO SOBREESCRIBIR LOS SCRIPTS, DEBE TENER EL NOMBER DE "custom-scripts" -->
@section('custom-scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('admin_assets/vendor/chart.js/Chart.min.js') }}"></script>
    <script>
            $(document).ready(function () {

            $(".form-select").select2();


            // Realizar la solicitud AJAX para obtener los precios
            $.ajax({
                url: '{{ route("productos") }}', // Ruta que llama al método 'getProducts' en el controlador AjaxController
                type: 'GET',
                success: function(prices) {
                    console.log("hola");
                    // var select = $('#select-products');
                    var select = $('.form-select');
                    // Vaciar el elemento select antes de agregar los precios
                    select.empty();
                    // Iterar sobre los precios y agregarlos como opciones al select
                    $.each(prices, function(index, price) {
                        console.log(index,price);
                        select.append($('<option>').text(price).attr('value', price));
                        console.log(select); 
                    });
                }
            });


                // Manejar el clic en el botón para mostrar/ocultar el formulario
                $('#toggleFormBtn').click(function () {
                    $('#productForm').fadeToggle();
                });

                $('#filterForm').submit(function (e) {
                    e.preventDefault();

                    // Obtener el valor del campo de título y tipo de producto
                    var titleInput = $('#titleInput').val().trim().toLowerCase();
                    var productTypeInput = $('#productTypeInput').val().trim().toLowerCase();

                    // Filtrar las filas de la tabla
                    $('tbody tr').each(function () {
                        var showRow = true; // Inicialmente asumimos que mostraremos la fila

                        // Obtener el valor de la columna de título en esta fila
                        var titleValue = $(this).find('.product-title').text().trim().toLowerCase();
                        var productTypeValue = $(this).find('.product-type').text().trim().toLowerCase();

                        // Verificar si el título coincide si se proporcionó un valor para el campo de título
                        if (titleInput !== '' && titleValue !== titleInput) {
                            showRow = false;
                        }

                        // Verificar si el tipo de producto coincide si se proporcionó un valor para el campo de tipo de producto
                        if (productTypeInput !== '' && productTypeValue !== productTypeInput) {
                            showRow = false;
                        }

                        // Mostrar u ocultar la fila según el resultado
                        if (showRow) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });

                // $('#filterForm').submit(function (e) {
                //     e.preventDefault(); // Prevenir el envío del formulario por defecto

                //     // Obtener el valor del campo de título
                //     var title = $('#titleInput').val().trim().toLowerCase();

                //     // Realizar la solicitud AJAX para filtrar productos
                //     $.ajax({
                //         url: '{{ route("filtrar_productos") }}',
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
                $('#titleInput').val('');

                // Limpiar el valor del campo de tipo de producto
                $('#productTypeInput').val('');

                // Mostrar todas las filas de la tabla
                $('tbody tr').fadeIn();
            });

        // Array para almacenar los tipos de productos y sus conteos
        var productTypes = {};
        // Obtener todas las celdas de la columna "Product Type"
        var productTypeCells = document.querySelectorAll('.product-type');

        // Iterar sobre cada celda para contar la cantidad de veces que aparece cada tipo de producto
        productTypeCells.forEach(function(cell) {
            var productType = cell.textContent.trim();
            if (productTypes[productType]) {
                productTypes[productType] += 1;
            } else {
                productTypes[productType] = 1;
            }
        });

        // Convertir el objeto de conteo en dos arrays separados para usarlos en el gráfico
        var xValues = Object.keys(productTypes);
        var yValues = Object.values(productTypes);

        // Colores de barras para el gráfico
        var barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
            "#e8c3b9",
            "#1e7145"
        ];

        // Crear el gráfico de donut
        new Chart("myChart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Cantidad de Productos por Tipo"
                }
            }
        });

        // Array para almacenar los precios de los productos
        var prices = [];
        // Obtener todas las celdas de la columna "Price"
        var priceCells = document.querySelectorAll('.product-price');

        // Iterar sobre cada celda para obtener el precio y guardarlo en el array
        priceCells.forEach(function(cell) {
            var price = parseFloat(cell.textContent.trim()); // Convertir el texto del precio a número
            prices.push(price);
        });

        // Crear un array de objetos para los valores x, y del scatterplot
        var xyValues = prices.map(function(price, index) {
            return { x: index, y: price }; // Usar el índice como valor x y el precio como valor y
        });

        // Crear el scatterplot
        new Chart("myChart1", {
            type: "scatter",
            data: {
                datasets: [{
                    pointRadius: 4,
                    pointBackgroundColor: "rgb(0,0,255)",
                    data: xyValues
                }]
            },
            options: {
                legend: { display: false },
                scales: {
                    xAxes: [{ scaleLabel: { display: true, labelString: 'Producto_id' } }], // Etiqueta del eje x
                    yAxes: [{ scaleLabel: { display: true, labelString: 'Precio' } }]   // Etiqueta del eje y
                }
            }
        });

        // Contar la cantidad de precios mayores o iguales a 100 y los que no
        var pricesOver100 = prices.filter(function(price) {
            return price >= 100;
        }).length;

        var pricesUnder100 = prices.length - pricesOver100;

        // Crear el gráfico de barras
        new Chart("myChart2", {
            type: "bar",
            data: {
                labels: ['Precios >= 100', 'Precios < 100'],
                datasets: [{
                    label: 'Cantidad de Productos',
                    backgroundColor: ['#ff6384', '#36a2eb'], // Colores para las barras
                    data: [pricesOver100, pricesUnder100]
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>
@endsection
