@extends('layout.main')

@section('titulo')
    <title>Tablero: {{$tablero->codigo}} | Batalla Naval</title>
@endsection

@section('css')

@endsection
<style type="text/css">
    .barco{
        margin-top: 2%;
    }
</style>
@section('titulo-pagina')
    <h1 class="h3 mb-4 text-gray-800">Tablero #{{$tablero->codigo}}</h1>
    Creado: {{$tablero->created_at}}
    <p class="mb-4">Instrucciones de juego
    </p>

    <!-- Content Row -->
    <div class="row">
        <input type="hidden" id="usuario-id" value="{{session('usuario')->id}}">
        <!-- Second Column -->
        <div class="col-lg-4 offset-1">

            <!-- Background Gradient Utilities -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tablero de: {{session('usuario')->correo}}</h6>
                    @if(!isset($tableroBarco))
                        <label style="margin-top: 5%;" class="text-info">Cantidad de Barcos: <b id="cantidadBarcos">3</b></label>
                        <input type="hidden" id="barcos-listos" value="0">
                    @else
                        <input type="hidden" id="barcos-listos" value="1">
                    @endif
                </div>
                <div class="card-body text-center">
                    @for($x = 1; $x <= 12; $x++)
                        @if(isset($tableroBarco))
                            @if($tableroBarco->barco1 == $x || $tableroBarco->barco2 == $x || $tableroBarco->barco3 == $x)
                                <button valorBarco="{{$x}}" class="barco btn-barco px-2 py-3 bg-gradient-success text-white">Barco {{$x}}</button>
                            @else
                                <button valorBarco="{{$x}}" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">Barco {{$x}}</button>
                            @endif
                        @else
                            <button valorBarco="{{$x}}" class="barco btn-barco px-2 py-3 bg-gradient-primary text-white">Barco {{$x}}</button>
                        @endif
                    @endfor
                    <hr>
                        @if(!isset($tableroBarco))
                            <button class="bg-gradient-info form-control text-white" id="jugador-1-listo">¡Estoy listo!</button>
                        @elseif(!isset($tableroBarco2))
                            <button class="bg-gradient-info form-control text-white" id="buscar-enemigo">¡BUSCAR ENEMIGO!</button>
                        @endif
                </div>
            </div>
        </div>
        <!-- Second Column -->
        <!-- Second Column -->
        <div class="col-lg-4 offset-2">
            @if ($tirosTotales == 3)
                <div class="alert alert-success">¡Felicidades has ganado!</div>
            @endif
            <!-- Background Gradient Utilities -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @if(isset($tableroBarco2))
                        <h6 class="m-0 font-weight-bold text-primary">Tablero de jugador: <b>{{$tableroBarco2->nombreUsuario}}</b></h6>
                    @else
                        <h6 class="m-0 font-weight-bold text-primary"><b>Sin Rival</b></h6>
                    @endif
                </div>

                <div class="card-body text-center">

                    @for($x = 1; $x <= 12; $x++)
                        @if(isset($tableroBarco2))
                            @php
                                $color = "bg-gradient-primary"
                            @endphp
                            @if ($tableroBarco2->barco1 == $x || $tableroBarco2->barco2 == $x || $tableroBarco2->barco3 == $x)
                            @else
                                @php $color = "bg-gradient-primary" @endphp
                            @endif

                            @if (in_array($x, $movimientos['tirosFallados']))
                                @php $color = "bg-gradient-warning" @endphp
                            @endif

                            @if (in_array($x, $movimientos['tirosHundidos']))
                                @php $color = "bg-gradient-danger" @endphp
                            @endif

                            <button valorBarco="{{$x}}" class="barco btn-barco px-2 py-3 {{ $color }}  text-white">Barco {{$x}}</button>
                        @endif
                    @endfor
                    <hr>
                    <button class="bg-gradient-info form-control text-white" id="atacar">¡Atacar!</button>
                </div>

            </div>
            <!-- Link to open the modal -->
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="buscar-rival" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p class="text-center">Buscando Rival.</p>
                    {{-- <img src="/img/cargando.gif"> --}}
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
            var idUsuario = $("#usuario-id").val();

            // -- Verificar si el jugador ya tiene barcos
            $("#buscar-enemigo").click(function (){
                empezar();
            });

            var barcosDisponibles = 3;
            var conjuntoBarcos = [];

            $(".btn-barco").click(function (){
                if($("#barcos-listos").val() == 1){
                    return false;
                }
                if(barcosDisponibles > 0){
                    if($(this).hasClass("bg-gradient-success")){
                        return false;
                    }
                    if($.inArray($(this).attr('valorBarco'),conjuntoBarcos)){
                        var idBarco = $(this).attr('valorBarco');
                        conjuntoBarcos.push(idBarco);
                        barcosDisponibles--;
                        $("#cantidadBarcos").html(barcosDisponibles);
                        $(this).addClass('bg-gradient-success');
                    }
                }else{
                    alert("Ya no cuentas con barcos disponibles");
                }
            });

            $("#jugador-1-listo").click(function (){
                if(barcosDisponibles == 0){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "get",
                        url: "{{route('tablero.agregar.barcos')}}/{{$tablero->codigo}}/"+conjuntoBarcos,
                        dataType: 'json',
                        cache: false,
                        success: function (data) {
                            location.reload();
                        }
                    });
                }else{
                    alert("Aún tienes barcos disponibles");
                }
            });

            function empezar(){
                $("#buscar-rival").modal('show');
                buscarJugador();
            }

            function buscarJugador(){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "get",
                    url: "{{route('tablero.consultar.barcos')}}/{{$tablero->codigo}}",
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        var posicionesBarcos = data.posicionesBarcos;
                        $.each( posicionesBarcos, function( key, value ) {
                            if(value.usuario_id != idUsuario){
                                location.reload();
                            }else{
                                $("#buscar-rival").modal('hide');
                                //alert("Intenta buscar nuevamente");
                            }
                        });
                    }
                });
            }
            var numPosiciones = 1
            var posicion = 0;

            $(".btn-barco").click(function (){
                if (numPosiciones > 0){
                    posicion = $(this).attr('valorBarco');
                    numPosiciones--;
                    $(this).addClass('bg-gradient-warning');
                }else{
                    alert("Solo 1 tiro a la vez");
                }
            });

            $("#atacar").click(function(event) {
                if (posicion == 0){
                    alert("Debes de seleccionar 1 barco");
                    return false;
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    url: "{{route('tablero.batalla.barcos')}}/{{$tablero->codigo}}/"+posicion,
                    dataType: 'json',
                    success: function (data){
                        console.log(data);
                        if(data.success == "error"){
                            alert(data.mensaje);
                            location.reload();
                        }else{
                            alert(data.mensaje);
                            location.reload();
                        }
                    }
                });
            });

        });
    </script>
@endsection

