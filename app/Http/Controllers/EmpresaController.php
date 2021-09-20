<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Storage;
use App\Http\Requests\StoreEmpresaRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::with('empleados')->paginate(10);
        
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
        try {
            $fileName0 = time().'-'.$request->logotipo->getClientOriginalName();
            $fileName = str_replace(" ","-", $fileName0);
            $nameEmpresa = str_replace(" ","", $request->nombre);
            $explode = explode( '/', $nameEmpresa );
            $explode2 = explode( '\\', $nameEmpresa );

            $empresa                        = new Empresa;
            $empresa->nombre                = $request->nombre;
            $empresa->correo_electronico    = $request->correo;
            $empresa->logotipo              = $fileName;
            $empresa->sitio_web             = $request->sitio_web;
            $empresa->save();

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

            if($request["destinatario"]){
                $array = $empresa->toArray();
                $destino = $request["destinatario"];
                Mail::send('emails.notificacion', $array, function ($message) use ($destino){
                    $message->from('pruebas@pruebas.com', 'Tani.com');
                    $message->to($destino)->subject('Notificación');
                });
            }

            DB::commit();

            return response()->json([
                'message' => 'Empresa creada con éxito'
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
        $empresa = Empresa::with('empleados')->find($id);
        if(!$empresa){
            return response()->json([
                'message' => 'No hay registros.'
            ],400);
        }
        $nameEmpresa = str_replace(" ","", $empresa->nombre);
        $explode = explode( '/', $nameEmpresa );
        $explode2 = explode( '\\', $nameEmpresa );

        if( count($explode) > 1 ){
            $folioComplete = str_replace("/","-", $nameEmpresa);
            $pathToFile = public_path('public').'/'.$folioComplete.'/';
        }else if( count($explode2) > 1 ){
            $folioComplete = str_replace("\\","-", $nameEmpresa);
            $pathToFile = public_path('public').'/'.$folioComplete.'/';
        }else{
            $folioComplete = $nameEmpresa;
            $pathToFile = public_path('public').'/'.$nameEmpresa.'/';
        }

        DB::commit();

        return response()->json([
            'empresa'=>$empresa,
            'img' => url('').'/storage/'.$folioComplete.'/'.$empresa->logotipo
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
    public function update(StoreEmpresaRequest $request, $id)
    {
        try {
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

            $fileName0 = time().'-'.$request->logotipo->getClientOriginalName();
            $fileName = str_replace(" ","-", $fileName0);
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
        $empresa = Empresa::find($id);
        if(!$empresa){
            return response()->json([
                'message' => 'No existen registros.'
            ],400);
        }

        $empresa->delete();

        return response()->json([
            'message' => 'La empresa se ha eliminado'
        ],200);
    }
}
