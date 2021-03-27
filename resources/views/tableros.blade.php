@extends('layout.main')

@section('titulo')
    <title>Mis tableros | Batalla Naval</title>
@endsection

@section('css')
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('titulo-pagina')
    <h1 class="h3 mb-4 text-gray-800">Tableros Nuevos</h1>
@endsection

@section('contenido')
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tableros Nuevos</h6>
            </div>
            <div class="card-body">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">A continuación se muestra todos los tableros disponibles para jugar.</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Codigo</th>
                                    <th>Estatus</th>
                                    <th>Jugador 1</th>
                                    <th>Creado</th>
                                    <th>JUGAR</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Codigo</th>
                                    <th>Estatus</th>
                                    <th>Jugador 1</th>
                                    <th>Creado</th>
                                    <th>JUGAR</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($tableros as $tablero)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$tablero->codigo}}</td>
                                        <td>{{$tablero->estatus}}</td>
                                        <td>{{$tablero->correoUsuario1}}</td>
                                        <td>{{$tablero->created_at}}</td>
                                        <td>
                                            <a href="{{route('usuario.detalle.tablero',["codigo" => $tablero->codigo])}}" class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-gamepad"></i>
                                                </span>
                                                <span class="text">JUGAR</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function (){
            $('#dataTable').DataTable();
        });
    </script>
@endsection

