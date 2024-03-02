@extends('layouts.app')
  
@section('title', 'Edit Product')
  
@section('contents')
    <h1 class="mb-0">Add Product</h1>
    <hr />
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="title" class="form-control" placeholder="Title">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" name="price" class="form-control" placeholder="Price">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="product_code" class="form-control" placeholder="Product Code">
                @error('product_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" name="description" class="form-control" placeholder="Description">
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <select name="select-products" id="select-products" class="form-select" style="width: 100%;">
                    <option value="">Select Product</option>
                </select>
                @error('select-products')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
 
        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    @endsection
    
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
            $(document).ready(function() {
                // Inicializar el plugin Select2
                $("#select-products").select2();

                // Realizar la solicitud AJAX para obtener los precios
                $.ajax({
                    url: '{{ route("productos") }}', // Ruta que llama al método 'getProducts' en el controlador AjaxController
                    type: 'GET',
                    success: function(prices) {
                        var select = $('#select-products');
                        // Vaciar el elemento select antes de agregar los precios
                        select.empty();
                        // Iterar sobre los precios y agregarlos como opciones al select
                        $.each(prices, function(index, price) {
                            select.append($('<option>').text(price).attr('value', price));
                        });
                    }
                });
            });

        </script>
    @show