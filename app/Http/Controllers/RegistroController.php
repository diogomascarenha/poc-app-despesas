<?php

namespace App\Http\Controllers;

use App\Registro;
use App\RegistroCategoria;
use App\RegistroTipo;
use App\Vendedor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $meses = [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];
        $mes = $request->input('mes',Carbon::now()->format('m'));
        $ano = Carbon::now()->format('Y');
        $mesNome = $meses[$mes] ?? null;
        $inicioDoMes = Carbon::createFromFormat('Y-m-d',"$ano-$mes-01")->startOfMonth()->format('Y-m-d');
        $fimDoDoMes = Carbon::createFromFormat('Y-m-d',"$ano-$mes-01")->endOfMonth()->format('Y-m-d');
        $registros = Registro::where('user_id', auth()->id())
            ->whereBetween('data', [$inicioDoMes, $fimDoDoMes])
            ->orderBy('data', 'desc')
            ->get();
        return view('registro.index', compact('registros','ano','mes', 'meses','mesNome') );
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
        $registroTipoId = $registro->registro_tipo_id;
        $vendedores     = Vendedor::where('user_id', auth()->id())->orderBy('nome')->get();
        if ($vendedores->count() === 0) {
            return redirect()->route('registro.index')->withErrors('Cadastre um vendedor');
        }
        $categorias = RegistroCategoria::where('registro_tipo_id', $registroTipoId)->orderBy('nome')->get();
        $tipo       = RegistroTipo::find($registroTipoId);
        return view('registro.edit', compact('vendedores', 'categorias', 'tipo', 'registro'));
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
        $registro->update($validatedData);
        return redirect()
            ->route('registro.index')
            ->with('success', 'Registro alterado com sucesso');
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
