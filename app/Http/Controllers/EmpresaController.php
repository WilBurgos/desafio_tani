<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Storage;
use App\Http\Requests\StoreEmpresaRequest;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::with('empleados')->get();
        return response()->json([
            'empresas'=>$empresas
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
    public function store(StoreEmpresaRequest $request)
    {
        // $validator = \Validator::make($request->all(), [
        //     'nombre' => 'required|string',
        //     'correo' => 'required|email',
        //     'sitio_web' => 'required|string',
        //     'logotipo' => 'required|image|dimensions:max_width=100,max_height=100'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'Los datos proporcionados no son válidos.',
        //         'errors' => $validator->errors()
        //     ], 404);
        // }

        $fileName = time().'-'.$request->logotipo->getClientOriginalName();
        $nameEmpresa = str_replace(" ","", $request->nombre);
        $explode = explode( '/', $nameEmpresa );
        $explode2 = explode( '\\', $nameEmpresa );

        if( count($explode) > 1 ){
            $imgComplete = str_replace("/","-", $nameEmpresa);
        }else if( count($explode2) > 1 ){
            $imgComplete = str_replace("\\","-", $nameEmpresa);
        }

        if( isset($imgComplete) ){
            Storage::disk('public')->put( $imgComplete.'/'.$fileName, file_get_contents($request->logotipo->getRealPath()) );
        }else{
            Storage::disk('public')->put( $nameEmpresa.'/'.$fileName, file_get_contents($request->logotipo->getRealPath()) );
        }

        $empresa                        = new Empresa;
        $empresa->nombre                = $request->nombre;
        $empresa->correo_electronico    = $request->correo;
        $empresa->logotipo              = $fileName;
        $empresa->sitio_web             = $request->sitio_web;
        $empresa->save();

        return response()->json([
            'message' => 'Empresa creada con éxito'
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
        $empresa = Empresa::with('empleados')->find($id);
        return response()->json([
            'empresa'=>$empresa
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
        // $old = Empresa::find($id);
        // if($old){
        //     $exName = str_replace(" ","", $old->nombre);
        //     $explode = explode( '/', $exName );
        //     $explode2 = explode( '\\', $exName );
        //     if( count($explode) > 1 ){
        //         $nameComplete = str_replace("/","-", $exName);
        //     }else if( count($explode2) > 1 ){
        //         $nameComplete = str_replace("\\","-", $exName);
        //     }
        //     if( isset($nameComplete) ){
        //         $folder = $nameComplete;
        //     }else{
        //         $folder = $exName;
        //     }
        //     Storage::disk('public')->deleteDirectory($folder);
        // }
        dd($request->all());
        $fileName = time().'-'.$request->logotipo->getClientOriginalName();
        $nameEmpresa = str_replace(" ","", $request->nombre);
        $explode = explode( '/', $nameEmpresa );
        $explode2 = explode( '\\', $nameEmpresa );

        if( count($explode) > 1 ){
            $imgComplete = str_replace("/","-", $nameEmpresa);
        }else if( count($explode2) > 1 ){
            $imgComplete = str_replace("\\","-", $nameEmpresa);
        }

        if( isset($imgComplete) ){
            Storage::disk('public')->put( $imgComplete.'/'.$fileName, file_get_contents($request->logotipo->getRealPath()) );
        }else{
            Storage::disk('public')->put( $nameEmpresa.'/'.$fileName, file_get_contents($request->logotipo->getRealPath()) );
        }
        /* GUARDADO DE IMAGEN */
        $empresa = Empresa::find($id);
        $empresa->nombre                = $request->nombre;
        $empresa->correo_electronico    = $request->correo;
        $empresa->logotipo              = $fileName;
        $empresa->sitio_web             = $request->sitio_web;
        $empresa->save();

        return response()->json([
            'message' => 'La empresa se ha actualizado'
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
        $empresa = Empresa::find($id);

        $empresa->delete();

        return response()->json([
            'message' => 'La empresa se ha eliminado'
        ],200);
    }
}
