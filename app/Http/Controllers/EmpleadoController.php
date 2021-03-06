<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empleado;
use App\Models\Empresa;
use App\Http\Requests\StoreEmpleadoRequest;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::with('empresa')->paginate(10);

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
    public function store(StoreEmpleadoRequest $request)
    {
        if( !Empresa::find($request->empresa) ){
            return response()->json([
                'message' => 'No existe la empresa.'
            ],422);
        }

        try {
            $empleado                = new Empleado;
            $empleado->primer_nombre = $request->primer_nombre;
            $empleado->apellido      = $request->apellido;
            $empleado->company_id    = $request->empresa;
            $empleado->correo        = $request->correo;
            $empleado->telefono      = $request->telefono;
            $empleado->save();

            DB::commit();
            
            return response()->json([
                'message' => 'Empleado creado con éxito'
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empleado = Empleado::with('empresa')->find($id);
        if(!$empleado){
            return response()->json([
                'message' => 'No existe el empleado solicitado.'
            ],400);
        }

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
    public function update(StoreEmpleadoRequest $request, $id)
    {
        if( !Empresa::find($request->empresa) ){
            return response()->json([
                'message' => 'No existe la empresa.'
            ],422);
        }

        $empleado = Empleado::find($id);
        if(!$empleado){
            return response()->json([
                'message' => 'No existe el empleado.'
            ],400);
        }

        try {
            $empleado->primer_nombre = $request->primer_nombre;
            $empleado->apellido      = $request->apellido;
            $empleado->company_id    = $request->empresa;
            $empleado->correo        = $request->correo;
            $empleado->telefono      = $request->telefono;
            $empleado->save();

            DB::commit();

            return response()->json([
                'message' => 'El empleado se ha actualizado'
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado = Empleado::find($id);
        if(!$empleado){
            return response()->json([
                'message' => 'No existe el empleado.'
            ],400);
        }

        $empleado->delete();

        return response()->json([
            'message' => 'El empleado se ha eliminado'
        ],200);
    }
}
