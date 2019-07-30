@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card-header">
            Edit Book
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('vendedor.update', $vendedor->id) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" name="nome" value="{{$vendedor->nome}}"/>
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="text" class="form-control" name="email" value="{{$vendedor->email}}"/>
                </div>
                <button type="submit" class="btn btn-primary">Alterar Vendedor</button>
            </form>
        </div>
    </div>
@endsection
