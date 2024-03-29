@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card uper">
            <div class="card-header">
                Adicionar Vendedor
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                <form method="post" action="{{ route('vendedor.store') }}">
                    <div class="form-group">
                        @csrf
                        <label for="name">Nome :</label>
                        <input type="text" class="form-control" name="nome"/>
                    </div>
                    <div class="form-group">
                        <label for="price">Email :</label>
                        <input type="email" class="form-control" name="email"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Criar Vendedor</button>
                </form>
            </div>
        </div>
    </div>


@endsection
