<?php

namespace App\Http\Controllers;

use App\Models\Residente;
use App\Models\Subsidio;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CodigoController extends Controller
{

    public function qrcodeIndex(){

        //generador de codigo qr a traves de el rut de residente
        //al escanear codigo deberia arrojar la siguiente ruta /qrcode/rut

        $residenteDatos = Residente::where('user_rut', auth()->user()->rut)->first();



        if ($residenteDatos != null){

            $datoresidente = $residenteDatos;
            $valor_rut = $datoresidente->user_rut;

            $valor_id = $residenteDatos->user_rut;



            $datoqr = QrCode::size(250)->generate( route('qrcode.show', $valor_id));


            $subsidio = Subsidio::where('user_rut', $valor_id)
                ->orderBy('fecha_viaje','desc')
                ->first();



            return view('codigoqr.index', ['datoqr' => $datoqr, 'datoresidente' => $datoresidente, 'valor_rut' => $valor_rut , 'subsidio' => $subsidio]);
        }else{
            return view('vistasError.errorAcceso');
        }


    }


    public function qrcodeShow($id){

        $datoid = Residente::find($id);

        $subsidio = Subsidio::where('user_rut', $id)
            ->orderBy('fecha_viaje','desc')
            ->first();

        if(auth()->user()->role_id == 3){
            return view('codigoqr.show', compact('datoid', 'subsidio'));
        }else{
            return view('vistasError.errorAcceso');
        }

    }

    public function index()
    {

        /*$datos = Residente::where('user_rut', auth()->user()->rut)->paginate();

        return view('fichaResidente.index', compact('datos'));
        */

        /*$residenteDatos = Residente::where('user_rut', auth()->user()->rut)->first();


        if ($residenteDatos != null){

            $dato = $residenteDatos->user_rut;

            if(auth()->user()->rut == $dato){
                $valor_id = $residenteDatos->id;

                return view('fichaResidente.index',compact('valor_id'));
            }else{
                echo 'no tiene acceso a los datos de este residente';
            }
        }

        return view('fichaResidente.index');
        */
    }

}
