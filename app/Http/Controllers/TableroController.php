<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use App\Models\Tablero_Movimiento;
use App\Models\Tablero;
use App\Models\Tablero_Barcos;
use App\Models\Usuario;
use Illuminate\Http\Request;

class TableroController extends Controller
{
    // Crear Tablero
    public function crearTablero (Request $request){
        $tablero = new Tablero();
        $tablero->codigo = $request->codigo;
        $tablero->usuario1_id = $request->idUsuario;
        $tablero->usuario2_id = $request->idUsuario;
        $tablero->estatus = "nuevo";
        $tablero->ganador_id = $request->idUsuario;
        $verificar = $tablero->save();
        if($verificar){
            return redirect()->route('usuario.detalle.tablero',['codigo' => $tablero->codigo]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    // Editar Tablero
    public function editar ($id){
        $tablero = Tablero::find($id);
        $tablero->codigo = "";
        $tablero->usuario1_id = "";
        $tablero->usuario2_id = "";
        $tablero->estatus = "";
        $tablero->ganador_id = "";
        $verificar = $tablero->save();
        if($verificar){
            echo json_encode(["estatus" => "success"]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    // Eliminar Tablero
    public function eliminarTablero ($id){
        $tablero = Tablero::find($id);
        $verificar = $tablero->delete();
        if($verificar){
            echo json_encode(["estatus" => "success"]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    // Mostrar Tablero
    public function mostrarTablero ($id){
        $tablero = Tablero::find($id);
        if($tablero)
            echo json_encode(["estatus" => "success","tablero" => $tablero]);
        else
            echo json_encode(["estatus" => "error"]);

    }

    // Mostrar Todo Tablero
    public function mostrarTodoTablero ($id){
        $tableros = Tablero::get();
        if($tableros)
            echo json_encode(["estatus" => "success","tablero" => $tableros]);
        else
            echo json_encode(["estatus" => "error"]);

    }

    public function crearCodigotablero(){
        // -- :D
        $verificar = 1;
        do{
            $codigo = Herramienta::crearCodigo(5);
            $tablero = Tablero::where('codigo',$codigo)->first();
            if (!$tablero)
                $verificar = 0;

        }while( $verificar == 1);

        echo json_encode(["estatus" => "success", "codigo" => $codigo]);
    }

    public function detalleTablero($codigo){
        $tablero = Tablero::where('codigo',$codigo)->first();
        if(!$tablero){
            return redirect()->route('usuario.menu');
        }
        $tableroBarco = Tablero_Barcos::where('tablero_id',$tablero->id)->where("usuario_id",session('usuario')->id)->first();
        $tableroBarco2 = Tablero_Barcos::where('tablero_id',$tablero->id)->where("usuario_id","!=",session('usuario')->id)->first();

        $movimientosJugador1 = Tablero_Movimiento::where('tablero_id',$tablero->id)->where('usuario_id',session('usuario')->id)->get();

        $movimientosJugador2 = Tablero_Movimiento::where('tablero_id',$tablero->id)->where('usuario_id','<>',session('usuario')->id)->get();

        $tirosFallados = [];
        $tirosHundidos = [];

        foreach ( $movimientosJugador1 as $movimiento) {

            if($movimiento->estatus == 1)
                array_push($tirosHundidos,$movimiento->posicion);
            else
                array_push($tirosFallados,$movimiento->posicion);
        }

        $informacionMovimientos1 = array(
            'tirosFallados' => $tirosFallados,
            'tirosHundidos' => $tirosHundidos,
        );

        //ganador
        $tirosHundidosTotales = Tablero_Movimiento::where('tablero_id',$tablero->id)->where('estatus',1)->where('usuario_id', session('usuario')->id)->get()->count();
        $tirosTotales = $tirosHundidosTotales;
        if ($tirosTotales == 3) {
            $tableroActualizar = Tablero::find($tablero->id);
            $tableroActualizar->estatus = "concluido";
            $tableroActualizar->save();
        }
        if($tableroBarco2){
            $usuario = Usuario::find($tableroBarco2->usuario_id);
            $tableroBarco2->nombreUsuario = $usuario->correo;
        }

        return view("tablero",["tablero" => $tablero,"tableroBarco" => $tableroBarco, "tableroBarco2" => $tableroBarco2, "movimientos" => $informacionMovimientos1, 'tirosTotales'=>$tirosTotales]);
    }

    public function agregarBarcos($codigo,$conjuntoBarcos){

        $tablero = Tablero::where("codigo",$codigo)->first();
        $ubicaciones = explode(",",$conjuntoBarcos);

        $tableroBarco = Tablero_Barcos::where('tablero_id',$tablero->id)->where("usuario_id",session('usuario')->id)->first();
        if(!$tableroBarco){
            $tableroBarco = new Tablero_Barcos();
            $tableroBarco->tablero_id = $tablero->id;
            $tableroBarco->usuario_id = session('usuario')->id;
            $tableroBarco->barco1 = $ubicaciones[0];
            $tableroBarco->barco2 = $ubicaciones[1];
            $tableroBarco->barco3 = $ubicaciones[2];
            $tableroBarco->save();

            $varificarEstatus = Tablero_Barcos::where('tablero_id',$tablero->id)->count();
            if($varificarEstatus < 2)
                $tablero->estatus = "activo";
            else
                $tablero->estatus = "jugando";

            $tablero->save();
            echo json_encode(["estatus" => "succes","mensaje" => "Barcos guardados correctamente"]);
        }
    }

    public function buscarBarcosTablero ($codigo){
        $tablero = Tablero::where("codigo",$codigo)->first();
        if(!$tablero)
            return json_encode(["estatus" => "error","mensaje" => "No fue posible encontrar el tablero"]);

        $posicionesBarcos = Tablero_Barcos::where('tablero_id',$tablero->id)->get();

        return json_encode(["tablero" => $tablero, "posicionesBarcos" => $posicionesBarcos]);
    }

    public function verificarPuesto($codigo,$posicion)
    {
        $tablero = Tablero::where("codigo",$codigo)->first();

        $tiro = Tablero_Movimiento::where("tablero_id",$tablero->id)->orderBy("created_at",'desc')->first();

        if ($tiro == false) {
            $tableroBarco = Tablero_Barcos::where("tablero_id",$tablero->id)->where('usuario_id', '<>', session('usuario')->id)->first();

            $tableroMovimientoVerificar = Tablero_Movimiento::where("tablero_id",$tablero->id)->where('usuario_id', session('usuario')->id)->where('posicion',$posicion)->first();

            if ($tableroMovimientoVerificar){
                return json_encode(['estatus'=>"error",'mensaje'=>"Posicion ya ocupada"]);
            }

            $tableroMovimiento = new Tablero_Movimiento();

            if ($tableroBarco->barco1 == $posicion || $tableroBarco->barco2 == $posicion || $tableroBarco->barco3 == $posicion) {
                $tableroMovimiento->tablero_id = $tablero->id;
                $tableroMovimiento->usuario_id = session('usuario')->id;
                $tableroMovimiento->posicion = $posicion;
                $tableroMovimiento->estatus = 1;
                $tableroMovimiento->save();
                return json_encode(['estatus'=>"success",'mensaje'=>"El barco undido"]);
            }else{
                $tableroMovimiento->tablero_id = $tablero->id;
                $tableroMovimiento->usuario_id = session('usuario')->id;
                $tableroMovimiento->posicion = $posicion;
                $tableroMovimiento->estatus = 0;
                $tableroMovimiento->save();
                return json_encode(['estatus'=>"error", "mensaje"=>"En esa posicion no se encuentra el barco"]);
            }
        }

        if (session('usuario')->id == $tiro->usuario_id){

            return json_encode(['estatus'=>"error",'mensaje'=>"No es tu turno"]);

        }else{

            $tableroBarco = Tablero_Barcos::where("tablero_id",$tablero->id)->where('usuario_id', '<>', session('usuario')->id)->first();

            $tableroMovimientoVerificar = Tablero_Movimiento::where("tablero_id",$tablero->id)->where('usuario_id', session('usuario')->id)->where('posicion',$posicion)->first();

            if ($tableroMovimientoVerificar){
                return json_encode(['estatus'=>"error",'mensaje'=>"Posicion ya ocupada"]);
            }

            $tableroMovimiento = new Tablero_Movimiento();

            if ($tableroBarco->barco1 == $posicion || $tableroBarco->barco2 == $posicion || $tableroBarco->barco3 == $posicion) {
                $tableroMovimiento->tablero_id = $tablero->id;
                $tableroMovimiento->usuario_id = session('usuario')->id;
                $tableroMovimiento->posicion = $posicion;
                $tableroMovimiento->estatus = 1;
                $tableroMovimiento->save();
                return json_encode(['estatus'=>"success",'mensaje'=>"El barco undido"]);
            }else{
                $tableroMovimiento->tablero_id = $tablero->id;
                $tableroMovimiento->usuario_id = session('usuario')->id;
                $tableroMovimiento->posicion = $posicion;
                $tableroMovimiento->estatus = 0;
                $tableroMovimiento->save();
                return json_encode(['estatus'=>"error", "mensaje"=>"En esa posicion no se encuentra el barco"]);
            }

        }
    }
}
