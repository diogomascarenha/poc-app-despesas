<?php

namespace App\Http\Controllers;

use App\Registro;
use App\RegistroCategoria;
use App\RegistroTipo;
use App\Vendedor;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registros = Registro::where('user_id', auth()->id())->orderBy('data', 'desc')->get();
        return view('registro.index', ['registros' => $registros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $registroTipoId = request()->input('registro_tipo_id');
        $vendedores     = Vendedor::where('user_id', auth()->id())->orderBy('nome')->get();
        if ($vendedores->count() === 0) {
            return redirect()->route('registro.index')->withErrors('Cadastre um vendedor');
        }
        $categorias = RegistroCategoria::where('registro_tipo_id', $registroTipoId)->orderBy('nome')->get();
        $tipo       = RegistroTipo::find($registroTipoId);
        return view('registro.create', compact('vendedores', 'categorias', 'tipo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData            = $request->validate([
            'registro_tipo_id'      => 'required|integer|exists:registro_tipo,id',
            'registro_categoria_id' => 'required|integer|exists:registro_categoria,id',
            'vendedor_id'           => 'required|integer|exists:vendedor,id',
            'data'                  => 'required|date',
            'valor'                 => 'required|numeric',
            'descricao'             => 'sometimes|nullable|string',
            'tags'                  => 'sometimes|nullable|string',
        ]);
        $validatedData['user_id'] = auth()->id();
        $validatedData['tags']    = explode(',', $request->input('tags'));
        Registro::create($validatedData);
        return redirect()
            ->route('registro.index')
            ->with('success', 'Registro incluído com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Registro $registro
     * @return \Illuminate\Http\Response
     */
    public function show(Registro $registro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Registro $registro
     * @return \Illuminate\Http\Response
     */
    public function edit(Registro $registro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Registro $registro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registro $registro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Registro $registro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registro $registro)
    {
        $registro->delete();

        return redirect()
            ->route('registro.index')
            ->with('success', 'Registro excluído com Sucesso');
    }
}
