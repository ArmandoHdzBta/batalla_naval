@extends('layout.main')

@section('titulo')
    <title>Menu | Batalla Naval</title>
@endsection

@section('css')

@endsection
<style type="text/css">
    .barco{
        margin-top: 2%;
    }
</style>
@section('titulo-pagina')
    <h1 class="h3 mb-4 text-gray-800">Página de testeo de tablero</h1>
    <p class="mb-4">Bootstrap's default utility classes can be found on the official <a
            href="https://getbootstrap.com/docs">Bootstrap Documentation</a> page. The custom utilities  below were created to extend this theme past the default utility classes built into Bootstrap's framework.
    </p>

    <!-- Content Row -->
    <div class="row">

        <!-- Second Column -->
        <div class="col-lg-4 offset-1">

            <!-- Background Gradient Utilities -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tablero de: {{session('usuario')->correo}}
                    </h6>
                </div>
                <div class="card-body">
                    <button valorBarco="1" class="barco btn-barco px-2 py-3 bg-gradient-danger text-white">.bg-gradient-dark</button>
                    <button valorBarco="2" class="barco btn-barco px-2 py-3 bg-gradient-dark text-white">.bg-gradient-dark</button>
                    <button valorBarco="3" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="4" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="5" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="6" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="7" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="8" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="9" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="10" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="11" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarco="12" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                </div>
            </div>
        </div>
        <!-- Second Column -->
        <!-- Second Column -->
        <div class="col-lg-4 offset-2">

            <!-- Background Gradient Utilities -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Custom Background Gradient Utilities
                    </h6>
                </div>
                <div class="card-body">
                    <button valorBarcoEnemigo="1" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-danger text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="2" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-dark text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="3" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="4" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="5" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="6" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="7" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="8" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="9" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="10" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="11" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                    <button valorBarcoEnemigo="12" class="barco btn-barco-enemigo px-2 py-3 bg-gradient-primary text-white">.bg-gradient-dark</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('contenido')

@endsection

@section('js')
    <script>
        $(document).ready(function (){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                url: "{{route('usuario.peticion')}}",
                dataType: 'json',
                cache: false,
                success: function (data) {
                    console.log(data);
                }
            });

            $(".btn-barco").click(function (){
                var idBarco = $(this).attr('valorBarco');
               //alert($(this).attr('valorBarco'));
                if(idBarco == 12)
                    alert(":D");


            });
        });
    </script>
@endsection

