<?php

namespace App\Http\Controllers;

use App\Vendedor;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores = Vendedor::where('user_id',auth()->id())->orderBy('updated_at', 'desc')->paginate();
        return view('vendedor.index', ['vendedores' => $vendedores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nome'    => 'required|max:255',
            'email'   => 'required|email',
        ]);
        $validatedData['user_id'] = auth()->id();

        Vendedor::create($validatedData);

        return redirect()
            ->route('vendedor.index')
            ->with('success', 'Vendedor incluído com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Vendedor $vendedor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendedor $vendedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Vendedor $vendedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendedor $vendedor)
    {
        return view('vendedor.edit', compact('vendedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Vendedor $vendedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendedor $vendedor)
    {
        $validatedData = $request->validate([
            'nome'  => 'required|max:255',
            'email' => 'required|email'
        ]);
        $vendedor->update($validatedData);

        return redirect()
            ->route('vendedor.index')
            ->with('success', 'Vendedor alterado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Vendedor $vendedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendedor $vendedor)
    {
        $vendedor->delete();

        return redirect()
            ->route('vendedor.index')
            ->with('success', 'Vendedor excluído com Sucesso');
    }
}
