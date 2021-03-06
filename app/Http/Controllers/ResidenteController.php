<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Tramo;
use App\Models\Subsidio;
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

            return view('residente.index', compact('datos'));
            */

            $residenteDatos = Residente::where('user_rut', auth()->user()->rut)->first();


            //comprueba si la variable $residenteDatos viene con datos
            if ($residenteDatos != null){

                //le asigna el valor de user_rut a $dato
                $dato = $residenteDatos->user_rut;

                //comprueba si el user_rut es igual a el rut de el usuario que se logeo
                if(auth()->user()->rut == $dato){

                    //se guarda el rut en una variable que sera usada en la vista index de la carpeta residente
                    $valor_rut = $residenteDatos->user_rut;

                    return view('residente.index',compact('valor_rut'));
                }else{
                    return view('vistasError.errorAcceso');
                }
            }else{
                return view('vistasError.errorAcceso');
            }



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
        $subsidio = Subsidio::where('user_rut', $user_rut)
            ->orderBy('fecha_viaje','desc')
            ->first();

        if ($residente != null){
            if( $residente->user_rut == auth()->user()->rut ){


                return view('residente.show', ['residente' => $residente, 'subsidio' => $subsidio]);
            }else{
                return view('vistasError.errorAcceso');
            }
        }else{
            return view('vistasError.errorAcceso');
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

    // vista que lista las solicitudes de el residente
    public function solicitud($user_rut)
    {

        $residente = Residente::find($user_rut);


        if ($residente != null){
            if( $residente->user_rut == auth()->user()->rut ){

                $subsidio = Subsidio::where('user_rut', $residente->user_rut)
                    ->orderBy('created_at','desc')
                    ->paginate();
                //$categoria = Categoria::where('tipo_subsidio', $subsidio->tipo_subsidio)->paginate();

                return view('residente.solicitud', compact('subsidio'));
            }else{
                return view('vistasError/errorAcceso');
            }
        }else{
            return view('vistasError/errorAcceso');
        }


    }
    // vista que muestra formulario para solicitar subsidio
    public function subsidio($user_rut)
    {
        //aqui pase en vez de id un user_rut para validar que este ingresando por
        //ruta el usuario y no pueda entrar a los datos de otro usuario, ademas
        // en el modelo se le cambio la llave primaria y el increment a false

        $residente = Residente::find($user_rut);
        //se eliminaron estas tablas
        //$categoria = Categoria::all();
        //$tramo = Tramo::all();

        //dump($categoria);

        if ($residente != null){
            if( $residente->user_rut == auth()->user()->rut ){
                return view('residente.subsidio', ['residente' => $residente]);
            }else{
                return view('errorAcceso');
            }
        }else{
            return view('errorAcceso');
        }
    }

    // create de subsidio
    public function createSubsidio()
    {
        return view('residentes.subsidio');
    }

    // store de subsidio para almacenar solicitudes de subsidio
    public function storeSubsidio(Request $request, Subsidio $subsidio)
    {

        $rules = [
            'fechaViaje' => 'required'
        ];

        request()->validate($rules);


        $subsidio = new Subsidio();
        $subsidio->user_rut = $request->get('rut');
        $subsidio->email = $request->get('email');
        $subsidio->nombres = $request->get('nombres');
        $subsidio->apellidos = $request->get('apellidos');
        $subsidio->tipo_subsidio = $request->get('subsidio');
        $subsidio->tramo = $request->get('tramo');
        $subsidio->fecha_viaje = $request->get('fechaViaje');
        $subsidio->save();


        //$categoria = $request->get('subsidio');
        //dump($categoria);

//        if ($request->get('subsidio') == "aereo"){
//            $this->middleware('throttle:2,1');
//        }else{
//
//        }

            //FALTA AGREGAR EL session()->flash('error', 'No ha seleccionado fecha');

        return back()->with('success', 'Solicitud de subsidio enviada con exito!');

    }


}
