<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;






class ResidenteController extends Controller
{

    public function __construct()
    {
        $this->middleware('EsResidente');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


            /*$datos = Residente::where('user_rut', auth()->user()->rut)->paginate();

            return view('fichaResidente.index', compact('datos'));
            */

            $residenteDatos = Residente::where('user_rut', auth()->user()->rut)->first();



            if ($residenteDatos != null){

                $dato = $residenteDatos->user_rut;

                if(auth()->user()->rut == $dato){
                    $valor_rut = $residenteDatos->user_rut;

                    return view('fichaResidente.index',compact('valor_rut'));
                }else{
                    return view('errorAcceso');
                }
            }else{
                return view('errorAcceso');
            }

            return view('fichaResidente.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_rut)
    {
        //aqui pase en vez de id un user_rut para validar que este ingresando por
        //ruta el usuario y no pueda entrar a los datos de otro usuario, ademas
        // en el modelo se le cambio la llave primaria y el increment a false

        $residente = Residente::find($user_rut);

        if ($residente != null){
            if( $residente->user_rut == auth()->user()->rut ){
                return view('fichaResidente.show', compact('residente'));
            }else{
                return view('errorAcceso');
            }
        }else{
            return view('errorAcceso');
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
