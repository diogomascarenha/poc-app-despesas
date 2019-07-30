@extends('layouts.app')

@section('content')
    <div class="container">

        <a class="btn btn-primary" href="{{ route('registro.create',['registro_tipo_id'=>1])}}">Adicionar Receita</a>
        <a class="btn btn-primary" href="{{ route('registro.create',['registro_tipo_id'=>2])}}">Adicionar Despesa</a>

        <div class="card-header">
            <div>
                Registros
            </div>

        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="row">
                <div class="col-md-12">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <ul>
                                <li>{{ $error }}</li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Data</td>
                <td>Categoria</td>
                <td>Valor (R$)</td>
                <td>Tags</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($registros as $registro)
                <tr style="color: {{$registro->tipo->cor}}">
                    <td>{{$registro->data->format('d/m/Y')}}</td>
                    <td>{{$registro->categoria->nome}}</td>
                    <td>{{number_format($registro->valor * $registro->tipo->multiplicador,2,'.',',')}}</td>
                    <td>{{implode(', ',$registro->tags)}}</td>
                    <td class="text-center">
                        <a href="{{ route('registro.edit',$registro->id)}}" class="btn btn-primary">Alterar</a>
                        <form action="{{ route('registro.destroy', $registro->id)}}"
                              method="post"
                              style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
