@extends('layouts.app')

@section('content')
    <div class="container">

        <a class="btn btn-primary" href="{{ route('vendedor.create')}}">Adicionar</a>

        <div class="card-header">
            <div>
                Vendedores
            </div>

        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>Nome</td>
                <td>Email</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($vendedores as $vendedor)
                <tr>
                    <td>{{$vendedor->id}}</td>
                    <td>{{$vendedor->nome}}</td>
                    <td>{{$vendedor->email}}</td>
                    <td class="text-center">
                        <a href="{{ route('vendedor.edit',$vendedor->id)}}" class="btn btn-primary">Alterar</a>
                        <form action="{{ route('vendedor.destroy', $vendedor->id)}}"
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
        <div class="text-center">
            {{ $vendedores->links() }}
        </div>
    </div>
@endsection
