<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empleado;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::with('empresa')->get();
        return response()->json([
            'empleados'=>$empleados
        ],200);
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
        /* VALIDAR QUE EXISTA LA EMPRESA */
        $empleado                = new Empleado;
        $empleado->primer_nombre = $request->primer_nombre;
        $empleado->apellido      = $request->apellido;
        $empleado->company_id    = $request->empresa;
        $empleado->correo        = $request->correo;
        $empleado->telefono      = $request->telefono;
        $empleado->save();

        return response()->json([
            'message' => 'Empleado creado con éxito'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* VALIDAR QUE EXISTA EL EMPLEADO */
        $empleado = Empleado::with('empresa')->find($id);
        return response()->json([
            'empleado'=>$empleado
        ],200);
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
        /* VALIDAR QUE EXISTA EMPLEADO Y EMPRESA */
        $empleado = Empleado::find($id);
        $empleado->primer_nombre = $request->primer_nombre;
        $empleado->apellido      = $request->apellido;
        $empleado->company_id    = $request->empresa;
        $empleado->correo        = $request->correo;
        $empleado->telefono      = $request->telefono;
        $empleado->save();

        return response()->json([
            'message' => 'El empleado se ha actualizado'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /* VALIDAR QUE EXISTA EL EMPLEADO */
        $empleado = Empleado::find($id);

        $empleado->delete();

        return response()->json([
            'message' => 'El empleado se ha eliminado'
        ],200);
    }
}
