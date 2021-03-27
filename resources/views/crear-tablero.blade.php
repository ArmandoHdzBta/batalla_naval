@extends('layout.main')

@section('titulo')
    <title>Crear Tablero | Batalla Naval</title>
@endsection

@section('css')

@endsection

@section('titulo-pagina')
    <h1 class="h3 mb-4 text-gray-800">Formulario para crear tablero</h1>
@endsection

@section('contenido')
    <div class="col-md-6 offset-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tablero</h6>
            </div>
            <div class="card-body">
                <form class="user" id="form-registrar" method="post" action="{{route('usuario.registrar.tablero')}}">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user"
                                   id="codigo" placeholder="Código" name="codigo" readonly required>
                        </div>
                        <div class="col-sm-6">
                            <button class="form-control" id="generar">Generar Código</button>
                        </div>
                    </div>
                    <input type="button" id="btnEnviar" class="btn btn-primary btn-user btn-block" value="Crear Tablero">
                    <hr>
                    <input type="hidden" name="idUsuario" value="{{session('usuario')->id}}">
                </form>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
        $(document).ready(function (){
            /// -- Ajax
            $("#generar").click(function (e){
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "get",
                    url: "{{route('usuario.crear.tablero.codigo')}}",
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        var codigo = data.codigo;
                        $("#codigo").val(codigo);
                    }
                });
            });

            $("#btnEnviar").click(function (e){
                e.preventDefault();
                if($("#codigo").val() == "" || $("#codigo").val() == null){
                    alert("No has generado el código");
                    return false
                }
                $("#form-registrar").submit();
            });

        });
    </script>
@endsection

